<x-layout.default>
    <link rel="stylesheet"
        href="https://cdn.datatables.net/v/dt/jqc-1.12.4/dt-1.13.6/b-2.4.2/sl-1.7.0/datatables.min.css" />
    <link rel="stylesheet" href="Editor-2.2.2/css/editor.dataTables.css">

    <script src="https://cdn.datatables.net/v/dt/jqc-1.12.4/dt-1.13.6/b-2.4.2/sl-1.7.0/datatables.min.js"></script>
    <script src="Editor-2.2.2/js/dataTables.editor.js"></script>

    <script>
        $(document).ready(function() {
            $('#company-table').DataTable();
        });
    </script>
    <!-- forms grid -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <style>
        .container_table {
            width: 100%;
            overflow-x: auto;
            white-space: nowrap;
        }

        .alert-danger {
            color: red;
        }

        .alert-success {
            color: #5CB85C;
        }
    </style>
    <form action="{{ route('transactions.store') }}" method="post">
        @csrf
        <div class="grid mt-4 grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="mr-5">
                <label for="routename">Transaction Id</label>
                <input id="transactionid" name="transaction_id" type="text" placeholder="Enter Transaction Id"
                    class="form-input" required value="{{ 'TRANSACTION-' . time() . '-' . uniqid() }}">
            </div>
            <div class="mr-5">
                <label for="routename">Select Booking ID</label>
                <select name="booking_id" id="booking_id" class="form-select mt-1 block w-full">
                    <option value="">Select Booking ID</option>
                    @foreach ($bookings as $booking)
                        <option value="{{ $booking->id }}">{{ $booking->booking_id }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="grid mt-4 grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="routename">Date</label>
                <input id="date" type="date" name="date" placeholder="--/--/--" class="form-input" required
                    value="<?php echo date('Y-m-d'); ?>">
            </div>
            <div>
                <label for="routename">Route Name</label>
                <input id="routename" type="text" name="route_name" placeholder="Enter Route Name" class="form-input"
                    required="" readonly="" value="">
            </div>
        </div>
        <div class="grid mt-4 grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="routename">Origin</label>
                <input name="origin" placeholder="Enter Origin" class="form-input text-white-dark" required=""
                    readonly="" value="">
            </div>
            <div>
                <label for="routename">Destination</label>
                <input name="destination" placeholder="Enter Destination" class="form-input text-white-dark"
                    required="" readonly="" value="">
            </div>
        </div>
        <div class="mt-5 mb-5">
            <table class="min-w-full bg-white border border-gray-200" style="max-width: 90%; margin-left: 5%;">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="py-2 px-4 border-b border-gray-200">Name</th>
                        <th class="py-2 px-4 border-b border-gray-200">Transporter Name</th>
                        <th class="py-2 px-4 border-b border-gray-200">Buying Amount</th>
                        <th class="py-2 px-4 border-b border-gray-200">Border Charges</th>
                        <th class="py-2 px-4 border-b border-gray-200">Waiting Amount</th>
                        <th class="py-2 px-4 border-b border-gray-200">Total Amount</th>
                        <th class="py-2 px-4 border-b border-gray-200">Advacne / Paid Amount</th>
                        <th class="py-2 px-4 border-b border-gray-200">Balance</th>
                        <th class="py-2 px-4 border-b border-gray-200">Amount</th>
                    </tr>
                </thead>
                <tbody id="driverData" class="form-input">
                    @php
                        $driverIds = explode(',', $booking->driver_id);
                        $buyingAmounts = json_decode($booking->semi_buying_amount);
                        $borderCharges = json_decode($booking->semi_border_charges);
                        $totalBookingAmounts = json_decode($booking->semi_total_booking_amount);
                    @endphp


                </tbody>
            </table>
        </div>
        <div class="mt-4">
            <div>
                <label for="routename">Payment Mode</label>
                <select name="mode" class="form-select text-white-dark" required="">
                    <option value="">Select payment mode</option>
                    <option value="cash">cash</option>
                    <option value="check">check</option>
                    <option value="wire">wire</option>
                </select>
                <div class="text-red-500 text-sm">Mode is required</div>
            </div>
        </div>
        <div class="mt-4">
            <div>
                <label for="routename">Cheque Number / Ref No</label>
                <input id="payable_ammount" type="text" name="cheque_number"
                    placeholder="Enter Cheque Number / ref No" class="form-input" value="">
                {{-- <div class="text-red-500 text-sm">Cheque Number is required</div> --}}
            </div>
        </div>
        <div class="flex justify-end items-center mt-8">
            <button type="button" id="cancelButton" class="btn btn-outline-danger">Cancel</button>
            <button type="submit" class="btn btn-primary ltr:ml-4 rtl:mr-4">Submit</button>
        </div>

    </form>

    <script>
        function removeCommas(value) {
            return value.replace(/,/g, '');
        }
    </script>
    <script>
        async function getBookingDriverTransporters(transporter_id) {
            try {
                let response = await $.ajax({
                    url: '/get-booking-driver-wise-transporter/' + transporter_id,
                    type: 'GET'
                });
                return response;
            } catch (error) {
                throw error;
            }
        }

        document.addEventListener("DOMContentLoaded", function() {

            const bookings = {!! json_encode($bookings) !!};
            const drivers = {!! json_encode($drivers) !!};
            const routes = {!! json_encode($routes) !!};
            const cities = {!! json_encode($city_list) !!};
            const driversTableBody = document.querySelector('#driverData');

            const bookingIdSelect = document.getElementById('booking_id');

            bookingIdSelect.addEventListener('change', async function() {
                const selectedBookingId = this.value;
                var selectedBooking = bookings.find(booking => booking.id === parseInt(
                    selectedBookingId));
                const transporterIds = selectedBooking.transporter_id;

                const amounts = selectedBooking.transactions[0]?.paid_amount || 0;
                const originCityId = selectedBooking ? selectedBooking.origin_city : '';
                const destinationCityId = selectedBooking ? selectedBooking.destination_city : '';
                if (selectedBooking.invoice != null) {
                    selectedBooking = selectedBooking.invoice;
                }
                if (selectedBooking) {
                    const routeId = parseInt(selectedBooking.route_id);
                    const route = routes.find(route => route.id === routeId);

                    const routeName = route ? route.route : '';
                    const originCity = cities.find(city => city.id === originCityId);
                    const destinationCity = cities.find(city => city.id === destinationCityId);
                    document.getElementById('routename').value = routeName;
                    document.getElementsByName('origin')[0].value = originCity.city_name;
                    document.getElementsByName('destination')[0].value = destinationCity.city_name;

                    driversTableBody.innerHTML = '';
                    const driverIds = selectedBooking.driver_id.split(',');

                    const selectedDrivers = [];

                    driverIds.forEach(driverId => {
                        // Remove double quotes from driverId and then parse it to an integer
                        const parsedDriverId = parseInt(driverId.replace(/"/g, '').trim());
                        if (!isNaN(parsedDriverId)) {
                            const driver = drivers.find(driver => driver.id === parsedDriverId);
                            if (driver) {
                                selectedDrivers.push(driver);
                            }
                        }
                    });

                    const buyingAmounts = JSON.parse(selectedBooking.semi_buying_amount);
                    const borderCharges = JSON.parse(selectedBooking.semi_border_charges);
                    let waitingAmounts = 0;
                    if (selectedBooking.semi_waiting_amount !== undefined) {
                        waitingAmounts = JSON.parse(selectedBooking.semi_waiting_amount);
                    }
                    const totalBookingAmounts = JSON.parse(selectedBooking.semi_total_booking_amount);

                    let paidAmount;
                    if (amounts != 0) {
                        paidAmount = amounts.split(',');
                    } else {
                        paidAmount = ['0'];
                    }

                    const extractedIds = transporterIds.match(/\d+/g);
                    const transporterIdArray = extractedIds.map(id => parseInt(id));
                    console.log(transporterIdArray);
                    const promises = [];
                    for (let [index, driver] of selectedDrivers.entries()) {
                        console.log(driver);
                        const transporterId = transporterIdArray[index];
                        console.log(`Driver: ${driver.id}, Transporter ID: ${transporterId}`);
                        promises.push(getBookingDriverTransporters(transporterId).then(
                            transporter_name => {
                                console.log(transporter_name);
                                const row = document.createElement('tr');
                                row.innerHTML = `
            <td class="border p-1" style="width:12px !important">${driver.driver_name}<input type="hidden" name="driver_id[]" value="${driver.id}"></td>
            <td class="border p-1" style="width:12px !important">${transporter_name}</td>
            <td class="border p-1" style="width:12px !important"><input type="number" step="0.01"  name="semi_buying_amount[]" onchange="recalculateTotal()" class="semi_buying_amount form-input mt-1 block w-full min-w-10" value="${buyingAmounts[index] || 0}" readonly></td>
            <td class="border p-1" style="width:12px !important"><input type="number" step="0.01"  name="semi_border_charges[]" onchange="recalculateTotal()" class="semi_border_charges form-input mt-1 block w-full min-w-10" value="${borderCharges[index] || 0}" readonly></td>
            <td class="border p-1" style="width:12px !important"><input type="number" step="0.01"  name="semi_waiting_amount[]" onchange="recalculateTotal()" class="semi_waitining_amount form-input mt-1 block w-full min-w-10" value="${waitingAmounts[index] || 0}" readonly></td>
            <td class="border p-1" style="width:12px !important"><input type="number" step="0.01"  onchange="recalculateTotal()" name="semi_total_booking_amount[]" class="semi_total_booking_amount form-input mt-1 block w-full min-w-10" value="${totalBookingAmounts[index] || 0}" readonly></td>
            <td class="border p-1" style="width:12px !important"><input type="number" step="0.01"  name="paid_amount[]" class="paid_amount form-input mt-1 block w-full min-w-10" value="${paidAmount[index] || 0}" readonly readonly></td>
            <td class="border p-1" style="width:12px !important"><input type="number" step="0.01"  name="balance_amount[]" class="balance_amount form-input mt-1 block w-full min-w-10" value="${parseFloat(totalBookingAmounts[index] || 0) - parseFloat(paidAmount[index] || 0)}" readonly></td>
            <td class="border p-1" style="width:12px !important">
                <input type="number" step="0.01"  name="amount[]" class="amount form-input mt-1 block w-full min-w-10" value="0" onchange="removeCommas(this.value); functionCall(this)" required>
                <span class="amount-error" style="color: red;"></span>
            </td>
        `;
                                driversTableBody.appendChild(row);
                            }).catch(error => {
                            console.error(error);
                        }));
                    }
                    await Promise.all(promises);
                } else {

                    document.getElementById('date').value = '';
                    document.getElementById('routename').value = '';
                    document.getElementsByName('origin')[0].value = '';
                    document.getElementsByName('destination')[0].value = '';
                    driversTableBody.innerHTML = '';
                }
            });

        });

        function functionCall(inputField) {
            const row = inputField.closest('tr');
            const balanceAmount = parseFloat(row.querySelector('[name="balance_amount[]"]').value);
            let enteredAmount = parseFloat(inputField.value);
            const errorMessage = row.querySelector('.amount-error');
            if (enteredAmount > balanceAmount) {
                enteredAmount = balanceAmount;
                inputField.value = enteredAmount;
                errorMessage.textContent = "Amount should be ≤ " + balanceAmount;
            } else {
                errorMessage.textContent = "";
            }
        }
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const cancelButton = document.getElementById('cancelButton');

            cancelButton.addEventListener('click', function() {
                const modal = document.getElementById('myModal');
                modal.remove();
            });
        });
    </script>
    <script src="/assets/js/ajax-function.js"></script>
</x-layout.default>
