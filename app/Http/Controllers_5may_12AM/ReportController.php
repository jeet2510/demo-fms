<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Driver;
use App\Models\Invoice;
use App\Models\Route;
use App\Models\Transaction;
use App\Models\Transporter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

class ReportController extends Controller
{

    public function bookingIndex(Request $request)
    {
        if (!$request->filled('date_from')) {
            $request->merge(['date_from' => now()->toDateString()]);
        }

        if (!$request->filled('date_to')) {
            $request->merge(['date_to' => now()->toDateString()]);
        }

        $bookingsQuery = Booking::where('created_by', Auth::user()->creatorId())->doesnthave('invoice');

        // Apply date filter
        $bookingsQuery->whereBetween('date', [
            $request->input('date_from'),
            $request->input('date_to') . ' 23:59:59' // End of the day
        ]);

        $bookings = $bookingsQuery->get();
        $processedData = [];

        foreach ($bookings as $booking) {
            $transactions = Transaction::where('booking_id', $booking->id)->latest()->first();

            if ($transactions) {
                $totalPaidArray = explode(',', $transactions->paid_amount);
                $paidAmount = array_sum($totalPaidArray);
            } else {
                $paidAmount = 0;
            }

            // Calculate balance amount
            $balanceAmount = $booking->total_booking_amount - $paidAmount;

            $processedData[] = [
                'booking_id' => $booking->booking_id,
                'transporter_name' => optional($booking->transporter)->transporter_name,
                'date' => $booking->date,
                'destination' => optional($booking->route)->route,
                'total_booking_amount' => $booking->total_booking_amount,
                'paid_amount' => $paidAmount,
                'balance_amount' => $balanceAmount, // Use the calculated balanceAmount
                'driver_count' => $booking->countDistinctDrivers(),
            ];
        }
        if ($request->has('downlodcsv')) {
            $items = [];

            foreach ($bookings as $index => $booking) {
                $transactions = Transaction::where('booking_id', $booking->id)->latest()->first();

                if ($transactions) {
                    $totalPaidArray = explode(',', $transactions->paid_amount);
                    $paidAmount = array_sum($totalPaidArray);
                } else {
                    $paidAmount = 0;
                }

                // Calculate balance amount
                $balanceAmount = $booking->total_booking_amount - $paidAmount;

                $processedData = [
                    'Sno' => $index + 1,
                    'booking_id' => $booking->booking_id,
                    'transporter_name' => optional($booking->transporter)->transporter_name,
                    'date' => $booking->date,
                    'destination' => optional($booking->route)->route,
                    'total_booking_amount' => $booking->total_booking_amount,
                    'paid_amount' => $paidAmount ?? 0,
                    'balance_amount' => $balanceAmount,
                    'driver_count' => $booking->countDistinctDrivers(),
                ];

                $items[] = $processedData;
            }

            return Excel::download(new BookingReportExport($items), 'Booking_reports_' . time() . '.xlsx');
        }

        if ($request->ajax()) {
            return view('reports.bookingIndex', compact('processedData'));
        }

        return view('reports.bookingIndex', compact('processedData', 'bookings'));
    }

    // public function bookingIndex(Request $request)
    // {
    //     $bookingsQuery = Booking::where('created_by', Auth::user()->creatorId());

    //     // Filter by date range
    //     if ($request->has('date_from') && $request->has('date_to')) {
    //         $bookingsQuery->whereBetween('date', [$request->date_from, $request->date_to]);
    //     }

    //     $bookings = $bookingsQuery->get();
    //     $processedData = [];
    //     dd($bookings);
    //     foreach ($bookings as $invoice) {
    //     $booking = Booking::where('booking_id', $invoice->booking_id)->first();

    //         if ($booking) {
    //             $transactions = Transaction::where('booking_id', $booking->id)->get();
    //             $paidAmount = $transactions->sum(function ($transaction) {
    //                 return is_numeric($transaction->amount) ? $transaction->amount : 0;
    //             });
    //             $processedData[] = [
    //                 'booking_id' => $invoice->booking_id,
    //                 'transporter_name' => optional($booking->transporter)->transporter_name,
    //                 'date' => $booking->date,
    //                 'destination' => optional($booking->route)->route,
    //                 'total_booking_amount' => $invoice->total_booking_amount,
    //                 'paid_amount' => $paidAmount,
    //                 'balance_amount' => $invoice->total_booking_amount - $paidAmount,
    //                 'driver_count' => $booking->countDistinctDrivers(),
    //             ];
    //         }
    //     }

