@extends('layout.superAdminDashboard')

@section('body')
<div class="package-edit-wrapper">
    <h2 class="package-title">Edit Package</h2>
    <form action="{{ route('packages.update', $package->id) }}" method="POST" class="package-form">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="title" class="form-label">Package Title</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $package->title) }}" required>
        </div>

        <div class="form-group">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="textarea-field" rows="5" required>{{ old('description', $package->description) }}</textarea>
        </div>

        <div class="form-group">
            <label>Features</label>
            <div id="features-container">
                @foreach ($package->features as $feature)
                <div class="feature-input-group">
                    <input type="text" name="features[]" class="input-field" value="{{ $feature }}" required>
                    <button type="button" class="remove-feature-btn" onclick="removeFeature(this)">×</button>
                </div>
                @endforeach
            </div>
            <button type="button" class="add-feature-btn" onclick="addFeature()">Add Feature</button>
        </div>

        <div class="form-group">
            <label for="price">Price</label>
            <input type="number" name="price" id="price" step="0.01" class="input-field" value="{{ old('price', $package->price) }}" required>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="duration">Duration (days)</label>
                <input type="number" name="duration" id="duration" class="input-field" value="{{ old('duration', $package->duration) }}" required>
            </div>
            <div class="form-group">
                <label for="is_active">Status</label>
                <select name="is_active" id="is_active" class="select-field" required>
                    <option value="1" {{ $package->is_active == 1 ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ $package->is_active == 0 ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="is_featured">Feature</label>
                <select name="is_featured" id="is_featured" class="select-field" required>
                    <option value="1" {{ $package->is_featured == 1 ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ $package->is_featured == 0 ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <div class="form-group">
                <label for="recovery_payment">Subscription</label>
                <select name="recovery_payment" class="select-field" required>
                    <option value="no">No</option>
                    <option value="yes">Yes</option>
                </select>
            </div>
        </div>

        <div class="form-submit">
            <button type="submit" class="submit-btn">Update Package</button>
        </div>
    </form>
</div>

<script>
    function addFeature() {
        const container = document.getElementById('features-container');
        const newFeature = document.createElement('div');
        newFeature.className = 'feature-input-group';
        newFeature.innerHTML = `
            <input type="text" name="features[]" class="input-field" required>
            <button type="button" class="remove-feature-btn" onclick="removeFeature(this)">×</button>
        `;
        container.appendChild(newFeature);
    }

    function removeFeature(button) {
        button.parentElement.remove();
    }
</script>
<style>
    .package-edit-wrapper {
        max-width: 600px;
        margin: auto;
        padding: 20px;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
    }
    .package-title {
        text-align: center;
        margin-bottom: 20px;
    }
    .form-group {
        margin-bottom: 15px;
    }
    .input-field, .textarea-field, .select-field {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }
    .feature-input-group {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .remove-feature-btn {
        background: red;
        color: white;
        border: none;
        cursor: pointer;
        padding: 5px 10px;
    }
    .add-feature-btn {
        background-color:rgb(235, 232, 232);
        color: darkgrey;
        border: none;
        padding: 5px 10px;
        border-radius: 10px;
        margin-top: 10px;
        cursor: pointer;
    }
    .form-row {
        display: flex;
        gap: 10px;
    }
    .submit-btn {
        width: 100%;
        background: black;
        color: white;
        border: none;
        padding: 10px;
        cursor: pointer;
        font-size: 16px;
    }
    @media (max-width: 768px) {
        .form-row {
            flex-direction: column;
        }
    }
</style>
@endsection
