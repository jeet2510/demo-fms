<x-layout.default>

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
        .alert-danger {
            color: red;
        }
    </style>

    <form action="{{ route('cities.update', $city->id) }}" method="post">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="country_id">Country:</label>
            <select name="country_id" id="country_id" class="form-input" required>
                <option value="">Select Country</option>
                @foreach($countries as $country)
                    <option value="{{ $country->id }}" {{ $city->country_id == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label class="block text-sm font-medium text-gray-700" for="city_name">City Name</label>
            <input type="text" class="form-input" id="city_name" name="city_name" value="{{ $city->city_name }}"
                required>
        </div>
        <button type="submit" class="btn mt-3 btn-primary">Update </button>
    </form>
    </div>
</x-layout.default>
