<x-layout.default>

    <style>
        #driverData tr.expanded {
            background-color: lightgray;
        }

        .overflow-x-auto {
            width: 100%;
            overflow-x: auto;
        }

        .expired-date {
            color: red;
        }
    </style>
    {{-- {{ dd($invoice) }} --}}
    <div class="container">
        <div class="grid grid-cols-3 gap-4">
            <div class="mb-4">
                <label for="booking_id" class="block text-gray-700">Booking ID</label>
                <p>{{ $invoice->booking_id }}</p>
            </div>

            <div class="mb-4">
                <label for="date" class="block text-gray-700">Date</label>
                <p>{{ $invoice->date }}</p>
            </div>

            <div class="mb-4">
                <label for="route_id" class="block text-gray-700">Route</label>
                <p>{{ $invoice->route->route }}</p>

            </div>
        </div>

        <div class="grid grid-cols-3 gap-4">
            <div class="mb-4">
                <label for="customer_id" class="block text-gray-700">Customer</label>
                <p>{{ $invoice->customer->company_name }}</p>
            </div>

            <div class="mb-4">
                <label for="receiver_id" class="block text-gray-700">Receiver</label>
                <p>{{ $invoice->receiver->company_name }}</p>
            </div>
        </div>
        @php
            // Extract numbers from the string using regular expression
            preg_match_all('/\d+/', $invoice->driver_id, $matches);
            $selectedDriverIds = !empty($matches[0]) ? $matches[0] : [];
        @endphp


        <div class="overflow-x-auto">
            <table id="selectedDriversTable">
                <thead>
                    <tr>
                        <th class="border p-4">Driver Name</th>
                        <th class="border p-4">Passport EXPIRE AT:</th>
                        <th class="border p-4">ID Card EXPIRE AT:</th>
                        <th class="border p-4">Driver License</th>
                        <th class="border p-4">Driver License EXPIRE AT:</th>
                        <th class="border p-4">Transporter </th>
                        <th class="border p-4">Buying Amount </th>
                        <th class="border p-4">Border Charges </th>
                        <th class="border p-4">Waiting Amount </th>
                        <th class="border p-4">Total </th>
                        <th class="border p-4">Paid Amount</th>
                        <th class="border p-4">Balance</th>
                    </tr>
                </thead>
                <tbody id="driverData">
                    @if ($invoice->driver_id)
                        {{-- {{dd($invoice->driver_id)}} --}}
                        @php

                            $buyingAmounts = json_decode($invoice->semi_buying_amount);
                            $borderCharges = json_decode($invoice->semi_border_charges);
                            $waitingAmount = json_decode($invoice->semi_waiting_amount);
                            $totalBookingAmounts = json_decode($invoice->semi_total_booking_amount);
                            $transporterIds = json_decode($invoice->booking->transporter_id);

                            preg_match_all('/\d+/', $invoice->driver_id, $matches);
                            $driverIds = array_map('intval', $matches[0]);
                            $drivers = \App\Models\Driver::whereIn('id', $driverIds)->get();
                        @endphp

                        {{-- {{dd($drivers, $driverIds)}} --}}
                        @foreach ($drivers as $driverIndex => $driver)
                            @if ($transactions && $transactions->count() > 0)
                                @php
                                    $driver_ids = $transactions->driver_id;
                                    $driver_ids = explode(',', $driver_ids);

                                    $paid_amount = $transactions->paid_amount;
                                    $paid_amount = explode(',', $paid_amount);
                                    $total_paid_amount = 0;
                                    foreach ($paid_amount as $pd) {
                                        $total_paid_amount += $pd;
                                    }
                                @endphp

                                {{ $paid_amount[$driverIndex] }}
                            @else
                            @endif
                            <tr>
                                <td class="border p-4">{{ $driver->driver_name }}</td>
                                <td class="border p-4">{{ $driver->passport_expiry_date }}</td>
                                <td class="border p-4">{{ $driver->id_card_expiry_date }}</td>
                                <td class="border p-4">{{ $driver->driving_license_number }}</td>
                                <td class="border p-4">{{ $driver->driving_license_expiry_date }}</td>
                                <td class="border p-4">
                                    @foreach ($transporters as $transporter)
                                        @if (is_array($transporterIds))
                                            {{ $transporter->id == $transporterIds[$driverIndex] ? $transporter->transporter_name : '' }}
                                        @else
                                            {{ $transporter->id == $booking->transporter_id ? $transporter->transporter_name : '' }}
                                        @endif
                                    @endforeach
                                </td>
                                <td class="border p-4">
                                    <p>{{ isset($buyingAmounts[$driverIndex]) ? $buyingAmounts[$driverIndex] : 0 }}</p>
                                </td>

                                <td class="border p-4">
                                    <p>{{ isset($borderCharges[$driverIndex]) ? $borderCharges[$driverIndex] : 0 }}
                                    </p>
                                </td>
                                <td class="border p-4">
                                    <p>{{ isset($waitingAmount[$driverIndex]) ? $waitingAmount[$driverIndex] : 0 }}</p>
                                </td>

                                <td colspan="" class="border p-4">
                                    <p>{{ isset($totalBookingAmounts[$driverIndex]) ? $totalBookingAmounts[$driverIndex] : 0 }}
                                    </p>
                                </td>
                                <td class="border p-4">
                                    <p>{{ isset($paid_amount[$driverIndex]) ? $paid_amount[$driverIndex] : 0 }}</p>
                                </td>
                                <td class="border p-4">
                                    <p>{{ ($totalBookingAmounts[$driverIndex] ?? 0) - ($paid_amount[$driverIndex] ?? 0) }}
                                    </p>
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td class="border p-4"></td>
                            <td class="border p-4"></td>
                            <td class="border p-4"></td>
                            <td class="border p-4"></td>
                            <td class="border p-4"></td>
                            <td class="border p-4"><strong>Total</strong></td>
                            <td class="border p-4">
                                <p>{{ $invoice->buying_amount ?? 0 }}</p>
                            </td>
                            <td class="border p-4">
                                <p>{{ $invoice->border_charges ?? 0 }}</p>
                            </td>
                            <td class="border p-4">
                                <p>{{ $invoice->waiting_amount ?? 0 }}</p>
                            </td>
                            <td class="border p-4">
                                <p>{{ $invoice->total_booking_amount ?? 0 }}</p>
                            </td>
                            <td class="border p-4">
                                <p>{{ $total_paid_amount ?? 0 }}</p>
                            </td>
                            <td class="border p-4">
                                <p>{{ ($invoice->total_booking_amount ?? 0) - ($total_paid_amount ?? 0) }}</p>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        <div class="overflow-x-auto mt-5 grid grid-cols-2 gap-4" id="borderChargesTable">
            <table style="">
                <thead>
                    <tr>
                        <th class="border p-4">Border Name</th>
                        <th class="border p-4">Border Charges</th>
                    </tr>
                </thead>
                <tbody id="borderChargesData">
                    @php
                        $seprateBorderCharges = json_decode($invoice->seprate_border_charge, true);
                    @endphp
                    @foreach ($borders as $border)
                        @if (array_key_exists($border->id, $seprateBorderCharges))
                            <tr>
                                <td class="border p-4">{{ $border->border_name }}</td>
                                <td class="border p-4">{{ $seprateBorderCharges[$border->id] }}</td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>

            </table>

            <div class=" p-6 rounded-lg shadow-lg">
                <div class="mb-4">
                    <h2 class="text-xl font-semibold text-gray-800">Origin City:</h2>
                    <p class="text-lg text-gray-600 mt-2">
                        <?php
                        $origin_city_data = $booking->getCityDetail($booking->origin_city) ?? 'N/A';
                        $origin_country = $booking->getCountryByCity($origin_city_data->country_id) ?? 'N/A';
                        ?>
                        {{ $origin_city_data->city_name . '(' . $origin_country->name . ')' }}
                    </p>
                </div>
                <div class="mb-4">
                    <?php
                    $destination_city_data = $booking->getCityDetail($booking->destination_city) ?? 'N/A';
                    $destination_country = $booking->getCountryByCity($destination_city_data->country_id) ?? 'N/A';
                    ?>
                    <h2 class="text-xl font-semibold text-gray-800">Destination City:</h2>
                    <p class="text-lg text-gray-600 mt-2">
                        {{ $destination_city_data->city_name . '(' . $destination_country->name . ')' }}
                    </p>
                </div>
            </div>

        </div>
        @if ($invoice->document->whereNotNull('hand_over')->count() > 0)
            <h2 class="h2 text-bold">Handover Documents</h2>
            @php $handoverIndex = 1; @endphp <!-- Initialize index variable -->
            @foreach ($invoice->document as $document)
                @if ($document->hand_over)
                    <div>
                        <a class="btn btn-primary" style="max-width: 120px; margin-top: 5px;"
                            href="{{ asset('/public' . $document->hand_over) }}" download>Handover
                            {{ $handoverIndex }}</a>
                    </div>
                    @php $handoverIndex++; @endphp <!-- Increment index -->
                @endif
            @endforeach
        @endif

        @if ($invoice->document->whereNotNull('border_receipt')->count() > 0)
            <h2 class="h2 text-bold">Border Receipt Documents</h2>
            @php $receiptIndex = 1; @endphp <!-- Initialize index variable -->
            @foreach ($invoice->document as $document)
                @if ($document->border_receipt)
                    <div>
                        <a class="btn btn-primary" style="max-width: 120px; margin-top: 5px;"
                            href="{{ asset('/public' . $document->border_receipt) }}" download>Receipt
                            {{ $receiptIndex }}</a>
                    </div>
                    @php $receiptIndex++; @endphp <!-- Increment index -->
                @endif
            @endforeach
        @endif
    </div>
</x-layout.default>
