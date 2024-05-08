<form action="{{ route('transporters.store') }}" class="ajax-form" method="post">
    @csrf
    <div class="grid grid-cols-2 gap-4">
        <div>
            <label for="transporter_name" class="block mb-2">Transporter Name</label>
            <input type="text" name="transporter_name" id="transporter_name" class="form-input" required>
        </div>
        <div>
            <label for="contact_person" class="block mb-2">Contact Person</label>
            <input type="text" name="contact_person" id="contact_person" class="form-input" required>
        </div>
        <div>
            <label for="email" class="block mb-2">Email</label>
            <input type="email" name="email" id="email" class="form-input" required>
        </div>
        <div>
            <label for="phone" class="block mb-2">Phone</label>
            <input type="text" name="phone" id="phone" class="form-input" required>
        </div>
    </div>
    <div class="mb-4">
        <label for="tax_register_number" class="block mb-2">Tax Register Number</label>
        <input type="text" name="tax_register_number" id="tax_register_number" class="form-input">
    </div>
    <div class="grid grid-cols-3 gap-4">
        <div>
            <label for="address" class="block mb-2">Address</label>
            <input type="text" name="address" id="address" class="form-input">
        </div>
        <div>
            <label for="city" class="block mb-2">City</label>
            <input type="text" name="city" id="city" class="form-input">
        </div>
        <div>
            <label for="state" class="block mb-2">State</label>
            <input type="text" name="state" id="state" class="form-input">
        </div>
    </div>
    <div class="mb-4">
        <label for="pin_code" class="block mb-2">Pin Code</label>
        <input type="text" name="pin_code" id="pin_code" class="form-input">
    </div>
    <div class="mb-4">
        <label for="country" class="block mb-2">Country</label>
        <input type="text" name="country" id="country" class="form-input">
    </div>
    <button type="submit" class="btn btn-primary">Create Transporter</button>
</form>
<script src="/assets/js/ajax-function.js"></script>
