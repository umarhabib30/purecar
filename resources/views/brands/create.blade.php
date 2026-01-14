@extends('layout.superAdminDashboard')
@section('body')
<section id="add-brand-outer-container">
    <h1>{{ $title }}</h1>
    <form action="{{ route('brand.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div id="add-brand-inner-container">

            <div class="input-group-brand">
                <label for="link">Brand Link</label>
                <input type="url" name="link">
            </div>

            <div class="input-group-brand">
                <label for="image">Image <span class="text-danger">*</span></label>
                <input type="file" name="image" id="image" required onchange="previewImage(event)">
                <!-- Image Preview Container -->
                <div id="image-preview-container" style="margin-top: 10px; display: none;">
                    <img id="image-preview" src="#" alt="Image Preview" style="max-width: 200px; max-height: 200px; border-radius: 10px;">
                </div>
            </div>

            <div id="btn-container-brand">
                <button type="submit" id="save-btn">Save</button>
            </div>
        </div>
    </form>
</section>

<style>
    #add-brand-outer-container{
        background-color:#f5f5f5 ;
        padding: 20px 30px;
        min-height: 90vh;
    }
    #add-brand-inner-container{
        background-color: white;
        padding: 20px 30px;
        border-radius: 20px;
    }
    .input-group-brand {
        margin-bottom: 20px;
    }
    .input-group-brand label{
        font-size: 24px;
        font-weight: 600;
    }
    .input-group-brand input{
        font-size: 20px;
        padding: 10px 10px;
        width: 100%;
    }
    #btn-container-brand{
        display: flex;
        justify-content: end;
        align-items: end;
    }
    #btn-container-brand button{
        background-color: black;
        padding: 10px 20px;
        color: white;
        border: none;
        border-radius: 10px;
    }
</style>

<script>
    function previewImage(event) {
        const input = event.target;
        const previewContainer = document.getElementById('image-preview-container');
        const previewImage = document.getElementById('image-preview');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                previewImage.src = e.target.result;
                previewContainer.style.display = 'block';
            };

            reader.readAsDataURL(input.files[0]);
        } else {
            previewImage.src = '#';
            previewContainer.style.display = 'none';
        }
    }
</script>
@endsection
