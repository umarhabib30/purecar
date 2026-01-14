@extends('layout.superAdminDashboard')

@section('body')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <h1 class="card-title">Normalization Rules</h1>
                    <p class="text-muted">Manage and normalize car data in real-time</p>
                </div>
                <div class="card-body">
                    <!-- Category Selection -->
                    <div class="mb-4">
                        <label for="categorySelect" class="form-label fw-bold">Select Category</label>
                        <select id="categorySelect" class="form-select form-select-lg">
                            <option value="">-- Choose Category --</option>
                            @foreach($categories as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button class="btn btn-info btn-sm" id="showHistoryBtn" style="display: none;">
                        <i class="fas fa-history"></i> View History
                    </button>

                    <!-- Filters Row -->
                    <div id="filtersRow" class="row mb-3" style="display: none;">
                        <div class="col-md-6">
                            <input type="text" id="searchInput" class="form-control" placeholder="Search values...">
                        </div>
                        <div class="col-md-3">
                            <select id="perPageSelect" class="form-select">
                                <option value="25">25 per page</option>
                                <option value="50" selected>50 per page</option>
                                <option value="100">100 per page</option>
                                <option value="200">200 per page</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <div class="form-check mt-2">
                                <input class="form-check-input" type="checkbox" id="showEmptyCheckbox">
                                <label class="form-check-label" for="showEmptyCheckbox">
                                    Show Empty/Null Only
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Loading Indicator -->
                    <div id="loadingIndicator" class="text-center py-5" style="display: none;">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2">Loading data...</p>
                    </div>

                    <!-- Values Table -->
                    <div id="valuesContainer" style="display: none;">
                        <!-- Bulk Actions Bar -->
                        <div id="bulkActionsBar" class="alert alert-info d-none mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <strong><span id="selectedCount">0</span> items selected</strong>
                                </div>
                                <div>
                                    <button class="btn btn-sm btn-success me-2" id="bulkNormalizeBtn">
                                        <i class="fas fa-check-double"></i> Normalize Selected
                                    </button>
                                    <button class="btn btn-sm btn-warning me-2" id="bulkHideBtn">
                                        <i class="fas fa-eye-slash"></i> Hide Selected
                                    </button>
                                    <button class="btn btn-sm btn-secondary" id="clearSelectionBtn">
                                        <i class="fas fa-times"></i> Clear Selection
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="mb-0" id="tableTitle">Available Values</h5>
                            <button class="btn btn-primary" id="addNewBtn">
                                <i class="fas fa-plus"></i> Add New Mapping
                            </button>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover table-sm">
                                <thead class="table-light">
                                    <tr id="tableHeader">
                                        <th width="5%">
                                            <input type="checkbox" id="selectAllCheckbox" class="form-check-input">
                                        </th>
                                        <th width="20%">Raw Value</th>
                                        <th width="20%">Normalized Value</th>
                                        <th width="8%">Count</th>
                                        <th width="22%">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="valuesTableBody">
                                    <!-- Dynamic content -->
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div id="paginationInfo" class="text-muted"></div>
                            <nav>
                                <ul class="pagination mb-0" id="paginationControls">
                                    <!-- Dynamic pagination -->
                                </ul>
                            </nav>
                        </div>
                    </div>

                    <!-- Empty State -->
                    <div id="emptyState" class="text-center py-5" style="display: none;">
                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                        <p class="text-muted">No values found for this category</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add/Edit Modal -->
<div class="modal fade" id="mappingModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Add New Mapping</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="mappingForm">
                    <input type="hidden" id="modalCategory">
                    <div class="mb-3">
                        <label for="modalRawValue" class="form-label">Raw Value</label>
                        <input type="text" class="form-control" id="modalRawValue" required>
                        <small class="text-muted">Leave as [EMPTY] to map null/empty values</small>
                    </div>
                    <div class="mb-3">
                        <label for="modalNormalizedValue" class="form-label">Normalized Value</label>
                        <input type="text" class="form-control" id="modalNormalizedValue">
                        <small class="text-muted">Leave empty to block this value</small>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="saveMapping">Save</button>
            </div>
        </div>
    </div>
</div>

<!-- Bulk Normalize Modal -->
<div class="modal fade" id="bulkNormalizeModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Bulk Normalize Values</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Normalizing <strong><span id="bulkSelectedCount">0</span> values</strong>:</p>
                <div id="bulkSelectedList" class="mb-3 p-2 bg-light rounded" style="max-height: 200px; overflow-y: auto;">
                    <!-- Selected values will be listed here -->
                </div>
                <form id="bulkNormalizeForm">
                    <div class="mb-3">
                        <label for="bulkNormalizedValue" class="form-label">Normalized Value</label>
                        <input type="text" class="form-control" id="bulkNormalizedValue" required>
                        <small class="text-muted">All selected values will be normalized to this value</small>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" id="saveBulkNormalize">Apply to All</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="historyModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Change History</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-sm table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Date/Time</th>
                                <th>Raw Value</th>
                                <th>Old Value</th>
                                <th>New Value</th>
                                <th>Action</th>
                                <th>Records Affected</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="historyTableBody">
                            <!-- Dynamic content -->
                        </tbody>
                    </table>
                </div>
                <div id="historyPaginationControls" class="d-flex justify-content-center mt-3"></div>
            </div>
        </div>
    </div>
</div>
<style>
.action-btn {
    width: 32px;
    height: 32px;
    padding: 0;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: all 0.2s;
    margin: 0 2px;
}

.action-btn:hover {
    transform: scale(1.1);
}

.badge-hidden {
    background-color: #dc3545;
    color: white;
    padding: 4px 8px;
    border-radius: 4px;
}

.badge-empty {
    background-color: #6c757d;
    color: white;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 0.75rem;
}

.context-info {
    font-size: 0.85rem;
    color: #6c757d;
    font-style: italic;
}

.pagination {
    margin: 0;
}

.pagination .page-link {
    cursor: pointer;
}

.toast-container {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 9999;
}

.custom-toast {
    min-width: 300px;
    margin-bottom: 10px;
    padding: 15px;
    border-radius: 8px;
    color: white;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    animation: slideIn 0.3s ease-out;
}

@keyframes slideIn {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

.toast-success { background-color: #28a745; }
.toast-error { background-color: #dc3545; }
.toast-info { background-color: #17a2b8; }

.row-selected {
    background-color: #e7f3ff !important;
}

.form-check-input {
    cursor: pointer;
}
</style>

<div class="toast-container" id="toastContainer"></div>

<script>
let currentCategory = '';
let currentPage = 1;
let perPage = 50;
let searchTerm = '';
let showEmpty = false;
let modalInstance = null;
let bulkNormalizeModalInstance = null;
let searchTimeout = null;
let selectedValues = new Set();

document.addEventListener('DOMContentLoaded', function() {
    // Category selection
    const categorySelect = document.getElementById('categorySelect');
    categorySelect.addEventListener('change', function() {
        currentCategory = this.value;
        currentPage = 1;
        clearSelection();
        if (currentCategory) {
            document.getElementById('filtersRow').style.display = 'flex';
            loadValues();
        } else {
            document.getElementById('filtersRow').style.display = 'none';
            document.getElementById('valuesContainer').style.display = 'none';
            document.getElementById('emptyState').style.display = 'none';
        }
    });

    // Search input with debounce
    document.getElementById('searchInput').addEventListener('input', function(e) {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            searchTerm = e.target.value;
            currentPage = 1;
            loadValues();
        }, 500);
    });

    // Per page selector
    document.getElementById('perPageSelect').addEventListener('change', function() {
        perPage = parseInt(this.value);
        currentPage = 1;
        loadValues();
    });

    // Show empty checkbox
    document.getElementById('showEmptyCheckbox').addEventListener('change', function() {
        showEmpty = this.checked;
        currentPage = 1;
        loadValues();
    });

    // Add new mapping button
    document.getElementById('addNewBtn').addEventListener('click', function() {
        openModal('add');
    });

    // Save mapping
    document.getElementById('saveMapping').addEventListener('click', function() {
        saveMapping();
    });

    // Select all checkbox
    document.getElementById('selectAllCheckbox').addEventListener('change', function() {
        toggleSelectAll(this.checked);
    });

    // Bulk actions
    document.getElementById('bulkNormalizeBtn').addEventListener('click', openBulkNormalizeModal);
    document.getElementById('bulkHideBtn').addEventListener('click', bulkHideValues);
    document.getElementById('clearSelectionBtn').addEventListener('click', clearSelection);
    document.getElementById('saveBulkNormalize').addEventListener('click', saveBulkNormalize);
});

function loadValues() {
    document.getElementById('loadingIndicator').style.display = 'block';
    document.getElementById('valuesContainer').style.display = 'none';
    document.getElementById('emptyState').style.display = 'none';

    const url = new URL('{{ route("admin.normalization_rules.getValues") }}');
    url.searchParams.append('category', currentCategory);
    url.searchParams.append('page', currentPage);
    url.searchParams.append('per_page', perPage);
    url.searchParams.append('search', searchTerm);
    url.searchParams.append('show_empty', showEmpty ? '1' : '0');

    fetch(url, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById('loadingIndicator').style.display = 'none';
        
        if (data.data.length === 0) {
            document.getElementById('emptyState').style.display = 'block';
            return;
        }

        updateTableHeader();
        renderValues(data.data);
        renderPagination(data.pagination);
        document.getElementById('valuesContainer').style.display = 'block';
        updateBulkActionsBar();
    })
    .catch(error => {
        document.getElementById('loadingIndicator').style.display = 'none';
        showToast('Error loading values', 'error');
        console.error('Error:', error);
    });
}

function updateTableHeader() {
    let headerHTML = '<th width="5%"><input type="checkbox" id="selectAllCheckbox" class="form-check-input"></th>';
    headerHTML += '<th width="20%">Raw Value</th>';
    
    if (currentCategory === 'model') {
        headerHTML += '<th width="12%">Makes</th>';
        headerHTML += '<th width="18%">Normalized Value</th>';
    } else if (currentCategory === 'variant') {
        headerHTML += '<th width="10%">Makes</th>';
        headerHTML += '<th width="10%">Models</th>';
        headerHTML += '<th width="15%">Normalized Value</th>';
    } else {
        headerHTML += '<th width="20%">Normalized Value</th>';
    }
    
    headerHTML += '<th width="8%">Count</th>';
    headerHTML += '<th width="22%">Actions</th>';
    
    document.getElementById('tableHeader').innerHTML = headerHTML;
    
    // Re-attach select all event
    document.getElementById('selectAllCheckbox').addEventListener('change', function() {
        toggleSelectAll(this.checked);
    });
}

function renderValues(values) {
    const tbody = document.getElementById('valuesTableBody');
    tbody.innerHTML = '';

    values.forEach(function(value) {
        const row = createValueRow(value);
        tbody.insertAdjacentHTML('beforeend', row);
    });

    // Attach checkbox event listeners
    document.querySelectorAll('.row-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            toggleRowSelection(this.value, this.checked);
        });
    });
}

