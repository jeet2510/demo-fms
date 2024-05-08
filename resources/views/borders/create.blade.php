<form action="{{ route('borders.store') }}" method="post" class="ajax-form">
    @csrf
    <div class="mb-4">
        <label for="country_id">Country:</label>
        <select name="country_id" id="country_id" class="form-input" required>
            <option value="">Select Country</option>
            @foreach ($countries as $country)
                <option value="{{ $country->id }}">{{ $country->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="border_name">Border Name:</label>
        <input type="text" id="border_name" name="border_name" class="form-input" required>
    </div><br>


    {{-- <div class="form-group">
        <label for="border_type">Border Type:</label>
        <select name="border_type" id="border_type" class="form-input" required>
            <option value="">Select Type</option>
            <option value="1">In</option>
            <option value="0">Out</option>
        </select>
    </div> --}}

    <div class="form-group">
        <label for="border_charges">Border Charges:</label>
        <input type="number" id="border_charges" name="border_charges" value="0" class="form-input" required>
    </div>
    {{-- <div class="form-group">
            <label for="created_by">Created By:</label>
            <input type="number" id="created_by" name="created_by" class="form-input" required>
        </div> --}}
    <br>
    <button type="submit" class="btn btn-primary">Create Border</button>
</form>
</div>
<script src="/assets/js/ajax-function.js"></script>
