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

        <form action="{{ route('borders.update', $border->id) }}" method="post">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="country_id">Country:</label>
                <select name="country_id" id="country_id" class="form-input" required>
                    <option value="">Select Country</option>
                    @foreach($countries as $country)
                        <option value="{{ $country->id }}" {{ $border->country_id == $country->id ? 'selected' : '' }}>{{ $country->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="border_name">Border Name:</label>
                <input type="text" id="border_name" name="border_name" class="form-input" value="{{ $border->border_name }}" required>
            </div>
            <div class="form-group">
                <label for="border_type">Border Type:</label>
                <select name="border_type" id="border_type" class="form-input" required>
                    <option value="">Select Type</option>
                    <option value="1" {{ $border->border_type == 1 ? 'selected' : '' }}>In</option>
                    <option value="0" {{ $border->border_type == 0 ? 'selected' : '' }}>Out</option>
                </select>
            </div>
            <div class="form-group">
                <label for="border_charges">Border Charges:</label>
                <input type="text" id="border_charges" name="border_charges" class="form-input" value="{{ $border->border_charges }}" required>
            </div><br>
            {{-- <div class="form-group">
                <label for="created_by">Created By:</label>
                <input type="number" id="created_by" name="created_by" class="form-input" value="{{ $border->created_by }}" required>
            </div> --}}
            <button type="submit" class="btn btn-primary">Update Border</button>
        </form>
    </div>
</x-layout.default>