function createValueRow(value) {
    const isHidden = value.is_hidden;
    const isEmpty = value.is_empty;
    const displayValue = isHidden ? '<span class="badge-hidden">Hidden</span>' : escapeHtml(value.normalized_value);
    const hasRule = value.has_rule;
    const customBadge = hasRule && value.normalized_value !== value.raw_value && !isHidden 
        ? '<span class="badge bg-info text-white ms-2">Custom</span>' 
        : '';
    
    const emptyBadge = isEmpty ? '<span class="badge-empty ms-2">EMPTY</span>' : '';
    const isAdvancedCategory = ['make', 'model', 'variant'].includes(currentCategory);
    const isSelected = selectedValues.has(value.raw_value);
    
    let rowHTML = `<tr data-raw="${escapeHtml(value.raw_value)}" class="${hasRule ? 'table-warning' : ''} ${isSelected ? 'row-selected' : ''}">
        <td>
            <input type="checkbox" class="form-check-input row-checkbox" value="${escapeHtml(value.raw_value)}" ${isSelected ? 'checked' : ''}>
        </td>
        <td>${escapeHtml(value.raw_value)}${emptyBadge}</td>`;
    
    // Add contextual columns
    if (currentCategory === 'model') {
        rowHTML += `<td><small class="context-info">${escapeHtml(value.makes || '')}</small></td>`;
    } else if (currentCategory === 'variant') {
        rowHTML += `<td><small class="context-info">${escapeHtml(value.makes || '')}</small></td>`;
        rowHTML += `<td><small class="context-info">${escapeHtml(value.models || '')}</small></td>`;
    }
    
    rowHTML += `<td>${displayValue}${customBadge}</td>
        <td><strong>${value.count}</strong></td>
        <td>
            <button class="action-btn btn btn-sm btn-primary" onclick="editValue('${escapeHtml(value.raw_value)}', '${escapeHtml(value.normalized_value)}')" title="Edit">
                <i class="fas fa-pencil-alt"></i>
            </button>
            <button class="action-btn btn btn-sm btn-warning" onclick="hideValue('${escapeHtml(value.raw_value)}')" title="Hide from filters">
                <i class="fas fa-trash"></i>
            </button>
            ${isAdvancedCategory ? `
            <button class="action-btn btn btn-sm btn-danger" onclick="hideAdvert('${escapeHtml(value.raw_value)}')" title="Hide entire advert">
                <i class="fas fa-times"></i>
            </button>
            ` : ''}
        </td>
    </tr>`;
    
    return rowHTML;
}

