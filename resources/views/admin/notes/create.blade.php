@extends('layout.superAdminDashboard')

@section('body')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg mb-4 border-0">
                <div class="card-header bg-primary text-white p-4 rounded-top">
                    <h2 class="text-white text-capitalize mb-0">Create New Note 📝</h2>
                </div>

                <div class="card-body p-4 bg-light">
                    <form action="{{ route('admin.notes.store') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6 border-end">
                                <h3 class="text-black mb-4 pb-2 border-bottom">Note Details</h3>
                                
                                <div class="mb-4">
                                    <label for="content" class="form-label fw-bold text-dark">Note Content <span class="text-danger">*</span></label>
                                    <textarea name="content" id="content" class="form-control form-control-lg" rows="5" required placeholder="Enter a descriptive note (e.g., Missing image for 20% of adverts)"></textarea>
                                </div>
                                
                                <div class="mb-4">
                                    <label for="type" class="form-label fw-bold text-dark">Type <span class="text-danger">*</span></label>
                                    <select name="type" id="type" class="form-select form-select-lg" required>
                                        <option value="success" class="text-success">✅ Success (e.g., Approved)</option>
                                        <option value="warning" class="text-warning">⚠️ Warning (e.g., Needs review)</option>
                                        <option value="danger" class="text-danger">🛑 Danger (e.g., Blocked)</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-6 ps-md-5">
                                <h3 class="text-black mb-4 pb-2 border-bottom">Assign Adverts</h3>

                                <div class="row mb-4 g-3">
                                    <div class="col-md-4">
                                        <label for="advert_make_filter" class="form-label text-muted">Filter by Make</label>
                                        <select id="advert_make_filter" class="form-select">
                                            <option value="">Select Make (All)</option>
                                            @foreach($makes as $make)
                                                <option value="{{ $make }}">{{ $make }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="advert_model_filter" class="form-label text-muted">Filter by Model</label>
                                        <input type="text" id="advert_model_filter" class="form-control" placeholder="Search Model...">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="advert_year_from" class="form-label text-muted">Year From</label>
                                        <input type="number" id="advert_year_from" class="form-control" placeholder="e.g., 2015" min="{{ $minYear }}" max="{{ $maxYear }}">
                                    </div>
                                </div>

                                <div class="row mb-4 g-3">
                                    <div class="col-md-4">
                                        <label for="advert_year_to" class="form-label text-muted">Year To</label>
                                        <input type="number" id="advert_year_to" class="form-control" placeholder="e.g., 2024" min="{{ $minYear }}" max="{{ $maxYear }}">
                                    </div>
                                    <div class="col-md-8 d-flex align-items-end">
                                        <button type="button" id="apply_advert_filter" class="btn btn-info w-100 shadow-sm" title="Apply Filter">
                                            <i class="fas fa-search me-2"></i> Apply Filter
                                        </button>
                                    </div>
                                </div>
                                
                                <div class="mb-4">
                                    <label for="selected_adverts" class="form-label fw-bold text-dark">Select Adverts (Max 100 results)</label>
                                    <select name="selected_adverts[]" id="selected_adverts" class="form-select" multiple size="10" required>
                                        @foreach($adverts as $advert)
                                            <option value="{{ $advert->advert_id }}">
                                                {{ ($advert->make ?? 'Unknown') . ' ' . ($advert->model ?? 'Unknown') . ' (' . ($advert->year ?? 'N/A') . ') - ' . $advert->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="form-text text-muted">
                                        Use **Ctrl/Cmd** to select multiple. The list updates after applying a filter.
                                    </small>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end pt-4 border-top mt-4">
                            <a href="{{ route('admin.notes.index') }}" class="btn btn-outline-secondary btn-lg me-3 shadow-sm">
                                <i class="fas fa-ban me-2"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg shadow-sm">
                                <i class="fas fa-paper-plane me-2"></i> Create and Assign Note
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#apply_advert_filter').on('click', function() {
        var make = $('#advert_make_filter').val();
        var model = $('#advert_model_filter').val();
        var yearFrom = $('#advert_year_from').val();
        var yearTo = $('#advert_year_to').val();
        var selectElement = $('#selected_adverts');
        
        // Clear previous options
        selectElement.empty().append('<option disabled>Loading adverts...</option>');
        
        $.ajax({
            url: "{{ route('admin.notes.getAdvertsByFilter') }}",
            type: 'GET',
            data: { 
                make: make, 
                model: model,
                year_from: yearFrom,
                year_to: yearTo
            },
            success: function(data) {
                selectElement.empty();
                if (data.length > 0) {
                    $.each(data, function(index, advert) {
                        selectElement.append('<option value="' + advert.id + '">' + advert.text + '</option>');
                    });
                } else {
                    selectElement.append('<option disabled>No adverts found with these filters.</option>');
                }
            },
            error: function() {
                selectElement.empty().append('<option disabled>Error loading adverts.</option>');
            }
        });
    });
});
</script>
@endsection