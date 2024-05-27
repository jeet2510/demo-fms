<x-layout.default>
    <form action="{{ route('user.update', $user->id) }}" method="post" class="ajax-form">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">User Name:</label>
            <input type="text" id="name" name="name" class="form-input" value="{{ $user->name }}" required>
        </div><br>

        <div class="form-group">
            <label for="email">User Email:</label>
            <input type="email" id="email" name="email" class="form-input" value="{{ $user->email }}" required>
        </div>

        <div class="form-group">
            <label for="password">Password:</label>
            <span class="grey text-xs text-muted"> (Leave this field empty if you don't want to change it)</span>
            <input type="password" id="password" name="password" class="form-input">
        </div>

        <br>
        <button type="submit" class="btn btn-primary">Update User</button>
    </form>
    </div>
</x-layout.default>
