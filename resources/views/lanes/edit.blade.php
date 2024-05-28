<x-layout.default>

    <style>
        .option-box {
            display: inline-block;
            width: 10px;
            height: 10px;
            background-color: #ccc;
            margin-right: 5px;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #2c7be5;
            border: 1px solid #2c7be5;
            border-radius: 4px;
            color: white;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            color: white;
        }

        .selected-options-wrapper {
            position: relative;
        }

        .selected-options-container {
            display: flex;
            flex-wrap: wrap;
        }

        .selected-option {
            display: flex;
            align-items: center;
            margin-right: 5px;
            padding: 5px;
            background-color: #2c7be5;
            color: white;
            border-radius: 4px;
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

            <div class="form-group">
                <label for="route">Route</label>
                <input id="route" type="text" class="form-input" name="route" value="{{ $route->route }}" required>
            </div>

            <div class="form-group">
                <label for="origin_city_id ">Select Origin Country</label>
                <select name="origin_city_id" id="origin_city_id" class="form-input" required>
                    <option value="">Select Origin Country</option>
                    @foreach ($countries as $city)
                        <option value="{{ $city->id }}" {{ $city->id == $route->origin_city_id ? 'selected' : '' }}>
                            {{ $city->name }}</option>
                    @endforeach
                </select>
            </div>



            <div class="form-group">
                <label for="destination_city_id">Select Destination Country</label>
                <select name="destination_city_id" id="destination_city_id" class="form-input" required>
                    <option value="">Select Destination Country</option>
                    @foreach ($countries as $city)
                        <option value="{{ $city->id }}"
                            {{ $city->id == $route->destination_city_id ? 'selected' : '' }}>{{ $city->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="fare">Fare</label>
                <input id="fare" type="number" class="form-input" name="fare" value="{{ $route->fare }}">
            </div><br>

            <div class="form-group">
                <label for="border_id">Select Border</label>
                <div class="relative">
                    <!-- <div id="selectedOptions" class="selected-options-wrapper form-input rounded-md shadow-sm mb-2 border border-gray-300 cursor-pointer w-full flex items-center justify-between" onclick="toggleSelect()">
                        <div id="selectedOptionsContainer" class="selected-options-container" placeholder="Select Border"></div>
                        <svg id="dropdownIcon" class="w-5 h-5 ml-2 cursor-pointer" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div> -->
                    @php
                        $selected_border_id = $route->border_id ? explode(',', $route->border_id) : [];
                    @endphp
                    <select id="border_id" class="form-input select2" name="border_id[]" multiple
                        style="display: none;">
                        @foreach ($borders as $border)
                            <option value="{{ $border->id }}"
                                {{ in_array($border->id, $selected_border_id) ? 'selected' : '' }}>
                                {{ $border->border_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
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
            placeholder: "Select Border",
            theme: "default",
        }).on('change', function() {
            updateSelectedBorders();
        });

        updateSelectedBorders();

        function updateSelectedBorders() {
            var selectedBorders = [];
            $('#border_id option:selected').each(function() {
                selectedBorders.push($(this).text());
            });
            $('#selectedOptionsContainer').html('');
            selectedBorders.forEach(function(border) {
                $('#selectedOptionsContainer').append(
                    `<span class="selected-option bg-blue-200 text-blue-800 rounded-md px-2 py-1 m-1 flex items-center">${border}<button onclick="deselectOption(this); return false;" class="ml-2 focus:outline-none">&times;</button></span>`
                );
            });
        }

        window.toggleSelect = function() {
            var selectBox = document.getElementById("border_id");
            selectBox.style.display = (selectBox.style.display === "none" || selectBox.style.display ===
                "") ? "block" : "none";
        }

        window.deselectOption = function(button) {
            var selectedOptionText = button.parentNode.firstChild.textContent.trim();
            var selectBox = document.getElementById("border_id");
            var options = selectBox.options;

            for (var i = 0; i < options.length; i++) {
                if (options[i].textContent.trim() === selectedOptionText) {
                    options[i].selected = false;
                    break;
                }
            }

            button.parentNode.remove();
            updateSelectedBorders();
        }

        document.addEventListener("click", function(event) {
            var selectBox = document.getElementById("border_id");
            var selectedOptions = document.getElementById("selectedOptions");
            if (event.target !== selectBox && !selectBox.contains(event.target) && event.target !==
                selectedOptions) {
                selectBox.style.display = "none";
            }
        });

        document.getElementById("dropdownIcon").addEventListener("click", function(event) {
            event.stopPropagation();
            toggleSelect();
        });
    });
</script>
{{--
<style>
    .border-highlight {
        /* background-color: white; */
    }
</style> --}}