function toggleRowSelection(rawValue, isSelected) {
    if (isSelected) {
        selectedValues.add(rawValue);
    } else {
        selectedValues.delete(rawValue);
    }
    
    // Update row styling
    const row = document.querySelector(`tr[data-raw="${escapeHtml(rawValue)}"]`);
    if (row) {
        if (isSelected) {
            row.classList.add('row-selected');
        } else {
            row.classList.remove('row-selected');
        }
    }
    
    updateBulkActionsBar();
    updateSelectAllCheckbox();
}

function toggleSelectAll(isSelected) {
    document.querySelectorAll('.row-checkbox').forEach(checkbox => {
        checkbox.checked = isSelected;
        toggleRowSelection(checkbox.value, isSelected);
    });
}

function updateSelectAllCheckbox() {
    const allCheckboxes = document.querySelectorAll('.row-checkbox');
    const checkedCheckboxes = document.querySelectorAll('.row-checkbox:checked');
    const selectAllCheckbox = document.getElementById('selectAllCheckbox');
    
    if (selectAllCheckbox) {
        selectAllCheckbox.checked = allCheckboxes.length > 0 && allCheckboxes.length === checkedCheckboxes.length;
        selectAllCheckbox.indeterminate = checkedCheckboxes.length > 0 && checkedCheckboxes.length < allCheckboxes.length;
    }
}

