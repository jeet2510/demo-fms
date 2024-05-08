<x-layout.default>

    <style>
        .option-box {
    display: inline-block;
    width: 10px; /* Adjust the width of the box as per your requirement */
    height: 10px; /* Adjust the height of the box as per your requirement */
    background-color: #ccc; /* You can set the background color as per your design */
    margin-right: 5px; /* Adjust the margin between the box and the text */
}

        </style>
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
        <form action="{{ route('lanes.update', $route->id) }}" method="post">
            @csrf
            @method('PUT')

            {{-- <div class="form-group">
                <label for="origin_city_id ">Select Origin City</label>
                <select name="origin_city_id " id="origin_city_id " class="form-input" required>
                    <option value="">Select Origin City</option>
                    @foreach ($cities as $city)
                        <option value="{{ $city->id }}" {{ $city->id == $route->origin_city_id ? 'selected' : '' }}>
                            {{ $city->city_name }}</option>
                    @endforeach
                </select>
            </div> --}}

            <div class="form-group">
                <label for="route">Route</label>
                <input id="route" type="text" class="form-input" name="route" value="{{ $route->route }}"
                    required>
            </div>

            <div class="form-group">
                <label for="origin_city_id ">Select Origin City</label>
                <select name="origin_city_id" id="origin_city_id" class="form-input" required>
                    <option value="">Select Origin City</option>
                    @foreach ($cities as $city)
                        <option value="{{ $city->id }}" {{ $city->id == $route->origin_city_id ? 'selected' : '' }}>
                            {{ $city->city_name }}</option>
                    @endforeach
                </select>
            </div>



            <div class="form-group">
                <label for="destination_city_id">Select Destination City</label>
                <select name="destination_city_id" id="destination_city_id" class="form-input" required>
                    <option value="">Select Destination City</option>
                    @foreach ($cities as $city)
                        <option value="{{ $city->id }}"
                            {{ $city->id == $route->destination_city_id ? 'selected' : '' }}>{{ $city->city_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="fare">Fare</label>
                <input id="fare" type="number" class="form-input" name="fare" value="{{ $route->fare }}">
            </div><br>



            {{-- <div class="form-group">
                <label for="border_id" class="block text-sm font-medium text-gray-700">Border</label>
                <select name="border_id" class="form-input block w-full mt-1 rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" id="border_id" required multiple>
                    <option value="">Select Border</option>
                    @foreach ($borders as $border)
                        <option value="{{ $border->id }}" {{ $border->id == $route->border_id ? 'selected' : '' }}>
                            {{ $border->border_name }}
                        </option>
                    @endforeach
                </select>
            </div> --}}

            <div class="mb-4" id="border-container">
                <label for="fare">Border</label>
                <select name="border_id[]" class="form-input border-select" required multiple>
                    <option value="">Select Border</option>
                    @foreach ($borders as $border)
                        <option value="{{ $border->id }}" {{ $border->id == $route->border_id ? 'selected' : '' }}>
                            {{ $border->border_name }}
                        </option>
                    @endforeach
                </select>
            </div>


            <div id="selectedBorders" class="mt-2 text-sm text-gray-500"></div>

            <button type="submit" class="btn btn-primary">Update Route</button>
        </form>
    </div>

</x-layout.default>


<!-- Select2 CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Select2 JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        $('#border_id').select2({
            tags: true,
            tokenSeparators: [',', ' '],
            templateSelection: function(selection) {
                return $('<span>' + selection.text + '</span>');
            }
        });
    });
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

   <script>
    $(document).ready(function () {
        $('#border_id').change(function () {
            updateSelectedBorders();
        });

        updateSelectedBorders();

        function updateSelectedBorders() {
            var selectedBorders = [];
            $('#border_id option:selected').each(function () {
                selectedBorders.push($(this).text());
            });
            $('#selectedBorders').text(selectedBorders.join(', '));
        }
    });
</script>

<style>
    .border-highlight {
        background-color: white;
    }
</style>
