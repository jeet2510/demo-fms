<form action="{{ route('cities.store') }}" method="post">
    @csrf


    {{-- <div class="mb-4">
        <label for="country_id">Country Name:</label>
        <select name="country_id" id="country_id" class="form-input" required>
            <option value="">Select Country</option>
            @foreach ($countries as $country)
                <option value="{{ $country->id }}">{{ $country->name }}</option>
            @endforeach
        </select>
    </div> --}}


    <div class="mb-4">
        <label for="country_id">Country:</label>
        <select name="country_id" id="country_id" class="form-input" required>
            <option value="">Select Country</option>
            @foreach ($countries as $country)
                <option value="{{ $country->id }}">{{ $country->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-4">
        <div class="form-group">
            <label for="city_name">City Name</label>
            <input type="text" class="form-input" id="city_name" name="city_name" required>
        </div>
    </div>
    {{-- <div class="form-group">
                <label for="body">Body</label>
                <textarea class="form-control" id="body" name="body" rows="3" required></textarea>
              </div> --}}
    <br>
    <button type="submit" class="btn btn-primary">Create City</button>
</form>
