@extends('layout.superAdminDashboard')

@section('body')
<div class="package-edit-wrapper">
    <h2 class="package-title">Add New Package</h2>
    <form action="{{ route('packages.store') }}" method="POST" class="package-form">
        @csrf
        <div class="form-group">
            <label for="title" class="form-label">Package Title</label>
            <input type="text" name="title" id="title" class="input-field" placeholder="Enter package title" required>
        </div>

        <div class="form-group">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="textarea-field" rows="5" placeholder="Enter package description" required></textarea>
        </div>

        <div class="form-group">
            <label class="form-label">Features</label>
            <div id="features-container">
                <div class="feature-input-group">
                    <input type="text" name="features[]" class="input-field" placeholder="Enter feature" required>
                    <button type="button" class="remove-feature-btn" onclick="removeFeature(this)" style="display: none;">×</button>
                </div>
            </div>
            <button type="button" class="add-feature-btn" onclick="addFeature()">Add Another Feature</button>
        </div>

        <div class="form-group">
            <label for="price" class="form-label">Price</label>
            <input type="number" name="price" id="price" step="0.01" class="input-field" placeholder="Enter package price" required>
        </div>

        <div class="form-group">
            <label for="duration" class="form-label">Duration (in days)</label>
            <input type="number" name="duration" id="duration" class="input-field" placeholder="Enter package duration in days" required>
        </div>

        <div class="form-group">
            <label for="is_active" class="form-label">Status</label>
            <select name="is_active" id="is_active" class="select-field" required>
                <option value="1" selected>Active</option>
                <option value="0">Inactive</option>
            </select>
        </div>

        <div class="form-group">
            <label for="is_featured" class="form-label">Featured Package</label>
            <select name="is_featured" id="is_featured" class="select-field" required>
                <option value="0" selected>No</option>
                <option value="1">Yes</option>
            </select>
        </div>

        <div class="form-group">
            <label for="recovery_payment" class="form-label">Subscription</label>
            <select name="recovery_payment" class="select-field" required>
                <option value="no">No</option>
                <option value="yes">Yes</option>
            </select>
        </div>

        <button type="submit" class="submit-btn">Add Package</button>
    </form>
</div>

<script>
    function addFeature() {
        const container = document.getElementById('features-container');
        const featureGroups = container.getElementsByClassName('feature-input-group');

        // Show remove button for existing features if there's more than one
        if (featureGroups.length === 1) {
            featureGroups[0].querySelector('.remove-feature-btn').style.display = 'block';
        }

        const newFeatureGroup = document.createElement('div');
        newFeatureGroup.className = 'feature-input-group';
        newFeatureGroup.innerHTML = `
            <input type="text" name="features[]" class="input-field" placeholder="Enter feature" style="margin-top:5px;" required>
            <button type="button" class="remove-feature-btn" onclick="removeFeature(this)">×</button>
        `;
        container.appendChild(newFeatureGroup);
    }

    function removeFeature(button) {
        const container = document.getElementById('features-container');
        const featureGroups = container.getElementsByClassName('feature-input-group');

        if (featureGroups.length > 1) {
            button.closest('.feature-input-group').remove();

            // Hide remove button if only one feature remains
            if (featureGroups.length === 1) {
                featureGroups[0].querySelector('.remove-feature-btn').style.display = 'none';
            }
        }
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
