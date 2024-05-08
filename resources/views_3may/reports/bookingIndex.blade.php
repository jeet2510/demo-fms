<x-layout.default>

    <form id="filterForm">
        <label for="date_from">Date From:</label>
        <input type="date" id="date_from" name="date_from">

        <label for="date_to">Date To:</label>
        <input type="date" id="date_to" name="date_to">

        <button type="submit" class="btn btn-primary">Filter</button>
    </form>


    <form action="{{ route('generate.report') }}" method="get">
        <label for="date_from">Date From:</label>
        <input type="date" id="date_from" name="date_from">

        <label for="date_to">Date To:</label>
        <input type="date" id="date_to" name="date_to">

        <button type="submit" class="btn btn-primary">Generate Report</button>
    </form>


    <div class="table-responsive">
        <table class="border">
            <thead>
                <tr>
                    <th class="border">S.No</th>
                    <th class="border">Booking Id</th>
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
                        <td class="border">{{ $invoice['transporter_name'] }}</td>
                        <td class="border">{{ $invoice['date'] }}</td>
                        <td class="border">{{ $invoice['destination'] }}</td>
                        <td class="border">{{ $invoice['total_booking_amount'] }}</td>
                        <td class="border">{{ $invoice['paid_amount'] }}</td>
                        <td class="border">{{ $invoice['balance_amount'] }}</td>
                        <td class="border">{{ $invoice['driver_count'] }}</td>
                        <td class="border">
                            <a href="{{ route('bookings.show', $invoice['booking_id']) }}" class="btn btn-primary"
                                style="width: 50px; display: inline-block;">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Function to fetch filtered data
            function fetchFilteredData() {
                var formData = $('#filterForm').serialize();
                $.ajax({
                    url: "{{ route('generate.report') }}",
                    type: "GET",
                    data: formData,
                    success: function(response) {
                        // Update table with filtered data
                        $('#bookingTable').html(response);
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            }

            // Submit form on change of date range
            $('#date_from, #date_to').on('change', function() {
                fetchFilteredData();
            });

            // Initial data load
            fetchFilteredData();
        });
    </script>
</x-layout.default>
