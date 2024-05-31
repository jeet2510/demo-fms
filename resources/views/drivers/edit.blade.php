<x-layout.default>

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
        <form action="{{ route('drivers.update', $driver->id) }}" enctype="multipart/form-data" method="post"
            class="grid grid-cols-5 gap-4">
            @csrf
            @method('PUT')

            <h1 style="font-size: large;">Driver Information</h1>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>
                    <label for="driver_name">Driver Name:</label>
                    <input type="text" class="form-input" id="driver_name" name="driver_name"
                        value="{{ $driver->driver_name }}">
                </div>

                <div>
                    <label for="email">Email:</label>
                    <input type="email" class="form-input" id="email" name="email" value="{{ $driver->email }}">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="phone_number">Phone Number:</label>
                    <input type="text" class="form-input" id="phone_number" name="phone_number"
                        value="{{ $driver->phone_number }}">
                </div>

                <div>
                    <label for="whatsapp_number">WhatsApp Number:</label>
                    <input type="text" class="form-input" id="whatsapp_number" name="whatsapp_number"
                        value="{{ $driver->whatsapp_number }}">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>
                    <label for="address_1">Address 1:</label>
                    <input type="text" class="form-input" id="address_1" name="address_1"
                        value="{{ $driver->address_1 }}">
                </div>

                <div>
                    <label for="address_2">Address 2:</label>
                    <input type="text" class="form-input" id="address_2" name="address_2"
                        value="{{ $driver->address_2 }}">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                <div>
                    <label for="country">Country:</label>
                    <input type="text" class="form-input" id="country" name="country"
                        value="{{ $driver->country }}">
                </div>

                <div>
                    <label for="state">State:</label>
                    <input type="text" class="form-input" id="state" name="state" value="{{ $driver->state }}">
                </div>

                <div>
                    <label for="city">City:</label>
                    <input type="text" class="form-input" id="city" name="city" value="{{ $driver->city }}">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>
                    <label for="driving_license_number">Driving License Number:</label>
                    <input type="text" class="form-input" id="driving_license_number" name="driving_license_number"
                        value="{{ $driver->driving_license_number }}">
                </div>

                <div>
                    <label for="driving_license_expiry_date">Driving License Expiry Date:</label>
                    <input type="date" class="form-input" id="driving_license_expiry_date"
                        name="driving_license_expiry_date" value="{{ $driver->driving_license_expiry_date }}">
                </div>
            </div>


            <div>
                <label for="driving_license">Driving License:</label>
                <span class="grey">Do not Upload if not wanted to update</span>
                <input type="file" class="form-input" id="driving_license" name="driving_license">
                @if ($driver->driving_license)
                    <div>
                        <a href="{{ asset('public/' . $driver->driving_license) }}" download class="btn btn-primary"
                            style="max-width: 80px; margin-top: 10px;">Download</a>
                    </div>
                @endif
            </div><br>

            <h1 style="font-size: large;">Truck Information</h1>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>
                    <label for="truck_type_id">Truck Type(Mulkiya):</label>
                    <select id="truck_type_id" class="form-input" name="truck_type_id">
                        <option value="">Select Truck Type</option>
                        @foreach ($trucks as $truckType)
                            <option value="{{ $truckType->id }}"
                                {{ $driver->truck_type_id == $truckType->id ? 'selected' : '' }}>
                                {{ $truckType->truck_type }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="truck_number">Truck Number(Mulkiya):</label>
                    <input type="text" class="form-input" id="truck_number" name="truck_number"
                        value="{{ $driver->truck_number }}">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>
                    <label for="truck_expiry_date">Truck Expiry Date(Mulkiya):</label>
                    <input type="date" class="form-input" id="truck_expiry_date" name="truck_expiry_date"
                        value="{{ $driver->truck_expiry_date }}">
                </div>


                <div>
                    <label for="truck_document">Truck Document(Mulkiya):</label>
                    <span class="grey">Do not Upload if not wanted to update</span>
                    <input type="file" class="form-input" id="truck_document" name="truck_document">
                    @if ($driver->truck_document)
                        <div>

                            <a href="{{ asset('public/' . $driver->truck_document) }}" download
                                class="btn btn-primary" style="max-width: 80px; margin-top: 10px;">Download</a>
                        </div>
                    @endif
                </div>
            </div><br>

            <h1 style="font-size: large;">ID Card Information</h1>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>
                    <label for="id_card_number">Emirates ID Card Number:</label>
                    <input type="text" class="form-input" id="id_card_number" name="id_card_number"
                        value="{{ $driver->id_card_number }}">
                </div>

                <div>
                    <label for="id_card_expiry_date">Emirates ID Card Expiry Date:</label>
                    <input type="date" class="form-input" id="id_card_expiry_date" name="id_card_expiry_date"
                        value="{{ $driver->id_card_expiry_date }}">
                </div>
            </div>
            {{-- {{ dd($driver) }} --}}
            <div>
                <label for="id_card">Emirates ID Card:</label>
                <span class="grey">Do not Upload if not wanted to update</span>
                <input type="file" class="form-input" id="id_card" name="id_card">
                @if ($driver->id_card)
                    <div>

                        <a href="{{ asset('public/' . $driver->id_card) }}" download class="btn btn-primary"
                            style="max-width: 80px; margin-top: 10px;">Download</a>
                    </div>
                @endif
            </div><br>

            <h1 style="font-size: large;">Passport Information</h1>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <div>
                    <label for="passport_number">Passport Number:</label>
                    <input type="text" class="form-input" id="passport_number" name="passport_number"
                        value="{{ $driver->passport_number }}">
                </div>

                <div>
                    <label for="passport_expiry_date">Passport Expiry Date:</label>
                    <input type="date" class="form-input" id="passport_expiry_date" name="passport_expiry_date"
                        value="{{ $driver->passport_expiry_date }}">
                </div>
            </div>

            <div>
                <label for="passport">Passport:</label>
                <span class="grey">Do not Upload if not wanted to update</span>
                <input type="file" class="form-input" id="passport" name="passport">
                @if ($driver->passport)
                    <div>

                        <a href="{{ asset('public/' . $driver->passport) }}" download class="btn btn-primary"
                            style="max-width: 80px; margin-top: 10px;">Download</a>
                    </div>
                @endif
            </div>

            <h1 style="font-size: large;">Drivers All Document</h1>

            <div>
                <label for="all_documents">Drivers's All Documents:</label>
                <span class="grey">Do not Upload if not wanted to update</span>
                <input type="file" class="form-input" id="all_documents" name="all_documents">
                @if ($driver->all_documents)
                    <div class="mt-2">

                        <a href="{{ asset('public/' . $driver->all_documents) }}" download class="btn btn-primary"
                            style="max-width: 80px;">Download</a>
                    </div>
                @endif
            </div>

            <div>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>

        </form>
    </div>
</x-layout.default>
