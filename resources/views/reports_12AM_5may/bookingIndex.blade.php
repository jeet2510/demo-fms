<x-layout.default>




    {{-- <form action="{{ route('generate.report') }}" method="get"> --}}
    {{-- <label for="date_from">Date From:</label>
        <input type="date" id="date_from" name="date_from">

        <label for="date_to">Date To:</label>
        <input type="date" id="date_to" name="date_to"> --}}


    {{-- </form> --}}


    <div class="table-responsive">


        <div class="row ">
            <div class="col-md-8">


                <form action="{{ route('reports.bookingIndex') }}" method="GET">
                    <div class="row mb-3 flex">
                        <div class="col-md-3 flex-inline">
                            <label for="date_from">{{ __('From Date') }}</label>
                            <input type="date" name="date_from" id="date_from" class="form-input"
                                value="{{ request()->get('date_from') }}">
                        </div>
                        <div class="col-md-3 flex-inline" style="margin-left: 20px;">
                            <label for="date_to">{{ __('To Date') }}</label>
                            <input type="date" name="date_to" id="date_to" class="form-input"
                                value="{{ request()->get('date_to') }}">
                        </div>
                        <div class="col-md-3 mt-6 flex-inline h-5" style="margin-left: 20px;">
                            <button class="btn btn-primary" id="filterBtn"
                                onclick="filteredData()">{{ __('Filter') }}</button>
                        </div>
                </form>
                <div class="col-md-3 mt-7 text-right" style="margin-left: 30rem;">
                    <a href="{{ route('reports.bookingIndex', array_merge(['downlodcsv' => true], request()->only(['date_from', 'date_to']))) }}"
                        class="btn btn-sm btn-outline-primary">{{ __('Export Excel') }}</a>
                </div>
            </div>

        </div>
    </div>

    </div>
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
