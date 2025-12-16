@extends('layouts.app')
@section('page-title','Fields Of Specializations')
@section('content')
<style>
    /* White container with rounded corners */
    .fos-container {
        background: #fff;
        border-radius: 12px;
        padding: 24px;
        margin: 20px auto;
        max-width: 1000px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .fos-container h4 {
        color: #666;
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 20px;
    }
    
    /* Table styling */
    .fos-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }
    
    .fos-table th {
        background: #f8f9fa;
        color: #666;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        padding: 12px 16px;
        border: none;
        border-bottom: 1px solid #e9ecef;
    }
    
    .fos-table td {
        padding: 16px;
        border-bottom: 1px solid #e9ecef;
        color: #333;
        vertical-align: middle;
    }
    
    .fos-table tbody tr:hover {
        background-color: #f8f9fa;
    }
    
    /* Action buttons - circular icons */
    .action-btn {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        border: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin: 0 4px;
        cursor: pointer;
        transition: all 0.2s ease;
        font-size: 14px;
    }
    
    .action-btn-view {
        background-color: #28a745;
        color: white;
    }
    
    .action-btn-view:hover {
        background-color: #218838;
        transform: scale(1.1);
    }
    
    .action-btn-edit {
        background-color: #007bff;
        color: white;
    }
    
    .action-btn-edit:hover {
        background-color: #0056b3;
        transform: scale(1.1);
    }
    
    .action-btn-delete {
        background-color: #dc3545;
        color: white;
    }
    
    .action-btn-delete:hover {
        background-color: #c82333;
        transform: scale(1.1);
    }
    
    /* Create New button */
    .btn-create-new {
        background-color: #007bff;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 500;
    }
    
    .btn-create-new:hover {
        background-color: #0056b3;
        color: white;
    }
</style>

<div class="container">
    <div class="fos-container">
        <!-- Header with title and Create New button -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4>Fields Of Specializations</h4>
            <a href="{{ route('reference-data.fields-of-specializations.create') }}" class="btn btn-create-new">Create New</a>
        </div>

        <!-- Search and Show entries -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="d-flex align-items-center">
                <span class="me-2" style="color: #666; font-size: 14px;">Show</span>
                <form method="GET" class="d-inline">
                    <input type="hidden" name="q" value="{{ request('q') }}">
                    <select name="perPage" onchange="this.form.submit()" class="form-select form-select-sm" style="width: 80px; color: #000; background: #fff; border: 1px solid #ddd;">
                        <option value="10" {{ request('perPage', 10) == 10 ? 'selected' : '' }}>10</option>
                        <option value="25" {{ request('perPage', 10) == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ request('perPage', 10) == 50 ? 'selected' : '' }}>50</option>
                    </select>
                </form>
                <span class="ms-2" style="color: #666; font-size: 14px;">entries</span>
            </div>
            <div class="d-flex align-items-center">
                <span class="me-2" style="color: #666; font-size: 14px;">Search:</span>
                <form method="GET" class="d-flex">
                    <input type="hidden" name="perPage" value="{{ request('perPage', 10) }}">
                    <input type="text" name="q" value="{{ request('q') }}" class="form-control form-control-sm" style="width: 200px; color: #000; background: #fff; border: 1px solid #ddd;" placeholder="Search...">
                    <button type="submit" class="btn btn-sm btn-primary ms-2">Go</button>
                </form>
            </div>
        </div>

        <!-- Table -->
        <table class="fos-table">
            <thead>
                <tr>
                    <th>Field Of Specialization</th>
                    <th>Description</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $i)
                    <tr>
                        <td style="text-transform: uppercase; font-weight: 500;">{{ $i->name }}</td>
                        <td>{{ $i->notes }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <!-- View Button -->
                                <button class="action-btn action-btn-view" title="View Details" onclick="window.location='{{ route('reference-data.fields-of-specializations.show', $i) }}'">
                                    <i class="ti ti-eye"></i>
                                </button>
                                
                                <!-- Edit Button -->
                                <button class="action-btn action-btn-edit" title="Edit" onclick="window.location='{{ route('reference-data.fields-of-specializations.edit', $i) }}'">
                                    <i class="ti ti-pencil"></i>
                                </button>
                                
                                <!-- Delete Button -->
                                <form action="{{ route('reference-data.fields-of-specializations.destroy', $i) }}" method="POST" style="display:inline" onsubmit="return confirm('Are you sure you want to delete this field of specialization?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="action-btn action-btn-delete" title="Delete">
                                        <i class="ti ti-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" style="text-align: center; color: #666; padding: 40px;">No fields of specialization found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination and entries info -->
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div style="color: #666; font-size: 14px;">
                Showing {{ $items->firstItem() ?? 0 }} to {{ $items->lastItem() ?? 0 }} of {{ $items->total() }} entries
            </div>
            <div>
                {{ $items->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>

<script>
    // No animation needed
    </script>
@endsection
