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

        <form action="{{ route('transporters.update', $transporter->id) }}" method="post">
            @csrf
            @method('PUT')

            <!-- Contact Information -->
            <fieldset style="margin-bottom: 20px;">
                <legend style="font-size: 25px">Contact Information</legend>

                <div class="grid grid-cols-2 gap-4" style="margin-top: 8px;">
                    <div>
                        <label for="transporter_name">Transporter Name</label>
                        <input type="text" name="transporter_name" id="transporter_name" class="form-input"
                            value="{{ $transporter->transporter_name }}" required placeholder="Enter tarnsporter name">
                    </div>
                    <div>
                        <label for="contact_person">Contact Person</label>
                        <input type="text" name="contact_person" id="contact_person" class="form-input"
                            value="{{ $transporter->contact_person }}" required placeholder="Enter contact person">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4" style="margin-top: 8px;">
                    <div>
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-input"
                            value="{{ $transporter->email }}" required placeholder="Enter email">
                    </div>
                    <div>
                        <label for="phone">Phone</label>
                        <input type="text" name="phone" id="phone" class="form-input"
                            value="{{ $transporter->phone }}" required placeholder="Enter phone number">
                    </div>
                </div>
            </fieldset>

            <!-- Address Information -->
            <fieldset style="margin-bottom: 16px;">
                <legend style="font-size: 25px">Address Information</legend>

                <div class="grid grid-cols-2 gap-4" style="margin-top: 5px;">
                    <div>
                        <label for="address">Address</label>
                        <input type="text" name="address" id="address" class="form-input"
                            value="{{ $transporter->address }}" placeholder="Enter address">
                    </div>
                    <div>
                        <label for="city">City</label>
                        <input type="text" name="city" id="city" class="form-input"
                            value="{{ $transporter->city }}" placeholder="Enter city">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4" style="margin-top: 8px;">
                    <div>
                        <label for="state">State</label>
                        <input type="text" name="state" id="state" class="form-input"
                            value="{{ $transporter->state }}" placeholder="Enter state">
                    </div>
                    <div>
                        <label for="pin_code">Pin Code</label>
                        <input type="text" name="pin_code" id="pin_code" class="form-input"
                            value="{{ $transporter->pin_code }}" placeholder="Enter pin code">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4" style="margin-top: 8px;">
                    <div>
                        <label for="country">Country</label>
                        <input type="text" name="country" id="country" class="form-input"
                            value="{{ $transporter->country }}" placeholder="Enter country">
                    </div>
                    <div>
                        <label for="tax_register_number">Tax Register Number</label>
                        <input type="text" name="tax_register_number" id="tax_register_number" class="form-input"
                            value="{{ $transporter->tax_register_number }}" placeholder="Enter tax register number">
                    </div>
                </div>
            </fieldset>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>

</x-layout.default>
