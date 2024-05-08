<div id="uploadModal" class="hidden fixed z-10 inset-0 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div
            class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Update Passport
                            Info</h3>
                        <form id="uploadForm" action="{{ route('documents.update', $driver->id) }}"
                            enctype="multipart/form-data" method="post" class="grid grid-cols-1 gap-4">
                            @csrf
                            @method('PUT')

                            <div class="mb-4">
                                <label for="passport_number">Passport Number:</label>
                                <input type="text" class="form-input" id="passport_number" name="passport_number">
                            </div>

                            <div class="mb-4">
                                <label for="passport_expiry_date"
                                    class="block text-sm font-medium text-gray-700">Passport Expiry Date:</label>
                                <input type="date" id="passport_expiry_date" name="passport_expiry_date"
                                    class="form-input mt-1 block w-full">
                            </div>
                            <div class="mb-4">
                                <label for="passport" class="block text-sm font-medium text-gray-700">Passport:</label>
                                <input type="file" id="passport" name="passport"
                                    class="form-input mt-1 block w-full">
                                {{-- @if ($driver->passport)
                                    <span class="text-gray-500">{{ $driver->passport }}</span>
                                @endif --}}
                            </div>
                            <div class="flex justify-end">
                                <button type="button" id="cancelButton"
                                    class="mr-2 w-20 inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">Cancel</button>
                                <button type="submit" id="uploadButton" class="">Upload</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="id_card_model" class="hidden fixed z-10 inset-0 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div
            class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                            Update ID Card Info
                        </h3>
                        <form id="uploadForm_id" action="{{ route('documents.update', $driver->id) }}"
                            enctype="multipart/form-data" method="post" class="grid grid-cols-1 gap-4">

                            @csrf
                            @method('PUT')
                            <div class="mt-2">
                                <div class="mb-4">
                                    <label for="id_card_number">ID Card Number:</label>
                                    <input type="text" class="form-input" id="id_card_number" name="id_card_number">
                                </div>

                                <div class="mb-4">
                                    <label for="id_card_expiry_date">ID Card Expiry Date:</label>
                                    <input type="date" class="form-input" id="id_card_expiry_date"
                                        name="id_card_expiry_date">
                                </div>
                                <div class="mb-4">
                                    <label for="id_card">ID Card:</label>
                                    <input type="file" class="form-input" id="id_card" name="id_card">
                                    {{-- @if ($driver->id_card)
                                        <span>{{ $driver->id_card }}</span>
                                    @endif --}}
                                </div>

                                <div class="flex justify-end">
                                    <button type="button" id="id_card_cancel"
                                        class="mr-2 w-20 inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">Cancel</button>
                                    <button type="submit" class="">Upload</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="driver_lic_model" class="hidden fixed z-10 inset-0 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div
            class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                            Update Driver Licance Info
                        </h3>

                        <form id="uploadForm_driverLi" action="{{ route('documents.update', $driver->id) }}"
                            enctype="multipart/form-data" method="post" class="grid grid-cols-1 gap-4">
                            @csrf
                            @method('PUT')
                            <div class="mb-4">
                                <label for="driving_license_number">Driving License Number:</label>
                                <input type="text" class="form-input" id="driving_license_number"
                                    name="driving_license_number">
                            </div>

                            <div class="mb-4">
                                <div class="col-span-1">
                                    <label for="driving_license_expiry_date">Driving License Expiry
                                        Date:</label>
                                    <input type="date" class="form-input" id="driving_license_expiry_date"
                                        name="driving_license_expiry_date">
                                </div>
                            </div>
                            <div class="mb-4">
                                <label for="driving_license">Driving License:</label>
                                <input type="file" class="form-input" id="driving_license"
                                    name="driving_license">
                                {{-- @if ($driver->driving_license)
                                    <span>{{ $driver->driving_license }}</span>
                                @endif --}}
                            </div>
                            <div class="flex justify-end">
                                <button type="button" id="driver_lic_cancel"
                                    class="mr-2 w-20 inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">Cancel</button>
                                <button type="submit" class="">Upload</button>
                            </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="{{ asset('assets/js/ajax-function.js') }}"></script>


<script>
    $(document).on('click', '.password_upload-button', function() {
        var dataId = $(this).attr('data-Id');
        console.log(dataId);

        var url = '{{ route('documents.update', ':dataId') }}';
        url = url.replace(':dataId', dataId);

        $('#uploadModal').removeClass('hidden');
        $('#uploadForm').attr('action', url);
    });

    $('#cancelButton').click(function() {
        $('#uploadModal').addClass('hidden');
    });

    $('#uploadForm').submit(function(event) {
        event.preventDefault();

        var formData = new FormData(this);

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                console.log(response);
                $('#uploadModal').addClass('hidden');
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });


    $(document).on('click', '.idcard_upload-button', function() {
        var dataId = $(this).attr('data-Id');
        console.log(dataId);

        var url = '{{ route('documents.update', ':dataId') }}';
        url = url.replace(':dataId', dataId);

        $('#id_card_model').removeClass('hidden');
        $('#uploadForm_id').attr('action', url);
    });

    $('#id_card_cancel').click(function() {
        $('#id_card_model').addClass('hidden');
    });

    $('#uploadForm_id').submit(function(event) {
        event.preventDefault();

        var formData = new FormData(this);

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                console.log(response);
                $('#id_card_model').addClass('hidden');
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });

    $(document).on('click', '.driver_upload-button', function() {

        var dataId = $(this).attr('data-Id');
        console.log(dataId);

        var url = '{{ route('documents.update', ':dataId') }}';
        url = url.replace(':dataId', dataId);

        $('#driver_lic_model').removeClass('hidden');
        $('#uploadForm_driverLi').attr('action', url);
    });

    $('#driver_lic_cancel').click(function() {
        $('#driver_lic_model').addClass('hidden');
    });

    $('#uploadForm_driverLi').submit(function(event) {
        event.preventDefault();

        var formData = new FormData(this);

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                console.log(response);
                $('#driver_lic_model').addClass('hidden');
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });
</script>