    //     // Return partial view if AJAX request
    //     if ($request->ajax()) {
    //         return view('reports.bookingIndex', compact('processedData'));
    //     }

    //     return view('reports.bookingIndex', compact('processedData', 'bookings'));
    // }

    public function show($booking_id)
    {
        $invoice = Invoice::where('booking_id', $booking_id)->first();

        if (!$invoice) {
            return redirect()->route('reports.bookingIndex')->with('error', 'Invoice not found');
        }

        $booking = Booking::where('booking_id', $booking_id)->first();
        if (!$booking) {
            return redirect()->route('reports.bookingIndex')->with('error', 'Booking not found');
        }

        $transactions = Transaction::where('booking_id', $booking_id)->get();
        $paidAmount = $transactions->sum('amount');

        $bookingDetails = [
            'booking_id' => $invoice->booking_id,
            'transporter_name' => optional($booking->transporter)->transporter_name,
            'date' => $booking->date,
            'destination' => optional($booking->route)->route,
            'total_booking_amount' => $invoice->total_booking_amount,
            'paid_amount' => $paidAmount,
            'balance_amount' => $invoice->total_booking_amount - $paidAmount,
            'driver_count' => $booking->countDistinctDrivers(),
        ];

        return view('reports.showBooking', compact('bookingDetails'));
    }

    public function indexDriver()
    {
        $processedData = [];
        $userCreatorId = Auth::user()->creatorId();

        // Fetch invoices and bookings separately
        $invoices = Invoice::where('created_by', $userCreatorId)->get();
        $bookings = Booking::where('created_by', $userCreatorId)->get();

        // Process invoices
        foreach ($invoices as $invoice) {
        $booking = Booking::where('booking_id', $invoice->booking_id)->first();

            if ($booking) {
                $transactions = Transaction::where('booking_id', $booking->id)->get();
                $paidAmount = $transactions->sum(function ($transaction) {
                    return is_numeric($transaction->amount) ? $transaction->amount : 0;
                });
                $driver = Driver::find($booking->driver_id);
                $driverName = $driver ? $driver->driver_name : 'Unknown';

                // Add a separate row for each driver associated with the same booking ID
                $processedData[] = [
                    'booking_id' => $invoice->booking_id,
                    'invoice_id' => $invoice->id,
                    'transporter_name' => optional($booking->transporter)->transporter_name,
                    'date' => $booking->date,
                    'destination' => optional($booking->route)->route,
                    'total_booking_amount' => $invoice->total_booking_amount,
                    'paid_amount' => $paidAmount,
                    'balance_amount' => $invoice->total_booking_amount - $paidAmount,
                    'driver_name' => $driverName,
                ];
            }
        }

        // Process bookings
        foreach ($bookings as $booking) {
            // Check if the booking is not already processed
            if (!collect($processedData)->contains('booking_id', $booking->booking_id)) {
                $transactions = Transaction::where('booking_id', $booking->booking_id)->get();
                $paidAmount = $transactions->sum('amount');
                $driver = Driver::find($booking->driver_id);
                $driverName = $driver ? $driver->driver_name : 'Unknown';

                // Add a separate row for each driver associated with the same booking ID
                $processedData[] = [
                    'booking_id' => $booking->booking_id,
                    'invoice_id' => null,
                    'transporter_name' => optional($booking->transporter)->transporter_name,
                    'date' => $booking->date,
                    'destination' => optional($booking->route)->route,
                    'total_booking_amount' => $booking->total_booking_amount,
                    'paid_amount' => $paidAmount,
                    'balance_amount' => $booking->total_booking_amount - $paidAmount,
                    'driver_name' => $driverName, // Include driver name here
                ];
            }
        }

        return view('reports.driverIndex', compact('processedData'));
    }

