<form action="{{ $action }}" method="POST">
    @csrf
    @if(in_array($method, ['PUT','PATCH'])) @method($method) @endif

    <div class="mb-3">
        <label class="form-label">Company</label>
        <select name="company_id" class="form-control" required>
            <option value="">Select company</option>
            @foreach($companies as $c)
                <option value="{{ $c->id }}" {{ old('company_id', optional($contact)->company_id) == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Name</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', optional($contact)->name) }}" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" value="{{ old('email', optional($contact)->email) }}">
    </div>

    <div class="mb-3">
        <label class="form-label">Phone</label>
        <input type="text" name="phone" class="form-control" value="{{ old('phone', optional($contact)->phone) }}">
    </div>

    <div class="mb-3">
        <label class="form-label">Role</label>
        <input type="text" name="role" class="form-control" value="{{ old('role', optional($contact)->role) }}">
    </div>

    <button class="btn btn-primary">Save</button>
    <a href="{{ route('reference-data.customer-contacts.index') }}" class="btn btn-secondary">Cancel</a>
</form>
