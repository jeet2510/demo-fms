<div style="height: 550px; overflow: auto;">
    <form action="{{ route('lanes.store') }}" class="ajax-form" method="post" class="ajax-form">
        @csrf

        <div class="mb-4 flex">
            <div class="mr-2 w-1/2">
                <label for="route">Route</label>
                <input id="route" type="text" class="form-input" name="route" required>
            </div>

            <div class="w-1/2">
                <label for="fare">Fare</label>
                <input id="fare" type="number" class="form-input" name="fare">
            </div>
        </div>

        <div class="mb-4 flex">
            <div class="mr-2 w-1/2">
                <label for="origin_city_id">Select Origin Country</label>
                <select name="origin_city_id" id="origin_city_id" class="form-input" required>
                    <option value="">Select Origin Country</option>
                    @if ($countries)
                        @foreach ($countries as $city)
                            <option value="{{ $city->id }}">{{ $city->name }}
                            </option>
                        @endforeach
                    @endif
                </select>
            </div>

            <div class="w-1/2">
                <label for="destination_city_id">Select Destination Country</label>
                <select name="destination_city_id" id="destination_city_id" class="form-input" required>
                    <option value="">Select Destination Country</option>
                    @if ($countries)
                        @foreach ($countries as $city)
                            <option value="{{ $city->id }}">{{ $city->name }}
                            </option>
                        @endforeach
                    @endif
                </select>
            </div>
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
<script src="/assets/js/ajax-function.js"></script>
