<form action="{{ $action }}" method="POST">
    @csrf
    @if(in_array($method, ['PUT','PATCH'])) @method($method) @endif

    <div class="mb-3">
        <label class="form-label">Service Number</label>
        <input type="text" name="service_number" class="form-control" value="{{ old('service_number', optional($member)->service_number) }}">
    </div>

    <div class="mb-3">
        <label class="form-label">Full Name</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', optional($member)->name) }}" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" value="{{ old('email', optional($member)->email) }}">
    </div>

    <div class="mb-3">
        <label class="form-label">Contact Mobile Number</label>
        <input type="text" name="contact_mobile" class="form-control" value="{{ old('contact_mobile', optional($member)->contact_mobile) }}">
    </div>

    <div class="mb-3">
        <label class="form-label">Group Name</label>
        <input type="text" name="group_name" class="form-control" value="{{ old('group_name', optional($member)->group_name) }}">
    </div>

    <div class="mb-3">
        <label class="form-label">Date of Birth (DOB)</label>
        <input type="date" name="dob" class="form-control" value="{{ old('dob', optional(optional($member)->dob)->format('Y-m-d')) }}">
    </div>

    <div class="mb-3">
        <label class="form-label">Calling Name</label>
        <input type="text" name="calling_name" class="form-control" value="{{ old('calling_name', optional($member)->calling_name) }}">
    </div>

    <div class="mb-3">
        <label class="form-label">Gender</label>
        <select name="gender" class="form-select">
            <option value="" {{ old('gender', optional($member)->gender)=='' ? 'selected' : '' }}>Select</option>
            <option value="Male" {{ old('gender', optional($member)->gender)=='Male' ? 'selected' : '' }}>Male</option>
            <option value="Female" {{ old('gender', optional($member)->gender)=='Female' ? 'selected' : '' }}>Female</option>
            <option value="Other" {{ old('gender', optional($member)->gender)=='Other' ? 'selected' : '' }}>Other</option>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Section</label>
        <input type="text" name="section" class="form-control" value="{{ old('section', optional($member)->section) }}">
    </div>

    <button class="btn btn-primary">Create</button>
    <a href="{{ route('reference-data.divisional-members.index') }}" class="btn btn-secondary">Back to List</a>
</form>
