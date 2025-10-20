<form action="{{ $action }}" method="POST">
    @csrf
    @if(in_array($method, ['PUT','PATCH'])) @method($method) @endif

    <div class="mb-3">
        <label class="form-label">Name</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', optional($item)->name) }}" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Notes</label>
        <textarea name="notes" class="form-control">{{ old('notes', optional($item)->notes) }}</textarea>
    </div>

    <button class="btn btn-primary">Save</button>
    <a href="{{ route('reference-data.fields-of-specializations.index') }}" class="btn btn-secondary">Cancel</a>
</form>
