<div style="max-height: 550px; overflow-y: auto;">
    <form id="driverForm" action="{{ route('drivers.store') }}" class="ajax-form" enctype="multipart/form-data"
        method="post">
        @csrf
        <div class="mx-auto">
            <div class="">
                <div class="h-auto overflow-y-auto">
                    <!-- Driver Section -->
                    <div class="grid grid-cols-4 gap-4">
                        <!-- Driver Fields -->
                        <div class="col-span-1">
                            <label for="driver_name" class="block">Driver Name:</label>
                            <input type="text" id="driver_name" class="form-input" name="driver_name" required>
                        </div>
                        <div class="col-span-1">
                            <label for="email" class="block">Email:</label>
                            <input type="email" id="email" class="form-input" name="email">
                        </div>
                        <div class="col-span-1">
                            <label for="phone_number" class="block">Phone Number:</label>
                            <input type="text" id="phone_number" class="form-input" name="phone_number" required>
                        </div>
                        <div class="col-span-1">
                            <label for="whatsapp_number" class="block">WhatsApp Number:</label>
                            <input type="text" id="whatsapp_number" class="form-input" name="whatsapp_number"
                                required>
                        </div>
                        <div class="col-span-1">
                            <label for="address_1" class="block">Address 1:</label>
                            <input type="text" id="address_1" class="form-input" name="address_1">
                        </div>
                        <div class="col-span-1">
                            <label for="address_2" class="block">Address 2:</label>
                            <input type="text" id="address_2" class="form-input" name="address_2">
                        </div>
                        <div class="col-span-1">
                            <label for="country" class="block">Country:</label>
                            <input type="text" id="country" class="form-input" name="country">
                        </div>
                        <div class="col-span-1">
                            <label for="state" class="block">State:</label>
                            <input type="text" id="state" class="form-input" name="state">
                        </div>
                        <div class="col-span-1">
                            <label for="city" class="block">City:</label>
                            <input type="text" id="city" class="form-input" name="city">
                        </div>
                        <div class="col-span-1">
                            <label for="driving_license_number" class="block">Driving License Number:</label>
                            <input type="text" id="driving_license_number" class="form-input"
                                name="driving_license_number" required>
                        </div>
                        <div class="col-span-1">
                            <label for="driving_license_expiry_date" class="block">Driving License Expiry Date:</label>
                            <input type="date" id="driving_license_expiry_date" class="form-input"
                                name="driving_license_expiry_date" required>
                        </div>
                        <div class="col-span-1">
                            <label for="driving_license" class="block">Driving License:</label>
                            <input type="file" id="driving_license" class="form-input" name="driving_license">
                        </div>
                    </div>

                    <!-- Truck Section -->
                    <div class="grid grid-cols-4 gap-4 mt-4">
                        <!-- Truck Fields -->
                        <div class="col-span-1">
                            <label for="truck_number" class="block">Truck Number(Mulkiya):</label>
                            <input type="text" id="truck_number" class="form-input" name="truck_number" required>
                        </div>
                        <div class="col-span-1">
                            <label for="truck_type_id" class="block">Truck Type(Mulkiya):</label>
                            <select id="truck_type_id" class="form-input" name="truck_type_id" required>
                                <option value="">Select Truck Type</option>
                                @foreach ($trucks as $truck)
                                    <option value="{{ $truck->id }}">{{ $truck->truck_type }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-span-1">
                            <label for="truck_expiry_date" class="block">Truck Expiry Date(Mulkiya):</label>
                            <input type="date" id="truck_expiry_date" class="form-input" name="truck_expiry_date"
                                required>
                        </div>
                        <div class="col-span-1">
                            <label for="truck_document" class="block">Truck Document(Mulkiya):</label>
                            <input type="file" id="truck_document" class="form-input" name="truck_document">
                        </div>
                    </div>

                    <!-- ID Card Section -->
                    <div class="grid grid-cols-4 gap-4 mt-4">
                        <!-- ID Card Fields -->
                        <div class="col-span-1">
                            <label for="id_card_number" class="block">Emirates ID Card Number:</label>
                            <input type="text" id="id_card_number" class="form-input" name="id_card_number"
                                required>
                        </div>
                        <div class="col-span-1">
                            <label for="id_card_expiry_date" class="block">Emirates ID Card Expiry Date:</label>
                            <input type="date" id="id_card_expiry_date" class="form-input"
                                name="id_card_expiry_date" required>
                        </div>
                        <div class="col-span-1">
                            <label for="id_card" class="block">Emirates ID Card:</label>
                            <input type="file" id="id_card" class="form-input" name="id_card">
                        </div>
                    </div>

                    <!-- Passport Section -->
                    <div class="grid grid-cols-4 gap-4 mt-4">
                        <!-- Passport Fields -->
                        <div class="col-span-1">
                            <label for="passport_number" class="block">Passport Number:</label>
                            <input type="text" id="passport_number" class="form-input" name="passport_number"
                                required>
                        </div>
                        <div class="col-span-1">
                            <label for="passport_expiry_date" class="block">Passport Expiry Date:</label>
                            <input type="date" id="passport_expiry_date" class="form-input"
                                name="passport_expiry_date" required>
                        </div>
                        <div class="col-span-1">
                            <label for="passport" class="block">Passport:</label>
                            <input type="file" id="passport" class="form-input" name="passport">
                        </div>
                    </div>
                    <div class="grid grid-cols-4 gap-4 mt-4">
                        <!-- Truck Fields -->
                        <div class="col-span-1">
                            <label for="driver_all_documents" class="block">Driver All Documents:</label>
                            <input type="file" id="driver_all_documents" class="form-input"
                                name="driver_all_documents">
                        </div>
                    </div>
                    <!-- Submit Button -->
                    <div class="mt-6">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    document.getElementById('driverForm').addEventListener('submit', function(event) {
        event.preventDefault();

        // Validate fields
        var driverName = document.getElementById('driver_name').value;
        var email = document.getElementById('email').value;
        var phoneNumber = document.getElementById('phone_number').value;
        var whatsappNumber = document.getElementById('whatsapp_number').value;
        var address1 = document.getElementById('address_1').value;
        var truckNumber = document.getElementById('truck_number').value;
        var drivingLicenseNumber = document.getElementById('driving_license_number').value;
        var drivingLicenseExpiryDate = document.getElementById('driving_license_expiry_date').value;
        var idCardNumber = document.getElementById('id_card_number').value;
        var idCardExpiryDate = document.getElementById('id_card_expiry_date').value;
        var passportNumber = document.getElementById('passport_number').value;
        var passportExpiryDate = document.getElementById('passport_expiry_date').value;

        // Check if required fields are empty
        if (!driverName || !phoneNumber || !whatsappNumber || !truckNumber || !drivingLicenseNumber ||
            // if (!driverName || !email || !phoneNumber || !whatsappNumber || !truckNumber || !drivingLicenseNumber ||
            !drivingLicenseExpiryDate || !idCardNumber || !idCardExpiryDate || !passportNumber || !
            passportExpiryDate) {
            alert('Please fill in all required fields.');
            return;
        }


        // Validate truck document file type
        var truckDocument = document.getElementById('truck_document');
        if (truckDocument.files.length > 0) {
            var allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/svg+xml',
                'application/pdf'
            ];
            var isValidType = allowedTypes.includes(truckDocument.files[0].type);
            if (!isValidType) {
                alert('The truck document must be a file of type: jpeg, png, jpg, gif, svg, pdf.');
                return;
            }
        }

        // Validate ID card file type
        var idCard = document.getElementById('id_card');
        if (idCard.files.length > 0) {
            var isValidType = allowedTypes.includes(idCard.files[0].type);
            if (!isValidType) {
                alert('The ID card must be a file of type: jpeg, png, jpg, gif, svg, pdf.');
                return;
            }
        }

        var passport = document.getElementById('passport');
        if (passport.files.length > 0) {
            var isValidType = allowedTypes.includes(passport.files[0].type);
            if (!isValidType) {
                alert('The passport must be a file of type: jpeg, png, jpg, gif, svg, pdf.');
                return;
            }
        }

        var drivingLicense = document.getElementById('driving_license');
        if (drivingLicense.files.length > 0) {
            var isValidType = allowedTypes.includes(drivingLicense.files[0].type);
            if (!isValidType) {
                alert('The driving license must be a file of type: jpeg, png, jpg, gif, svg, pdf.');
                return;
            }
        }

        var allDocument = document.getElementById('driver_all_documents');
        if (allDocument.files.length > 0) {
            var allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/svg+xml',
                'application/pdf'
            ];
            var isValidType = allowedTypes.includes(allDocument.files[0].type);
            if (!isValidType) {
                alert('The All Document must be a file of type: jpeg, png, jpg, gif, svg, pdf.');
                return;
            }
        }

        this.submit();
    });
</script>
{{-- <script src="/assets/js/ajax-function.js"></script> --}}
