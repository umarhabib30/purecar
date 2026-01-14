@extends('layout.superAdminDashboard')
@section('body')
<section id="faq-update-outer-container">
    <h1>Update FAQ</h1>
    <form action="{{ route('faq.update', ['id' => $faq->id]) }}" method="post" enctype="multipart/form-data">
        @csrf
        <div id="faq-update-inner-container">
            <div class="form-group">
                <label for="question">Question <span class="text-danger">*</span></label>
                <textarea name="question" id="question" class="form-control" rows="3" placeholder="Enter the question">{{ $faq->question }}</textarea>
            </div>
            <div class="form-group">
                <label for="answer">Answer <span class="text-danger">*</span></label>
                <textarea name="answer" id="answer" class="form-control" rows="5" placeholder="Enter the answer">{{ $faq->answer }}</textarea>
            </div>
            <div class="btn-container">
                <button type="submit" class="btn-save">Save Changes</button>
            </div>
        </div>
    </form>
</section>
<style>
    #faq-update-outer-container {
        max-width: 800px;
        margin: 20px auto;
        padding: 20px;
        background-color: #f9f9f9;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    #faq-update-outer-container h1 {
        font-size: 24px;
        margin-bottom: 20px;
        color: #333;
        text-align: center;
    }
    .form-group {
        margin-bottom: 20px;
    }
    .form-group label {
        display: block;
        font-weight: 600;
        margin-bottom: 8px;
        color: #555;
    }
    .form-control {
        width: 100%;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
        resize: vertical;
    }
    .form-control:focus {
        border-color: black;
        outline: none;
    }
    .btn-save {
        background-color: black;
        color: #fff;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        font-size: 16px;
        cursor: pointer;
    }
    @media (max-width: 768px) {
        #faq-update-outer-container {
            padding: 15px;
        }
        #faq-update-outer-container h1 {
            font-size: 20px;
        }
        .form-control {
            font-size: 12px;
        }
        .btn-save {
            padding: 8px 16px;
            font-size: 14px;
        }
    }
    @media (max-width: 480px) {
        #faq-update-outer-container {
            padding: 10px;
        }
        #faq-update-outer-container h1 {
            font-size: 18px;
        }
        .form-group label {
            font-size: 14px;
        }
        .form-control {
            padding: 8px;
        }
        .btn-save {
            width: 100%;
            padding: 10px;
        }
    }
</style>
@endsection
