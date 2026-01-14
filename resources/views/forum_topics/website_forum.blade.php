@extends('layout.layout')
<title>Pure Car Forum | Engage with Fellow Car Enthusiasts</title>
<meta name="description" content=" Participate in discussions with car lovers in Ni. Share experiences, get advice, and stay updated on the latest automotive trends.">
@section('body')
<link rel="stylesheet" href="{{asset('css/forum_page.css')}}">
<style>
@media (max-width: 767px) {
    .ForumDetails .forum-content {
        margin-top: 0 !important;
        padding-top: 0 !important;
    }
}
.fixed-bottom-end {
    position: fixed;
    top: 500px; 
    right: 100px; 
    z-index: 1000; 
}
.fixed-bottom-end-mobile {
    position: fixed;
    bottom: 50px; 
    right: 20px; 
    z-index: 1000; 
}
</style>

<section class="ForumDetails">

    <div class="container forum-container my-4">

        <!-- <h1>{{ $title }}</h1> -->
        <h1 class="d-none d-md-block">PureCar Forum</h1>
        @guest
            <a href="{{ route('signup_view') }}" class="btn btn-success open-modal responsivecategorybutton ms-auto mb-2 d-none d-lg-block fixed-bottom-end d-flex justify-content-center align-items-center">
                <i class="fas fa-user-plus me-2"></i> Signup
            </a>

            <a href="{{ route('signup_view') }}" class="btn btn-success open-modal responsivecategorybutton ms-auto mb-2 d-lg-none fixed-bottom-end-mobile d-flex justify-content-center align-items-center">
                <i class="fas fa-user-plus me-2"></i> Signup
            </a>
        @endguest


        @if($isBlocked)
        <div class="blocked-message text-center">
            <h1>Access Denied</h1>
            <p>You are blocked by the moderator. You do not have access to the forum. Please contact support if you
                believe this is an error.</p>
        </div>
        @else
        @include('layout.forum_heading')
        <div class="forum-tab mb-0">
            <div class="p-2">
                <div class="blocked-users" style="display: none;">
                    @if($blocked_users->isEmpty())
                    <p>No blocked users</p>
                    @else
                    @foreach($blocked_users as $blocked_user)
                    <button class="btn btn-danger blocked-user-btn" data-user-id="{{ $blocked_user->user->id }}"
                        data-user-name="{{ $blocked_user->user->name }}">
                        {{ $blocked_user->user->name }}
                    </button>
                    @endforeach
                    @endif
                </div>

                @foreach($forum_topics as $forum_topic)

                <div class="forum-category  row mb-3 mt-3" style="height: 45px;">
                    <span>{{ $forum_topic->title }}</span>
                </div>
                
                <div class="post-container d-none d-md-block" style="align-items: center;">
                    @foreach($forum_topic->forumTopicCategories as $forum_topic_category)
                    <div class="forum-item row align-items-center mb-3"
                        onclick="window.location.href='{{ route('forum-topic-category', ['forum_topic_category' => $forum_topic_category->id]) }}'">
                        <div class="col-12 col-md-4 d-flex align-items-center mb-2 mb-md-0">
                            <img src="{{ asset('assets/msg.svg') }}" class="icon me-2" alt="comment icon" width="20"
                                height="20">
                            <a class="fw-bold text-dark"
                                href="{{ route('forum-topic-category', ['forum_topic_category' => $forum_topic_category->id]) }}"
                                style="text-decoration: none;">
                                {{ $forum_topic_category->category }}
                            </a>
                        </div>

                        <!-- Empty Space (40%) -->
                        <div class="col-12 col-md-4 d-none d-md-block"></div>

                        <!-- Post Count (5%) -->
                        <div class="col-12 col-md-1 text-center" style="padding: 0; text-align: center">
                            <p class="text-muted small mb-0">
                                {{ $forum_topic->countPostsInForumCategory($forum_topic_category->id) }}<br>posts</p>

                        </div>

                        <!-- Topic Content, Author Info (25%) -->
                        <div class="col-12 col-md-3 d-flex align-items-center g-0">
                            <!-- @if($latestPosts->has($forum_topic_category->id))
                            @php
                            $latestPost = $latestPosts[$forum_topic_category->id];
                            $latestPostcontent = html_entity_decode($latestPost->topic);
                            $latestPostcontent = strip_tags($latestPostcontent);
                            @endphp
                            <img src="{{ $latestPost->userDetails && $latestPost->userDetails->image 
                            ? asset('/images/users/' . $latestPost->userDetails->image) 
                            : asset('/images/default.png') }}" alt="Post author" class="rounded-circle me-2" width="40"
                                height="40">
                            <div>
                                <p class="mb-1 small g-0">
                                    {{ $latestPost->created_at->diffForHumans() }}
                                    <br>
                                    {{ strlen($latestPostcontent) > 20 ? substr($latestPostcontent, 0, 20) . '...' : $latestPostcontent }}
                                </p>
                                <p class="small mb-0 g-0">
                                    <span class="fw-bold">{{ $latestPost->userDetails->name ?? 'Unknown User' }}</span>,


                                </p>
                            </div>
                            @else
                           
                            @endif -->
                            <!-- @if($latestReplies->has($forum_topic_category->id) && $latestReplies[$forum_topic_category->id])
                            @php
                                $reply = $latestReplies[$forum_topic_category->id];
                                $user = $reply->author ?? null;
                                $post = $reply->forumPost ?? null;
                                $postTitle = $post?->topic ?? 'Untitled Topic';
                                $content = strip_tags(html_entity_decode($reply->content ?? ''));
                            @endphp
                            <img src="{{ $user && $user->image 
                                ? asset('/images/users/' . $user->image) 
                                : asset('/images/default.png') }}" 
                                alt="User" class="rounded-circle me-2" width="40" height="40">
                            <div>
                                <p class="mb-1 small g-0">
                                {{ $reply->created_at->diffForHumans() }}
                                    <br>
                                    {{ $postTitle }}
                                </p>
                                <p class="small mb-0 g-0">
                                    <span class="fw-bold">{{ $user->name ?? 'Unknown User' }}</span>,


                                </p>
                            </div>
                            @else
                           
                            @endif -->
                            @if($latestPosts->has($forum_topic_category->id) || $latestReplies->has($forum_topic_category->id))
    @php
        $latestPost = $latestPosts->has($forum_topic_category->id) ? $latestPosts[$forum_topic_category->id] : null;
        $latestReply = $latestReplies->has($forum_topic_category->id) ? $latestReplies[$forum_topic_category->id] : null;

        // Determine which is more recent
        $displayItem = null;
        if ($latestPost && $latestReply) {
            $displayItem = $latestPost->created_at->gt($latestReply->created_at) ? $latestPost : $latestReply;
        } elseif ($latestPost) {
            $displayItem = $latestPost;
        } elseif ($latestReply) {
            $displayItem = $latestReply;
        }

        // Prepare data based on whether it's a post or reply
        if ($displayItem) {
            $isPost = get_class($displayItem) === get_class($latestPost);
            $user = $isPost ? ($displayItem->userDetails ?? null) : ($displayItem->author ?? null);
            $content = $isPost 
                ? strip_tags(html_entity_decode($displayItem->topic ?? ''))
                : strip_tags(html_entity_decode($displayItem->content ?? ''));
            $title = $isPost ? $content : ($displayItem->forumPost->topic ?? 'Untitled Topic');
            $image = $user && $user->image 
                ? asset('/images/users/' . $user->image)
                : asset('/images/default.png');
            $userName = $user->name ?? 'Unknown User';
            $createdAt = $displayItem->created_at->diffForHumans();
        }
    @endphp

    @if($displayItem)
        <img src="{{ $image }}" alt="User" class="rounded-circle me-2" width="40" height="40">
        <div>
            <p class="mb-1 small g-0">
                {{ $createdAt }}<br>
                {{ strlen($title) > 20 ? substr($title, 0, 20) . '...' : $title }}
            </p>
            <p class="small mb-0 g-0">
                <span class="fw-bold">{{ $userName }}</span>
            </p>
        </div>
    @endif
