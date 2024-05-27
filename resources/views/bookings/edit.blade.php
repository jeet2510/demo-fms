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

        .password_upload-button {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 5px;
        }

        .idcard_upload-button {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 5px;
        }

        .driver_upload-button {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 5px;
        }
    </style>

    <div class="container">

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('bookings.update', $booking->id) }}" method="post">
            @csrf
            @method('PUT')



            <div class="grid grid-cols-3 gap-4">
                <div class="mb-4">
                    <label for="booking_id" class="block text-gray-700">Booking ID</label>
                    <input type="text" name="booking_id" id="booking_id" value="{{ $booking->booking_id }}"
                        class="form-select mt-1 block w-full" required readonly>
                </div>

                <div class="mb-4">
                    <label for="date" class="block text-gray-700">Date</label>
                    <input type="date" name="date" id="date" class="form-select mt-1 block w-full"
                        value="{{ $booking->date }}" required disabled>
                </div>

                <div class="mb-4">
                    <label for="route_id" class="block text-gray-700">Route</label>
                    <select name="route_id" id="route_id" class="form-select mt-1 block w-full" disabled>
                        <option value="">Select Route</option>
                        @foreach ($routes as $route)
                            <option value="{{ $route->id }}" {{ $booking->route_id == $route->id ? 'selected' : '' }}
                                data-border-charges="{{ $route->border->border_charges ?? 0 }}"
                                data-route-detail="{{ $route }}">{{ $route->route }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-4">
                <div class="mb-4">
                    <label for="customer_id" class="block text-gray-700">Customer</label>
                    <select name="customer_id" id="customer_id" class="form-select mt-1 block w-full" disabled>
                        <option value="">Select Customer</option>
                        @foreach ($customers as $customer)
                            <option value="{{ $customer->id }}"
                                {{ $booking->customer_id == $customer->id ? 'selected' : '' }}>
                                {{ $customer->company_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="transporter_id" class="block text-gray-700">Transporter</label>
                    <select name="transporter_id" id="transporter_id" class="form-select mt-1 block w-full" disabled>
                        <option value="">Select Transporter</option>
                        @foreach ($transporters as $transporter)
                            <option value="{{ $transporter->id }}"
                                {{ $booking->transporter_id == $transporter->id ? 'selected' : '' }}>
                                {{ $transporter->transporter_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-4">
                    <label for="receiver_id" class="block text-gray-700">Receiver</label>
                    <select name="receiver_id" id="receiver_id" class="form-select mt-1 block w-full" disabled>
                        <option value="">Select Receiver</option>
                        @foreach ($clients as $receiver)
                            <option value="{{ $receiver->id }}"
                                {{ $booking->receiver_id == $receiver->id ? 'selected' : '' }}>
                                {{ $receiver->company_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            @php
                // Extract numbers from the string using regular expression
                preg_match_all('/\d+/', $booking->driver_id, $matches);
                $selectedDriverIds = !empty($matches[0]) ? $matches[0] : [];
            @endphp

            <select name="driver_id[]" id="driver_id" class="form-select mt-1 block w-full" style="display: none;"
                multiple disabled>
                @foreach ($drivers as $driver)
                    @if (in_array($driver->id, $selectedDriverIds))
                        <option value="{{ $driver->id }}" selected>{{ $driver->driver_name }}</option>
                    @else
                        <option value="{{ $driver->id }}">{{ $driver->driver_name }}</option>
                    @endif
                @endforeach
            </select>

            <div class="overflow-x-auto">
                <table id="selectedDriversTable" class="mt-5">
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
                            <th class="border p-4">Total </th>
                            <th class="border p-4">Advance /Paid Amount </th>
                        </tr>
                    </thead>
                    <tbody id="driverData">
                        @php
                            $driverIds = explode(',', $booking->driver_id);
                            $buyingAmounts = json_decode($booking->semi_buying_amount);
                            $borderCharges = json_decode($booking->semi_border_charges);
                            $totalBookingAmounts = json_decode($booking->semi_total_booking_amount);
                            $transporterIds = json_decode($booking->transporter_id);
                        @endphp

                        @foreach ($driverIds as $driverIndex => $driverId)
                            @foreach ($drivers as $driver)
                                @if ($driver->id == $driverId)
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
                                            @if (Auth::user()->type == 0)
                                                <input type="number" style="width: 100px;" name="semi_buying_amount[]"
                                                    onchange="recalculateTotal()"
                                                    class="semi_buying_amount form-input mt-1 block w-full"
                                                    value="{{ isset($buyingAmounts[$driverIndex]) ? $buyingAmounts[$driverIndex] : 0 }}"
                                                    required>
                                            @else
                                                <input type="number" style="width: 100px;" name="semi_buying_amount[]"
                                                    onchange="recalculateTotal()"
                                                    class="semi_buying_amount form-input mt-1 block w-full"
                                                    value="{{ isset($buyingAmounts[$driverIndex]) ? $buyingAmounts[$driverIndex] : 0 }}"
                                                    required readonly>
                                            @endif
                                        </td>

                                        <td class="border p-4">
                                            @if (Auth::user()->type == 0)
                                                <input type="text" style="width: 100px;" name="semi_border_charges[]"
                                                    onchange="recalculateTotal()"
                                                    class="semi_border_charges form-input mt-1 block w-full"
                                                    value="{{ isset($borderCharges[$driverIndex]) ? $borderCharges[$driverIndex] : 0 }}">
                                            @else
                                                <input type="text" style="width: 100px;"
                                                    name="semi_border_charges[]" onchange="recalculateTotal()"
                                                    class="semi_border_charges form-input mt-1 block w-full"
                                                    value="{{ isset($borderCharges[$driverIndex]) ? $borderCharges[$driverIndex] : 0 }}"
                                                    readonly>
                                            @endif
                                        </td>
                                        <td colspan="" class="border p-4">
                                            <input type="number" style="width: 7rem;" onchange="recalculateTotal()"
                                                name="semi_total_booking_amount[]"
                                                class="semi_total_booking_amount form-input mt-1 block w-full"
                                                value="{{ isset($totalBookingAmounts[$driverIndex]) ? $totalBookingAmounts[$driverIndex] : 0 }}"
                                                required readonly>
                                        </td>
                                        <td class="border p-4">
                                            @if ($transactions && $transactions->count() > 0)
                                                @php
                                                    $driver_ids = $transactions->driver_id;
                                                    $driver_ids = explode(',', $driver_ids);

                                                    $paid_amount = $transactions->paid_amount;
                                                    $paid_amount = explode(',', $paid_amount);

                                                @endphp

                                                {{ $paid_amount[$driverIndex] }}
                                            @else
                                                0
                                            @endif
                                        </td>

                                    </tr>
                                @endif
                            @endforeach
                        @endforeach
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

            <div class="grid grid-cols-3 gap-4">
                <div class="mb-4">
                    <label for="buying_amount" class="block text-gray-700">Buying Amount</label>
                    <input type="text" name="buying_amount" id="buying_amount"
                        class="form-input mt-1 block w-full" value="{{ $booking->buying_amount }}" readonly>
                </div>

                <div class="mb-4">
                    <label for="border_charges" class="block text-gray-700">Border Charges</label>
                    <input type="text" name="border_charges" id="border_charges"
                        class="form-input mt-1 block w-full" value="{{ $booking->border_charges }}" readonly>
                </div>

                <div class="mb-4">
                    <label for="total_booking_amount" class="block text-gray-700">Total Booking Amount</label>
                    <input type="text" name="total_booking_amount" id="total_booking_amount"
                        class="form-input mt-1 block w-full" value="{{ $booking->total_booking_amount }}" required
                        readonly>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Update Booking</button>
        </form>
    </div>
    @include('bookings.modals')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
        function recalculateTotal() {
            let totalBookingAmount = 0;
            const buyingAmountInputs = document.querySelectorAll('.semi_buying_amount');
            const borderChargesInputs = document.querySelectorAll('.semi_border_charges');
            let buyingAmount = 0;
            let borderCharges = 0;

            buyingAmountInputs.forEach(input => {
                let singleBuyingAmount = parseFloat(input.value) || 0;
                buyingAmount += singleBuyingAmount;
            });

            borderChargesInputs.forEach(input => {
                let singleBorderCharges = parseFloat(input.value) || 0;
                borderCharges += singleBorderCharges;
            });

            totalBookingAmount = buyingAmount + borderCharges;

            const rows = document.querySelectorAll('.semi_total_booking_amount');
            rows.forEach(row => {
                let singleBuyingAmount = parseFloat(row.closest('tr').querySelector('.semi_buying_amount').value) ||
                    0;
                let singleBorderCharges = parseFloat(row.closest('tr').querySelector('.semi_border_charges')
                    .value) || 0;
                row.value = (singleBuyingAmount + singleBorderCharges).toFixed(2);
            });

            document.getElementById('buying_amount').value = buyingAmount.toFixed(2);
            document.getElementById('border_charges').value = borderCharges.toFixed(2);
            document.getElementById('total_booking_amount').value = totalBookingAmount.toFixed(2);
        }
    </script>

    <script>
        $(document).ready(function() {
            $('#driver_id').change(function() {
                var selectedDrivers = $(this).val();

                if (selectedDrivers && selectedDrivers.length > 0) {
                    $('#driverData').html('');

                    selectedDrivers.forEach(function(driverId) {
                        $.ajax({
                            type: 'GET',
                            url: '/get-driver-details/' + driverId,
                            success: function(data) {
                                if (data.success) {
                                    var driverData = data.driver;

                                    var row = $('<tr>' +
                                        '<td class="border p-4">' + driverData
                                        .driver_name + '</td>' +
                                        '<td class="border p-4' + (isDateExpired(
                                                driverData.passport_expiry_date) ?
                                            ' expired-date' : '') + '">' +
                                        driverData.passport_expiry_date + (
                                            isDateExpired(driverData
                                                .passport_expiry_date) ?
                                            ' <button class="password_upload-button" data-id =' +
                                            driverId + ' >Upload</button>' :
                                            '') + '</td>' +
                                        '<td class="border p-4' + (isDateExpired(
                                                driverData.id_card_expiry_date) ?
                                            ' expired-date' : '') + '">' +
                                        driverData.id_card_expiry_date + (
                                            isDateExpired(driverData
                                                .id_card_expiry_date) ?
                                            ' <button class="idcard_upload-button" data-id =' +
                                            driverId + ' >Upload</button>' :
                                            '') + '</td>' +
                                        '<td class="border p-4">' + driverData
                                        .driving_license_number + '</td>' +
                                        '<td class="border p-4' + (isDateExpired(
                                                driverData
                                                .driving_license_expiry_date) ?
                                            ' expired-date' : '') + '">' +
                                        driverData.driving_license_expiry_date + (
                                            isDateExpired(driverData
                                                .driving_license_expiry_date) ?
                                            ' <button class="driver_upload-button" data-id =' +
                                            driverId + ' >Upload</button>' :
                                            '') + '</td>' +
                                        '<td class="border p-4"><input type="number" style="width: 68px;" name="semi_buying_amount[]" onchange="recalculateTotal()" class="semi_buying_amount form-input mt-1 block w-full" value="0" required></td>' +
                                        '<td class="border p-4"><input type="text" style="width: 69px;" name="semi_border_charges[]" onchange="recalculateTotal()" class="semi_border_charges form-input mt-1 block w-full" value="0" readonly></td>' +
                                        '<td colspan="2" class="border p-4"><input type="number" style="width: 7rem;" onchange="recalculateTotal()" name="semi_total_booking_amount[]" class="semi_total_booking_amount form-input mt-1 block w-full" value="0" required readonly></td>' +
                                        '</tr>');

                                    $('#driverData').append(row);
                                    row.find(
                                            '.semi_buying_amount, .semi_border_charges')
                                        .on('input', function() {
                                            var buyingAmount = parseFloat($(row)
                                                .find('.semi_buying_amount')
                                                .val()) || 0;
                                            var borderCharges = parseFloat($(row)
                                                .find('.semi_border_charges')
                                                .val()) || 0;
                                            var totalBookingAmount = buyingAmount +
                                                borderCharges;
                                            $(row).find(
                                                    '.semi_total_booking_amount')
                                                .val(totalBookingAmount);
                                        });
                                } else {
                                    $('#driverData').append(
                                        '<tr><td colspan="11">Driver data not found</td></tr>'
                                    );
                                }
                            }
                        });
                    });
                } else {
                    $('#driverData').html('');
                }
            });

            function isDateExpired(dateString) {
                var date = new Date(dateString);
                var currentDate = new Date();
                return date < currentDate;
            }


            function isDateExpired(dateString) {
                var date = new Date(dateString);
                var currentDate = new Date();
                return date < currentDate;
            }

        });

        function recalculateBorderCharges() {
            var borderChargeInputs = document.getElementsByClassName('border-charge-input');
            let borderTotal = 0;
            for (var i = 0; i < borderChargeInputs.length; i++) {
                // Update the value of each input element to ensure consistency
                var inputValue = parseFloat(borderChargeInputs[i].value) || 0;
                borderChargeInputs[i].value = inputValue.toFixed(2);
                borderTotal += inputValue;
            }
            // Remove this line if not needed
            semiBorderChargesInputs = borderTotal;

            // Loop through each input with the class semi_border_charges and set their value to 2 decimal places
            var semiBorderChargesInputElements = document.querySelectorAll('.semi_border_charges');
            semiBorderChargesInputElements.forEach(function(semiBorderChargesInput) {
                semiBorderChargesInput.value = borderTotal.toFixed(2);
            });
            recalculateTotal();
        }
        document.addEventListener("DOMContentLoaded", function() {

            const selectElement = document.getElementById('driver_id');
            const driversTableElement = document.getElementById('selectedDriversTable');
            const driversTbodyElement = driversTableElement.querySelector('tbody');
            const routeTableElement = document.getElementById('borderChargesTable');
            const routeTbodyElement = routeTableElement.querySelector('tbody');
            const borders = @json($borders);
            selectElement.addEventListener('change', function() {
                const selectedDrivers = Array.from(this.selectedOptions);
                driversTbodyElement.innerHTML = '';

                if (selectedDrivers.length > 0) {
                    driversTableElement.classList.remove('hidden');
                    selectedDrivers.forEach(driver => {
                        fetchData(driver.value);
                    });
                } else {
                    driversTableElement.classList.add('hidden');
                }
            });

            function fetchData(driverId) {
                fetch('/get-driver-details/' + driverId)
                    .then(response => response.json())
                    .then(data => {
                        const row = document.createElement('tr');
                        const cell = document.createElement('td');
                        cell.textContent = data.driver_name;
                        row.appendChild(cell);
                        driversTbodyElement.appendChild(row);
                    })
                    .catch(error => console.error('Error fetching data:', error));
            }

            const bookingDetails = @json($booking);
            let borderCharges = bookingDetails.seprate_border_charge;

            if (borderCharges) {
                borderCharges = JSON.parse(borderCharges);
            }
            loadBorderCharges();
            document.getElementById('route_id').addEventListener('change', function() {
                borderCharges = {};
                loadBorderCharges();
            });

            function loadBorderCharges() {


                const selectedRoute = document.getElementById('route_id').value;
                if (selectedRoute) {
                    const routeDetails = JSON.parse(document.querySelector('#route_id [value="' + selectedRoute +
                        '"]').getAttribute('data-route-detail'));
                    let borderIds = routeDetails.border_id.split(',');
                    routeTbodyElement.innerHTML = '';
                    if (borderIds && borderIds.length > 0) {
                        routeTableElement.classList.remove('hidden');
                        borderIds.forEach(borderId => {
                            const border = getBorderDetails(borderId);
                            if (border) {
                                const row = document.createElement('tr');
                                const cell1 = document.createElement('td');
                                const cell2 = document.createElement('td');
                                cell1.textContent = border.border_name;

                                const inputElement = document.createElement('input');
                                inputElement.type = 'text';
                                inputElement.name = `separate_border_charge[${borderId}]`;
                                inputElement.value = borderCharges[borderId] || border.border_charges;
                                inputElement.classList.add('border-charge-input', 'form-input');
                                cell2.appendChild(inputElement);

                                if ("{{ Auth::user()->type }}" === "0") {
                                    inputElement.addEventListener('change', function() {
                                        recalculateBorderCharges();
                                    });
                                } else {
                                    inputElement.setAttribute('readonly', true);
                                }

                                row.appendChild(cell1);
                                row.appendChild(cell2);
                                routeTbodyElement.appendChild(row);
                            }
                        });
                    } else {
                        routeTableElement.classList.add('hidden');
                    }
                }
            }

            function getBorderDetails(borderId) {
                for (let i = 0; i < borders.length; i++) {
                    if (borders[i].id == borderId) {
                        return borders[i];
                    }
                }
                return null;
            }

            document.getElementById('route_id').addEventListener('change', function() {
                var selectedRoute = this.options[this.selectedIndex];
                var borderCharges = selectedRoute.getAttribute('data-border-charges');
                var borderChargeInputs = document.getElementsByClassName('semi_border_charges');
                for (var i = 0; i < borderChargeInputs.length; i++) {
                    borderChargeInputs[i].value = borderCharges;
                }
            });
        });

        window.addEventListener('load', function() {
            const semiInputs = document.querySelectorAll('.semi_buying_amount, .semi_border_charges');
            semiInputs.forEach(input => {
                input.addEventListener('input', updateTotalBookingAmount);
            });

            function updateTotalBookingAmount() {
                let totalBookingAmount = 0;
                const semiBuyingAmountInputs = document.querySelectorAll('.semi_buying_amount');
                const semiBorderChargesInputs = document.querySelectorAll('.semi_border_charges');
                semiBuyingAmountInputs.forEach(input => {
                    const buyingAmount = parseFloat(input.value) || 0;
                    const borderCharges = parseFloat(input.nextElementSibling.value) || 0;
                    totalBookingAmount += buyingAmount + borderCharges;
                });
                semiBorderChargesInputs.forEach(input => {
                    const borderCharges = parseFloat(input.value) || 0;
                    const buyingAmount = parseFloat(input.previousElementSibling.value) || 0;
                    totalBookingAmount += buyingAmount + borderCharges;
                });
                document.getElementById('total_booking_amount').value = totalBookingAmount.toFixed(2);
            }


        });
    </script>
</x-layout.default>
