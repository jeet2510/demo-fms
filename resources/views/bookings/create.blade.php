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
    <link rel='stylesheet' type='text/css' href="{{ asset('resources/css/select2.min.css') }}">
    <link rel='stylesheet' type='text/css' href="{{ asset('resources/css/nice-select2.css') }}">

    <div class="container mx-auto">
        <form action="{{ route('bookings.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-2 gap-4">
                <div class="mb-4">
                    <label for="booking_id" class="block text-gray-700">Booking ID</label>
                    <input type="text" name="booking_id" id="booking_id"
                        value="BOOK-{{ time() }}-{{ mt_rand(100, 999) }}" class="form-select mt-1 block w-full"
                        required readonly>
                </div>

                <div class="mb-4">
                    <label for="date" class="block text-gray-700">Date</label>
                    <input type="date" name="date" id="date" class="form-select mt-1 block w-full" required>
                </div>

            </div>

            <div class="grid grid-cols-2 gap-4">

                <div class="mb-4">
                    <label for="customer_id" class="block text-gray-700">Customer</label>
                    <select name="customer_id" id="customer_id" class="form-select mt-1 block w-full" required>
                        <option value="">Select Customer</option>
                        @foreach ($customers as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->company_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="receiver_id" class="block text-gray-700">Receiver</label>
                    <select name="receiver_id" id="receiver_id" class="form-select mt-1 block w-full" required>
                        <option value="">Select Receiver</option>
                        @foreach ($clients as $receiver)
                            <option value="{{ $receiver->id }}">{{ $receiver->company_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
          <div class="grid grid-cols-2 gap-4">

          
			 <div class="mb-4">
                <label for="driver_id" class="block text-gray-700">Driver</label>
                <select name="driver_id[]" id="driver_id" class="form-select mt-1 block w-full" placeholder="Select Driver"multiple="multiple">
                     @foreach ($drivers as $driver)
                        <option value="{{ $driver->id }}">{{ $driver->driver_name }}/{{ $driver->phone_number }}</option>
                    @endforeach
                </select>
			
            </div>
</div>



            <div class="overflow-x-auto">
                <table id="selectedDriversTable" class="hidden">
                    <thead>
                        <tr>
                            <th class="border p-4">Driver Name</th>
                            {{-- <th class="border p-4">Passport</th> --}}
                            <th class="border p-4">Passport EXPIRE AT:</th>
                            {{-- <th class="border p-4">ID Card</th> --}}
                            <th class="border p-4">ID Card EXPIRE AT:</th>
                            <th class="border p-4">Driver License</th>
                            <th class="border p-4">Driver License EXPIRE AT:</th>
                            {{-- <th class="border p-4">Truck Documents</th> --}}
                            {{-- <th class="border p-4">Vehicle Documents EXPIRE AT:</th> --}}
                            <th class="border p-4">Transporter:</th>
							 <th class="border p-4">Buying Amount </th>
                            {{-- <th class="border p-4">Waiting Amount </th> --}}
                            <th class="border p-4">Border Charges </th>
                            <th class="border p-4">Total </th>
                        </tr>
                    </thead>
                    <tbody id="driverData">

                    </tbody>
                </table>
            </div>

            <br>
            <br>
            <div class="mb-4">
                <label for="route_id" class="block text-gray-700">Route</label>
                <select name="route_id" id="route_id" class="form-select mt-1 block w-full">
                    <option value="">Select Route</option>
                    @foreach ($routes as $route)
                        <option value="{{ $route->id }}" data-route-detail="{{ $route }}"
                            data-border-charges="{{ $route->border_charges() }}" id="route_id">
                            {{ $route->route }}</option>
                    @endforeach
                </select>
            </div>

            <br>

            <div class="overflow-x-auto">
                <table id="borderChargesTable" class="hidden w-1/2">
                    <thead>
                        <tr>
                            <th class="border p-4">Border Name</th>
                            <th class="border p-4">Charges</th>
                        </tr>
                    </thead>
                    <tbody id="borderChargesData">

                    </tbody>
                </table>
            </div>

            <div class="grid grid-cols-4 gap-4">

                <div class="mb-4">
                    <label for="buying_amount" class="block text-gray-700">Buying Amount</label>
                    <input type="text" readonly name="buying_amount" id="buying_amount"
                        class="form-input mt-1 block w-full">
                </div>

                <div class="mb-4">
                    <label for="border_charges" class="block text-gray-700">Border Charges</label>
                    <input type="text" readonly name="border_charges" id="border_charges"
                        class="form-input mt-1 block w-full">
                </div>

                <div class="mb-4">
                    <label for="total_booking_amount" class="block text-gray-700">Total Booking Amount</label>
                    <input type="text" readonly name="total_booking_amount" id="total_booking_amount"
                        class="form-input mt-1 block w-full" required>
                </div>

            </div>
            <div class="mt-6">
                <button type="submit" class="btn btn-primary">
                    Submit
                </button>
            </div>
        </form>
    </div>
    @include('bookings.modals')
    <link rel="stylesheet" href="{{ asset('resources/css/highlight.min.css') }}">
    <script src="{{env('APP_URL')}}/assets/js/highlight.min.js"></script>
    <script src="{{env('APP_URL')}}/assets/js/nice-select2.js"></script>
    <script src="{{env('APP_URL')}}/assets/js/select2.full.min.js"></script>
    <script>
        $('.select2').select2();
        // seachable
        $(".select2").select2({
            placeholder: 'Select Transporter',
            tags: true
        });

        document.addEventListener("DOMContentLoaded", function(e) {
            // default
            var els = document.querySelectorAll(".driver_id");
            els.forEach(function(select) {
                NiceSelect.bind(select);
            });

            // seachable
            var options = {
                searchable: true
            };
            NiceSelect.bind(document.getElementById("driver_id"), options);
        });

        document.addEventListener("alpine:init", () => {
            Alpine.data("form", () => ({

                // highlightjs
                codeArr: [],
                toggleCode(name) {
                    if (this.codeArr.includes(name)) {
                        this.codeArr = this.codeArr.filter((d) => d != name);
                    } else {
                        this.codeArr.push(name);

                        setTimeout(() => {
                            document.querySelectorAll('pre.code').forEach(el => {
                                hljs.highlightElement(el);
                            });
                        });
                    }
                }
            }));
        });
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    {{-- <script src="{{ asset('js/custom.js') }}"></script> --}}

    <script>
        // Define the recalculateTotal function in the global scope
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

            // Set the individual total for each row
            const rows = document.querySelectorAll('.semi_total_booking_amount');
            rows.forEach(row => {
                let singleBuyingAmount = parseFloat(row.closest('tr').querySelector('.semi_buying_amount').value) ||
                    0;
                let singleBorderCharges = parseFloat(row.closest('tr').querySelector('.semi_border_charges')
                    .value) || 0;
                row.value = (singleBuyingAmount + singleBorderCharges).toFixed(2);
            });

            // Update total amounts
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
                    // Clear previous data in the table
                    $('#driverData').html('');

                    // Iterate over each selected driver
                    selectedDrivers.forEach(function(driverId) {
                        $.ajax({
                            type: 'GET',
                             url: '{{env('APP_URL')}}get-driver-details/' + driverId,
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
                                            driverId + '>Upload</button>' :
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
                                            '') + '</td><td>' +
                                       '<select name="transporter_id[]" id="transporter_id[]" style="width: 180px;" class="form-select select2 mt-1 block w-full" placeholder="Select Transporter" required>'+
                                             '<option value="" >Select Transporter</option>' +
					                      @foreach ($transporters as $transporter)
                               '<option value="{{ $transporter->id }}">{{ $transporter->transporter_name }}</option>'+
                                         @endforeach  
										 '</select></td>'  +
               
                                        '<td class="border p-4"><input type="number" style="width: 100px;" name="semi_buying_amount[]" onchange="recalculateTotal()" class="semi_buying_amount form-input mt-1 block w-full" value="0" required></td>' +
                                        '<td class="border p-4"><input type="text" style="width: 100px;" name="semi_border_charges[]" onchange="recalculateTotal()" class="semi_border_charges form-input mt-1 block w-full" value="0" readonly></td>' +
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
                                    // Handle case when data is not found
                                    $('#driverData').append(
                                        '<tr><td colspan="11">Driver data not found</td></tr>'
                                    );
                                }
                            }
                        });
                    });
                } else {
                    // Clear the table if no drivers are selected
                    $('#driverData').html('');
                }
            });

            // Function to check if a date is expired
            function isDateExpired(dateString) {
                var date = new Date(dateString);
                var currentDate = new Date();
                return date < currentDate;
            }


            // Function to check if a date is expired
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

            document.getElementById('route_id').addEventListener('change', function() {
                const selectedRoute = this.options[this.selectedIndex];
                const routeDetails = JSON.parse(selectedRoute.getAttribute('data-route-detail'));
                let borderIds = routeDetails.border_id.split(',');
                const borderCharges = routeDetails.border_charges;
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
                            inputElement.name = `seprate_border_charge[${borderId}]`;
                            inputElement.type = 'text';
                            inputElement.value = border.border_charges;
                            inputElement.classList.add('border-charge-input', 'form-input');
                            // inputElement.setAttribute('name', 'border_charge');
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
            });

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
    <script>
        // Get today's date
        var today = new Date();

        // Format the date to YYYY-MM-DD (required by input type="date")
        var yyyy = today.getFullYear();
        var mm = String(today.getMonth() + 1).padStart(2, '0'); // January is 0!
        var dd = String(today.getDate()).padStart(2, '0');
        var formattedDate = yyyy + '-' + mm + '-' + dd;

        // Set the input field value to today's date
        document.getElementById('date').value = formattedDate;
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById('bookingForm').addEventListener('submit', function(event) {
                event.preventDefault();

                // Validate fields
                var bookingId = document.getElementById('booking_id').value;
                var date = document.getElementById('date').value;
                var customerId = document.getElementById('customer_id').value;
                var receiverId = document.getElementById('receiver_id').value;
                var transporterId = document.getElementById('transporter_id').value;
                var driverIds = document.getElementById('driver_id').value;
                var routeId = document.getElementById('route_id').value;
                var buyingAmount = document.getElementById('buying_amount').value;
                var borderCharges = document.getElementById('border_charges').value;
                var totalBookingAmount = document.getElementById('total_booking_amount').value;

                if (!bookingId || !date || !customerId || !receiverId || !transporterId || !driverIds || !
                    routeId || !buyingAmount || !borderCharges || !totalBookingAmount) {
                    alert('Please fill in all fields.');
                    return;
                }

                // Validate buying amount, border charges, and total booking amount to be numeric
                if (isNaN(parseFloat(buyingAmount)) || isNaN(parseFloat(borderCharges)) || isNaN(parseFloat(
                        totalBookingAmount))) {
                    alert('Buying amount, border charges, and total booking amount must be numeric.');
                    return;
                }

                // If all validations pass, submit the form
                this.submit();
            });
        });
    </script>
</x-layout.default>
