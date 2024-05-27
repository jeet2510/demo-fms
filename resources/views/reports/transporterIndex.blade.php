<x-layout.default>

    <div class="table-responsive">
        <div class="row ">
            <div class="col-md-8">


                <form action="{{ route('reports.transporterIndex') }}" method="GET">
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
                        <div class="col-md-3 flex-inline" style="margin-left: 20px; width: 160px;">
                            <label for="selected_transporter_id">{{ __('Select Driver') }}</label>
                            <select name="selected_transporter_id" id="selected_transporter_id" class="form-select">
                                <option value=""
                                    {{ !request()->filled('selected_transporter_id') ? 'selected' : '' }}>
                                    Select Transporter</option>
                                @foreach ($transporter_list as $t)
                                    <option value="{{ $t->id }}"
                                        {{ request()->get('selected_transporter_id') == $t->id ? 'selected' : '' }}>
                                        {{ $t->transporter_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mt-6 flex-inline h-5" style="margin-left: 20px;">
                            <button class="btn btn-primary" id="filterBtn"
                                onclick="filteredData()">{{ __('Filter') }}</button>
                        </div>
                </form>
                <div class="col-md-3 mt-7 text-right" style="margin-left: 30rem;">
                    <a href="{{ route('reports.transporterIndex', array_merge(['downlodcsv' => true], request()->only(['date_from', 'date_to', 'selected_transporter_id']))) }}"
                        class="btn btn-sm btn-outline-primary">{{ __('Export Excel') }}</a>
                </div>
            </div>

        </div>

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
                    <th class="border">Advance / Paid Amount</th>
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
                        <td class="border">{{ $data['driver_name'] }}</td>
                        <td class="border">{{ $data['transporter_name'] }}</td>
                        <td class="border">{{ \Carbon\Carbon::parse($data['date'])->format('d-m-Y') }}</td>
                        <td class="border">{{ $data['destination'] }}</td>
                        <td class="border">{{ $data['total_booking_amount'] }}</td>
                        <td class="border">
                            {{ $data['paid_amount'] }}
                        </td>
                        <td class="border">
                            {{ $data['balance_amount'] }}
                        </td>
                        <td class="border">
                            @if (App\Models\Invoice::where('booking_id', $data['booking_id'])->exists())
                                <a href="{{ route('invoices.show', $data['booking_id']) }}" class="btn btn-warning"
                                    style="width: 130px; display: inline-block;">View Invoice</a>
                            @else
                                <a href="{{ route('bookings.show', $data['booking_id']) }}" class="btn btn-primary"
                                    style="width: 130px; display: inline-block;">View Booking</a>
                            @endif
                @endforeach
            </tbody>
        </table>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</x-layout.default>
