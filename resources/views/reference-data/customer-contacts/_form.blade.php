<form action="{{ $action }}" method="POST">
    @csrf
    @if(in_array($method, ['PUT','PATCH'])) @method($method) @endif

    <div class="row mb-3">
        <div class="col-md-3 text-end">
            <label class="form-label" style="color:#fff;">Company</label>
        </div>
        <div class="col-md-9">
            <select name="company_id" id="company_id" class="form-control" required>
                <option value="">Select company</option>
                @foreach($companies as $c)
                    <option value="{{ $c->id }}" {{ old('company_id', optional($contact)->company_id) == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-3 text-end">
            <label class="form-label" style="color:#fff;">External Platform/Solution</label>
        </div>
        <div class="col-md-9">
            <select name="external_platform_id" id="external_platform_id" class="form-control">
                <option value="">Select external platform (optional)</option>
                @foreach($externalPlatforms as $platform)
                    <option value="{{ $platform->platform_id }}" {{ old('external_platform_id', optional($contact)->external_platform_id) == $platform->platform_id ? 'selected' : '' }}>
                        {{ $platform->platform_name }}
                    </option>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const companySelect = document.getElementById('company_id');
    const platformSelect = document.getElementById('external_platform_id');
    
    if (companySelect && platformSelect) {
        companySelect.addEventListener('change', function() {
            const companyId = this.value;
            
            // Clear current options except the first one
            platformSelect.innerHTML = '<option value="">Select external platform (optional)</option>';
            
            if (companyId) {
                // Show loading state
                platformSelect.innerHTML = '<option value="">Loading platforms...</option>';
                
                // Fetch external platforms for this company
                fetch(`{{ route('reference-data.customer-contacts.external-platforms') }}?company_id=${companyId}`)
                    .then(response => response.json())
                    .then(platforms => {
                        // Clear loading state
                        platformSelect.innerHTML = '<option value="">Select external platform (optional)</option>';
                        
                        // Add platforms to dropdown
                        platforms.forEach(platform => {
                            const option = document.createElement('option');
                            option.value = platform.platform_id;
                            option.textContent = platform.platform_name;
                            platformSelect.appendChild(option);
                        });
                    })
                    .catch(error => {
                        console.error('Error fetching platforms:', error);
                        platformSelect.innerHTML = '<option value="">Error loading platforms</option>';
                    });
            }
        });
    }
});
</script>