@endif
                            

                            

                            



                        </div>
                    </div>
                    @endforeach
                </div>
                <!-- for mobile -->
                <div class="post-container mb-0 d-md-none">
                    @foreach($forum_topic->forumTopicCategories as $forum_topic_category)
                    <div class="forum-item row align-items-center mb-3"
                        onclick="window.location.href='{{ route('forum-topic-category', ['forum_topic_category' => $forum_topic_category->id]) }}'">

                        <!-- Category Title and Icon -->
                        <div class="col-8 d-flex align-items-center">
                            <a class="fw-bold text-dark text-truncate"
                                href="{{ route('forum-topic-category', ['forum_topic_category' => $forum_topic_category->id]) }}"
                                style="text-decoration: none;">
                                {{ $forum_topic_category->category }}
                            </a>
                        </div>

                        <!-- Post Count -->
                        <div class="col-4 text-end p-0 pe-0 m-0">
                            <p class="text-muted small mb-0">
                                {{ $forum_topic->countPostsInForumCategory($forum_topic_category->id) }}
                                <img src="{{ asset('assets/msg.svg') }}" class="icon me-2" alt="comment icon" width="20"
                                    height="20">
                            </p>
                        </div>

                        <!-- Latest Post Info -->
                        <div class="col-12">






                        <!-- @if($latestReplies->has($forum_topic_category->id) && $latestReplies[$forum_topic_category->id])
                            @php
                                $reply = $latestReplies[$forum_topic_category->id];
                                $user = $reply->author ?? null;
                                $post = $reply->forumPost ?? null;
                                $postTitle = $post?->topic ?? 'Untitled Topic';
                                $content = strip_tags(html_entity_decode($reply->content ?? ''));
                            @endphp
                            <div class="overflow-hidden pb-3 pt-1">
                                <p class="mb-1 small text-truncate">

                                {{ $postTitle }}
                                </p>
                            </div>
                            <div class="d-flex align-items-center">
                                <img src="{{ $latestPost->userDetails && $latestPost->userDetails->image 
                                ? asset('/images/users/' . $latestPost->userDetails->image) 
                                : asset('/images/default.png') }}" alt="Post author" class="rounded-circle me-2" width="40"
                                    height="40">
                                <div class="overflow-hidden">

                                    <p class="small mb-0 text-truncate">
                                        <span
                                            class="fw-bold">{{ $user->name ?? 'Unknown User' }}</span>
                                        <br>
                                        {{ $reply->created_at->diffForHumans() }}

                                    </p>
                                </div>
                            </div>
                            @endif -->
                            @if($latestPosts->has($forum_topic_category->id) || $latestReplies->has($forum_topic_category->id))
    @php
        $latestPost = $latestPosts->has($forum_topic_category->id) ? $latestPosts[$forum_topic_category->id] : null;
        $latestReply = $latestReplies->has($forum_topic_category->id) ? $latestReplies[$forum_topic_category->id] : null;

        // Determine which is more recent
        $displayItem = null;
        if ($latestPost && $latestReply) {
            $displayItem = $latestPost->created_at->gt($latestReply->created_at) ? $latestPost : $latestReply;
        } elseif ($latestPost) {
            $displayItem = $latestPost;
        } elseif ($latestReply) {
            $displayItem = $latestReply;
        }

        // Prepare data based on whether it's a post or reply
        if ($displayItem) {
            $isPost = get_class($displayItem) === get_class($latestPost);
            $user = $isPost ? ($displayItem->userDetails ?? null) : ($displayItem->author ?? null);
            $content = $isPost 
                ? strip_tags(html_entity_decode($displayItem->topic ?? ''))
                : strip_tags(html_entity_decode($displayItem->content ?? ''));
            $title = $isPost ? $content : ($displayItem->forumPost->topic ?? 'Untitled Topic');
            $image = $user && $user->image 
                ? asset('/images/users/' . $user->image)
                : asset('/images/default.png');
            $userName = $user->name ?? 'Unknown User';
            $createdAt = $displayItem->created_at->diffForHumans();
        }
    @endphp

    @if($displayItem)
        <div class="overflow-hidden pb-3 pt-1">
            <p class="mb-1 small text-truncate">
                {{ strlen($title) > 100 ? substr($title, 0, 100) . '...' : $title }}
            </p>
        </div>
        <div class="d-flex align-items-center">
            <img src="{{ $image }}" alt="User" class="rounded-circle me-2" width="40" height="40">
            <div class="overflow-hidden">
                <p class="small mb-0 text-truncate">
                    <span class="fw-bold">{{ $userName }}</span>
                    <br>
                    {{ $createdAt }}
                </p>
            </div>
        </div>
    @endif