function updateBulkActionsBar() {
    const count = selectedValues.size;
    const bar = document.getElementById('bulkActionsBar');
    
    if (count > 0) {
        bar.classList.remove('d-none');
        document.getElementById('selectedCount').textContent = count;
    } else {
        bar.classList.add('d-none');
    }
}

function clearSelection() {
    selectedValues.clear();
    document.querySelectorAll('.row-checkbox').forEach(checkbox => {
        checkbox.checked = false;
    });
    document.querySelectorAll('.row-selected').forEach(row => {
        row.classList.remove('row-selected');
    });
    updateBulkActionsBar();
    updateSelectAllCheckbox();
}

function openBulkNormalizeModal() {
    if (selectedValues.size === 0) {
        showToast('Please select at least one value', 'error');
        return;
    }

    document.getElementById('bulkSelectedCount').textContent = selectedValues.size;
    
    const listContainer = document.getElementById('bulkSelectedList');
    listContainer.innerHTML = '';
    
    selectedValues.forEach(value => {
        const div = document.createElement('div');
        div.className = 'mb-1';
        div.innerHTML = `<i class="fas fa-check-circle text-success"></i> ${escapeHtml(value)}`;
        listContainer.appendChild(div);
    });
    
    document.getElementById('bulkNormalizedValue').value = '';
    
    const modalElement = document.getElementById('bulkNormalizeModal');
    if (!bulkNormalizeModalInstance) {
        bulkNormalizeModalInstance = new bootstrap.Modal(modalElement);
    }
    bulkNormalizeModalInstance.show();
}

