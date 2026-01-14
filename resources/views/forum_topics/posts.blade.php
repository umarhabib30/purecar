@extends('layout.superAdminDashboard')

@section('body')
<div class="outer-container">
    <section id="category-posts">
        <h2>Posts in Category: {{ $category->category }}</h2>
        <div class="inner-container">
        @foreach ($moderator as $mod)
            @if ($mod->user)
                <p><strong>Selected Moderator:</strong> {{ $mod->user->name }} (ID: {{ $mod->user_id }})</p>
            @else
                <p><strong>Selected Moderator:</strong> Unknown (ID: {{ $mod->user_id }})</p>
            @endif
        @endforeach   
            <button id="add-moderator-btn" class="custom-btn mb-4">Moderator
                <li class="fas fa-cog ms-2"></li>
            </button>

            
        </div>
    </section>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  function editPost(postId, postContent) {
    function stripHtml(html) {
        const div = document.createElement('div');
        div.innerHTML = html;
        return div.textContent || div.innerText || '';
    }
    const sanitizedContent = stripHtml(postContent);
    Swal.fire({
        title: 'Edit Post',
        input: 'textarea',
        inputValue: sanitizedContent,
        inputLabel: 'Update Content',
        inputPlaceholder: 'Enter updated content...',
        showCancelButton: true,
        confirmButtonText: 'Save',
        cancelButtonText: 'Cancel',
        preConfirm: (updatedContent) => {
            if (!updatedContent) {
                Swal.showValidationMessage('Content cannot be empty.');
            } else {
                fetch(`{{ url('/moderator/posts/update') }}/${postId}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ content: updatedContent })
                })
                .then(response => response.json())
                .then(data => {
                    Swal.fire({
                        text: 'This post has been Edited Successfully!',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        location.reload();
                    });
                })
                .catch(error => {
                    Swal.fire({
                        title: 'Error!',
                        text: 'There was an error updating the post.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                });
            }
        }
    });
}
function deletePost(postId) {
    Swal.fire({
        title: 'Are you sure?',
        text: 'This action cannot be undone!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No, cancel!',
        preConfirm: () => {
            fetch(`{{ url('/moderator/posts/delete') }}/${postId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                Swal.fire({
                    text: 'This post has been Deleted Successfully!',
                    confirmButtonText: 'OK'
                }).then(() => {
                    location.reload();
                });
            })
            .catch(error => {
                Swal.fire({
                    title: 'Error!',
                    text: 'There was an error deleting the post.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            });
        }
    });
}
</script>
<script>
      document.getElementById('add-moderator-btn').addEventListener('click', function() {
        let userOptions = {};
        @foreach($users as $user)
            userOptions['{{ $user->id }}'] = '{{ $user->name }}';
        @endforeach

        Swal.fire({
            title: 'Select a User to Add or Update as Moderator',
            text: 'Current Moderator: {{ $currentModerator && $currentModerator->user ? $currentModerator->user->name : 'None' }}',
            input: 'select',
            inputOptions: userOptions,
            inputPlaceholder: 'Select a User',
            showCancelButton: true,
            confirmButtonText: 'Save',
            cancelButtonText: 'Cancel',
            preConfirm: (selectedUserId) => {
                if (!selectedUserId) {
                    Swal.showValidationMessage('Please select a user.');
                } else {
                    let forumTopicCategoryId = '{{ $category->id }}';
                    
                    fetch('{{ route("add.moderator") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            user_id: selectedUserId,
                            forum_topic_category_id: forumTopicCategoryId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                            Swal.fire({
                            text: data.message,
                            confirmButtonText: 'OK'
                        }).then(() => {
                            location.reload();
                        });
                    })
                    .catch(error => {
                        Swal.fire({
                            title: 'Error!',
                            text: 'There was an error adding the moderator.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    });
                }
            }
        });
    });
    </script>
@endsection

<style>
    .posts-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 15px;
    }

    .post-card {
        background-color: #f5f5f5;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
        position: relative;
    }

    .post-card h4 {
        font-size: 18px;
        margin-bottom: 10px;
    }

    .post-card p {
        font-size: 14px;
        margin-bottom: 10px;
    }

    .action-buttons {
        display: flex;
        justify-content: space-between;
        margin-top: 15px;
    }

    .custom-btn-sm {
        padding: 5px 10px;
        font-size: 12px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }
 
</style>