    public function showDriver($booking_id)
    {
        $invoice = Invoice::where('booking_id', $booking_id)->first();

        if (!$invoice) {
            return redirect()->route('reports.bookingIndex')->with('error', 'Invoice not found');
        }

        $booking = Booking::where('booking_id', $booking_id)->with('driver')->first();
        if (!$booking) {
            return redirect()->route('reports.bookingIndex')->with('error', 'Booking not found');
        }

        $transactions = Transaction::where('booking_id', $booking_id)->get();
        $paidAmount = $transactions->sum('amount');

        $bookingDetails = [
            'booking_id' => $invoice->booking_id,
            'transporter_name' => optional($booking->transporter)->transporter_name,
            'date' => $booking->date,
            'destination' => optional($booking->route)->route,
            'total_booking_amount' => $invoice->total_booking_amount,
            'paid_amount' => $paidAmount,
            'invoice_id' => $invoice->id,
            'balance_amount' => $invoice->total_booking_amount - $paidAmount,
            'driver_id' => $booking->driver_id, // assuming 'driver_id' is the foreign key in the bookings table
            'driver_name' => optional($booking->driver)->name, // Assuming 'name' is the driver's name field in the drivers table
            'driver_count' => $booking->countDistinctDrivers(),
        ];

        return view('reports.showDriver', compact('bookingDetails'));
    }

    public function generateReport(Request $request)
    {
        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');

        $invoices = Booking::where('created_by', Auth::user()->creatorId())
            ->whereBetween('date', [$dateFrom, $dateTo])
            ->get();

        $reportContent = "S.No\tBooking Id\tTransporter Name\tDate\tDestination\tTotal Amount\tPaid Amount\tBalance Amount\tNo of Driver\n";

        foreach ($invoices as $index => $invoice) {
            $booking = Booking::where('booking_id', $invoice->booking_id)->first();

            if ($booking) {
                $transactions = Transaction::where('booking_id', $invoice->booking_id)->get();
                $paidAmount = $transactions->sum('amount');

                $driverIds = explode(',', $booking->driver_id);
                $driverCount = count(array_unique($driverIds));

                $reportContent .= ($index + 1) . "\t" .
                $invoice->booking_id . "\t" .
                optional($booking->transporter)->transporter_name . "\t" .
                $booking->date . "\t" .
                optional($booking->route)->route . "\t" .
                $invoice->total_booking_amount . "\t" .
                    $paidAmount . "\t" .
                    ($invoice->total_booking_amount - $paidAmount) . "\t" .
                    $driverCount . "\n";
            }
        }

        $headers = [
            'Content-Type' => 'text/plain',
            'Content-Disposition' => 'attachment; filename="report.txt"',
        ];

        return response()->make($reportContent, 200, $headers);
    }

    public function generateDriverReport(Request $request)
    {
        $userCreatorId = Auth::user()->creatorId();
        $invoices = Invoice::where('created_by', $userCreatorId)->get();
        $bookings = Booking::where('created_by', $userCreatorId)->get();

        $reportContent = "S.No\tBooking Id\tTransporter Name\tDate\tDestination\tTotal Amount\tPaid Amount\tBalance Amount\tInvoice ID\tDriver Name\n";

        // Process invoices
        foreach ($invoices as $index => $invoice) {
            $booking = Booking::where('booking_id', $invoice->booking_id)->first();

            if ($booking) {
                $transactions = Transaction::where('booking_id', $invoice->booking_id)->get();
                $paidAmount = $transactions->sum('amount');

                $driver = Driver::find($booking->driver_id);
                $driverName = $driver ? $driver->driver_name : 'Unknown';

                $reportContent .= ($index + 1) . "\t" .
                $invoice->booking_id . "\t" .
                optional($booking->transporter)->transporter_name . "\t" .
                $booking->date . "\t" .
                optional($booking->route)->route . "\t" .
                $invoice->total_booking_amount . "\t" .
                $paidAmount . "\t" .
                ($invoice->total_booking_amount - $paidAmount) . "\t" .
                $invoice->id . "\t" .
                    $driverName . "\n";
            }
        }

        // Process bookings without associated invoices
        foreach ($bookings as $index => $booking) {
            if (!Invoice::where('booking_id', $booking->booking_id)->exists()) {
                $transactions = Transaction::where('booking_id', $booking->booking_id)->get();
                $paidAmount = $transactions->sum('amount');

                $driver = Driver::find($booking->driver_id);
                $driverName = $driver ? $driver->driver_name : 'Unknown';

                $reportContent .= (count($invoices) + $index + 1) . "\t" .
                $booking->booking_id . "\t" .
                optional($booking->transporter)->transporter_name . "\t" .
                $booking->date . "\t" .
                optional($booking->route)->route . "\t" .
                $booking->total_booking_amount . "\t" .
                    $paidAmount . "\t" .
                    ($booking->total_booking_amount - $paidAmount) . "\tN/A\t" .
                    $driverName . "\n";
            }
        }

        $headers = [
            'Content-Type' => 'text/plain',
            'Content-Disposition' => 'attachment; filename="report.txt"',
        ];

        return response()->make($reportContent, 200, $headers);
    }

