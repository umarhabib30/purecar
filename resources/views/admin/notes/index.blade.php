@extends('layout.superAdminDashboard')

@section('body')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg mb-4 bg-light border-0">
                <div class="card-header bg-dark text-white p-4 d-flex justify-content-between align-items-center rounded-top">
                    <h2 class="text-white text-capitalize mb-0">Note Management 📝</h2>
                    <a href="{{ route('admin.notes.create') }}" class="btn btn-outline-light d-flex align-items-center shadow-sm">
                        <i class="fas fa-plus-circle me-2"></i> Create New Note
                    </a>
                </div>

                <div class="card-body p-0">
                    <div class="p-4 border-bottom bg-white rounded-bottom">
                        <h4 class="text-black mb-3">Filter Notes</h4>
                        <form action="{{ route('admin.notes.index') }}" method="GET" class="row g-3 align-items-end">
                            <div class="col-md-3">
                                <label for="search" class="form-label text-muted">Search Content</label>
                                <input type="text" name="search" id="search" class="form-control form-control-lg" placeholder="Search note content..." value="{{ $search }}">
                            </div>
                            <div class="col-md-2">
                                <label for="typeFilter" class="form-label text-muted">Note Type</label>
                                <select name="type" id="typeFilter" class="form-select form-select-lg">
                                    <option value="all">All Types</option>
                                    @foreach($types as $type)
                                        <option value="{{ $type }}" @if($typeFilter === $type) selected @endif>{{ ucfirst($type) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="makeFilter" class="form-label text-muted">Advert Make</label>
                                <select name="make" id="makeFilter" class="form-select form-select-lg">
                                    <option value="">All Makes</option>
                                    @foreach($makes as $make)
                                        <option value="{{ $make }}" @if($makeFilter === $make) selected @endif>{{ $make }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="modelFilter" class="form-label text-muted">Advert Model</label>
                                <input type="text" name="model" id="modelFilter" class="form-control form-control-lg" placeholder="Search model..." value="{{ $modelFilter }}">
                            </div>
                            <div class="col-md-3 d-flex flex-column gap-2">
                                <button type="submit" class="btn btn-primary btn-lg w-100 shadow-sm">
                                    <i class="fas fa-filter me-2"></i> Apply Filters
                                </button>
                                @if($search || $typeFilter !== 'all' || $makeFilter || $modelFilter)
                                    <a href="{{ route('admin.notes.index') }}" class="btn btn-outline-secondary w-100 shadow-sm">
                                        <i class="fas fa-times me-1"></i> Clear Filters
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th class="text-uppercase text-light text-sm font-weight-bold ps-4">Content</th>
                                    <th class="text-uppercase text-light text-sm font-weight-bold">Type</th>
                                    <th class="text-uppercase text-light text-sm font-weight-bold">Created By</th>
                                    <th class="text-uppercase text-light text-sm font-weight-bold">Assigned Adverts</th>
                                    <th class="text-light text-sm">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($notes as $note)
                                    <tr class="border-bottom">
                                        <td>
                                            <p class="text-sm font-weight-bold mb-0 ps-4 text-truncate" style="max-width: 300px;">{{ Str::limit($note->content, 70) }}</p>
                                        </td>
                                        <td>
                                            @php
                                                $badgeClass = 'secondary';
                                                if ($note->type === 'success') {
                                                    $badgeClass = 'success';
                                                } elseif ($note->type === 'warning') {
                                                    $badgeClass = 'warning text-dark';
                                                } elseif ($note->type === 'danger') {
                                                    $badgeClass = 'danger';
                                                }
                                            @endphp
                                            <span class="badge bg-{{ $badgeClass }} py-2 px-3 fw-bold">
                                                {{ ucfirst($note->type) }}
                                            </span>
                                        </td>
                                        <td>
                                            <p class="text-sm font-weight-bold mb-0">{{ $note->creator->name ?? 'N/A' }}</p>
                                        </td>
                                        <td>
                                            <span class="d-block text-sm font-weight-bold text-dark">{{ $note->adverts->count() }} Adverts</span>
                                            <span class="d-block text-xs text-muted">{{ Str::limit($note->adverts->pluck('name')->implode(', '), 50, '...') }}</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.notes.edit', $note) }}" class="btn btn-sm btn-warning shadow-sm me-2" title="Edit Note">
                                                <i class="fas fa-edit me-1"></i> Edit
                                            </a>
                                            <form action="{{ route('admin.notes.destroy', $note) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this note? This action cannot be undone.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger shadow-sm" title="Delete Note">
                                                    <i class="fas fa-trash-alt me-1"></i> Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center p-5 text-muted bg-light">
                                            <i class="fas fa-exclamation-circle me-2"></i> No notes found matching your criteria.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="p-4 border-top">
                        {{ $notes->appends(request()->except('page'))->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection