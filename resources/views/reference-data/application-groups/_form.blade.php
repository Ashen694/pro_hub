<form action="{{ $action }}" method="POST">
    @csrf
    @if(in_array($method, ['PUT','PATCH'])) @method($method) @endif

    <div class="mb-3">
        <label class="form-label">Application Group</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', optional($group)->name) }}" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Description</label>
        <input type="text" name="description" class="form-control" value="{{ old('description', optional($group)->description) }}">
    </div>

    <button class="btn btn-primary">{{ ($method ?? 'POST') === 'POST' ? 'Create' : 'Save' }}</button>
    <a href="{{ route('reference-data.application-groups.index') }}" class="btn btn-secondary">Back to List</a>
</form>
