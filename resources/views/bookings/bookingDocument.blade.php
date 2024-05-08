<form action="{{ route('bookings.storeDocument') }}" method="post" class="ajax-form" enctype="multipart/form-data">
    @csrf

    <label for="booking_ids" class="block text-gray-700">Select Booking IDs</label>
    <select name="booking_id" id="booking_ids" class="form-multiselect block w-full mt-1" x-model="selectedBookingId"
        readonly>
        <option readonly> {{ $booking->booking_id }} </option>
    </select>

    <label for="booking_document" class="block text-gray-700 mt-4">Upload</label>
    <input type="file" name="booking_document" id="booking_document" class="form-input mt-1 block w-full">

    <input type="hidden" name="selected_booking_id" x-model="selectedBookingId">

    <button type="submit" class="btn btn-primary mt-4">Submit</button>
</form>