    public function showTransporter($booking_id)
    {
        $invoice = Invoice::where('booking_id', $booking_id)->first();

        if (!$invoice) {
            return redirect()->route('reports.bookingIndex')->with('error', 'Invoice not found');
        }

        $booking = Booking::where('booking_id', $booking_id)->first();
        if (!$booking) {
            return redirect()->route('reports.bookingIndex')->with('error', 'Booking not found');
        }

        $transactions = Transaction::where('booking_id', $booking_id)->get();
        $paidAmount = $transactions->sum('amount');

        $bookingDetails = [
            'booking_id' => $invoice->booking_id,
            'transporter_name' => optional($booking->transporter)->transporter_name,
            'date' => $booking->date,
            'destination' => optional($booking->route)->route,
            'total_booking_amount' => $invoice->total_booking_amount,
            'paid_amount' => $paidAmount,
            'invoice_id' => $invoice->id,
            'balance_amount' => $invoice->total_booking_amount - $paidAmount,
            'driver_count' => $booking->countDistinctDrivers(),
        ];
        return view('reports.showDriver', compact('bookingDetails'));
    }

    public function generateTranporterReport(Request $request)
    {
        $userCreatorId = Auth::user()->creatorId();
        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');

        $bookings = Booking::where('created_by', $userCreatorId)
            ->whereBetween('date', [$dateFrom, $dateTo])
            ->get();

        $bookingIds = $bookings->pluck('booking_id')->toArray();
        $invoices = Invoice::whereIn('booking_id', $bookingIds)->get();

        $reportContent = "S.No\tBooking Id\tTransporter Name\tDate\tDestination\tTotal Amount\tPaid Amount\tBalance Amount\tNumber of Drivers\tInvoice ID\n";

        foreach ($invoices as $index => $invoice) {
            $booking = $bookings->firstWhere('booking_id', $invoice->booking_id);

            if ($booking) {
                $transactions = Transaction::where('booking_id', $invoice->booking_id)->get();
                $paidAmount = $transactions->sum('amount');

                $driverIds = explode(',', $booking->driver_id);
                $driverCount = count(array_unique($driverIds));

                $reportContent .= ($index + 1) . "\t" .
                $invoice->booking_id . "\t" .
                optional($booking->transporter)->transporter_name . "\t" .
                $booking->date . "\t" .
                optional($booking->route)->route . "\t" .
                $invoice->total_booking_amount . "\t" .
                $paidAmount . "\t" .
                ($invoice->total_booking_amount - $paidAmount) . "\t" .
                $driverCount . "\t" .
                $invoice->id . "\n";
            }

        }

        foreach ($bookings as $index => $booking) {
            if (!$invoices->contains('booking_id', $booking->booking_id)) {
                $transactions = Transaction::where('booking_id', $booking->booking_id)->get();
                $paidAmount = $transactions->sum('amount');

                $driverIds = explode(',', $booking->driver_id);
                $driverCount = count(array_unique($driverIds));

                $reportContent .= (count($invoices) + $index + 1) . "\t" .
                $booking->booking_id . "\t" .
                optional($booking->transporter)->transporter_name . "\t" .
                $booking->date . "\t" .
                optional($booking->route)->route . "\t" .
                $booking->total_booking_amount . "\t" .
                    $paidAmount . "\t" .
                    ($booking->total_booking_amount - $paidAmount) . "\t" .
                    $driverCount . "\t" .
                    "N/A\n";
            }
        }

        $headers = [
            'Content-Type' => 'text/plain',
            'Content-Disposition' => 'attachment; filename="report.txt"',
        ];

        return response()->make($reportContent, 200, $headers);
    }