@endif
                           
                        </div>
                    </div>
                    @endforeach
                </div>

                @endforeach

            </div>
        </div>

   
           
                
          <style>
            .upergreybar {
    margin-top: 15px !important;
    background-color: #e8e8e8 !important;
    padding: 0.75rem !important;
    border-radius: 0.5rem !important;
    font-weight: bold !important;
    height: 45px !important;
    display: flex;
    align-items: center;  
    justify-content: flex-start; 
    line-height: 45px !important; 
}

.upergreybar p{
    padding-top:18px !important; 
    padding-left: 15px !important;
    padding-left: 15px !important;
}


          </style>   

        <div class="activity-tab" style="display: none;">
       
            @auth
            <ul style="list-style: none; padding: 0;">
                
                <div class="upergreybar mb-2">
                    <p style="">You posted on</p>
                </div>
                @foreach($activities as $activity)
                <div class='list-item'
                    onclick="window.location.href='{{ route('forum-topic-category', ['forum_topic_category' => $activity->forum_topic_category_id]) }}'"
                    style="background-color: #F5F6FA; padding: 10px; margin-bottom: 8px; border-radius: 5px; cursor: pointer;">

                    <li style="margin: 0; padding: 0; background:">

                        <a href="{{ route('forum-topic-category', ['forum_topic_category' => $activity->forum_topic_category_id]) }}"
                            style="color:rgb(22, 22, 22); text-decoration: none;">
                            {{ $activity->forumTopicCategory->category ?? 'No Category' }}

                        </a>
                        <div style="color: #888; font-size: 12px; margin-top: 5px;">
                          {{ \Carbon\Carbon::parse($activity->created_at)->format('d/m/Y') }} :
                            {{ \Carbon\Carbon::parse($activity->created_at)->format('H:i') }}
                        </div>
                    </li>
                </div>
                @endforeach
            </ul>



            @endauth
        </div>
        @if(App\Models\Moderator::where('user_id', auth()->id())->exists())
        <div class="mod-tab" style="display: none;">
            @auth
            @if($moderatedCategories->isNotEmpty())
            <div class="upergreybar">
                <p>Moderated Categories</p>
            
             </div>
            <!-- <div class="reports col-6 text-end">
                    <button class="custom-btn-sm ms-auto" id="view-reports-btn">Reports</button>
                </div> -->

            <div class="forum-items">

                @foreach($moderatedCategories as $category)


                <div class="forum-item d-flex justify-content-between align-items-center mb-3"
                    onclick="window.location.href='{{ route('moderator.posts', $category->id) }}'">
                    <div class="d-flex align-items-center">
                        <img src="{{ asset('assets/msg.svg') }}" class="icon" alt="comment icon" width="20" height="20">
                        <div>
                            <a class="fw-bold mb-0 text-dark" href="{{ route('moderator.posts', $category->id) }}"
                                style="text-decoration: none">{{ $category->category }}</a>
                            <p class="text-muted mb-0 small">Moderated Category</p>
                        </div>
                    </div>
                   
                </div>
                @endforeach
            </div>
            @else
          
            <div class="upergreybar">
                <p>No Moderated Categories</p> 
             </div>
            @endif
            @endauth
        </div>
        <div class="blocked-users-tab" style="display: none;">
            <div class="upergreybar">
                    <p>Blocked Users List</p> 
            </div>
            <div class="blocked-users-list">
                @if($blocked_users->isEmpty())
              
                <p>No blocked users found.</p>
                @else
                @foreach($blocked_users as $blocked_user)
                <div class="forum-item d-flex justify-content-between align-items-center mb-3">
                    <div class="d-flex align-items-center">
                        <img src="{{ $blocked_user->user->image && $blocked_user->user->image 
                            ? asset('/images/users/' . $blocked_user->user->image) 
                            : asset('/images/default.png') }}" class="rounded-circle me-2" width="40" height="40">
                        <div>
                            <p class="fw-bold mb-0">{{ $blocked_user->user->name }}</p>
                            <p class="text-muted mb-0 small">Blocked since:
                                {{ $blocked_user->created_at->format('d/m/Y') }}</p>
                        </div>
                    </div>
                    <button class="btn btn-danger unblock-btn" data-user-id="{{ $blocked_user->user->id }}">
                        Unblock User
                    </button>
                </div>
                @endforeach
                @endif
            </div>
        </div>
        @endif
    </div>

