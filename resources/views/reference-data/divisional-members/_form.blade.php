<form action="{{ $action }}" method="POST">
    @csrf
    @if(in_array($method, ['PUT','PATCH'])) @method($method) @endif

    <div class="mb-3">
        <label class="form-label">Name</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', optional($member)->name) }}" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Division</label>
        <input type="text" name="division" class="form-control" value="{{ old('division', optional($member)->division) }}">
    </div>

    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" value="{{ old('email', optional($member)->email) }}">
    </div>

    <div class="mb-3">
        <label class="form-label">Position</label>
        <input type="text" name="position" class="form-control" value="{{ old('position', optional($member)->position) }}">
    </div>

    <button class="btn btn-primary">Save</button>
    <a href="{{ route('reference-data.divisional-members.index') }}" class="btn btn-secondary">Cancel</a>
</form>
