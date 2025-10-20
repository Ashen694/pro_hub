<form action="{{ $action }}" method="POST">
    @csrf
    @if(in_array($method, ['PUT','PATCH'])) @method($method) @endif

    <div class="mb-3">
        <label class="form-label">Name</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', optional($group)->name) }}" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea name="description" class="form-control">{{ old('description', optional($group)->description) }}</textarea>
    </div>

    <button class="btn btn-primary">Save</button>
    <a href="{{ route('reference-data.application-groups.index') }}" class="btn btn-secondary">Cancel</a>
</form>
