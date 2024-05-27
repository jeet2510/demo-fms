<form action="{{ route('user.store') }}" method="post" class="ajax-form">
    @csrf
    <div class="form-group">
        <label for="name">User Name:</label>
        <input type="text" id="name" name="name" class="form-input" required>
    </div><br>

    <div class="form-group">
        <label for="email">User Email:</label>
        <input type="email" id="email" name="email" class="form-input" required>
    </div>

    <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" class="form-input" required>
    </div>

    <br>
    <button type="submit" class="btn btn-primary">Create User</button>
</form>
</div>
<script src="/assets/js/ajax-function.js"></script>
