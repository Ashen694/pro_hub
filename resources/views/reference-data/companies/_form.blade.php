<form action="{{ $action }}" method="POST">
    @csrf
    @if(in_array($method, ['PUT','PATCH']))
        @method($method)
    @endif

    <div class="mb-3">
        <label class="form-label">Name</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', optional($company)->name) }}" required>
        @error('name')<div class="text-danger">{{ $message }}</div>@enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Type</label>
        <input type="text" name="type" class="form-control" value="{{ old('type', optional($company)->type) }}">
    </div>

    <div class="mb-3">
        <label class="form-label">Contact Email</label>
        <input type="email" name="contact_email" class="form-control" value="{{ old('contact_email', optional($company)->contact_email) }}">
    </div>

    <div class="mb-3">
        <label class="form-label">Address</label>
        <textarea name="address" class="form-control">{{ old('address', optional($company)->address) }}</textarea>
    </div>

    <button class="btn btn-primary">Save</button>
    <a href="{{ route('reference-data.companies.index') }}" class="btn btn-secondary">Cancel</a>
</form>
