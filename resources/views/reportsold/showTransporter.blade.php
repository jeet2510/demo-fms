<x-layout.default>
    <div class="table-responsive">
        <table class="border">
            <thead>
                <tr>
                    <th class="border">Field</th>
                    <th class="border">Details</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="border">Booking Id</td>
                    <td class="border">{{ $bookingDetails['booking_id'] }}</td>
                </tr>
                <tr>
                    <td class="border">Transporter Name</td>
                    <td class="border">{{ $bookingDetails['transporter_name'] }}</td>
                </tr>
                <tr>
                    <td class="border">Date</td>
                    <td class="border">{{ $bookingDetails['date'] }}</td>
                </tr>
                <tr>
                    <td class="border">Destination</td>
                    <td class="border">{{ $bookingDetails['destination'] }}</td>
                </tr>

                <tr>
                    <td class="border">Invoice ID</td>
                    <td class="border">{{ $bookingDetails['invoice_id'] }}</td>
                </tr>
                <tr>
                    <td class="border">Total Amount</td>
                    <td class="border">{{ $bookingDetails['total_booking_amount'] }}</td>
                </tr>
                <tr>
                    <td class="border">Paid Amount</td>
                    <td class="border">{{ $bookingDetails['paid_amount'] }}</td>
                </tr>
                <tr>
                    <td class="border">Balance Amount</td>
                    <td class="border">{{ $bookingDetails['balance_amount'] }}</td>
                </tr>
                <tr>
                    <td class="border">No of Driver</td>
                    <td class="border">{{ $bookingDetails['driver_count'] }}</td>
                </tr>
                <tr>
                    <td class="border" colspan="2">
                        <a href="{{ route('reports.bookingTranporter') }}" class="btn btn-primary">Back to Index</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</x-layout.default>