function saveBulkNormalize() {
    const normalizedValue = document.getElementById('bulkNormalizedValue').value.trim();
    
    if (!normalizedValue) {
        showToast('Please enter a normalized value', 'error');
        return;
    }

    const rawValues = Array.from(selectedValues);
    
    showToast('Processing bulk normalization...', 'info');
    
    fetch('{{ route("admin.normalization_rules.bulkNormalize") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            category: currentCategory,
            raw_values: rawValues,
            normalized_value: normalizedValue
        })
    })
    .then(response => response.json())
    .then(data => {
        showToast(data.message, 'success');
        if (bulkNormalizeModalInstance) {
            bulkNormalizeModalInstance.hide();
        }
        clearSelection();
        loadValues();
    })
    .catch(error => {
        showToast('Error applying bulk normalization', 'error');
        console.error('Error:', error);
    });
}

function bulkHideValues() {
    if (selectedValues.size === 0) {
        showToast('Please select at least one value', 'error');
        return;
    }

    if (!confirm(`Hide ${selectedValues.size} selected values from filters?`)) return;

    const rawValues = Array.from(selectedValues);
    
    fetch('{{ route("admin.normalization_rules.bulkHide") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            category: currentCategory,
            raw_values: rawValues
        })
    })
    .then(response => response.json())
    .then(data => {
        showToast(data.message, 'success');
        clearSelection();
        loadValues();
    })
    .catch(error => {
        showToast('Error hiding values', 'error');
        console.error('Error:', error);
    });
}

function renderPagination(pagination) {
    const { current_page, last_page, total } = pagination;
    
    const start = (current_page - 1) * perPage + 1;
    const end = Math.min(current_page * perPage, total);
    document.getElementById('paginationInfo').textContent = `Showing ${start}-${end} of ${total} values`;
    
    let paginationHTML = '';
    
    paginationHTML += `
        <li class="page-item ${current_page === 1 ? 'disabled' : ''}">
            <a class="page-link" onclick="changePage(${current_page - 1})">Previous</a>
        </li>
    `;
    
    const maxVisible = 5;
    let startPage = Math.max(1, current_page - Math.floor(maxVisible / 2));
    let endPage = Math.min(last_page, startPage + maxVisible - 1);
    
    if (endPage - startPage < maxVisible - 1) {
        startPage = Math.max(1, endPage - maxVisible + 1);
    }
    
    if (startPage > 1) {
        paginationHTML += `<li class="page-item"><a class="page-link" onclick="changePage(1)">1</a></li>`;
        if (startPage > 2) {
            paginationHTML += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
        }
    }
    
    for (let i = startPage; i <= endPage; i++) {
        paginationHTML += `
            <li class="page-item ${i === current_page ? 'active' : ''}">
                <a class="page-link" onclick="changePage(${i})">${i}</a>
            </li>
        `;
    }
    
    if (endPage < last_page) {
        if (endPage < last_page - 1) {
            paginationHTML += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
        }
        paginationHTML += `<li class="page-item"><a class="page-link" onclick="changePage(${last_page})">${last_page}</a></li>`;
    }
    
    paginationHTML += `
        <li class="page-item ${current_page === last_page ? 'disabled' : ''}">
            <a class="page-link" onclick="changePage(${current_page + 1})">Next</a>
        </li>
    `;
    
    document.getElementById('paginationControls').innerHTML = paginationHTML;
}