</section>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('blocked-users-btn').addEventListener('click', function() {
        const blockedUsers = [];
        @foreach($blocked_users as $blocked_user)
        blockedUsers.push({
            name: '{{ $blocked_user->user->name }}',
            user_id: '{{ $blocked_user->user->id }}'
        });
        @endforeach

        let blockedUsersList = '';
        blockedUsers.forEach(user => {
            blockedUsersList += `
                    <div style="display: flex; justify-content: center; align-items: center; margin-bottom: 10px;">
                        <span style=text-align: center; margin-right: 10px;">${user.name}</span>
                        <button class="custom-btn-sm unblock-btn" style="font-size:13px; margin-left: 10px;" data-user-id="${user.user_id}">Unblock</button>
                    </div>
                `;
        });

        Swal.fire({
            title: 'Blocked Users',
            html: blockedUsersList,
            showCancelButton: true,
            confirmButtonText: 'Close'
        });
        document.querySelectorAll('.unblock-btn').forEach(button => {
            button.addEventListener('click', function() {
                const userId = this.dataset.userId;
                Swal.fire({
                    title: 'Are you sure?',
                    text: `You are about to unblock ${this.previousSibling.textContent.trim()}.`,
                    showCancelButton: true,
                    confirmButtonText: 'Yes, unblock it!',
                    cancelButtonText: 'No, cancel!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch('{{route('forum.unblock')}}', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': document.querySelector(
                                                'meta[name="csrf-token"]')
                                            .getAttribute('content')
                                    },
                                    body: JSON.stringify({
                                        user_id: userId
                                    })
                                })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    Swal.fire('Unblocked!',
                                        'The user has been unblocked.');
                                    button.closest('div').remove();
                                } else {
                                    Swal.fire('Failed!', data.message ||
                                        'An error occurred.', 'error');
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                Swal.fire('Error!',
                                    'Something went wrong.');
                            });
                    }
                });
            });
        });
    });
});
document.querySelectorAll('.blocked-users-tab .unblock-btn').forEach(button => {
    button.addEventListener('click', function() {
        const userId = this.dataset.userId;
        const userElement = this.closest('.forum-item');
        const userName = userElement.querySelector('.fw-bold').textContent;

        Swal.fire({
            title: 'Are you sure?',
            text: `You are about to unblock ${userName}`,
            showCancelButton: true,
            confirmButtonText: 'Yes, unblock it!',
            cancelButtonText: 'No, cancel!'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('{{ route('forum.unblock') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({
                                user_id: userId
                            })
                        })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire('Unblocked!', 'The user has been unblocked.');
                            userElement.remove();

                            // Check if there are no more blocked users
                            const blockedUsersList = document.querySelector(
                                '.blocked-users-list');
                            if (blockedUsersList && blockedUsersList.children.length ===
                                0) {
                                blockedUsersList.innerHTML =
                                    '<p>No blocked users found.</p>';
                            }
                            // Refresh the page to update both views
                            // window.location.reload();
                        } else {
                            Swal.fire('Failed!', data.message || 'An error occurred.',
                                'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire('Error!', 'Something went wrong.');
                    });
            }
        });
    });
});
</script>
<script>
document.getElementById('forum-tab').addEventListener('click', function() {
    document.getElementById('forum-tab').classList.add('active');
    document.getElementById('activity-tab').classList.remove('active');
    const modTab = document.getElementById('mod-tab');
    const blockedUsersTab = document.getElementById('blocked-users-tab');
    if (modTab) modTab.classList.remove('active');
    if (blockedUsersTab) blockedUsersTab.classList.remove('active');

    document.querySelector('.forum-tab').style.display = 'block';
    document.querySelector('.activity-tab').style.display = 'none';
    if (document.querySelector('.mod-tab')) {
        document.querySelector('.mod-tab').style.display = 'none';
    }
    if (document.querySelector('.blocked-users-tab')) {
        document.querySelector('.blocked-users-tab').style.display = 'none';
    }
});

