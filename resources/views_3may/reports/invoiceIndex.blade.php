<x-layout.default>


    <form method="GET" action="{{ route('generate.Invoice') }}">
        <label for="fromDate">From:</label>
        <input type="date" id="fromDate" name="fromDate" value="{{ request('fromDate') }}">
        <label for="toDate">To:</label>
        <input type="date" id="toDate" name="toDate" value="{{ request('toDate') }}">
        <button type="submit">Apply Filters</button>
    </form>

    <div class="table-responsive">
        <table class="border">
            <thead>
                <tr>
                    <th class="border">S.No</th>
                    <th class="border">Booking Id</th>
                    <th class="border">Invoice ID</th>
                    <th class="border">Transporter Name</th>
                    <th class="border">Date</th>
                    <th class="border">Destination</th>
                    <th class="border">Total Amount</th>
                    <th class="border">Paid Amount</th>
                    <th class="border">Balance Amount</th>
                    <th class="border">No of Driver</th>
                    <th class="border">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($processedData as $index => $invoice)
                    <tr>
                        <td class="whitespace-nowrap border">{{ $index + 1 }}</td>
                        <td class="border">{{ $invoice['booking_id'] }}</td>
                        <td class="border">{{ $invoice['invoice_id'] }}</td>
                        <td class="border">{{ $invoice['transporter_name'] }}</td>
                        <td class="border">{{ $invoice['date'] }}</td>
                        <td class="border">{{ $invoice['destination'] }}</td>
                        <td class="border">{{ $invoice['total_booking_amount'] }}</td>
                        <td class="border">{{ $invoice['paid_amount'] }}</td>
                        <td class="border">{{ $invoice['balance_amount'] }}</td>
                        <td class="border">{{ $invoice['driver_count'] }}</td>
                        <td class="border">
                            <a href="{{ route('invoices.show', $invoice['booking_id']) }}" class="btn btn-warning" style="width: 130px; display: inline-block;">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>



</x-layout.default>