function changePage(page) {
    if (page < 1 || page > Math.ceil(document.getElementById('paginationInfo').textContent.split('of ')[1].split(' ')[0] / perPage)) {
        return;
    }
    currentPage = page;
    loadValues();
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function editValue(rawValue, normalizedValue) {
    openModal('edit', rawValue, normalizedValue);
}

function openModal(mode, rawValue = '', normalizedValue = '') {
    if (!currentCategory) {
        showToast('Please select a category first', 'error');
        return;
    }
    
    document.getElementById('modalTitle').textContent = mode === 'add' ? 'Add New Mapping' : 'Edit Mapping';
    document.getElementById('modalCategory').value = currentCategory;
    document.getElementById('modalRawValue').value = rawValue;
    document.getElementById('modalRawValue').readOnly = mode === 'edit';
    document.getElementById('modalNormalizedValue').value = normalizedValue === 'null' ? '' : normalizedValue;
    
    const modalElement = document.getElementById('mappingModal');
    if (!modalInstance) {
        modalInstance = new bootstrap.Modal(modalElement);
    }
    modalInstance.show();
}

function saveMapping() {
    const rawValue = document.getElementById('modalRawValue').value.trim();
    const normalizedValue = document.getElementById('modalNormalizedValue').value.trim();
    const category = document.getElementById('modalCategory').value;

    if (!category) {
        showToast('Category is missing. Please close modal and try again.', 'error');
        return;
    }

    if (!rawValue) {
        showToast('Raw value is required', 'error');
        return;
    }

    fetch('{{ route("admin.normalization_rules.storeOrUpdate") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            category: category,
            raw_value: rawValue,
            normalized_value: normalizedValue || null
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        showToast(data.message, 'success');
        if (modalInstance) {
            modalInstance.hide();
        }
        loadValues();
    })
    .catch(error => {
        showToast('Error saving mapping: ' + error.message, 'error');
        console.error('Error:', error);
    });
}

function hideValue(rawValue) {
    if (!confirm('Hide this value from filters?')) return;

    fetch('{{ route("admin.normalization_rules.hide") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            category: currentCategory,
            raw_value: rawValue
        })
    })
    .then(response => response.json())
    .then(data => {
        showToast(data.message, 'success');
        loadValues();
    })
    .catch(error => {
        showToast('Error hiding value', 'error');
        console.error('Error:', error);
    });
}

function hideAdvert(rawValue) {
    if (!confirm('This will hide ALL adverts with this ' + currentCategory + '. Continue?')) return;

    fetch('{{ route("admin.normalization_rules.hide") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            category: currentCategory,
            raw_value: rawValue
        })
    })
    .then(response => response.json())
    .then(data => {
        showToast('Adverts hidden successfully', 'success');
        loadValues();
    })
    .catch(error => {
        showToast('Error hiding adverts', 'error');
        console.error('Error:', error);
    });
}