document.getElementById('activity-tab').addEventListener('click', function() {
    document.getElementById('activity-tab').classList.add('active');
    document.getElementById('forum-tab').classList.remove('active');
    const modTab = document.getElementById('mod-tab');
    const blockedUsersTab = document.getElementById('blocked-users-tab');
    if (modTab) modTab.classList.remove('active');
    if (blockedUsersTab) blockedUsersTab.classList.remove('active');

    document.querySelector('.forum-tab').style.display = 'none';
    document.querySelector('.activity-tab').style.display = 'block';
    if (document.querySelector('.mod-tab')) {
        document.querySelector('.mod-tab').style.display = 'none';
    }
    if (document.querySelector('.blocked-users-tab')) {
        document.querySelector('.blocked-users-tab').style.display = 'none';
    }
});

const modTab = document.getElementById('mod-tab');
if (modTab) {
    modTab.addEventListener('click', function() {
        modTab.classList.add('active');
        document.getElementById('forum-tab').classList.remove('active');
        document.getElementById('activity-tab').classList.remove('active');
        const blockedUsersTab = document.getElementById('blocked-users-tab');
        if (blockedUsersTab) blockedUsersTab.classList.remove('active');

        document.querySelector('.forum-tab').style.display = 'none';
        document.querySelector('.activity-tab').style.display = 'none';
        document.querySelector('.mod-tab').style.display = 'block';
        if (document.querySelector('.blocked-users-tab')) {
            document.querySelector('.blocked-users-tab').style.display = 'none';
        }
    });
}

