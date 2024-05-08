<form action="{{ route('countries.store') }}" class="ajax-form" method="post">
    @csrf

    <div class="mb-4">
        <label for="name" class="block text-sm font-medium text-gray-700">Country:</label>
        <input type="text" name="name" id="name" class="mt-1 p-2 w-full border rounded-md form-input" required>
    </div>

    {{-- <div class="flex space-x-4">
            <button type="submit" class="px-4 py-2 bg-blue-500  rounded-md">Submit</button>
            <button type="reset" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md">Reset</button>
        </div> --}}

        <button type="submit" class="btn btn-primary">Save</button>
</form>



{{-- <div class="container h-100 mt-5">
    <div class="row h-100 justify-content-center align-items-center">
      <div class="col-10 col-md-8 col-lg-6">
        <h3>Add a Post</h3>
        <form action="{{ route('countries.store') }}" method="post">
          @csrf
          <div class="form-group">
            <label for="country">country</label>
            <input type="text" class="form-control" id="category" name="country" required>
          </div> --}}
{{-- <div class="form-group">
            <label for="body">Body</label>
            <textarea class="form-control" id="body" name="body" rows="3" required></textarea>
          </div> --}}
{{-- <br>
          <button type="submit" class="btn btn-primary">Create Post</button>
        </form>
      </div>
    </div>
  </div> --}}


{{-- <script src="/assets/js/ajax-function.js"></script> --}}