function escapeHtml(text) {
    if (!text || text === 'null') return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

function showToast(message, type = 'info') {
    const container = document.getElementById('toastContainer');
    const toast = document.createElement('div');
    toast.className = `custom-toast toast-${type}`;
    toast.innerHTML = `
        <strong>${type.charAt(0).toUpperCase() + type.slice(1)}</strong>
        <p style="margin: 5px 0 0 0;">${message}</p>
    `;
    
    container.appendChild(toast);
    
    setTimeout(() => {
        toast.style.opacity = '0';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

let historyModalInstance = null;
let currentHistoryPage = 1;


document.getElementById('showHistoryBtn').addEventListener('click', function() {
    loadHistory();
});


document.getElementById('categorySelect').addEventListener('change', function() {
    currentCategory = this.value;
    currentPage = 1;
    clearSelection();
    if (currentCategory) {
        document.getElementById('filtersRow').style.display = 'flex';
        document.getElementById('showHistoryBtn').style.display = 'inline-block';
        loadValues();
    } else {
        document.getElementById('filtersRow').style.display = 'none';
        document.getElementById('showHistoryBtn').style.display = 'none';
        document.getElementById('valuesContainer').style.display = 'none';
        document.getElementById('emptyState').style.display = 'none';
    }
});

function loadHistory(page = 1) {
    currentHistoryPage = page;
    
    const url = new URL('{{ route("admin.normalization_rules.getHistory") }}');
    url.searchParams.append('category', currentCategory);
    url.searchParams.append('page', page);
    url.searchParams.append('per_page', 20);

    fetch(url, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        renderHistory(data.data);
        renderHistoryPagination(data.pagination);
        
        const modalElement = document.getElementById('historyModal');
        if (!historyModalInstance) {
            historyModalInstance = new bootstrap.Modal(modalElement);
        }
        historyModalInstance.show();
    })
    .catch(error => {
        showToast('Error loading history', 'error');
        console.error('Error:', error);
    });
}

function renderHistory(history) {
    const tbody = document.getElementById('historyTableBody');
    tbody.innerHTML = '';

    if (history.length === 0) {
        tbody.innerHTML = '<tr><td colspan="7" class="text-center text-muted">No history found</td></tr>';
        return;
    }

    history.forEach(function(item) {
        const date = new Date(item.created_at);
        const formattedDate = date.toLocaleString();
        
        const oldValue = item.old_normalized_value === null ? '<span class="badge bg-secondary">Hidden</span>' : escapeHtml(item.old_normalized_value) || '<em class="text-muted">None</em>';
        const newValue = item.new_normalized_value === null ? '<span class="badge bg-secondary">Hidden</span>' : escapeHtml(item.new_normalized_value) || '<em class="text-muted">None</em>';
        
        let actionBadge = '';
        switch(item.action) {
            case 'normalize':
                actionBadge = '<span class="badge bg-primary">Normalize</span>';
                break;
            case 'bulk_normalize':
                actionBadge = '<span class="badge bg-success">Bulk Normalize</span>';
                break;
            case 'hide':
                actionBadge = '<span class="badge bg-warning">Hide</span>';
                break;
            case 'bulk_hide':
                actionBadge = '<span class="badge bg-danger">Bulk Hide</span>';
                break;
            case 'revert':
                actionBadge = '<span class="badge bg-info">Revert</span>';
                break;
        }
        
        const canRevert = item.action !== 'revert';
        
        const row = `
            <tr>
                <td style="white-space: nowrap;">${formattedDate}</td>
                <td>${escapeHtml(item.raw_value) || '<span class="badge-empty">EMPTY</span>'}</td>
                <td>${oldValue}</td>
                <td>${newValue}</td>
                <td>${actionBadge}</td>
                <td><strong>${item.affected_records}</strong></td>
                <td>
                    ${canRevert ? `
                        <button class="btn btn-sm btn-outline-primary" onclick="revertChange(${item.id})" title="Revert this change">
                            <i class="fas fa-undo"></i> Revert
                        </button>
                    ` : '<span class="text-muted">-</span>'}
                </td>
            </tr>
        `;
        
        tbody.insertAdjacentHTML('beforeend', row);
    });
}

function renderHistoryPagination(pagination) {
    const { current_page, last_page } = pagination;
    
    if (last_page <= 1) {
        document.getElementById('historyPaginationControls').innerHTML = '';
        return;
    }
    
    let paginationHTML = '<ul class="pagination mb-0">';
    
    paginationHTML += `
        <li class="page-item ${current_page === 1 ? 'disabled' : ''}">
            <a class="page-link" onclick="loadHistory(${current_page - 1})">Previous</a>
        </li>
    `;
    
    for (let i = 1; i <= last_page; i++) {
        if (i === 1 || i === last_page || (i >= current_page - 2 && i <= current_page + 2)) {
            paginationHTML += `
                <li class="page-item ${i === current_page ? 'active' : ''}">
                    <a class="page-link" onclick="loadHistory(${i})">${i}</a>
                </li>
            `;
        } else if (i === current_page - 3 || i === current_page + 3) {
            paginationHTML += '<li class="page-item disabled"><span class="page-link">...</span></li>';
        }
    }
    
    paginationHTML += `
        <li class="page-item ${current_page === last_page ? 'disabled' : ''}">
            <a class="page-link" onclick="loadHistory(${current_page + 1})">Next</a>
        </li>
    `;
    
    paginationHTML += '</ul>';
    
    document.getElementById('historyPaginationControls').innerHTML = paginationHTML;
}

function revertChange(historyId) {
    if (!confirm('Are you sure you want to revert this change? This will restore the previous value and affect all related records.')) {
        return;
    }
    
    showToast('Reverting change...', 'info');
    
    fetch('{{ route("admin.normalization_rules.revert") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            history_id: historyId
        })
    })
    .then(response => response.json())
    .then(data => {
        showToast(data.message, 'success');
        loadHistory(currentHistoryPage); 
        loadValues(); 
    })
    .catch(error => {
        showToast('Error reverting change', 'error');
        console.error('Error:', error);
    });
}
</script>
@endsection