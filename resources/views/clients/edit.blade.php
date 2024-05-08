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

        <form action="{{ route('clients.update', $client->id) }}" method="post">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="company_name">Company Name</label>
                    <input type="text" name="company_name" id="company_name" class="form-input"
                           value="{{ $client->company_name }}" required>
                </div>
                <div>
                    <label for="contact_person">Contact Person</label>
                    <input type="text" name="contact_person" id="contact_person" class="form-input"
                           value="{{ $client->contact_person }}" required>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-input"
                           value="{{ $client->email }}" required>
                </div>
                <div>
                    <label for="phone">Phone</label>
                    <input type="text" name="phone" id="phone" class="form-input"
                           value="{{ $client->phone }}" required>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="address">Address</label>
                    <input type="text" name="address" id="address" class="form-input"
                           value="{{ $client->address }}" >
                </div>
                <div>
                    <label for="city">City</label>
                    <input type="text" name="city" id="city" class="form-input" value="{{ $client->city }}"
                           >
                </div>
            </div>

            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label for="state">State</label>
                    <input type="text" name="state" id="state" class="form-input"
                           value="{{ $client->state }}" >
                </div>
                <div>
                    <label for="pin_code">Pin Code</label>
                    <input type="text" name="pin_code" id="pin_code" class="form-input"
                           value="{{ $client->pin_code }}" >
                </div>
                <div>
                    <label for="country">Country</label>
                    <input type="text" name="country" id="country" class="form-input" value="{{ $client->country }}"
                           >
                </div>
            </div><br>

            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>

</x-layout.default>
