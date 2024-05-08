<form action="{{ route('trucks.store') }}" class="ajax-form" method="post">
    @csrf
    <div class="mb-4">
        <label for="truck_type">Truck Type</label>
        <input id="truck_type" type="text" class="form-input" name="truck_type" required>
    </div>

    <div class="mb-4">
        <label for="number">Registration Number</label>
        <input id="number" type="text" class="form-input" name="number" required>
    </div>

    <div class="mb-4">
        <label for="capacity">Capacity Tons</label>
        <input id="capacity" type="text" class="form-input" name="capacity" required>
    </div>


        <button type="submit" class="btn btn-primary">Save</button>
</form>