    public function indexTranporter(Request $request)
    {
        $userCreatorId = Auth::user()->creatorId();

        // Fetch all invoices and bookings
        $invoices = Invoice::where('created_by', $userCreatorId)->get();
        $bookings = Booking::where('created_by', $userCreatorId)->get();

        foreach ($invoices as $invoice) {
            // Check if there's a corresponding booking for this invoice
        $booking = Booking::where('booking_id', $invoice->booking_id)->first();

            // If a booking is found, use invoice data
            if ($booking) {
                $transactions = Transaction::where('booking_id', $booking->id)->get();
                $paidAmount = $transactions->sum(function ($transaction) {
                    return is_numeric($transaction->amount) ? $transaction->amount : 0;
                });
                $processedData[] = [
                    'booking_id' => $invoice->booking_id,
                    'invoice_id' => $invoice->id,
                    'transporter_name' => optional($booking->transporter)->transporter_name,
                    'date' => $booking->date,
                    'destination' => optional($booking->route)->route,
                    'total_booking_amount' => $invoice->total_booking_amount,
                    'paid_amount' => $paidAmount,
                    'balance_amount' => $invoice->total_booking_amount - $paidAmount,
                    'driver_count' => $booking->countDistinctDrivers(),

                ];
            }
        }

        // Process bookings for which there are no corresponding invoices
        foreach ($bookings as $booking) {
            // Check if there's no processed data for this booking ID
            if (!collect($processedData)->contains('booking_id', $booking->booking_id)) {
                $transactions = Transaction::where('booking_id', $booking->booking_id)->get();
                $paidAmount = $transactions->sum('amount');

                $processedData[] = [
                    'booking_id' => $booking->booking_id,
                    'invoice_id' => null,
                    'transporter_name' => optional($booking->transporter)->transporter_name,
                    'date' => $booking->date,
                    'destination' => optional($booking->route)->route,
                    'total_booking_amount' => $booking->total_booking_amount,
                    'paid_amount' => $paidAmount,
                    'balance_amount' => $booking->total_booking_amount - $paidAmount,
                    'driver_count' => $booking->countDistinctDrivers(),

                ];
            }
        }

        return view('reports.transporterIndex', compact('processedData'));
    }

       public function indexInvoice(Request $request)
        {
            if (!$request->filled('date_from')) {
                $request->merge(['date_from' => now()->toDateString()]);
            }

            if (!$request->filled('date_to')) {
                $request->merge(['date_to' => now()->toDateString()]);
            }

            $invoicesQuery = Invoice::where('created_by', Auth::user()->creatorId());

            // Filter by date range if both from and to dates are provided
            if ($request->filled('date_from') && $request->filled('date_to')) {
                $invoicesQuery->whereBetween('date', [$request->input('date_from'), $request->input('date_to') . ' 23:59:59']);
            }

            $invoices = $invoicesQuery->get();
            $processedData = [];

            foreach ($invoices as $invoice) {
                $booking = Booking::where('booking_id', $invoice->booking_id)->first();
                $transactions = Transaction::where('booking_id', $booking->id)->latest()->first();

                if ($transactions) {
                    $totalPaidArray = explode(',', $transactions->paid_amount);
                    $paidAmount = array_sum($totalPaidArray);
                } else {
                    $paidAmount = 0;
                }

                // Calculate balance amount
                $balanceAmount = $invoice->total_booking_amount - $paidAmount;

                $processedData[] = [
                    'booking_id' => $invoice->booking_id,
                    'invoice_id' => $invoice->id,
                    'transporter_name' => optional($booking->transporter)->transporter_name,
                    'date' => $invoice->date,
                    'destination' => optional($booking->route)->route,
                    'total_booking_amount' => $invoice->total_booking_amount,
                    'paid_amount' => $paidAmount,
                    'balance_amount' => $balanceAmount,
                    'driver_count' => $booking->countDistinctDrivers(),
                ];
            }

            // CSV export logic
            if ($request->has('downlodcsv')) {
                $items = [];

                foreach ($invoices as $index => $invoice) {
                    $booking = Booking::where('booking_id', $invoice->booking_id)->first();
                    $transactions = Transaction::where('booking_id', $booking->id)->latest()->first();

                    if ($transactions) {
                        $totalPaidArray = explode(',', $transactions->paid_amount);
                        $paidAmount = array_sum($totalPaidArray);
                    } else {
                        $paidAmount = 0;
                    }

                    // Calculate balance amount
                    $balanceAmount = $invoice->total_booking_amount - $paidAmount;

                    $processedData = [
                        'S.No' => $index + 1,
                        'Booking Id' => $invoice->booking_id,
                        'Invoice ID' => $invoice->id,
                        'Transporter Name' => optional($booking->transporter)->transporter_name,
                        'Date' => $invoice->date,
                        'Destination' => optional($invoice->route)->route,
                        'Total Amount' => $invoice->total_booking_amount,
                        'Paid Amount' => $paidAmount ?? 0,
                        'Balance Amount' => $balanceAmount,
                        'No of Driver' => $booking->countDistinctDrivers(),
                    ];
                    $items[] = $processedData;
                }

                return Excel::download(new InvoiceReportExport($items), 'Invoice_reports_' . time() . '.xlsx');
            }

            return view('reports.invoiceIndex', compact('processedData'));
        }

