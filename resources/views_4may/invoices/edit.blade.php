<x-layout.default>

    <style>
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

        <form action="{{ route('invoices.invoiceStore') }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('POST')

            <div class="grid grid-cols-3 gap-4">
                <div class="mb-4">
                    <label for="booking_id" class="block text-gray-700">Booking ID</label>
                    <input type="text" name="booking_id" id="booking_id" value="{{ $booking->booking_id }}"
                        class="form-select mt-1 block w-full" required readonly>
                </div>

                <div class="mb-4">
                    <label for="date" class="block text-gray-700">Date</label>
                    <input type="date" name="date" id="date" class="form-select mt-1 block w-full"
                        value="{{ $booking->date }}" required>
                </div>

                <div class="mb-4">
                    <label for="route_id" class="block text-gray-700">Route</label>
                    <input type="hidden" id="route_id" name="route_id" class="form-input mt-1 block w-full"
                        value="{{ $booking->route_id }}" readonly>
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
                    <input type="hidden" id="customer_id" name="customer_id" class="form-input mt-1 block w-full"
                        value="{{ $booking->customer_id }}" readonly>
                    <input type="text" class="form-input mt-1 block w-full"
                        value="{{ $booking->customer->company_name }}" readonly>
                </div>

                <div class="mb-4">
                    <label for="receiver_id" class="block text-gray-700">Receiver</label>
                    <input type="hidden" id="receiver_id" name="receiver_id" class="form-input mt-1 block w-full"
                        value="{{ $booking->receiver_id }}" readonly>
                    <input type="text" class="form-input mt-1 block w-full"
                        value="{{ $booking->client->company_name }}" readonly>
                </div>

                <div class="mb-4">
                    <label for="receiver_id" class="block text-gray-700">Transporter</label>
                    <input type="hidden" id="transporter_id" name="receiver_id" class="form-input mt-1 block w-full"
                        value="{{ $booking->receiver_id }}" readonly>
                    <input type="text" class="form-input mt-1 block w-full"
                        value="{{ optional($booking->transporter)->transporter_name }}" readonly>
                </div>
            </div>

            {{-- <select name="driver_id[]" id="driver_id" class="form-select mt-1 block w-full" multiple>
                @if ($booking->driver_ids)
                    @foreach ($drivers as $driver)
                        @if (in_array($driver->id, $booking->driver_ids))
                            <option value="{{ $driver->id }}" selected>{{ $driver->driver_name }}</option>
                        @else
                            <option value="{{ $driver->id }}">{{ $driver->driver_name }}</option>
                        @endif
                    @endforeach
                @else
                    <option value="" selected>Select Driver</option>
                    @foreach ($drivers as $driver)
                        <option value="{{ $driver->id }}">{{ $driver->driver_name }}</option>
                    @endforeach
                @endif
            </select> --}}

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
                            <th class="border p-4">Border Charges </th>
                            <th class="border p-4">Total </th>
                        </tr>
                    </thead>
                    <tbody id="driverData">
                        @php
                            $driverIds = explode(',', $booking->driver_id);
                            $buyingAmounts = json_decode($booking->semi_buying_amount);
                            $waitingAmount = json_decode($booking->semi_waiting_amount);
                            $borderCharges = json_decode($booking->semi_border_charges);
                            $totalBookingAmounts = json_decode($booking->semi_total_booking_amount);
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
                                            <input type="number" style="width: 100px;" name="semi_buying_amount[]"
                                                onchange="recalculateTotal()"
                                                class="semi_buying_amount form-input mt-1 block w-full"
                                                value="{{ isset($buyingAmounts[$driverIndex]) ? $buyingAmounts[$driverIndex] : 0 }}"
                                                required>
                                        </td>
                                        <td class="border p-4">
                                            <input type="text" style="width: 100px;" name="semi_waiting_amount[]"
                                                onchange="recalculateTotal()"
                                                class="semi_waiting_amount form-input mt-1 block w-full"
                                                value="{{ isset($waitingAmount[$driverIndex]) ? $waitingAmount[$driverIndex] : 0 }}"
                                                required>
                                        </td>

                                        <td class="border p-4">
                                            <input type="text" style="width: 100px;" name="semi_border_charges[]"
                                                onchange="recalculateTotal()"
                                                class="semi_border_charges form-input mt-1 block w-full"
                                                value="{{ isset($borderCharges[$driverIndex]) ? $borderCharges[$driverIndex] : 0 }}"
                                                readonly>
                                        </td>
                                        <td colspan="2" class="border p-4">
                                            <input type="number" style="width: 7rem;" onchange="recalculateTotal()"
                                                name="semi_total_booking_amount[]"
                                                class="semi_total_booking_amount form-input mt-1 block w-full"
                                                value="{{ isset($totalBookingAmounts[$driverIndex]) ? $totalBookingAmounts[$driverIndex] : 0 }}"
                                                required readonly>
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
                    <label for="buying_amount" class="block text-gray-700" readonly>Buying Amount</label>
                    <input type="text" name="buying_amount" id="buying_amount"
                        class="form-input mt-1 block w-full" value="{{ $booking->buying_amount }}" readonly>
                </div>

                <div class="mb-4">
                    <label for="border_charges" class="block text-gray-700">Border Charges</label>
                    <input type="text" name="border_charges" id="border_charges"
                        class="form-input mt-1 block w-full" value="{{ $booking->border_charges }}" readonly>
                </div>

                <div class="mb-4">
                    <label for="waiting_amount" class="block text-gray-700" readonly>Waiting Amount</label>
                    <input type="text" name="waiting_amount" id="waiting_amount"
                        class="form-input mt-1 block w-full" value="0" readonly>
                </div>

                <div class="mb-4">
                    <label for="hand_over" class="block text-gray-700">Hand Over Documents:</label>
                    <input type="file" id="hand_over" class="form-input mt-1 block w-full" name="hand_over[]"
                        multiple required>
                </div>

                <div class="mb-4">
                    <label for="border_receipt" class="block text-gray-700">Border Receipt Documents:</label>
                    <input type="file" id="border_receipt" class="form-input mt-1 block w-full"
                        name="border_receipt[]" multiple required>
                </div>


                <div class="mb-4">
                    <label for="total_booking_amount" class="block text-gray-700">Total Booking Amount</label>
                    <input type="text" name="total_booking_amount" id="total_booking_amount"
                        class="form-input mt-1 block w-full" value="{{ $booking->total_booking_amount }}" required
                        readonly>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Generate Invoice</button>
        </form>
    </div>
    @include('bookings.modals')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
        function recalculateTotal() {
            let totalBookingAmount = 0;
            const buyingAmountInputs = document.querySelectorAll('.semi_buying_amount');
            const semiWaitingAmountInputs = document.querySelectorAll('.semi_waiting_amount');
            const borderChargesInputs = document.querySelectorAll('.semi_border_charges');
            let buyingAmount = 0;
            let semiWaitingAmount = 0;
            let borderCharges = 0;

            buyingAmountInputs.forEach(input => {
                let singleBuyingAmount = parseFloat(input.value) || 0;
                buyingAmount += singleBuyingAmount;
            });

            semiWaitingAmountInputs.forEach(input => {
                let singleWaitingAmount = parseFloat(input.value) || 0;
                semiWaitingAmount += singleWaitingAmount;
            });

            borderChargesInputs.forEach(input => {
                let singleBorderCharges = parseFloat(input.value) || 0;
                borderCharges += singleBorderCharges;
            });

            totalBookingAmount = buyingAmount + borderCharges + semiWaitingAmount;

            const rows = document.querySelectorAll('.semi_total_booking_amount');
            rows.forEach(row => {
                let singleBuyingAmount = parseFloat(row.closest('tr').querySelector('.semi_buying_amount').value) ||
                    0;
                let singleWaitingAmount = parseFloat(row.closest('tr').querySelector('.semi_waiting_amount')
                    .value) || 0;
                let singleBorderCharges = parseFloat(row.closest('tr').querySelector('.semi_border_charges')
                    .value) || 0;
                row.value = (singleBuyingAmount + singleBorderCharges + singleWaitingAmount).toFixed(2);
            });

            document.getElementById('buying_amount').value = buyingAmount.toFixed(2);
            document.getElementById('waiting_amount').value = semiWaitingAmount.toFixed(2);
            document.getElementById('border_charges').value = borderCharges.toFixed(2);
            document.getElementById('total_booking_amount').value = totalBookingAmount.toFixed(2);

            document.addEventListener('DOMContentLoaded', function() {
                const semiInputs = document.querySelectorAll(
                    '.semi_buying_amount, .semi_waiting_amount, .semi_border_charges');
                semiInputs.forEach(input => {
                    input.addEventListener('input', recalculateTotal);
                });
            });
        }
    </script>

    <script>
        $(document).ready(function() {
            $('#driver_id').change(function() {
                var selectedDrivers = $(this).val();

                if (selectedDrivers && selectedDrivers.length > 0) {
                    // Clear previous data in the table
                    $('#driverData').html('');

                    // Iterate over each selected driver
                    selectedDrivers.forEach(function(driverId) {
                        $.ajax({
                            type: 'GET',
                            url: '/get-driver-details/' + driverId,
                            success: function(data) {
                                if (data.success) {
                                    var driverData = data.driver;

                                    // Append driver details to the table
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
                                            driverId + '>Upload</button>' :
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
                                            driverId + '>Upload</button>' :
                                            '') + '</td>' +
                                        '<td class="border p-4"><input type="number" style="width: 68px;" name="semi_buying_amount[]" onchange="recalculateTotal()" class="semi_buying_amount form-input mt-1 block w-full" value="0" required></td>' +
                                        '<td class="border p-4"><input type="number" style="width: 68px;" name="semi_waiting_amount[]" onchange="recalculateTotal()" class="semi_waiting_amount form-input mt-1 block w-full" value="0" required></td>' +
                                        '<td class="border p-4"><input type="text" style="width: 69px;" name="semi_border_charges[]" onchange="recalculateTotal()" class="semi_border_charges form-input mt-1 block w-full" value="0" readonly></td>' +
                                        '<td colspan="2" class="border p-4"><input type="number" style="width: 7rem;" onchange="recalculateTotal()" name="semi_total_booking_amount[]" class="semi_total_booking_amount form-input mt-1 block w-full" value="0" required readonly></td>' +
                                        '</tr>');

                                    $('#driverData').append(row);

                                    // Event listeners for changes in semi_buying_amount and semi_border_charges
                                    row.find(
                                            '.semi_buying_amount, .semi_border_charges , .waiting_amount'
                                        )
                                        .on('input', function() {
                                            var buyingAmount = parseFloat($(row)
                                                .find('.semi_buying_amount')
                                                .val()) || 0;
                                            var borderCharges = parseFloat($(row)
                                                .find('.semi_border_charges')
                                                .val()) || 0;
                                            var borderCharges = parseFloat($(row)
                                                .find('.waiting_amount')
                                                .val()) || 0;
                                            var totalBookingAmount = buyingAmount +
                                                borderCharges;
                                            $(row).find(
                                                    '.semi_total_booking_amount')
                                                .val(totalBookingAmount);
                                        });
                                } else {
                                    // Handle case when data is not found
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
                var inputValue = parseFloat(borderChargeInputs[i].value) || 0;
                borderChargeInputs[i].value = inputValue.toFixed(2);
                borderTotal += inputValue;
            }
            semiBorderChargesInputs = borderTotal;

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

            const bookingDetails = @json($booking);
            let borderCharges = bookingDetails.seprate_border_charge;

            if (borderCharges) {
                borderCharges = JSON.parse(borderCharges);
            }
            loadBorderCharges();
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
                                inputElement.name = `seprate_border_charge[${borderId}]`;
                                // Set the border charge value from the booking details
                                inputElement.value = borderCharges[borderId] || border.border_charges;
                                inputElement.classList.add('border-charge-input', 'form-input');
                                cell2.appendChild(inputElement);
                                inputElement.addEventListener('change', function() {
                                    recalculateBorderCharges();
                                });
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
            const semiInputs = document.querySelectorAll(
                '.semi_buying_amount, .waiting_amount, .semi_border_charges');
            semiInputs.forEach(input => {
                input.addEventListener('input', updateTotalBookingAmount);
            });

            function updateTotalBookingAmount() {
                let totalBookingAmount = 0;
                const semiBuyingAmountInputs = document.querySelectorAll('.semi_buying_amount');
                const waitingAmount = document.querySelectorAll('.waiting_amount');
                const semiBorderChargesInputs = document.querySelectorAll('.semi_border_charges');
                semiBuyingAmountInputs.forEach(input => {
                    const buyingAmount = parseFloat(input.value) || 0;
                    const waitingAmount = parseFloat(input.value) || 0;
                    const borderCharges = parseFloat(input.nextElementSibling.value) || 0;
                    totalBookingAmount += buyingAmount + borderCharges + waitingAmount;
                });

                waitingAmount.forEach(input => {
                    const buyingAmount = parseFloat(input.value) || 0;
                    const waitingAmount = parseFloat(input.value) || 0;
                    const borderCharges = parseFloat(input.nextElementSibling.value) || 0;
                    totalBookingAmount += buyingAmount + borderCharges + waitingAmount;
                });

                semiBorderChargesInputs.forEach(input => {
                    const borderCharges = parseFloat(input.value) || 0;
                    const buyingAmount = parseFloat(input.previousElementSibling.value) || 0;
                    totalBookingAmount += buyingAmount + borderCharges + waitingAmount;
                });
                document.getElementById('total_booking_amount').value = totalBookingAmount.toFixed(2);
            }


        });
    </script>
</x-layout.default>
