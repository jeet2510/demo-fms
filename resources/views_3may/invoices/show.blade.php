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
                   <p>{{$invoice->route->route}}</p>

                </div>
            </div>

            <div class="grid grid-cols-3 gap-4">
                <div class="mb-4">
                    <label for="customer_id" class="block text-gray-700">Customer</label>
                    <p>{{ $invoice->customer->company_name }}</p>
                </div>

                <div class="mb-4">
                    <label for="transporter_id" class="block text-gray-700">Transporter</label>
                   <p>{{ optional($invoice->transporter)->transporter_name }}</p>
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
                            <th class="border p-4">Buying Amount </th>
                            <th class="border p-4">Waiting Amount </th>
                            <th class="border p-4">Paid Amount</th>
                            <th class="border p-4">Border Charges </th>
                            <th class="border p-4">Total </th>
                        </tr>
                    </thead>
                    <tbody id="driverData">
                         @if ($invoice->driver_id)
                    {{-- {{dd($invoice->driver_id)}} --}}
                    @php
                    $buyingAmounts = json_decode($invoice->semi_buying_amount);
                    $borderCharges = json_decode($invoice->semi_border_charges);
                    $waitingAmount = json_decode($invoice->semi_waiting_amount);
                    $totalBookingAmounts = json_decode($invoice->booking->semi_total_booking_amount);
                    $paidAmount = json_decode($invoice->paid_amount);

                    preg_match_all('/\d+/', $invoice->driver_id, $matches);
                    $driverIds = array_map('intval', $matches[0]);
                    $drivers = \App\Models\Driver::whereIn('id', $driverIds)->get();
                @endphp

    {{-- {{dd($drivers, $driverIds)}} --}}
                        @foreach ($drivers as $driverIndex => $driver)
                                    <tr>
                                        <td class="border p-4">{{ $driver->driver_name }}</td>
                                        <td class="border p-4">{{ $driver->passport_expiry_date }}</td>
                                        <td class="border p-4">{{ $driver->id_card_expiry_date }}</td>
                                        <td class="border p-4">{{ $driver->driving_license_number }}</td>
                                        <td class="border p-4">{{ $driver->driving_license_expiry_date }}</td>
                                        <td class="border p-4">
                                            <p>{{ isset($buyingAmounts[$driverIndex]) ? $buyingAmounts[$driverIndex] : 0 }}</p>
                                        </td>
										 <td class="border p-4">
                                            <p>{{ isset($waitingAmount[$driverIndex]) ? $waitingAmount[$driverIndex] : 0 }}</p>
                                        </td>
                                        <td class="border p-4">
                                            <p>{{ isset($paidAmounts[$driver->id]) ? $paidAmounts[$driver->id] : 0 }}</p>
                                        </td>
                                        <td class="border p-4">
                                             <p>{{ isset($borderCharges[$driverIndex]) ? $borderCharges[$driverIndex] : 0 }} </p>
                                        </td>
                                        <td colspan="2" class="border p-4">
                                            <p>{{ isset($totalBookingAmounts[$driverIndex]) ? $totalBookingAmounts[$driverIndex] : 0 }} </p>
                                        </td>
                                    </tr>

                            @endforeach

						 @endif
                    </tbody>
                </table>
            </div>
            <div class="overflow-x-auto hidden" id="borderChargesTable">
                <table>
                    <thead>
                        <tr>
                            <th class="border p-4">Border Name</th>
                            <th class="border p-4">Border Charges</th>
                        </tr>
                    </thead>
                    <tbody id="borderChargesData">
                    </tbody>
                </table>
            </div>
            <div class="grid grid-cols-4 gap-4">
                <div class="mb-4">
                    <label for="buying_amount" class="block text-gray-700">Buying Amount</label>
                    <p>{{ $invoice->buying_amount }}</p>
                </div>
                <div class="mb-4">
                    <label for="buying_amount" class="block text-gray-700">Waiting Amount</label>
                    <p>{{ $invoice->waiting_amount }}</p>
                </div>
                <div class="mb-4">
                    <label for="border_charges" class="block text-gray-700">Border Charges</label>
                    <p>{{ $invoice->border_charges }}</p>
                </div>

                <div class="mb-4">
                    <label for="total_booking_amount" class="block text-gray-700">Total Booking Amount</label>
                   <p>{{ $invoice->total_booking_amount }}</p>
                </div>
            </div>
  <h2>Border Receipt Documents</h2>
  
  @foreach ($invoice->document as $document)
  <div>
      <embed src="{{ asset('/public/' . $document->border_receipt) }}" type="application/pdf" style="width: 250px; height: 250px;">
  </div>
  @endforeach
    </div>
</x-layout.default>
