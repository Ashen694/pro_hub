<form action="{{ $action }}" method="POST">
    @csrf
    @if(in_array($method, ['PUT','PATCH']))
        @method($method)
    @endif

    <div class="row">
        <div class="col-md-3 text-end">
            <label class="form-label">Company_Name</label>
        </div>
        <div class="col-md-6">
            <input type="text" name="name" class="form-control" value="{{ old('name', optional($company)->name) }}" required>
            @error('name')<div class="text-danger">{{ $message }}</div>@enderror
        </div>
    </div>

    <div class="mt-3">
        <button class="btn btn-primary">{{ in_array($method, ['PUT','PATCH']) ? 'Update' : 'Create' }}</button>
        <a href="{{ route('reference-data.companies.index') }}" class="btn btn-link">Back to List</a>
    </div>
</form>
