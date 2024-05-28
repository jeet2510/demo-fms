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

        .driver-name-container {
            display: flex;
            align-items: center;
        }

        .driver-name {
            flex-grow: 1;
        }

        .selected-options-wrapper {
            padding: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .selected-options-container {
            display: flex;
            flex-wrap: wrap;
        }

        .selected-option {
            background-color: #f3f4f6;
            border: 1px solid #e5e7eb;
            border-radius: 0.375rem;
            padding: 0.25rem 0.5rem;
            margin-right: 0.5rem;
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
            color: #374151;
            display: flex;
            align-items: center;
        }

        .remove-option {
            background: none;
            border: none;
            color: #ef4444;
            margin-left: 0.5rem;
            cursor: pointer;
            font-size: 0.875rem;
        }

        .dropdown-option {
            padding: 0.5rem;
            cursor: pointer;
        }

        .dropdown-option:hover {
            background-color: #f3f4f6;
        }

        #addDriverBtn {
            margin-top: 1.75rem;
            /* Adjust based on the height of the input field */
            margin-left: 1.5rem;
            /* Add space between the field and the button */
        }

        #dropdownMenu {
            max-height: 200px;
            /* Adjust the maximum height as needed */
            overflow-y: auto;
        }
    </style>
    <link rel='stylesheet' type='text/css' href="http://127.0.0.1:8000/assets/css/select2.min.css">
    <link rel='stylesheet' type='text/css' href="http://127.0.0.1:8000/assets/css/nice-select2.css">

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
                <div class="mb-4 flex items-start">
                    <div class="flex-1">
                        <label for="driver_id" class="block text-gray-700">Driver</label>
                        <div class="relative">
                            <div id="selectedDrivers"
                                class="selected-options-wrapper form-input rounded-md shadow-sm mb-2 border border-gray-300 cursor-pointer w-full flex items-center justify-between"
                                onclick="toggleSelect()">
                                <div id="selectedDriversContainer" class="selected-options-container"
                                    placeholder="Select Driver"></div>
                                <svg id="dropdownIcon" class="w-5 h-5 ml-2 cursor-pointer" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                            <div id="dropdownMenu"
                                class="absolute bg-white border border-gray-300 rounded-md shadow-lg w-full mt-1"
                                style="display: none; max-height: 200px; overflow-y: auto;">
                                <input type="text" id="searchInput" class="form-input w-full px-3 py-2 mb-1"
                                    placeholder="Search...">
                                <div id="dropdownOptions">
                                    @foreach ($drivers as $driver)
                                        <div class="dropdown-option cursor-pointer px-4 py-2 hover:bg-gray-100"
                                            data-driver-id="{{ $driver->id }}"
                                            data-driver-name="{{ $driver->driver_name }}"
                                            data-driver-phone="{{ $driver->phone_number }}">
                                            {{ $driver->driver_name }}/{{ $driver->phone_number }}
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <select id="driver_id" name="driver_id[]" class="form-input select2" multiple
                                style="display: none;">
                                @foreach ($drivers as $driver)
                                    <option value="{{ $driver->id }}">
                                        {{ $driver->driver_name }}/{{ $driver->phone_number }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <button type="button" id="addDriverBtn" class="ml-6 mt-7 btn btn-primary text-sm"
                        style="width: 9rem;">Driver Details</button>
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
                            data-border-charges="{{ $route->border_charges() }}" id="route_id"
                            onchange="updateCitySelections(this.dataset.routeDetail)">
                            {{ $route->route }}
                        </option>
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
                <div class="grid grid-cols-4 gap-4">
                    <div class="mb-4">
                        <label for="origin_city" class="block text-gray-700">Origin City</label>
                        <select name="origin_city" id="origin_city" class="form-select mt-1 block w-full" required>
                            <option value="">Select Origin City</option>
                            <!-- Options will be populated dynamically -->
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="destination_city" class="block text-gray-700">Destination City</label>
                        <select name="destination_city" id="destination_city" class="form-select mt-1 block w-full"
                            required>
                            <option value="">Select Destination City</option>
                            <!-- Options will be populated dynamically -->
                        </select>
                    </div>
                </div>
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
    <link rel="stylesheet" href="http://127.0.0.1:8000/assets/css/highlight.min.css">
    <script src="http://127.0.0.1:8000/assets/js/highlight.min.js"></script>
    <script src="http://127.0.0.1:8000/assets/js/nice-select2.js"></script>
    <script src="http://127.0.0.1:8000/assets/js/select2.full.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->
    <!-- <script src="{{ asset('js/custom.js') }}"></script> -->

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
        function toggleSelect() {
            const dropdownMenu = document.getElementById('dropdownMenu');
            dropdownMenu.style.display = dropdownMenu.style.display === 'none' ? 'block' : 'none';
        }

        function closeDropdown() {
            const dropdownMenu = document.getElementById('dropdownMenu');
            dropdownMenu.style.display = 'none';
        }

        document.addEventListener('DOMContentLoaded', function() {
            const select = document.getElementById('driver_id');
            const selectedDriversContainer = document.getElementById('selectedDriversContainer');
            const dropdownMenu = document.getElementById('dropdownMenu');
            const driversTable = document.getElementById('driversTable');
            const searchInput = document.getElementById('searchInput');
            const dropdownOptions = document.getElementById('dropdownOptions').querySelectorAll('.dropdown-option');
            const addDriverBtn = document.getElementById('addDriverBtn');

            dropdownMenu.addEventListener('click', function(event) {
                if (event.target.classList.contains('dropdown-option')) {
                    const driverId = event.target.getAttribute('data-driver-id');
                    const option = select.querySelector(`option[value="${driverId}"]`);
                    option.selected = !option.selected;
                    updateSelectedOptions();
                }
            });

            addDriverBtn.addEventListener('click', function() {
                closeDropdown();
            });

            searchInput.addEventListener('input', function() {
                const searchTerm = searchInput.value.toLowerCase();
                dropdownOptions.forEach(option => {
                    const optionText = option.textContent.toLowerCase();
                    if (optionText.includes(searchTerm)) {
                        option.style.display = 'block';
                    } else {
                        option.style.display = 'none';
                    }
                });
            });

            function updateSelectedOptions() {
                selectedDriversContainer.innerHTML = ''; // Clear previous selections

                Array.from(select.selectedOptions).forEach(option => {
                    const div = document.createElement('div');
                    div.textContent = option.textContent;
                    div.classList.add('selected-option');

                    const removeBtn = document.createElement('button');
                    removeBtn.textContent = '✖';
                    removeBtn.classList.add('remove-option');
                    removeBtn.onclick = function() {
                        option.selected = false;
                        updateSelectedOptions();
                        updateTable();
                    };

                    div.appendChild(removeBtn);
                    selectedDriversContainer.appendChild(div);
                });

                updateTable(); // Update table whenever options are updated
            }

            function updateTable() {
                const selectedDriverIds = Array.from(select.selectedOptions).map(option => option.value);
                const rows = driversTable.querySelectorAll('tbody tr');

                rows.forEach(row => {
                    const driverId = row.getAttribute('data-driver-id');
                    if (selectedDriverIds.includes(driverId)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            }

            updateSelectedOptions(); // Initialize the selected options container
        });
    </script>

    <script>
        $(document).ready(function() {
            // Function to fetch and display driver details with a delay
            function fetchAndDisplayDriverDetailsWithDelay(selectedDrivers, delay) {
                selectedDrivers = selectedDrivers || $('#driver_id').val() || [];
                // Clear the table before adding new rows
                $('#driverData').empty();

                if (selectedDrivers.length > 0) {
                    // Loop through each selected driver with a delay
                    selectedDrivers.forEach(function(driverId, index) {
                        setTimeout(function() {
                            // Fetch driver details via AJAX
                            $.ajax({
                                type: 'GET',
                                url: '{{ env('APP_URL') }}get-driver-details/' + driverId,
                                success: function(data) {
                                    if (data.success) {
                                        // Add row to table for each driver
                                        addRowToTable(data.driver);
                                    } else {
                                        console.log('Driver data not found');
                                    }
                                },
                                error: function(jqXHR, textStatus, errorThrown) {
                                    console.error('AJAX error:', errorThrown);
                                }
                            });
                        }, delay * index); // Delay between each driver's details
                    });
                    $('#selectedDriversTable').removeClass('hidden');
                } else {
                    $('#selectedDriversTable').addClass('hidden');
                }
            }

            // Add event listener for the "Add Driver" button
            $('#addDriverBtn').click(function() {
                console.log("Button clicked"); // Check if this message appears in the console
                var selectedDrivers = $('#driver_id').val();
                fetchAndDisplayDriverDetailsWithDelay(selectedDrivers, 250);
            });

            var selectedDriversTable = $('#driversTable');

            function updateSelectedOptions() {
                var selectedOptionsContainer = $('#selectedDriversContainer');
                selectedOptionsContainer.empty();

                var selectedDrivers = $('#driver_id').val() || [];
                selectedDrivers.forEach(function(driverId) {
                    var option = $('#driver_id option[value="' + driverId + '"]').text();
                    var div = $('<div>').addClass('selected-option').text(option);

                    var removeBtn = $('<button>').addClass('remove-option').text('✖').click(function() {
                        // Remove the selected option from the dropdown
                        $('#driver_id option[value="' + driverId + '"]').remove();
                        $('#driver_id').trigger('change');
                    });

                    div.append(removeBtn);
                    selectedOptionsContainer.append(div);
                });
            }

            function removeRowFromTable(driverId) {
                selectedDriversTable.find('tbody tr[data-driver-id="' + driverId + '"]').remove();
            }

            // Function to check if a date is expired
            function isDateExpired(dateString) {
                var date = new Date(dateString);
                var currentDate = new Date();
                return date < currentDate;
            }

            // Function to add row to table
            function addRowToTable(driverData) {
                var existingRow = $('#driverData').find('tr[data-driver-id="' + driverData.id + '"]');
                if (existingRow.length > 0) {
                    // If the row already exists, update the existing row with the new data
                    existingRow.find('.driver_name').text(driverData.driver_name);
                    existingRow.find('.passport_expiry_date').text(driverData.passport_expiry_date);
                    existingRow.find('.id_card_expiry_date').text(driverData.id_card_expiry_date);
                    existingRow.find('.driving_license_number').text(driverData.driving_license_number);
                    existingRow.find('.driving_license_expiry_date').text(driverData.driving_license_expiry_date);
                } else {
                    // Construct the row HTML
                    var row = $('<tr data-driver-id="' + driverData.id + '">' +
                        '<td class="border p-4">' + driverData.driver_name + '</td>' +
                        '<td class="border p-4' + (isDateExpired(driverData.passport_expiry_date) ?
                            ' expired-date' : '') + '">' + driverData.passport_expiry_date +
                        (isDateExpired(driverData.passport_expiry_date) ?
                            ' <button class="passport_upload-button" data-id="' + driverData.id +
                            '">Upload</button>' : '') + '</td>' +
                        '<td class="border p-4' + (isDateExpired(driverData.id_card_expiry_date) ?
                            ' expired-date' : '') + '">' + driverData.id_card_expiry_date +
                        (isDateExpired(driverData.id_card_expiry_date) ?
                            ' <button class="idcard_upload-button" data-id="' + driverData.id +
                            '">Upload</button>' : '') + '</td>' +
                        '<td class="border p-4">' + driverData.driving_license_number + '</td>' +
                        '<td class="border p-4' + (isDateExpired(driverData.driving_license_expiry_date) ?
                            ' expired-date' : '') + '">' + driverData.driving_license_expiry_date +
                        (isDateExpired(driverData.driving_license_expiry_date) ?
                            ' <button class="driver_upload-button" data-id="' + driverData.id +
                            '">Upload</button>' : '') + '</td>' +
                        '<td class="border p-4">' +
                        '<select name="transporter_id[]" id="transporter_id[]" style="width: 180px;" class="form-select select2 mt-1 block w-full" placeholder="Select Transporter" required>' +
                        '<option value="">Select Transporter</option>' +
                        '@foreach ($transporters as $transporter)' +
                        '<option value="{{ $transporter->id }}">{{ $transporter->transporter_name }}</option>' +
                        '@endforeach' +
                        '</select>' +
                        '</td>' +
                        '<td class="border p-4"><input type="number" style="width: 100px;" name="semi_buying_amount[]" onchange="recalculateTotal()" class="semi_buying_amount form-input mt-1 block w-full" value="0" required></td>' +
                        '<td class="border p-4"><input type="text" style="width: 100px;" name="semi_border_charges[]" onchange="recalculateTotal()" class="semi_border_charges form-input mt-1 block w-full" value="0" readonly></td>' +
                        '<td colspan="2" class="border p-4"><input type="number" style="width: 7rem;" onchange="recalculateTotal()" name="semi_total_booking_amount[]" class="semi_total_booking_amount form-input mt-1 block w-full" value="0" required readonly></td>' +
                        '</tr>');

                    // Append the row to the table
                    $('#driverData').append(row);
                    $('#selectedDriversTable').removeClass('hidden');
                }
            }

            // Add event listener for the "Add Driver" button
            // $('#addDriverBtn').click(function() {
            //     var selectedDrivers = $('#driver_id').val();
            //     fetchAndDisplayDriverDetails(selectedDrivers);
            // });

            // Add event listener for the select change event
            $('#driver_id').on('change', function() {
                var selectedDrivers = $(this).val() || [];
                var previouslySelectedDrivers = $(this).data('previouslySelected') || [];
                var deselectedDrivers = $(previouslySelectedDrivers).not(selectedDrivers).get();
                var newlySelectedDrivers = $(selectedDrivers).not(previouslySelectedDrivers).get();
                $(this).data('previouslySelected', selectedDrivers);

                // Fetch and display driver details for newly selected drivers
                fetchAndDisplayDriverDetails(newlySelectedDrivers);

                // Remove rows from the table for deselected drivers
                deselectedDrivers.forEach(function(driverId) {
                    removeRowFromTable(driverId);
                });

                // Update the selected options display
                updateSelectedOptions();
            });

            // Initialize the selected options container
            updateSelectedOptions();
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
            // Remove this line if not needed\\\
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
                const routeDetails = JSON.parse(selectedRoute.getAttribute(
                    'data-route-detail'));
                let borderIds = routeDetails.border_id.split(',');
                const borderCharges = routeDetails.border_charges;
                routeTbodyElement.innerHTML = '';
                updateCitySelections(routeDetails);
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
                            inputElement.classList.add('border-charge-input',
                                'form-input');
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

        function updateCitySelections(routeDetails) {
            const originCitySelect = document.getElementById('origin_city');
            const destinationCitySelect = document.getElementById('destination_city');
            const cityList = @json($cities);
            originCitySelect.innerHTML = '<option value="">Select Origin City</option>';
            destinationCitySelect.innerHTML = '<option value="">Select Destination City</option>';

            cityList.forEach(city => {
                if (city.country_id == routeDetails.origin_city_id) {
                    const originOption = document.createElement('option');
                    originOption.value = city.id;
                    originOption.text = city.city_name;

                    originCitySelect.appendChild(originOption);
                }

                if (city.country_id == routeDetails.destination_city_id) {
                    const destinationOption = document.createElement('option');
                    destinationOption.value = city.id;
                    destinationOption.text = city.city_name;

                    destinationCitySelect.appendChild(destinationOption);
                }
            });
        }


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
    <script></script>
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
