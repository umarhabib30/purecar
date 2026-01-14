@extends('layout.superAdminDashboard')
@section('body')
<section id="add-blog-outer-container">
<h1>Create Coupon</h1>
    <form action="{{ route('coupons.store') }}" method="post">
        @csrf
        <div id="add-coupon-inner-container">
            <!-- Coupon Code Input -->
            <div class="input-group">
                <label for="code">Coupon Code <span class="text-danger">*</span></label>
                <input type="text" name="code" placeholder="Enter Coupon Code" required>
            </div>

            <!-- Discount Input -->
            <div class="input-group">
                <label for="discount">Discount Amount <span class="text-danger">*</span></label>
                <input type="number" name="discount" step="0.01" placeholder="Enter Discount" required>
            </div>

            <!-- Discount Type Selection -->
            <div class="input-group">
                <label for="type">Discount Type <span class="text-danger">*</span></label>
                <select name="type" required>
                    <option value="fixed">Fixed</option>
                    <option value="percentage">Percentage</option>
                </select>
            </div>

            <!-- Usage Limit Input -->
            <div class="input-group">
                <label for="usage_limit">Usage Limit</label>
                <input type="number" name="usage_limit" placeholder="Enter Usage Limit (optional)">
            </div>

            <!-- Expiry Date Input -->
            <div class="input-group">
                <label for="expiry_date">Expiry Date</label>
                <input type="date" name="expiry_date">
            </div>

            <!-- Save Button -->
            <div class="btn-container-add-blog">
                <button type="submit" class="btn-primary-1">Save</button>
            </div>
        </div>
    </form>
</section>


<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Manrope:wght@200..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    .note-editor .modal {
    z-index: 1050 !important;
}
.modal-backdrop {
    z-index: 1040 !important;
}

    #add-blog-outer-container {
        font-family: 'Poppins', sans-serif;
        padding: 32px;
        background-color: #F5F6FA;
    }

    #add-blog-outer-container h1 {
        font-weight: 600;
        font-size: 28px;
        margin-bottom: 24px;
        text-align: center;
    }

    #add-blog-inner-container {
        background-color: #fff;
        border-radius: 16px;
        padding: 32px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .input-group {
        margin-bottom: 24px;
        display: block;
    }

    .input-group label {
        font-size: 14px;
        font-weight: 500;
        color: #333;
        margin-top: 8px;
        margin-right: 10px;
        display: block;
    }

    .input-group input,
    .input-group select,
    .input-group textarea {
        width: 100%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 14px;
        font-family: 'Manrope', sans-serif;
     
    }

    .input-group textarea {
        resize: vertical;
    }
    

    .input-group input::placeholder {
        color: #a1a1a1;
    }

    .btn-container-add-blog {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 32px;
    }

    .btn-primary-1 {
        background-color: black;
        border: none;
        padding: 12px 24px;
        font-size: 16px;
        border-radius: 8px;
        max-width: 200px;
        min-width: 200px;
        color: #fff;
        cursor: pointer;
    }

    /* Summernote Editor Customization */
    .note-editor.note-frame {
        border-radius: 8px;
        border: 1px solid #ddd;
    }

    .note-editor.note-frame .note-toolbar {
        background-color: #f8f9fa;
        border-bottom: 1px solid #ddd;
        border-radius: 8px 8px 0 0;
    }

    .note-editor.note-frame .note-statusbar {
        background-color: #f8f9fa;
        border-top: 1px solid #ddd;
        border-radius: 0 0 8px 8px;
    }

    @media (max-width: 768px) {
        #add-blog-outer-container {
            padding: 16px;
        }

        #add-blog-inner-container {
            padding: 16px;
        }

        .btn-container {
            justify-content: center;
        }
    }
</style>
@endsection
