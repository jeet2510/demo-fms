<x-layout.default>


    <div class="table-responsive">

        <div class="row ">
            <div class="col-md-8">


                <form action="{{ route('reports.driverIndex') }}" method="GET">
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
                            <label for="selected_driver_id">{{ __('Select Driver') }}</label>
                            <select name="selected_driver_id" id="selected_driver_id" class="form-select">
                                <option value="" {{ !request()->filled('selected_driver_id') ? 'selected' : '' }}>
                                    Select Driver</option>
                                @foreach ($driver_list as $driver)
                                    <option value="{{ $driver->id }}"
                                        {{ request()->get('selected_driver_id') == $driver->id ? 'selected' : '' }}>
                                        {{ $driver->driver_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3 flex-inline" style="margin-left: 20px; width: 160px;">
                            <label for="selected_transporter_id">{{ __('Select Transporter') }}</label>
                            <select name="selected_transporter_id" id="selected_transporter_id" class="form-select">
                                <option value=""
                                    {{ !request()->filled('selected_transporter_id') ? 'selected' : '' }}>
                                    Select Transporter</option>
                                @foreach ($transporter_list as $transporter)
                                    <option value="{{ $transporter->id }}"
                                        {{ request()->get('selected_transporter_id') == $transporter->id ? 'selected' : '' }}>
                                        {{ $transporter->transporter_name }}</option>
                                @endforeach
                            </select>
                        </div>


                        <div class="col-md-3 mt-6 flex-inline h-5" style="margin-left: 20px;">
                            <button class="btn btn-primary" id="filterBtn"
                                onclick="filteredData()">{{ __('Filter') }}</button>
                        </div>
                </form>
                <div class="col-md-3 mt-7 text-right" style="margin-left: 30rem;">
                    <a href="{{ route('reports.driverIndex', array_merge(['downlodcsv' => true], request()->only(['date_from', 'date_to', 'selected_driver_id', 'selected_transporter_id']))) }}"
                        class="btn btn-sm btn-outline-primary">{{ __('Export Excel') }}</a>
                </div>
            </div>

        </div>

        <table class="border">
            <thead>
                <tr>
                    <th class="border">S.No</th>
                    <th class="border">Booking Id</th>
                    <th class="border">Driver Name</th>
                    <th class="border">Invoice ID</th>
                    <th class="border">Transporter Name</th>
                    <th class="border">Date</th>
                    <th class="border">Destination</th>
                    <th class="border">Total Amount</th>
                    <th class="border">Advacne / Paid Amount</th>
                    <th class="border">Balance Amount</th>
                    <th class="border">Action</th>
                </tr>
            </thead>
            <tbody>
                {{-- {{ dd($processedData) }} --}}
                @foreach ($processedData as $index => $invoice)
                    <tr>
                        <td class="whitespace-nowrap border">{{ $index + 1 }}</td>
                        <td class="border">{{ $invoice['booking_id'] }}</td>
                        <td class="border">{{ $invoice['driver_name'] }}</td>
                        <td class="border">{{ $invoice['invoice_id'] }}</td>
                        <td class="border">{{ $invoice['transporter_name'] }}</td>
                        <td class="border">{{ \Carbon\Carbon::parse($invoice['date'])->format('d-m-Y') }}</td>
                        <td class="border">{{ $invoice['destination'] }}</td>
                        <td class="border">{{ $invoice['total_amount'] }}</td>
                        <td class="border">{{ $invoice['paid_amount'] }}</td>
                        <td class="border">{{ $invoice['balance_amount'] }}</td>
                        <td class="border">
                            @if (App\Models\Invoice::where('booking_id', $invoice['booking_id'])->exists())
                                <a href="{{ route('invoices.show', $invoice['booking_id']) }}" class="btn btn-warning "
                                    style="width: 125px; ">View Invoice </a>
                            @else
                                <a href="{{ route('bookings.show', $invoice['booking_id']) }}" class="btn btn-primary"
                                    style="width: 125px; display: inline-block; text-align: center;">Show Booking</a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>

        </table>
    </div>
</x-layout.default>
