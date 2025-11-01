<!-- Details Modal -->
<div class="modal modal-blur fade" id="details-modal-{{ $solution->platform_id }}" tabindex="-1" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header"><h5 class="modal-title">{{ $solution->platform_name }}</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
            <div class="modal-body modal-details">
                <div class="row">
                    <div class="col-md-6 mb-3"><div class="detail-label">Platform Type</div><div class="detail-value">{{ $solution->platform_type ?? '-' }}</div></div>
                    <div class="col-md-6 mb-3"><div class="detail-label">Platform Owner</div><div class="detail-value">{{ $solution->platform_owner ?? '-' }}</div></div>
                    <div class="col-md-6 mb-3"><div class="detail-label">Developed By</div><div class="detail-value">{{ $solution->developed_by ?? '-' }}</div></div>
                    <div class="col-md-6 mb-3"><div class="detail-label">Software Value</div><div class="detail-value">{{ $solution->software_value ? number_format($solution->software_value, 2) : '-' }}</div></div>
                </div>
            </div>
            <div class="modal-footer"><button type="button" class="btn" data-bs-dismiss="modal">Close</button></div>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal modal-blur fade" id="delete-modal-{{ $solution->platform_id }}" tabindex="-1" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            <div class="modal-status bg-danger"></div>
            <div class="modal-body text-center py-4">
                <h3>Are you sure?</h3>
                <div class="text-muted">Do you really want to delete <strong>{{ $solution->platform_name }}</strong>? This cannot be undone.</div>
            </div>
            <div class="modal-footer">
                <div class="w-100"><div class="row">
                    <div class="col"><a href="#" class="btn w-100" data-bs-dismiss="modal">Cancel</a></div>
                    <div class="col"><button type="button" class="btn btn-danger w-100" wire:click="delete({{ $solution->platform_id }})" data-bs-dismiss="modal">Delete</button></div>
                </div></div>
            </div>
        </div>
    </div>
</div>