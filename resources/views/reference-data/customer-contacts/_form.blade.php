<form action="{{ $action }}" method="POST">
    @csrf
    @if(in_array($method, ['PUT','PATCH'])) @method($method) @endif

    <div class="row mb-3">
        <div class="col-md-3 text-end">
            <label class="form-label" style="color:#fff;">Company</label>
        </div>
        <div class="col-md-9">
            <select name="company_id" class="form-control" required>
                <option value="">Select company</option>
                @foreach($companies as $c)
                    <option value="{{ $c->id }}" {{ old('company_id', optional($contact)->company_id) == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-3 text-end">
            <label class="form-label" style="color:#fff;">Title</label>
        </div>
        <div class="col-md-9">
            <select name="title" class="form-control" required>
                <option value="">Select title</option>
                @foreach(['Mr','Mrs','Ms','Dr','Prof'] as $t)
                    <option value="{{ $t }}" {{ old('title', optional($contact)->title) == $t ? 'selected' : '' }}>{{ $t }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-3 text-end">
            <label class="form-label" style="color:#fff;">Name</label>
        </div>
        <div class="col-md-9">
            <input type="text" name="name" class="form-control" value="{{ old('name', optional($contact)->name) }}" required>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-3 text-end">
            <label class="form-label" style="color:#fff;">Email</label>
        </div>
        <div class="col-md-9">
            <input type="email" name="email" class="form-control" value="{{ old('email', optional($contact)->email) }}">
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-3 text-end">
            <label class="form-label" style="color:#fff;">Phone</label>
        </div>
        <div class="col-md-9">
            <input type="text" name="phone" class="form-control" value="{{ old('phone', optional($contact)->phone) }}">
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-3 text-end">
            <label class="form-label" style="color:#fff;">Role</label>
        </div>
        <div class="col-md-9">
            <input type="text" name="role" class="form-control" value="{{ old('role', optional($contact)->role) }}">
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-3"></div>
        <div class="col-md-9">
            <button class="btn btn-primary">Save</button>
            <a href="{{ route('reference-data.customer-contacts.index') }}" class="btn btn-secondary">Back to List</a>
        </div>
    </div>
</form>
