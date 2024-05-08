<form action="{{ route('trucks.store') }}" class="ajax-form" method="post">
    @csrf
    <div class="mb-4">
        <label for="truck_type">Truck Type</label>
        <input id="truck_type" type="text" class="form-input" name="truck_type" required>
    </div>

   

    <div class="mb-4">
        <label for="capacity">Capacity Tons</label>
        <input id="capacity" type="text" class="form-input" name="capacity" >
    </div>


        <button type="submit" class="btn btn-primary">Save</button>
</form>
