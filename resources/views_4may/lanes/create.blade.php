<div style="height: 550px; overflow: auto;">
<form action="{{ route('lanes.store') }}" class="ajax-form" method="post">
    @csrf
    <div class="mb-4">
        <label for="route">Route</label>
        <input id="route" type="text" class="form-input" name="route" required>
    </div>

    <div class="mb-4">
        <label for="origin_city_id">Select Origin City</label>
        <select name="origin_city_id" id="origin_city_id" class="form-input" required>
            <option value="">Select Origin City</option>
            @if ($cities)
                @foreach ($cities as $city)
                    @if (isset($city->country->name))
                        <option value="{{ $city->id }}">{{ $city->city_name }} ({{ $city->country->name }})</option>
                    @endif
                @endforeach
            @endif
        </select>
    </div>


    <div class="mb-4">
        <label for="destination_city_id">Select Destination City</label>
        <select name="destination_city_id" id="destination_city_id" class="form-input" required>
            <option value="">Select Destination City</option>
            @if ($cities)
                @foreach ($cities as $city)
                    @if (isset($city->country->name))
                        <option value="{{ $city->id }}">{{ $city->city_name }} ({{ $city->country->name }})</option>
                    @endif
                @endforeach
            @endif
        </select>
    </div>



    <div class="mb-4">
        <label for="fare">Fare</label>
        <input id="fare" type="number" class="form-input" name="fare">
    </div>

    <div class="mb-4" id="border-container">
        <label for="fare">Border</label>
        <select name="border_id[]" class="form-input border-select" required>
            <option value="">Select Border</option>
            @foreach ($borders as $border)
                <option value="{{ $border->id }}">{{ $border->border_name }}</option>
            @endforeach
        </select>
    </div>

    <div id="additional-borders"></div>

    <br>
    <button type="button" id="add-border" class="btn btn-primary" onclick="addBorder()">Add Another Border</button>
    <br>
    <button type="submit" class="btn btn-primary">Create Route</button>
</form>
</div>
<script>
    function addBorder() {
        const borderContainer = document.getElementById('border-container');
        const borderSelect = borderContainer.querySelector('.border-select');
        const clonedBorderSelect = borderSelect.cloneNode(true);
        document.getElementById('additional-borders').appendChild(clonedBorderSelect);
    }
</script>