    public function generateInvoiceReport(Request $request)
    {
        $dateFrom = $request->input('fromDate');
        $dateTo = $request->input('toDate');

        // Convert dates to proper format (assuming Y-m-d format)
        $dateFrom = date('Y-m-d', strtotime($dateFrom));
        $dateTo = date('Y-m-d', strtotime($dateTo));

        // Query invoices with filters
        $invoices = Invoice::where('created_by', Auth::user()->creatorId())
            ->whereBetween('created_at', [$dateFrom, $dateTo])
            ->get();

        $reportContent = "S.No\tBooking Id\tTransporter Name\tDate\tDestination\tTotal Amount\tPaid Amount\tBalance Amount\tNo of Driver\tInvoice ID\n";

        foreach ($invoices as $index => $invoice) {
            $booking = Booking::where('booking_id', $invoice->booking_id)->first();

            if ($booking) {
                $transactions = Transaction::where('booking_id', $invoice->booking_id)->get();
                $paidAmount = $transactions->sum('amount');

                $driverIds = explode(',', $booking->driver_id);

                $driverCount = count(array_unique($driverIds));

                $reportContent .= ($index + 1) . "\t" .
                $invoice->booking_id . "\t" .
                optional($booking->transporter)->transporter_name . "\t" .
                $booking->date . "\t" .
                optional($booking->route)->route . "\t" .
                $invoice->total_booking_amount . "\t" .
                $paidAmount . "\t" .
                ($invoice->total_booking_amount - $paidAmount) . "\t" .
                $driverCount . "\t" .
                $invoice->id . "\n";
            }
        }

        $headers = [
            'Content-Type' => 'text/plain',
            'Content-Disposition' => 'attachment; filename="report.txt"',
        ];

        return response()->make($reportContent, 200, $headers);
    }

    public function showInvoice($booking_id)
    {
        $invoice = Invoice::where('booking_id', $booking_id)->first();

        if (!$invoice) {
            return redirect()->route('reports.bookingIndex')->with('error', 'Invoice not found');
        }

        $booking = Booking::where('booking_id', $booking_id)->first();
        if (!$booking) {
            return redirect()->route('reports.bookingIndex')->with('error', 'Booking not found');
        }

        $transactions = Transaction::where('booking_id', $booking_id)->get();
        $paidAmount = $transactions->sum('amount');

        $bookingDetails = [
            'booking_id' => $invoice->booking_id,
            'transporter_name' => optional($booking->transporter)->transporter_name,
            'date' => $booking->date,
            'destination' => optional($booking->route)->route,
            'total_booking_amount' => $invoice->total_booking_amount,
            'paid_amount' => $paidAmount,
            'invoice_id' => $invoice->id,
            'balance_amount' => $invoice->total_booking_amount - $paidAmount,
            'driver_count' => $booking->countDistinctDrivers(),
        ];

        return view('reports.showInvoice', compact('bookingDetails'));
    }

}