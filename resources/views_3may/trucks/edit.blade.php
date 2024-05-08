<x-layout.default>

    <!-- forms grid -->
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

<form action="{{ route('trucks.update', $truck->id) }}"  method="post">
    @csrf
    @method('PUT')

    <div class="mb-4">
        <label for="truck_type">Truck Type</label>
        <input id="truck_type" type="text" class="form-input" name="truck_type" value="{{ $truck->truck_type }}" required>
    </div>

    <div class="mb-4">
        <label for="number">Registration Number</label>
        <input id="number" type="text" class="form-input" name="number" value="{{ $truck->number }}" required>
    </div>

    <div class="mb-4">
        <label for="capacity">Capacity Tons</label>
        <input id="capacity" type="text" class="form-input" name="capacity" value="{{ $truck->capacity }}" required>
    </div>

    <button type="submit" class="btn btn-primary">Update</button>
</form>

</x-layout.default>

