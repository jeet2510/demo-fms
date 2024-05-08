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

        <form action="{{ route('customers.update', $customer->id) }}" method="post">
            @csrf
            @method('PUT')

            <!-- Contact Information -->
            <fieldset style="margin-bottom: 20px;">
                <legend style="font-size: 25px">Contact Information</legend>

                <div class="grid grid-cols-2 gap-4" style="margin-top: 8px;">
                    <div>
                        <label for="company_name">Company Name</label>
                        <input type="text" name="company_name" id="company_name" class="form-input"
                            value="{{ $customer->company_name }}" required placeholder="Enter company name">
                    </div>
                    <div>
                        <label for="contact_person">Contact Person</label>
                        <input type="text" name="contact_person" id="contact_person" class="form-input"
                            value="{{ $customer->contact_person }}" required placeholder="Enter contact person">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4" style="margin-top: 8px;">
                    <div>
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-input"
                            value="{{ $customer->email }}" required placeholder="Enter email">
                    </div>
                    <div>
                        <label for="phone">Phone</label>
                        <input type="text" name="phone" id="phone" class="form-input"
                            value="{{ $customer->phone }}" required placeholder="Enter phone number">
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
                            value="{{ $customer->address }}" placeholder="Enter address">
                    </div>
                    <div>
                        <label for="city">City</label>
                        <input type="text" name="city" id="city" class="form-input"
                            value="{{ $customer->city }}" placeholder="Enter city">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4" style="margin-top: 8px;">
                    <div>
                        <label for="state">State</label>
                        <input type="text" name="state" id="state" class="form-input"
                            value="{{ $customer->state }}" placeholder="Enter state">
                    </div>
                    <div>
                        <label for="pin_code">Pin Code</label>
                        <input type="text" name="pin_code" id="pin_code" class="form-input"
                            value="{{ $customer->pin_code }}" placeholder="Enter pin code">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4" style="margin-top: 8px;">
                    <div>
                        <label for="country">Country</label>
                        <input type="text" name="country" id="country" class="form-input"
                            value="{{ $customer->country }}" placeholder="Enter country">
                    </div>
                    <div>
                        <label for="tax_register_number">Tax Register Number</label>
                        <input type="text" name="tax_register_number" id="tax_register_number" class="form-input"
                            value="{{ $customer->tax_register_number }}" placeholder="Enter tax register number">
                    </div>
                </div>
            </fieldset>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>

</x-layout.default>