const blockedUsersTab = document.getElementById('blocked-users-tab');
if (blockedUsersTab) {
    blockedUsersTab.addEventListener('click', function() {
        blockedUsersTab.classList.add('active');
        document.getElementById('forum-tab').classList.remove('active');
        document.getElementById('activity-tab').classList.remove('active');
        if (modTab) modTab.classList.remove('active');

        document.querySelector('.forum-tab').style.display = 'none';
        document.querySelector('.activity-tab').style.display = 'none';
        if (document.querySelector('.mod-tab')) {
            document.querySelector('.mod-tab').style.display = 'none';
        }
        document.querySelector('.blocked-users-tab').style.display = 'block';
    });
}
</script>
<script>
document.getElementById('view-reports-btn').addEventListener('click', function() {
    fetch('/reports')
        .then(response => response.json())
        .then(data => {
            const reports = data.reports;

            if (reports.length > 0) {
                let reportHtml = `
                    <table>
                        <thead>
                            <tr>
                                <th>Reported By</th>
                                <th>Reason</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                `;

                reports.forEach(report => {
                    reportHtml += `
                        <tr>
                            <td>${report.user.name}</td>
                            <td>${report.reason}</td>
                           <td>
                                <div class="action-buttons-rep">
                                    <button class="delete-report-btn custom-btn-sm-rep" data-report-id="${report.id}" data-user-id="${report.user.id}">
                                        <i class="fas fa-trash-alt"></i> 
                                    </button>
                                    <button class="block-user-btn custom-btn-sm-rep" data-user-id="${report.user.id}">
                                        <i class="fas fa-ban"></i>
                                    </button>
                                     <button class="view-user-btn custom-btn-sm-rep" data-forum_topic_id="${report.forum_topic_id}">
                                            <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    `;
                });

                reportHtml += `
                    </tbody>
                </table>
                `;

                Swal.fire({
                    title: 'Reported Users',
                    html: reportHtml,
                    showCancelButton: true,
                    confirmButtonText: 'Close',
                    cancelButtonText: 'Cancel',
                });

                document.querySelectorAll('.delete-report-btn').forEach(button => {
                    button.addEventListener('click', function() {
                        const reportId = this.dataset.reportId;
                        deleteReport(reportId);
                    });
                });

                document.querySelectorAll('.block-user-btn').forEach(button => {
                    button.addEventListener('click', function() {
                        const userId = this.dataset.userId;
                        blockUser(userId);
                    });
                });
                document.querySelectorAll('.view-user-btn').forEach(button => {
                    button.addEventListener('click', function() {
                        const forum_topic_id = this.dataset.forum_topic_id;
                        console.log(forum_topic_id);
                        window.open(`forum/topic/${forum_topic_id}`, '_blank');
                    });
                });

            } else {
                Swal.fire('No reports found', 'There are no reports for this topic.', 'info');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire('No reports found', 'There are no reports for this topic.');
        });
});



function deleteReport(reportId) {
    fetch(`/forum/report/delete/${reportId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire('Report deleted', 'The report has been deleted successfully.', 'success');
            } else {
                Swal.fire('Error', 'An error occurred while deleting the report.', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire('Error', 'An error occurred while deleting the report.', 'error');
        });
}

function blockUser(userId) {
    fetch(`/forum/block/user/${userId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: JSON.stringify({
                user_id: userId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire('User blocked', 'The user has been blocked successfully.', 'success');
            } else {
                Swal.fire('Error', 'An error occurred while blocking the user.', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire('Error', 'An error occurred while blocking the user.', 'error');
        });
}
</script>
@endif


<style>
.forum-item {
    cursor: pointer;
}
</style>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get the URL parameter
    const urlParams = new URLSearchParams(window.location.search);
    const tabParam = urlParams.get('tab'); // Get the value of the 'tab' parameter

    // If the 'tab' parameter exists, trigger the corresponding button
    if (tabParam) {
        const tabButton = document.getElementById(`${tabParam}-tab`);
        if (tabButton) {
            tabButton.click(); // Trigger the button click
        }
    }

    // Add event listeners to tab buttons
    const tabButtons = document.querySelectorAll('.tab-option');
    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Hide all tab content
            document.querySelectorAll('.forum-tab, .activity-tab, .mod-tab, .blocked-users-tab')
                .forEach(tab => {
                    tab.style.display = 'none';
                });

            // Show the corresponding tab content
            const tabId = this.id.replace('-tab',
            ''); // Extract the tab ID (e.g., 'activity' from 'activity-tab')
            const tabContent = document.querySelector(`.${tabId}-tab`);
            if (tabContent) {
                tabContent.style.display = 'block';
            }
        });
    });
});

</script>
@endsection