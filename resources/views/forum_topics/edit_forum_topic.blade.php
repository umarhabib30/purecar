@extends('layout.superAdminDashboard')
@section('body')
    <section id="add-post-forum-outer-container">
        <h1>{{ $title }}</h1>
        <form action="{{ route('forum-topic.update', ['id' => $forum_topic->id]) }}" method="post" enctype="multipart/form-data">
            @csrf
            <div id="add-post-forum-inner-container">
                <h2>Edit Post Title, Image, and Relevant Categories</h2>
                <div class="input-group-forum">
                    <label for="title">Title</label>
                    <input type="text" name="title" value="{{ $forum_topic->title }}" placeholder="Add a Title">
                </div>
                <div class="input-group-forum" id="categories-container">
                    <label for="categories">Categories</label>
                    @foreach($forum_topic->forumTopicCategories as $index => $category)
                        <div class="category-input-group">
                            <input type="text" name="categories[{{ $index }}][name]" value="{{ $category->category }}" placeholder="Add a Category" />
                            <input type="file" name="categories[{{ $index }}][image]" accept="image/*">
                            <button type="button" class="delete-category-btn btn btn-danger" data-category-id="{{ $category->id }}">Delete</button>
                        </div>
                    @endforeach
                </div>
                <button type="button" id="new-category" class="btn btn-dark">+ Add</button>
                <div id="btn-container-forum">
                    <button id="cancel-btn" class="btn">Cancel</button>
                    <button type="submit" id="save-btn" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </section>

    <script src="{{ asset('js/jquery.js') }}"></script>
    <script>
        document.getElementById("new-category").addEventListener("click", function () {
            const container = document.getElementById("categories-container");
            const lastInputGroup = container.querySelector(".category-input-group:last-of-type");
            if (lastInputGroup) {
                const newInputGroup = lastInputGroup.cloneNode(true);
                const index = container.querySelectorAll(".category-input-group").length;
                newInputGroup.querySelector('input[type="text"]').name = `categories[${index}][name]`;
                newInputGroup.querySelector('input[type="file"]').name = `categories[${index}][image]`;
                newInputGroup.querySelector('input[type="text"]').value = "";
                newInputGroup.querySelector('.delete-category-btn').removeAttribute('data-category-id');
                container.appendChild(newInputGroup);
            }
        });

        document.querySelectorAll('.delete-category-btn').forEach(button => {
            button.addEventListener('click', function() {
                const categoryId = this.getAttribute('data-category-id');
                if (categoryId) {
                    // If the category has an ID, it means it exists in the database
                    // You can add a hidden input to mark this category for deletion
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'categories_to_delete[]';
                    input.value = categoryId;
                    document.querySelector('form').appendChild(input);
                }
                // Remove the category input group from the DOM
                this.closest('.category-input-group').remove();
            });
        });
    </script>

    <style>
        #add-post-forum-outer-container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h1, h2 {
            text-align: center;
        }
        .input-group-forum {
            margin-bottom: 15px;
        }
        .input-group-forum label {
            display: block;
            font-weight: bold;
        }
        .input-group-forum input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-top: 5px;
        }
        .category-input-group {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }
        #btn-container-forum {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
        }
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-dark {
            background: gray;
            color: #fff;
        }
        .btn-primary {
            background: black;
            color: #fff;
        }
        @media (max-width: 480px) {
            #add-post-forum-outer-container {
                width: 90%;
                padding: 15px;
            }
            .category-input-group {
                flex-direction: column;
            }
            .btn {
                width: 100%;
                margin-top: 5px;
            }
        }
    </style>
@endsection
