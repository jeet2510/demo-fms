<x-layout.default>



    <form action="{{ route('generate.transporter') }}" method="GET">
        <div class="form-group">
            <label for="date_from">Date From:</label>
            <input type="date" id="date_from" name="date_from">
        </div>
        <div class="form-group">
            <label for="date_to">Date To:</label>
            <input type="date" id="date_to" name="date_to">
        </div>
        <button type="submit" class="btn btn-primary">Generate Report</button>
    </form>




    <div class="table-responsive">
        <table class="border">
            <thead>
                <tr>
                    <th class="border">S.No</th>
                    <th class="border">Booking Id</th>
                    <th class="border">Invoice ID</th>
                    <th class="border">Number of Driver</th>
                    <th class="border">Transporter Name</th>
                    <th class="border">Date</th>
                    <th class="border">Destination</th>
                    <th class="border">Total Amount</th>
                    <th class="border">Paid Amount</th>
                    <th class="border">Balance Amount</th>
                    <th class="border">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($processedData as $index => $data)
                <tr>
                    <td class="whitespace-nowrap border">{{ $index + 1 }}</td>
                    <td class="border">{{ $data['booking_id'] }}</td>
                    <td class="border">{{ $data['invoice_id'] }}</td>
                    <td class="border">{{ $data['driver_count'] }}</td>
                    <td class="border">{{ $data['transporter_name'] }}</td>
                    <td class="border">{{ $data['date'] }}</td>
                    <td class="border">{{ $data['destination'] }}</td>
                    <td class="border">{{ $data['total_booking_amount']}}</td>
                    <td class="border">
                        {{ $data['paid_amount']}}
                    </td>
                    <td class="border">
                        {{ $data['balance_amount']}}
                    </td>
                    <td class="border">
                        @if (App\Models\Invoice::where('booking_id', $data['booking_id'])->exists())
                        <a href="{{ route('invoices.show', $data['booking_id']) }}" class="btn btn-warning" style="width: 130px; display: inline-block;">View</a>
                    @else
                        <a href="{{ route('bookings.show', $data['booking_id']) }}" class="btn btn-primary" style="width: 130px; display: inline-block;">View</a>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</x-layout.default>
