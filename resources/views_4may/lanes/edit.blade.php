<x-layout.default>

    <style>
        .option-box {
            display: inline-block;
            width: 10px;
            /* Adjust the width of the box as per your requirement */
            height: 10px;
            /* Adjust the height of the box as per your requirement */
            background-color: #ccc;
            /* You can set the background color as per your design */
            margin-right: 5px;
            /* Adjust the margin between the box and the text */
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
                <input id="route" type="text" class="form-input" name="route" value="{{ $route->route }}" required>
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

            {{-- <div class="mb-4" id="border-container">
                <label for="fare">Border</label>
                <select name="border_id[]" class="form-input border-select" required multiple>
                    <option value="">Select Border</option>
                    @foreach ($borders as $border)
                        <option value="{{ $border->id }}" {{ $border->id == $route->border_id ? 'selected' : '' }}>
                            {{ $border->border_name }}
                        </option>
                    @endforeach
                </select>
            </div> --}}


            <div>
                <label for="selectedOptions" class="block text-sm font-medium text-gray-700">Border</label>
                <div class="relative">
                    <div id="selectedOptions"
                        class="selected-options-wrapper form-input rounded-md shadow-sm mb-2 border border-gray-300 cursor-pointer w-full flex items-center justify-between"
                        onclick="toggleSelect()">
                        <div id="selectedOptionsContainer" class="selected-options-container"></div>
                        <svg id="dropdownIcon" class="w-5 h-5 ml-2 cursor-pointer" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                            </path>
                        </svg>
                    </div>
                    <select id="deduction-choices-multiple" class="form-input select2" name="border_id[]" multiple
                        style="display: none;">
                        <option value="">Select Border</option>
                        @php
                            $selected_border_id = $route->border_id ? explode(',', $route->border_id) : [];
                        @endphp
                        @foreach ($borders as $border)
                            <option value="{{ $border->id }}"
                                {{ in_array($border->id, $selected_border_id) ? 'selected' : '' }}>
                                {{ $border->border_name }}
                            </option>
                        @endforeach
                        <!-- Add more options as needed -->
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
    $(document).ready(function() {
        $('#deduction-choices-multiple').change(function() {
            updateSelectedBorders();
        });

        updateSelectedBorders();

        function updateSelectedBorders() {
            var selectedBorders = [];
            $('#deduction-choices-multiple option:selected').each(function() {
                selectedBorders.push($(this).text());
            });
            $('#selectedBorders').text(selectedBorders.join(', '));
        }
    });
</script>
    document.addEventListener("alpine:init", () => {
        Alpine.data("form", () => ({
            // highlightjs
            codeArr: [],
            toggleCode(name) {
                if (this.codeArr.includes(name)) {
                    this.codeArr = this.codeArr.filter((d) => d != name);
                } else {
                    this.codeArr.push(name);

                    setTimeout(() => {
                        document.querySelectorAll('pre.code').forEach(el => {
                            hljs.highlightElement(el);
                        });
                    });
                }
            }
        }));
    });

    function toggleSelect() {
        var selectBox = document.getElementById("deduction-choices-multiple");
        selectBox.style.display = (selectBox.style.display === "none" || selectBox.style.display === "") ? "block" :
            "none";
    }

    // Function to handle selection of options
    function handleOptionSelection(option) {
        var selectedOptionsContainer = document.getElementById("selectedOptionsContainer");
        var optionText = option.textContent;

        if (!selectedOptionsContainer.innerHTML.includes(optionText)) {
            selectedOptionsContainer.innerHTML +=
                `<span class="selected-option bg-blue-200 text-blue-800 rounded-md flex items-center">${optionText}<button onclick="deselectOption(this); return false;" class="ml-2 focus:outline-none">&times;</button></span>`;
            option.selected = true; // Mark the option as selected
        }
    }

    // Function to deselect an option
    function deselectOption(button) {
        var selectedOptionText = button.parentNode.firstChild.textContent
            .trim(); // Get the text content of the selected option
        var selectBox = document.getElementById("deduction-choices-multiple");
        var options = selectBox.options;

        for (var i = 0; i < options.length; i++) {
            if (options[i].textContent.trim() === selectedOptionText) {
                options[i].selected = false; // Deselect the option
                break;
            }
        }

        button.parentNode.remove(); // Remove the selected option from the input field
    }

    // Add event listeners
    var options = document.querySelectorAll("#deduction-choices-multiple option");
    options.forEach(function(option) {
        option.addEventListener("click", function(event) {
            event.stopPropagation();
            handleOptionSelection(option);
        });
    });

    document.addEventListener("click", function(event) {
        var selectBox = document.getElementById("deduction-choices-multiple");
        var selectedOptions = document.getElementById("selectedOptions");
        if (event.target !== selectBox && !selectBox.contains(event.target) && event.target !==
            selectedOptions) {
            selectBox.style.display = "none";
        }
    });

    // Event listener for the dropdown icon
    document.getElementById("dropdownIcon").addEventListener("click", function(event) {
        event.stopPropagation(); // Prevent the click event from bubbling up to the parent
        toggleSelect(); // Toggle the display of the select box
    });
</script>
<style>
    .border-highlight {
        background-color: white;
    }
</style>
