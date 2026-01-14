@extends('layout.layout')

@section('body')
<title>{{ $forum_post->topic }} | Pure Car Forum</title>
<meta name="description" content="{{ Str::limit(strip_tags($forum_post->content), 160, '') }}">
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
      @media screen and (max-width: 767px) {
        .event-container-box img {
            width: 140px;
            height: 140px;
            border-radius: 8px;
            object-fit: cover;
        }
        .event-container-box {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            padding: 10px;
            place-items: center; 
        } 
    }
    @media screen and (min-width: 768px) {
        .event-container-box img{
            width: 100%;
            height: 200px;
            border-radius: 8px;
            object-fit: cover;
        }
        .event-container-box{
            display: grid;
            grid-template-columns: repeat(3,1fr);
            gap: 10px;
            border-radius: 8px;
            overflow: hidden;
            cursor: pointer;
            text-align: center;
        }
       
    }  
    @media (max-width: 767px) { 
        /* .media-thumbnail {
            width: 130px !important;  
            height: 130px !important;  
            margin-bottom: 10px !important;   
            object-fit: cover !important; 
        } */
        #editpostbutttonmobile{
            width: 50px !important;  
            height: 50px !important;
        }
}
@media (max-width: 576px) {
        #hello {
                background-color: #e8e8e8;
                padding: 0.75rem !important;
                margin-top: 0 !important;
                border-radius: 0.5rem !important;
                font-weight: bold !important;
                height: 45px !important;
                width: 100% !important;
                font-size: 16px !important;

                display: flex !important;
                align-items: center !important;
                justify-content: start; /* Optional: Centers text horizontally */
            }

            .responsivecategorybutton{
                /* padding: 0 !important;
                margin: 0 !important; */
                align-items: center !important;
                justify-content: end; /* Optional: Centers text horizontally */
            }
            .forum #forum-container{
                margin: 40px auto !important;
            }
            .forum{
                padding: 8px !important;
                margin: 0 !important;

            }
}
#hello {
                background-color: #e8e8e8;
                padding: 0.75rem !important;
                margin-top: 20px;
                border-radius: 0.5rem !important;
                font-weight: bold !important;
                height: 45px !important;
                width: 100% !important;
                font-size: 16px !important;

                display: flex !important;
                align-items: center !important;
                justify-content: start; /* Optional: Centers text horizontally */
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

   
    

<script src="{{ asset('tinymce/tinymce.min.js') }}"></script>


<div class="forum container">
    <div id="forum-container">

        @include('layout.forum_heading')
        <div class="forum-tab">
        <h5 id="hello" style="overflow: hidden; word-wrap: break-word; padding">
        {!! $forum_post->topic !!}
        </h5>
        @guest
            <a href="{{ route('signup_view') }}" class="btn btn-success open-modal responsivecategorybutton ms-auto mb-2 d-none d-lg-block fixed-bottom-end d-flex justify-content-center align-items-center">
                <i class="fas fa-user-plus me-2"></i> Signup
            </a>

            <a href="{{ route('signup_view') }}" class="btn btn-success open-modal responsivecategorybutton ms-auto mb-2 d-lg-none fixed-bottom-end-mobile d-flex justify-content-center align-items-center">
                <i class="fas fa-user-plus me-2"></i> Signup
            </a>
        @endguest
        @if ($currentPage === 1)
            <div class="forum-topic inner-container"
            style="background-color: #F5F6FA; padding: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); margin: 20px 0; width: 100%; position: relative;">
                <div class="post-header" style=" padding: 10px 0; display: flex; align-items: flex-start; gap: 10px;">
                

                    <img src="{{ $forum_post->userDetails && $forum_post->userDetails->image 
                        ? asset('/images/users/' . $forum_post->userDetails->image) 
                        : asset('/images/default.png') }}" alt="User Image"
                        style="width: 50px; height: 50px; border-radius: 50%;">
                    <div>
                        <p style="margin: 0; font-weight: bold;">
                            {{ $forum_post->userDetails ? $forum_post->userDetails->name : 'Unknown Author' }}
                        </p>

                        <span style="font-size: 0.9em; color: gray;">
                            <i class="fa fa-location" style="margin-right: 5px;"></i>
                            {{ $forum_post->userDetails ? $forum_post->userDetails->location : 'Unknown' }}</span>
                        <br>
                        <span style="font-size: 0.9em; color: gray;">
                            <i class="fa fa-calendar" style="margin-right: 5px;"></i>
                            {{ \Carbon\Carbon::parse($forum_post->created_at)->format('j F Y g:i A') }}
                        </span>

                    </div>
                   
                    <div class="forum-dropdown" style="position: absolute; right: 10px; top: 10px;">
    <button class="forum-dropdown-btn" style="background: none; border: none; cursor: pointer; width: 35px; height: 35px; border-radius: 50%; display: flex; align-items: center; justify-content: center; transition: background-color 0.2s;">
        <i class="fa fa-cog" style="font-size: 16px;"></i>
    </button>
    <div class="forum-dropdown-menu" style="display: none; position: absolute; right: 0; top: 100%; background-color: white; border: 1px solid #ddd; border-radius: 5px; box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.2); z-index: 1000; width: 200px; margin-top: 5px;">
        @if(Auth::check() && Auth::id() === $forum_post->user_id)
            <button class="forum-dropdown-item edit-btn" data-post-id="{{ $forum_post->id }}"
                data-post-topic="{{ $forum_post->topic }}"
                data-post-content="{{ $forum_post->content }}"
                style="display: block; width: 100%; padding: 12px 15px; border: none; background: none; cursor: pointer; text-align: left; font-size: 14px; transition: background-color 0.2s; border-bottom: 1px solid #eee;">
                Edit
            </button>
            <button class="forum-dropdown-item delete-btn" data-post-id="{{ $forum_post->id }}"
                style="display: block; width: 100%; padding: 12px 5px !important; border: none; background: none; cursor: pointer; text-align: left; font-size: 14px; transition: background-color 0.2s;">
                Delete
            </button>
        @elseif(Auth::check() && (Auth::user()->role === 'admin' || App\Models\Moderator::where('user_id', auth()->id())->where('forum_topic_id', $forum_post->forum_topic_category_id)->exists()))
            <form action="" method="POST" id="block-permanent-form" style="display: block; width: 100%; border-bottom: 1px solid #eee;">
                @csrf
                <input type="hidden" name="user_id" value="{{ $forum_post->userDetails?->id }}">
                <button type="button" class="forum-dropdown-item block-user" id="blockP"
                    data-user-id="{{ $forum_post->userDetails?->id }}"
                    style="display: block; width: 100%; padding: 12px 15px; border: none; background: none; cursor: pointer; text-align: left; font-size: 14px; transition: background-color 0.2s;"
                    data-is-blocked="{{ $isBlocked = \App\Models\ModeratorBlockedUser::where('auth_id', auth()->id())->where('user_id', $forum_post->userDetails?->id)->exists() }}">
                    {{ $isBlocked ? 'Unblock User' : 'Block User' }}
                </button>
            </form>
            <button class="forum-dropdown-item edit-btn" data-post-id="{{ $forum_post->id }}"
                data-post-topic="{{ $forum_post->topic }}"
                data-post-content="{{ $forum_post->content }}"
                style="display: block; width: 100%; padding: 12px 27px !important; border: none; background: none; cursor: pointer; text-align: left; font-size: 14px; transition: background-color 0.2s; border-bottom: 1px solid #eee;">
                Edit
            </button>
            <button class="forum-dropdown-item delete-btn" data-post-id="{{ $forum_post->id }}"
                style="display: block; width: 100%; padding: 12px 15px; border: none; background: none; cursor: pointer; text-align: left; font-size: 14px; transition: background-color 0.2s;">
                Delete
            </button>
        @else
            <form id="report-form" action="{{ route('forum.report') }}" method="POST" style="display: none;">
                @csrf
                <input type="hidden" name="user_id" value="">
                <input type="hidden" name="post_id" value="{{ $forum_post->id }}">
                <input type="hidden" name="forum_topic_id" value="{{ $forum_post->id }}">
                <input type="hidden" name="forum_topic_category_id" value="{{ $forum_post->forum_topic_category_id }}">
                <input type="hidden" name="type" value="post">
                <input type="hidden" name="reason" value="">
            </form>
            <button class="forum-dropdown-item" id="report-option"
                style="display: block; width: 100%; padding: 12px 15px; border: none; background: none; cursor: pointer; text-align: left; font-size: 14px; transition: background-color 0.2s;">
                Report
                <input type="hidden" name="user_id" value="{{ $forum_post->userDetails?->id ?? '' }}">
                <input type="hidden" name="forum_topic_id" value="{{ $forum_post->id }}">
                <input type="hidden" name="forum_topic_category_id" value="{{ $forum_post->forum_topic_category_id }}">
            </button>
        @endif
    </div>
</div>





                    
                </div>
               
                <div class="event-container-box forum-media" style="margin-top: 5px;">
    @foreach($forum_post->forumPostMedia as $media)
    <img src="{{ asset('/images/forum_posts/'.$media->media) }}" alt="Media" class="media-thumbnail"
       
        onclick="openFullScreen(this)">
    @endforeach
</div>
                <div class="forum-content" style="margin-top: 0px; word-wrap: break-word;">
                <p style="margin-top: 0px; padding-left: 0px !important; word-wrap: break-word; overflow-wrap: break-word;">
                    {!! preg_replace_callback(
                        '/<(img|source)\s+([^>]*src=[\'"])(\.\.\/(images|videos)\/[^\'"]+)([\'"])/i',
                        function ($matches) {
                            return '<' . $matches[1] . ' ' . $matches[2] . '../../' . $matches[3] . $matches[5];
                        },
                        str_replace(
                            ['<img', '<source'], 
                            ['<img class="media-thumbnail" style="width: 300px; height: 300px; margin-right: 10px; border-radius: 20px; cursor: pointer; object-fit: cover;"', 
                            '<source class="video-source"'], 
                            $forum_post->content
                        )
                    ) !!}
                </p>


                </div>

                @endif
               

            </div>

            <div class="replies-section">

                
              


                @foreach($replies as $reply)

                <div class="inner-container mt-4"
                style="background-color: #F5F6FA; padding: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); margin: 20px 0; width: 100%; position: relative;">
                    <div class="reply-item"
                        style="padding: 10px 0; display: flex; align-items: flex-start; gap: 10px;">
                        <img src="{{ $reply->users_profile ? asset('/images/users/'.$reply->users_profile) : asset('/images/default.png') }}"
                            alt="Post author" class="author-pic" style="width: 50px; height: 50px; border-radius: 50%;">
                        <div style="max-width: calc(100% - 50px); word-wrap: break-word;">
                            <p style="margin: 0; font-weight: bold;">
                                {{ $reply->user_name }}
                            </p>
                            <span style="font-size: 0.9em; color: gray;">
                                <i class="fa fa-location" style="margin-right: 5px;"></i>
                                {{ $reply->user_location ? $reply->user_location : 'Unknown' }}
                            </span>
                            <br>
                            <span style="font-size: 0.9em; color: gray;">
                                <i class="fa fa-calendar" style="margin-right: 5px;"></i>
                                {{ \Carbon\Carbon::parse($reply->created_at)->format('j F Y g:i A') }}
                            </span>

                            
                            <!-- <p style="margin-top: 5px; padding-left: 0px; word-wrap: break-word; overflow-wrap: break-word;">
                                    {!! str_replace('<img', '<img class="media-thumbnail" style="width: 300px; height: 300px; margin-right: 10px; border-radius: 20px; cursor: pointer; object-fit: cover;"', $reply->content) !!}
                            </p> -->

                        </div>
                       

                        <div class="forum-dropdown" style="position: absolute; right: 10px; top: 10px;">
                            <button class="forum-dropdown-btn" style="background: none; border: none; cursor: pointer; padding: 8px;">
                                <i class="fa fa-cog"></i>
                            </button>
                            <div class="forum-dropdown-menu" style="display: none; position: absolute; right: 0; top: 100%; background-color: white; border: 1px solid #ddd; border-radius: 5px; box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.2); z-index: 1000; width: 200px; margin-top: 5px;">
                                @if(Auth::check() && Auth::id() === $reply->auth_id)
                                    <button class="forum-dropdown-item edit-btn_reply" data-reply-id="{{ $reply->id }}"
                                        data-reply-content="{{ $reply->content }}"
                                         data-reply-media="{{ $reply->media }}"
                                         data-reply-media-urls="{{ json_encode(array_map(function($media) { return asset($media); }, json_decode($reply->media, true) ?? [])) }}"
                                        style="display: block; width: 100%; padding: 12px 15px; border: none; background: none; cursor: pointer; text-align: left; border-bottom: 1px solid #eee;">
                                        Edit
                                    </button>
                                    <button class="forum-dropdown-item delete-btn_reply" data-reply-id="{{ $reply->id }}"
                                        style="display: block; width: 100%; padding: 12px 15px; border: none; background: none; cursor: pointer; text-align: left;">
                                        Delete
                                    </button>
                                @elseif(Auth::check() && (Auth::user()->role === 'admin' || App\Models\Moderator::where('user_id', Auth::id())->where('forum_topic_id', $forum_post->forum_topic_category_id)->exists()))
                                    <form action="" method="POST" id="block-permanent-form" style="display: block; width: 100%;">
                                        @csrf
                                        <input type="hidden" name="auth_id" value="{{ $reply->auth_id }}">
                                        <button type="button" class="forum-dropdown-item block-user" id="blockP"
                                            data-user-id="{{ $reply->auth_id }}"
                                            style="display: block; width: 100%; padding: 12px 5px !important; border: none; background: none; cursor: pointer; text-align: left; border-bottom: 1px solid #eee;"
                                            data-is-blocked="{{ $isBlocked = \App\Models\ModeratorBlockedUser::where('auth_id', auth()->id())->where('user_id', $forum_post->userDetails->id)->exists() }}">
                                            {{ $isBlocked ? 'Unblock User' : 'Block User' }}
                                        </button>
                                    </form>
                                    <button class="forum-dropdown-item edit-btn_reply" data-reply-id="{{ $reply->id }}"
                                        data-reply-content="{{ $reply->content }}"
                                         data-reply-media="{{ $reply->media }}"
                                         data-reply-media-urls="{{ json_encode(array_map(function($media) { return asset($media); }, json_decode($reply->media, true) ?? [])) }}"
                                        style="display: block; width: 100%; padding: 12px 15px !important; border: none; background: none; cursor: pointer; text-align: left; border-bottom: 1px solid #eee;">
                                        Edit
                                    </button>
                                    <button class="forum-dropdown-item delete-btn_reply" data-reply-id="{{ $reply->id }}"
                                        style="display: block; width: 100%; padding: 12px 15px; border: none; background: none; cursor: pointer; text-align: left;">
                                        Delete
                                    </button>
                                @else
                                    <form id="report-form-reply-{{ $reply->id }}" action="{{ route('forum.report') }}"
                                        method="POST" style="display: none;">
                                        @csrf
                                        <input type="hidden" name="user_id" value="">
                                        <input type="hidden" name="post_id" value="{{ $forum_post->id }}">
                                        <input type="hidden" name="forum_topic_id" value="{{ $forum_post->forum_topic_category_id }}">
                                        <input type="hidden" name="forum_topic_category_id" value="{{ $forum_post->forum_topic_category_id }}">
                                        <input type="hidden" name="reply_id" value="{{ $reply->id }}">
                                        <input type="hidden" name="type" value="reply">
                                        <input type="hidden" name="reason" value="">
                                    </form>
                                    <button class="forum-dropdown-item report-option-reply" data-reply-id="{{ $reply->id }}"
                                        style="display: block; width: 100%; padding: 12px 15px; border: none; background: none; cursor: pointer; text-align: left;">
                                        Report
                                        <input type="hidden" name="user_id" value="{{ $reply->auth_id }}">
                                        <input type="hidden" name="post_id" value="{{ $forum_post->id }}">
                                        <input type="hidden" name="forum_topic_id" value="{{ $forum_post->id }}">
                                        <input type="hidden" name="reply_id" value="{{ $reply->id }}">
                                        <input type="hidden" name="forum_topic_category_id" value="{{ $forum_post->forum_topic_category_id }}">
                                    </button>
                                @endif
                            </div>
                        </div>



                    </div>
                    
                    <div style="word-wrap: break-word;">     
                            <p style="margin-top: 5px; padding-left: 0px !important; word-wrap: break-word; overflow-wrap: break-word;">
                                    {!! str_replace('<img', '<img class="media-thumbnail" style="width: 300px; height: 300px; margin-right: 10px; border-radius: 20px; cursor: pointer; object-fit: cover;"', $reply->content) !!}
                            </p>
                    </div>
                    @if(!empty($reply->media))
                        <div class="reply-images" style="margin-top: 10px; display: flex; flex-wrap: wrap; gap: 10px;">
                            @foreach(json_decode($reply->media, true) as $image)
                                <img src="{{ asset($image) }}" 
                                    alt="Reply Image" 
                                    class="media-thumbnail"
                                    style="width: 300px; height: 300px; margin-right: 10px; border-radius: 20px; cursor: pointer; object-fit: cover;">
                            @endforeach
                        </div>
                    @endif
                </div>




                @endforeach
                <div class="pagination-container">
                    <p>{{ $replies->links() }}</p>
                </div>
            </div>

            <div id="fullscreenViewer" class="fullscreen-viewer">
    <span class="close-btnmodel" onclick="closeFullScreen()">&times;</span>
    <button class="prev-btn" onclick="changeImage(-1)">&#10094;</button>
    <img id="fullscreenImage" class="fullscreen-image">
    <button class="next-btn" onclick="changeImage(1)">&#10095;</button>
</div>

<style>
   
    .fullscreen-viewer { 
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.9);
        z-index: 1000;
        justify-content: center;
        align-items: center;
        flex-direction: column;
    }

    .fullscreen-image {
        max-width: 90%;
        max-height: 80vh;
   
    }

    .close-btnmodel {
        position: absolute;
        top: 20px;
        right: 30px;
        font-size: 30px;
        color: white;
        cursor: pointer;
    }

    .prev-btn, .next-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        font-size: 30px;
        color: white;
        background: none;
        border: none;
        cursor: pointer;
    }

    .prev-btn { left: 20px; }
    .next-btn { right: 20px; }
    @media (max-width: 600px) {
        .fullscreen-image {
            max-width: 95%;
            max-height: 70vh;
        }
        .prev-btn, .next-btn { font-size: 25px; }
        .close-btnmodel { font-size: 25px; }
    }
</style>

<script>
     document.getElementById("fullscreenViewer").addEventListener("click", function (event) {
    if (event.target === this) {
        closeFullScreen();
    }
});
 let images = [];
let currentIndex = 0;

// document.addEventListener("DOMContentLoaded", function () {
//     images = Array.from(document.querySelectorAll('.media-thumbnail'));

//     images.forEach(img => {
//         img.addEventListener("click", function () {
//             openFullScreen(img);
//         });
//         img.addEventListener("touchstart", function (e) {
//             e.preventDefault(); 
//             openFullScreen(img);
//         }, { passive: false }); 
//     });
// });
document.addEventListener("DOMContentLoaded", function () {
    images = Array.from(document.querySelectorAll('.media-thumbnail'));

  
    images.forEach(img => {
        img.addEventListener("click", function () {
            openFullScreen(img);
        });
        img.addEventListener("touchstart", function (e) {
        this.touchStartX = e.touches[0].clientX;
        this.touchStartY = e.touches[0].clientY;
        }, { passive: true });

        img.addEventListener("touchend", function (e) {
            let deltaX = Math.abs(e.changedTouches[0].clientX - this.touchStartX);
            let deltaY = Math.abs(e.changedTouches[0].clientY - this.touchStartY);

            if (deltaX < 10 && deltaY < 10) {
                openFullScreen(img);
            }
        });

    });
});

function openFullScreen(img) {
    const viewer = document.getElementById('fullscreenViewer');
    const fullscreenImg = document.getElementById('fullscreenImage');

    currentIndex = images.indexOf(img);
    fullscreenImg.src = img.src;
    viewer.style.display = "flex";
}

function closeFullScreen() {
    document.getElementById('fullscreenViewer').style.display = "none";
}

function changeImage(direction) {
    currentIndex += direction;

    if (currentIndex < 0) {
        currentIndex = images.length - 1;
    } else if (currentIndex >= images.length) {
        currentIndex = 0;
    }

    document.getElementById('fullscreenImage').src = images[currentIndex].src;
}

</script>
    

            @auth
            <div class="reply-section" style="margin-top: 20px;">
    <h3>Leave a Reply</h3>
    <form action="{{ route('forum.topic.reply', $forum_post->id) }}" method="POST" id="replyForm" enctype="multipart/form-data">
        @csrf
        <textarea id="editor" name="reply_content"></textarea>
        <p id="media-upload">Media Upload</p>
        <div id="media-upload-container">
            <div class="p-4 upload-area" id="uploadArea">
                <p>Add your documents here, and you can upload up to 10 files max</p>
                <p class="subtext">Only support .jpg, .png files.</p>
                <input type="file" name="media[]" id="fileInput" accept=".jpg, .png" multiple>
                <p>Drag your file(s) or <span>Browse</span></p>
                <div id="previewContainerreply" class="preview-containerreply"></div>
            </div>
        </div>
        <div class="progress-container" style="margin-top: 15px; display: none;">
            <div class="progress-bar-outer" style="height: 20px; background-color: #e9ecef; border-radius: 4px; overflow: hidden;">
                <div class="progress-bar-inner" style="height: 100%; width: 0%; background-color: #3490dc; border-radius: 4px; display: flex; align-items: center; justify-content: center; transition: width 0.3s ease;">
                    <span class="progress-text" style="color: white; font-size: 12px; font-weight: bold;">0%</span>
                </div>
            </div>
        </div>
        <div style="display: flex; justify-content: flex-end; margin-top: 20px;">
            <button type="submit" class="custom-btn" id="submitButton">Post</button>
        </div>
    </form>
</div>

<script>
// Get references to the file input and preview container
const replyFileInput = document.getElementById('fileInput');
const replyPreviewContainer = document.getElementById('previewContainerreply');
const uploadArea = document.getElementById('uploadArea');
const replyForm = document.getElementById('replyForm');
const submitButton = document.getElementById('submitButton');
const progressContainer = document.querySelector('.progress-container');
const progressBarInner = document.querySelector('.progress-bar-inner');
const progressText = document.querySelector('.progress-text');

// Maintain a collection of files
let selectedFiles = new Set();
let processedFiles = new Map(); // To store processed WebP files

// Make sure the entire upload area is clickable and opens the file dialog
uploadArea.addEventListener('click', function(e) {
    // Only trigger the file input if the click wasn't on a button or preview
    if (!e.target.closest('.remove-preview') && !e.target.closest('.preview-item')) {
        replyFileInput.click();
    }
});

// Function to create file previews
function createFilePreview(file) {
    // Only process image files
    if (!file.type.match('image.*')) {
        return null;
    }
    
    const reader = new FileReader();
    
    reader.onload = function(e) {
        // Create container for preview image and remove button
        const previewItem = document.createElement('div');
        previewItem.classList.add('preview-item');
        previewItem.style.position = 'relative';
        previewItem.style.display = 'inline-block';
        previewItem.style.margin = '5px';
        previewItem.dataset.fileName = file.name; // Store filename as data attribute
        
        // Create image element
        const img = document.createElement('img');
        img.src = e.target.result;
        img.alt = "Preview Image";
        img.style.width = '100px';
        img.style.height = '100px';
        img.style.objectFit = 'cover';
        img.style.borderRadius = '5px';
        
        // Create remove button
        const removeBtn = document.createElement('button');
        removeBtn.type = 'button';
        removeBtn.classList.add('remove-preview');
        removeBtn.textContent = '×';
        removeBtn.style.position = 'absolute';
        removeBtn.style.top = '5px';
        removeBtn.style.right = '5px';
        removeBtn.style.background = 'rgba(255, 0, 0, 0.7)';
        removeBtn.style.color = 'white';
        removeBtn.style.border = 'none';
        removeBtn.style.borderRadius = '50%';
        removeBtn.style.width = '20px';
        removeBtn.style.height = '20px';
        removeBtn.style.cursor = 'pointer';
        removeBtn.style.display = 'flex';
        removeBtn.style.justifyContent = 'center';
        removeBtn.style.alignItems = 'center';
        removeBtn.style.fontSize = '16px';
        removeBtn.style.padding = '0';
        removeBtn.style.lineHeight = '1';
        
        // Add click event to remove button
        removeBtn.addEventListener('click', function(e) {
            e.stopPropagation(); // Prevent triggering the file input click
            previewItem.remove();
            
            // Remove the file from our collection
            removeFileFromSelection(file.name);
        });
        
        // Append elements to the preview item
        previewItem.appendChild(img);
        previewItem.appendChild(removeBtn);
        
        // Add the preview to the container
        replyPreviewContainer.appendChild(previewItem);
    };
    
    // Read the file as a data URL to create the preview
    reader.readAsDataURL(file);
    
    return file;
}

// Function to remove a file from selection by name
function removeFileFromSelection(fileName) {
    // Convert selectedFiles Set to an array to find and remove the file
    let filesArray = Array.from(selectedFiles);
    let fileIndex = filesArray.findIndex(file => file.name === fileName);
    
    if (fileIndex !== -1) {
        selectedFiles.delete(filesArray[fileIndex]);
        
        // Also remove from processed files if exists
        processedFiles.delete(fileName);
        
        // Update the file input with remaining files
        updateFileInput();
    }
}

// Update the file input with current selected files
function updateFileInput() {
    const dt = new DataTransfer();
    selectedFiles.forEach(file => dt.items.add(file));
    replyFileInput.files = dt.files;
}

// Function to get image dimensions
function getImageDimensions(file) {
    return new Promise((resolve, reject) => {
        const img = new Image();
        const objectUrl = URL.createObjectURL(file);
        
        img.onload = function() {
            URL.revokeObjectURL(objectUrl);
            resolve({ width: img.width, height: img.height });
        };
        
        img.onerror = function() {
            URL.revokeObjectURL(objectUrl);
            reject(new Error('Failed to load image'));
        };
        
        img.src = objectUrl;
    });
}

// Function to compress image and convert to WebP
function compressAndConvertToWebP(file) {
    return new Promise(async (resolve, reject) => {
        try {
            // First get the image dimensions
            const dimensions = await getImageDimensions(file);
            
            // Read the file
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = new Image();
                img.onload = function() {
                    // Determine target dimensions
                    let width = dimensions.width;
                    let height = dimensions.height;
                    
                    // Set maximum dimension (limited to 1920px)
                    const maxDimension = 1920;
                    
                    if (width > maxDimension || height > maxDimension) {
                        if (width > height) {
                            height = Math.round(height * (maxDimension / width));
                            width = maxDimension;
                        } else {
                            width = Math.round(width * (maxDimension / height));
                            height = maxDimension;
                        }
                    }
                    
                    // Create canvas for resizing and conversion
                    const canvas = document.createElement('canvas');
                    canvas.width = width;
                    canvas.height = height;
                    
                    // Draw the image on the canvas
                    const ctx = canvas.getContext('2d');
                    ctx.drawImage(img, 0, 0, width, height);
                    
                    // Convert to WebP format
                    // Use low quality (0.6) for better compression
                    canvas.toBlob(function(blob) {
                        if (!blob) {
                            reject(new Error('Canvas to Blob conversion failed'));
                            return;
                        }
                        
                        // Create new file with WebP extension
                        const fileName = file.name.substring(0, file.name.lastIndexOf('.')) + '.webp';
                        
                        // Use much lower quality (0.6) for better compression
                        const webpFile = new File([blob], fileName, { type: 'image/webp' });
                        
                        // Log sizes for comparison
                        console.log(`Original size: ${file.size}, WebP size: ${webpFile.size}`);
                        
                        resolve(webpFile);
                    }, 'image/webp', 0.6); // 0.6 quality for much better compression
                };
                
                img.onerror = function() {
                    reject(new Error('Image loading failed'));
                };
                
                img.src = e.target.result;
            };
            
            reader.onerror = function() {
                reject(new Error('File reading failed'));
            };
            
            reader.readAsDataURL(file);
        } catch (error) {
            reject(error);
        }
    });
}

// Add event listener for file selection
replyFileInput.addEventListener('change', function() {
    if (this.files && this.files.length > 0) {
        // Check total files (existing + new)
        const totalFiles = selectedFiles.size + this.files.length;
        if (totalFiles > 10) {
            alert('You can only upload up to 10 files total.');
            return;
        }
        
        // Add new files to our collection and create previews
        for (let i = 0; i < this.files.length; i++) {
            const file = this.files[i];
            // Check if file already exists in our collection
            let exists = false;
            selectedFiles.forEach(existingFile => {
                if (existingFile.name === file.name && 
                    existingFile.size === file.size && 
                    existingFile.type === file.type) {
                    exists = true;
                }
            });
            
            if (!exists) {
                selectedFiles.add(file);
                createFilePreview(file);
            }
        }
        
        // Update the file input with all selected files
        updateFileInput();
    }
});

// Handle form submission
// Handle form submission
replyForm.addEventListener('submit', async function(e) {
    e.preventDefault();
    
    // Show progress container
    progressContainer.style.display = 'block';
    submitButton.disabled = true;
    
    // Check if we have any files to process
    if (selectedFiles.size > 0) {
        // Process each file (convert to WebP)
        const totalFiles = selectedFiles.size;
        let processedCount = 0;
        
        const updateProgress = () => {
            processedCount++;
            const percentage = Math.round((processedCount / totalFiles) * 100);
            progressBarInner.style.width = percentage + '%';
            progressText.textContent = percentage + '%';
        };
        
        const filesArray = Array.from(selectedFiles);
        
        for (const file of filesArray) {
            try {
                if (file.type.match('image.*')) {
                    const webpFile = await compressAndConvertToWebP(file);
                    
                    // Verify compression actually happened
                    if (webpFile.size >= file.size) {
                        // In case WebP is larger (rare), keep original file
                        console.warn('WebP file is not smaller, keeping original');
                        processedFiles.set(file.name, file);
                    } else {
                        processedFiles.set(file.name, webpFile);
                    }
                } else {
                    // Not an image, keep as is
                    processedFiles.set(file.name, file);
                }
                updateProgress();
            } catch (error) {
                console.error('Error processing file:', error);
                // On error, keep original file
                processedFiles.set(file.name, file);
                updateProgress();
            }
        }
        
        // Now that all files are processed, prepare the form data
        const formData = new FormData();
        
        // Add all form fields except the original file input
        const editorContent = document.getElementById('editor').value;
        formData.append('reply_content', editorContent);
        formData.append('_token', document.querySelector('input[name="_token"]').value);
        
        // Add the processed WebP files
        processedFiles.forEach((processedFile) => {
            formData.append('media[]', processedFile);
        });
        
        // Complete the progress bar
        progressBarInner.style.width = '100%';
        progressText.textContent = '100%';
        
        // Submit the form using fetch or XMLHttpRequest
        try {
            const response = await fetch(replyForm.action, {
                method: 'POST',
                body: formData
            });
            
            if (response.ok) {
                // Handle successful submission - e.g., redirect to the response URL
                window.location.href = response.url;
            } else {
                throw new Error('Form submission failed');
            }
        } catch (error) {
            console.error('Error submitting form:', error);
            alert('There was an error submitting your reply. Please try again.');
            submitButton.disabled = false;
        }
    } else {
        // If no files to process, submit the form normally
        replyForm.submit();
    }
});

// Add drag and drop functionality
['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
    uploadArea.addEventListener(eventName, preventDefaults, false);
});

function preventDefaults(e) {
    e.preventDefault();
    e.stopPropagation();
}

// Add highlight effect when dragging over the upload area
['dragenter', 'dragover'].forEach(eventName => {
    uploadArea.addEventListener(eventName, highlight, false);
});

// Remove highlight effect when leaving or after drop
['dragleave', 'drop'].forEach(eventName => {
    uploadArea.addEventListener(eventName, unhighlight, false);
});

function highlight() {
    uploadArea.style.border = '2px dashed #3490dc';
    uploadArea.style.backgroundColor = '#f8fafc';
}

function unhighlight() {
    uploadArea.style.border = '2px dashed #CBD5E0';
    uploadArea.style.backgroundColor = '';
}

// Handle file drop
uploadArea.addEventListener('drop', handleDrop, false);

function handleDrop(e) {
    const dt = e.dataTransfer;
    const files = dt.files;
    
    // Check total files (existing + new)
    const totalFiles = selectedFiles.size + files.length;
    if (totalFiles > 10) {
        alert('You can only upload up to 10 files total.');
        return;
    }
    
    // Add new files to our collection and create previews
    for (let i = 0; i < files.length; i++) {
        const file = files[i];
        // Check if file already exists in our collection
        let exists = false;
        selectedFiles.forEach(existingFile => {
            if (existingFile.name === file.name && 
                existingFile.size === file.size && 
                existingFile.type === file.type) {
                exists = true;
            }
        });
        
        if (!exists) {
            selectedFiles.add(file);
            createFilePreview(file);
        }
    }
    
    // Update the file input with all selected files
    updateFileInput();
}
</script>


<script>


document.addEventListener('DOMContentLoaded', function () {
    tinymce.init({
        selector: 'textarea#editor',
        height: 300,
        menubar: false,
        plugins: [
            'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
            'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
            'insertdatetime', 'media', 'table', 'help', 'wordcount', 'emoticons', 'media'
        ],
        toolbar: 'undo redo | blocks | ' +
            'bold italic forecolor | alignleft aligncenter ' +
            'alignright alignjustify | bullist numlist outdent indent | ' +
            'emoticons giphy| image media|removeformat', // Added Giphy button

        content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',
        branding: false,

        images_upload_handler: function (blobInfo, progress) {
            return new Promise((resolve, reject) => {
                let data = new FormData();
                data.append('file', blobInfo.blob());

                fetch("{{ route('forum.upload.image') }}", {
                    method: 'POST',
                    body: data,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                    }
                })
                .then(response => {
                    console.log('Server response:', response);
                    if (!response.ok) {
                        throw new Error('HTTP error! status: ' + response.status);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Parsed JSON response:', data);
                    if (data && data.location) {
                        resolve(data.location); 
                    } else if (data && data.error) {
                        reject(data.error); 
                    } else {
                        reject('Invalid response from server'); 
                    }
                })
                .catch(error => {
                    console.error('Image upload failed:', error);
                    reject('Image upload failed: ' + error.message);
                });
            });
        },
        file_picker_types: 'media',
    file_picker_callback: function (callback, value, meta) {
        if (meta.filetype === 'media') {
            const input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'video/*');

            input.onchange = function () {
                const file = this.files[0];
                const formData = new FormData();
                formData.append('file', file);

                fetch("{{ route('forum.upload.video') }}", {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data && data.location) {
                        callback(data.location, { source: data.location });
                    } else {
                        console.error('Invalid response from server');
                    }
                })
                .catch(error => {
                    console.error('Video upload failed:', error);
                });
            };

            input.click();
        }
    },


        setup: function (editor) {
            // Add custom Giphy button
            editor.ui.registry.addButton('giphy', {
                text: 'GIF',
                onAction: function () {
                    openGiphyModal(editor);
                }
            });
        }
    });

  
    function openGiphyModal(editor) {
       
        if (document.getElementById('giphyModal')) {
            document.getElementById('giphyModal').remove();
        }
        const giphyModal = document.createElement('div');
        giphyModal.id = 'giphyModal';
        giphyModal.style.position = 'fixed';
        giphyModal.style.top = '50%';
        giphyModal.style.left = '50%';
        giphyModal.style.transform = 'translate(-50%, -50%)';
        giphyModal.style.background = 'white';
        giphyModal.style.padding = '20px';
        giphyModal.style.borderRadius = '10px';
        giphyModal.style.boxShadow = '0 0 10px rgba(0,0,0,0.2)';
        giphyModal.style.width = '400px';
        giphyModal.style.zIndex = '10000';

        giphyModal.innerHTML = `
            <input type="text" id="giphySearch" placeholder="Search for GIFs..." 
                style="width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 5px;">
            <div id="giphyResults" style="max-height: 300px; overflow-y: auto; display: flex; flex-wrap: wrap; gap: 5px;"></div>
            <button id="closeGiphy" style="margin-top: 10px; padding: 8px 12px; border: none; background: red; color: white; cursor: pointer; border-radius: 5px;">Close</button>
        `;

        document.body.appendChild(giphyModal);
        document.getElementById('closeGiphy').addEventListener('click', closeGiphyModal);
        document.getElementById('giphySearch').addEventListener('input', function () {
            fetchGiphyGIFs(this.value, editor);
        });
    }

    function closeGiphyModal() {
        const modal = document.getElementById('giphyModal');
        if (modal) modal.remove();
    }

    function fetchGiphyGIFs(query, editor) {
        const API_KEY = 'LoEtBVykwd74rrZOM6oCxaXolWJu8cQn'; 
        const url = `https://api.giphy.com/v1/gifs/search?api_key=${API_KEY}&q=${query}&limit=10`;

        fetch(url)
            .then(response => response.json())
            .then(data => {
                const resultsDiv = document.getElementById('giphyResults');
                resultsDiv.innerHTML = ''; 

                data.data.forEach(gif => {
                    const img = document.createElement('img');
                    img.src = gif.images.fixed_height_small.url;
                    img.style.cursor = 'pointer';
                    img.style.width = '100px';
                    img.style.height = '100px';
                    img.style.objectFit = 'cover';
                    img.style.borderRadius = '5px';

                    img.addEventListener('click', function () {
                        insertGifIntoEditor(editor, gif.images.original.url);
                    });

                    resultsDiv.appendChild(img);
                });
            })
            .catch(error => console.error('Error fetching GIFs:', error));
    }

    function insertGifIntoEditor(editor, gifUrl) {
        editor.execCommand('mceInsertContent', false, `<img src="${gifUrl}" alt="GIF" style="max-width:100%;">`);
        closeGiphyModal();
    }
});

document.getElementById('replyForm').addEventListener('submit', function(e) {
    if (!tinymce.get('editor').getContent()) {
        e.preventDefault();
        alert("Please enter a reply before submitting.");
    }
});
</script>




@endauth


        </div>

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
                        <li style="margin: 0; padding: 0;">
                            
                            <a href="{{ route('forum-topic-category', ['forum_topic_category' => $activity->forum_topic_category_id]) }}"
                                style="color:rgb(19, 19, 19); text-decoration: none;">
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

    </div>
</div>

<script>
document.getElementById('forum-tab').addEventListener('click', function() {

    document.getElementById('forum-tab').classList.add('active');
    document.getElementById('activity-tab').classList.remove('active');

    document.querySelector('.forum-tab').style.display = 'block';
    document.querySelector('.activity-tab').style.display = 'none';
});

document.getElementById('activity-tab').addEventListener('click', function() {

    document.getElementById('activity-tab').classList.add('active');
    document.getElementById('forum-tab').classList.remove('active');

    document.querySelector('.forum-tab').style.display = 'none';
    document.querySelector('.activity-tab').style.display = 'block';
});
</script>
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

}


</style>  
<style>
.pagination-container {
    display: flex;
    gap: 10px;
    justify-content: flex-start;
    margin: 10px;
}

.pagination-container .page-item {
    display: inline-block;
}

.pagination-container .page-link {
    padding: 8px 16px;
    margin: 0;
    text-decoration: none;
    color: #007bff;
    border: 1px solid #ddd;
    border-radius: 4px;
}

.pagination-container .page-item.active .page-link {
    background-color: #007bff;
    color: white;
}

.pagination-container .page-link:hover {
    background-color: #f1f1f1;
}
</style>



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>








<style>
.forum-dropdown {
    position: absolute;
    right: 15px;
    top: 15px;
}

.forum-dropdown-btn {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    transition: background-color 0.2s;
}

.forum-dropdown-btn:hover {
    background-color: rgba(0, 0, 0, 0.05);
}

.forum-dropdown-menu {
    min-width: 180px;
    background: white;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    overflow: hidden;
}

.forum-dropdown-item {
    transition: background-color 0.2s;
}

.forum-dropdown-item:hover {
    background-color: #f5f5f5;
}

@media (max-width: 768px) {
    .forum-dropdown {
        position: absolute;
        right: 10px;
        top: 10px;
    }
    
    .forum-dropdown-menu {
        position: absolute;
        right: 0;
        top: 100%;
        width: auto;
        min-width: 200px;
        max-width: calc(100vw - 40px);
        margin-top: 5px;
    }
    
    .forum-dropdown-btn {
        width: 40px;
        height: 40px;
    }
    
    .forum-dropdown-item {
        padding: 15px !important;
        font-size: 16px !important;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.forum-dropdown-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.stopPropagation();
            const menu = this.nextElementSibling;
            const isOpen = menu.style.display === 'block';
            
            document.querySelectorAll('.forum-dropdown-menu').forEach(m => {
                m.style.display = 'none';
            });
            
            menu.style.display = isOpen ? 'none' : 'block';
            
            if (!isOpen) {
                const menuRect = menu.getBoundingClientRect();
                const viewportWidth = window.innerWidth;
                
                if (menuRect.right > viewportWidth) {
                    menu.style.right = '0';
                }
            }
        });
    });
    

    document.addEventListener('click', function(e) {
        if (!e.target.closest('.forum-dropdown')) {
            document.querySelectorAll('.forum-dropdown-menu').forEach(menu => {
                menu.style.display = 'none';
            });
        }
    });
    
    document.querySelectorAll('.forum-dropdown-item').forEach(item => {
        item.addEventListener('touchend', function(e) {
            e.stopPropagation();
        });
    });
});
</script>
<script>
    document.getElementById('report-option').addEventListener('click', function() {
    const userId = this.querySelector('input[name="user_id"]').value;
    const forumTopicId = this.querySelector('input[name="forum_topic_id"]').value;
    const forumCategoryId = this.querySelector('input[name="forum_topic_category_id"]').value;

    Swal.fire({
        title: 'Report Post',
        input: 'textarea',
        inputPlaceholder: 'Please enter the reason for reporting...',
        showCancelButton: true,
        confirmButtonText: 'Submit',
        cancelButtonText: 'Cancel',
        inputValidator: (value) => {
            if (!value) {
                return 'You must enter a reason!';
            }
        }
    }).then((result) => {
        if (result.isConfirmed) {
            console.log('Reason for Report:', result.value);

            const form = document.getElementById('report-form');
            form.querySelector('input[name="user_id"]').value = userId;
            form.querySelector('input[name="forum_topic_id"]').value = forumTopicId;
            form.querySelector('input[name="forum_topic_category_id"]').value = forumCategoryId;
            form.querySelector('input[name="reason"]').value = result.value;
            form.querySelector('input[name="type"]').value = 'post';

            console.log('Form Data:', {
                user_id: userId,
                forum_topic_id: forumTopicId,
                reason: result.value,
                type: 'post'
            });

            form.submit();

          
            Swal.fire({
                icon: 'success', 
                title: 'Success!',
                text: 'Your report has been submitted successfully!',
                showConfirmButton: false,
                timer: 2000,
                customClass: {
                    popup: 'custom-swal-popup'
                }
            });

        }
    });
});

document.querySelectorAll('.report-option-reply').forEach(button => {
    button.addEventListener('click', function() {
        const userId = this.querySelector('input[name="user_id"]').value;
        const postId = this.querySelector('input[name="post_id"]').value;
        const replyId = this.querySelector('input[name="reply_id"]').value;
        const forumTopicId = this.querySelector('input[name="forum_topic_id"]').value;
        const forumCategoryId = this.querySelector('input[name="forum_topic_category_id"]').value;
        const formId = `report-form-reply-${this.dataset.replyId}`;

        Swal.fire({
            title: 'Report Reply',
            input: 'textarea',
            inputPlaceholder: 'Please enter the reason for reporting...',
            showCancelButton: true,
            confirmButtonText: 'Submit',
            cancelButtonText: 'Cancel',
            inputValidator: (value) => {
                if (!value) {
                    return 'You must enter a reason!';
                }
            }
        }).then((result) => {
            if (result.isConfirmed) {
                console.log('Reason for Report:', result.value);

                const form = document.getElementById(formId);
                form.querySelector('input[name="user_id"]').value = userId;
                form.querySelector('input[name="post_id"]').value = postId;
                form.querySelector('input[name="forum_topic_id"]').value = forumTopicId;
                form.querySelector('input[name="forum_topic_category_id"]').value = forumCategoryId;
                form.querySelector('input[name="reply_id"]').value = replyId;
                form.querySelector('input[name="reason"]').value = result.value;

                console.log('Form Data:', {
                    user_id: userId,
                    post_id: postId,
                    forum_topic_id: forumTopicId,
                    reply_id: replyId,
                    reason: result.value
                });

                form.submit();
                Swal.fire({
                    icon: 'success', 
                    title: 'Success!',
                    text: 'Your report has been submitted successfully!',
                    showConfirmButton: false,
                    timer: 4000,
                    customClass: {
                        popup: 'custom-swal-popup'
                    }
                });

            }
        });
    });
});

</script>

<script>

document.querySelectorAll('.edit-btn_reply').forEach(button => {
    button.addEventListener('click', function() {
        const postId = this.getAttribute('data-reply-id');
        const postContent = this.getAttribute('data-reply-content');
        const originalContent = postContent;
        const replyMedia = this.getAttribute('data-reply-media');
        const replyMediaUrls = this.getAttribute('data-reply-media-urls');
        const replyId = this.getAttribute('data-reply-id');

        let existingImagesHTML = '';
        if (replyMediaUrls && replyMediaUrls !== 'null') {
            try {
                const mediaUrlsArray = JSON.parse(replyMediaUrls);
                const mediaArray = JSON.parse(replyMedia);

                console.log("Media Array:", mediaArray);

                if (mediaUrlsArray.length > 0 && mediaArray.length > 0) {
                    for (let i = 0; i < mediaUrlsArray.length; i++) {
                        console.log("Image Path (data-image):", mediaArray[i]);

                        existingImagesHTML += `
                            <div class="preview-container">
                                <img src="${mediaUrlsArray[i]}" alt="Reply Image" style="width: 100px; height: 100px; object-fit: cover;">
                                <button type="button" class="remove-image-reply" 
                                        data-reply-id="${replyId}" 
                                        data-image="${mediaArray[i]}">×</button>
                            </div>
                        `;
                    }
                }
            } catch (e) {
                console.error('Error parsing media JSON:', e);
            }
        }
        
        const modalHTML = `
            <div id="editPostModal" class="p-4 modal mobilemodal" style="display: block; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.4);">
                <div class="modal-content mobilemodalcontent" style="background-color: white;  padding: 20px; border-radius: 10px; width: 100%; max-width: 800px;">
                <div>
                <span class="edit-close-btn" style="color: #aaa; float: right; font-size: 28px; font-weight: bold; cursor: pointer;">&times;</span>
                        <p id="media-upload"><strong>Edit Reply</strong></p>
                        <div id="edit-text-area">
                            <textarea id="editContent">${originalContent}</textarea>
                        </div>
                        <p id=""></p>
                         <div class="p-4 upload-area" id="uploadArea">
                            <p>Add your documents here, and you can upload up to 10 files max</p>
                            <p class="subtext">Images will be converted to WebP format for faster loading</p>
                            <input type="file" name="media[]" id="fileInput" accept=".jpg, .png, .jpeg, .webp" multiple>
                            <label for="fileInput" style="cursor: pointer; display: block; padding: 10px; text-align: center; border: 2px dashed #CBD5E0; border-radius: 8px;">
                                Drag your file(s) or <span style="color: blue; text-decoration: underline;">Browse</span>
                            </label>
                         </div>
                        <p id="media-upload">Existing Media</p>
                        <div id="edit-media-upload-container">
                            <div id="edit-buttons-container">
                                <div id="existing-images-container" class="mt-3 image-preview-grid">
                                    ${existingImagesHTML}
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-dark" id="saveEdit">Save Changes</button>
                                </div>
                            </div>
                        </div>
                        <div id="upload-progress-container" style="display: none; margin-top: 15px;">
                            <p>Uploading files...</p>
                            <div class="progress" style="height: 20px; border-radius: 5px; overflow: hidden;">
                                <div id="upload-progress-bar" class="progress-bar bg-primary" role="progressbar" style="width: 0%; height: 100%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        // Append the modal to the body
        document.body.insertAdjacentHTML('beforeend', modalHTML);
        
        // Initialize TinyMCE for the edit modal
        tinymce.init({
            selector: '#editPostModal textarea',
            menubar: false,
            plugins: [
                'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                'insertdatetime', 'media', 'table', 'help', 'wordcount', 'emoticons'
            ],
            toolbar: 'undo redo | blocks | ' +
                'bold italic forecolor |' +
                'emoticons giphy|image media| bullist numlist outdent indent ' +
                'removeformat | alignright | alignjustify alignleft aligncenter',
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',
            branding: false,
            images_upload_handler: function (blobInfo, progress) {
                return new Promise((resolve, reject) => {
                    let data = new FormData();
                    data.append('file', blobInfo.blob());

                    fetch("/forum/upload/image", {
                        method: 'POST',
                        body: data,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                        }
                    })
                    .then(response => {
                        console.log('Server response:', response);
                        if (!response.ok) {
                            throw new Error('HTTP error! status: ' + response.status);
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Parsed JSON response:', data);
                        if (data && data.location) {
                            resolve(data.location); 
                        } else if (data && data.error) {
                            reject(data.error);
                        } else {
                            reject('Invalid response from server'); 
                        }
                    })
                    .catch(error => {
                        console.error('Image upload failed:', error);
                        reject('Image upload failed: ' + error.message);
                    });
                });
            },
            file_picker_types: 'media',
            file_picker_callback: function (callback, value, meta) {
                if (meta.filetype === 'media') {
                    const input = document.createElement('input');
                    input.setAttribute('type', 'file');
                    input.setAttribute('accept', 'video/*');

                    input.onchange = function () {
                        const file = this.files[0];
                        const formData = new FormData();
                        formData.append('file', file);

                        fetch("/forum/upload/video", {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data && data.location) {
                                callback(data.location, { source: data.location });
                            } else {
                                console.error('Invalid response from server');
                            }
                        })
                        .catch(error => {
                            console.error('Video upload failed:', error);
                        });
                    };

                    input.click();
                }
            },
            setup: function (editor) {
                editor.ui.registry.addButton('giphy', {
                    text: 'GIF',
                    onAction: function () {
                        openGiphyModal(editor);
                    }
                });
            }
        });
        
        // Handle close button click
        document.querySelector('.edit-close-btn').addEventListener('click', () => {
            document.getElementById('editPostModal').remove();
            tinymce.remove('#editContent');
        });
        
        // Function to convert image to WebP format with specified quality
        function convertToWebP(file, quality = 0.8, maxWidth = 1200) {
            return new Promise((resolve) => {
                const reader = new FileReader();
                reader.onload = function(event) {
                    const img = new Image();
                    img.onload = function() {
                        // Calculate new dimensions while maintaining aspect ratio
                        let width = img.width;
                        let height = img.height;
                        
                        if (width > maxWidth) {
                            height = (height * maxWidth) / width;
                            width = maxWidth;
                        }
                        
                        const canvas = document.createElement('canvas');
                        canvas.width = width;
                        canvas.height = height;
                        
                        const ctx = canvas.getContext('2d');
                        ctx.drawImage(img, 0, 0, width, height);
                        
                        canvas.toBlob((blob) => {
                            const fileName = file.name.split('.').slice(0, -1).join('.') + '.webp';
                            const webpFile = new File([blob], fileName, { type: 'image/webp' });
                            resolve(webpFile);
                        }, 'image/webp', quality);
                    };
                    img.src = event.target.result;
                };
                reader.readAsDataURL(file);
            });
        }
        
        // Handle save button click
        document.getElementById('saveEdit').addEventListener('click', async function() {
            // Get content from TinyMCE editor
            const updatedContent = tinymce.get('editContent').getContent();
            
            if (!updatedContent) {
                alert('Content is required');
                return;
            }
            
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            
            // Collect file data for upload
            const formData = new FormData();
            formData.append('content', updatedContent);
            
            // Add files if any, converting them to WebP
            const fileInput = document.getElementById('fileInput');
            const progressContainer = document.getElementById('upload-progress-container');
            const progressBar = document.getElementById('upload-progress-bar');
            
            // Show a loading indicator
            const saveButton = document.getElementById('saveEdit');
            saveButton.innerHTML = 'Preparing files...';
            saveButton.disabled = true;
            
            if (fileInput && fileInput.files.length > 0) {
                // Show progress bar for conversion
                progressContainer.style.display = 'block';
                progressBar.style.width = '0%';
                progressBar.textContent = '0%';
                
                // Convert all images to WebP
                const totalFiles = fileInput.files.length;
                let processedFiles = 0;
                
                for (let i = 0; i < fileInput.files.length; i++) {
                    const file = fileInput.files[i];
                    
                    if (file.type.match('image.*')) {
                        try {
                            // Convert image to WebP and reduce size
                            const webpFile = await convertToWebP(file, 0.75);
                            formData.append('media[]', webpFile);
                        } catch (error) {
                            console.error('Error converting to WebP:', error);
                            // If conversion fails, use original file
                            formData.append('media[]', file);
                        }
                    } else {
                        // For non-image files, use as is
                        formData.append('media[]', file);
                    }
                    
                    // Update progress for conversion
                    processedFiles++;
                    const progress = Math.round((processedFiles / totalFiles) * 50); // 50% for conversion
                    progressBar.style.width = progress + '%';
                    progressBar.textContent = progress + '%';
                }
            }
            
            saveButton.innerHTML = 'Uploading...';
            
            // Use FormData with progress tracking
            const xhr = new XMLHttpRequest();
            xhr.open('POST', `/forum/reply/${postId}/edit`);
            xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);
            
            xhr.upload.onprogress = function(e) {
                if (e.lengthComputable) {
                    // Start from 50% (after conversion) and go to 100%
                    const uploadProgress = 50 + Math.round((e.loaded / e.total) * 50);
                    progressBar.style.width = uploadProgress + '%';
                    progressBar.textContent = uploadProgress + '%';
                }
            };
            
            xhr.onload = function() {
                if (xhr.status === 200) {
                    try {
                        const data = JSON.parse(xhr.responseText);
                        if (data.success) {
                            // Remove the modal
                            document.getElementById('editPostModal').remove();
                            tinymce.remove('#editContent');
                            
                            // Show success message
                            Swal.fire('Success', data.message, 'success').then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire('Error', data.message || 'Something went wrong', 'error');
                            saveButton.innerHTML = 'Save Changes';
                            saveButton.disabled = false;
                        }
                    } catch (e) {
                        console.error('Error parsing response:', e);
                        Swal.fire('Error', 'Failed to process server response', 'error');
                        saveButton.innerHTML = 'Save Changes';
                        saveButton.disabled = false;
                    }
                } else {
                    Swal.fire('Error', 'Failed to update post', 'error');
                    saveButton.innerHTML = 'Save Changes';
                    saveButton.disabled = false;
                }
            };
            
            xhr.onerror = function() {
                console.error('Request error');
                Swal.fire('Error', 'Failed to update post', 'error');
                saveButton.innerHTML = 'Save Changes';
                saveButton.disabled = false;
            };
            
            xhr.send(formData);
        });
        
        const fileInput = document.getElementById('fileInput');
        // The previewContainer wasn't properly defined - this was missing in the original code
        let previewContainer = document.createElement('div');
        previewContainer.id = 'previewContainer';
        previewContainer.classList.add('image-preview-grid');
        document.getElementById('existing-images-container').after(previewContainer);

        fileInput.addEventListener('change', async function() {
            if (this.files && this.files.length > 0) {
                if (this.files.length > 10) {
                    alert('You can only upload up to 10 files.');
                    this.value = '';
                    return;
                }
                
                for (let i = 0; i < this.files.length; i++) {
                    const file = this.files[i];
                    
                    if (file.type.match('image.*')) {
                        const reader = new FileReader();
                        
                        reader.onload = function(e) {
                            // Create a preview container with a small preview of the image
                            const previewContainerDiv = document.createElement('div');
                            previewContainerDiv.classList.add('preview-container');
                            previewContainerDiv.style.position = 'relative';
                            previewContainerDiv.style.display = 'inline-block';
                            previewContainerDiv.style.margin = '5px';
                            previewContainerDiv.dataset.fileName = file.name;
                            
                            const img = document.createElement('img');
                            img.src = e.target.result;
                            img.alt = "Preview Image";
                            img.style.width = '100px';
                            img.style.height = '100px';
                            img.style.objectFit = 'cover';
                            img.style.borderRadius = '5px';
                            
                            const details = document.createElement('div');
                            details.style.fontSize = '10px';
                            details.style.marginTop = '2px';
                            details.style.color = '#666';
                            details.innerHTML = `${(file.size / (1024 * 1024)).toFixed(2)} MB → WebP`;
                            
                            const removeBtn = document.createElement('button');
                            removeBtn.type = 'button';
                            removeBtn.classList.add('remove-preview');
                            removeBtn.textContent = '×';
                            removeBtn.style.position = 'absolute';
                            removeBtn.style.top = '5px';
                            removeBtn.style.right = '5px';
                            removeBtn.style.background = 'rgba(255, 0, 0, 0.7)';
                            removeBtn.style.color = 'white';
                            removeBtn.style.border = 'none';
                            removeBtn.style.borderRadius = '50%';
                            removeBtn.style.width = '20px';
                            removeBtn.style.height = '20px';
                            removeBtn.style.cursor = 'pointer';
                            removeBtn.style.display = 'flex';
                            removeBtn.style.justifyContent = 'center';
                            removeBtn.style.alignItems = 'center';
                            removeBtn.style.fontSize = '16px';
                            removeBtn.style.padding = '0';
                            removeBtn.style.lineHeight = '1';
                            
                            removeBtn.addEventListener('click', function() {
                                previewContainerDiv.remove();
                                // We need to update the fileInput.files object to reflect removals
                                // Unfortunately, we can't directly modify the files property
                                // You would need to use a solution with FormData instead
                            });
                            
                            previewContainerDiv.appendChild(img);
                            previewContainerDiv.appendChild(details);
                            previewContainerDiv.appendChild(removeBtn);
                            
                            // Insert into the preview container
                            previewContainer.appendChild(previewContainerDiv);
                        };
                        
                        reader.readAsDataURL(file);
                    }
                }
            }
        });
        
        const uploadArea = document.getElementById('uploadArea');
        
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            uploadArea.addEventListener(eventName, preventDefaults, false);
        });
        
        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }
        
        ['dragenter', 'dragover'].forEach(eventName => {
            uploadArea.addEventListener(eventName, highlight, false);
        });
        
        ['dragleave', 'drop'].forEach(eventName => {
            uploadArea.addEventListener(eventName, unhighlight, false);
        });
        
        function highlight() {
            uploadArea.classList.add('highlight');
        }
        
        function unhighlight() {
            uploadArea.classList.remove('highlight');
        }
        
        uploadArea.addEventListener('drop', handleDrop, false);
        
        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            fileInput.files = files;
            
            // Trigger change event to show previews
            const event = new Event('change');
            fileInput.dispatchEvent(event);
        }
   
       
        function openGiphyModal(editor) {
            const existingModal = document.getElementById('giphyModal');
            if (existingModal) existingModal.remove(); // Remove old modal if it exists

            const giphyModal = document.createElement('div');
            giphyModal.id = 'giphyModal';
            giphyModal.style.position = 'fixed';
            giphyModal.style.top = '50%';
            giphyModal.style.left = '50%';
            giphyModal.style.transform = 'translate(-50%, -50%)';
            giphyModal.style.background = 'white';
            giphyModal.style.padding = '20px';
            giphyModal.style.borderRadius = '10px';
            giphyModal.style.boxShadow = '0 0 10px rgba(0,0,0,0.2)';
            giphyModal.style.width = '400px';
            giphyModal.style.zIndex = '10000';

            giphyModal.innerHTML = `
                <input type="text" id="giphySearch" placeholder="Search for GIFs..." 
                    style="width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 5px;">
                <div id="giphyResults" style="max-height: 300px; overflow-y: auto; display: flex; flex-wrap: wrap; gap: 5px;"></div>
                <button id="closeGiphy" style="margin-top: 10px; padding: 8px 12px; border: none; background: red; color: white; cursor: pointer; border-radius: 5px;">Close</button>
            `;

            document.body.appendChild(giphyModal);

            document.getElementById('closeGiphy').addEventListener('click', closeGiphyModal);
            document.getElementById('giphySearch').addEventListener('input', function () {
                fetchGiphyGIFs(this.value, editor);
            });
        }

        function closeGiphyModal() {
            const modal = document.getElementById('giphyModal');
            if (modal) modal.remove();
        }

        function fetchGiphyGIFs(query, editor) {
            const API_KEY = 'LoEtBVykwd74rrZOM6oCxaXolWJu8cQn'; 
            const url = `https://api.giphy.com/v1/gifs/search?api_key=${API_KEY}&q=${query}&limit=10`;

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    const resultsDiv = document.getElementById('giphyResults');
                    resultsDiv.innerHTML = '';

                    data.data.forEach(gif => {
                        const img = document.createElement('img');
                        img.src = gif.images.fixed_height_small.url;
                        img.style.cursor = 'pointer';
                        img.style.width = '100px';
                        img.style.height = '100px';
                        img.style.objectFit = 'cover';
                        img.style.borderRadius = '5px';

                        img.addEventListener('click', function () {
                            insertGifIntoEditor(editor, gif.images.original.url);
                        });

                        resultsDiv.appendChild(img);
                    });
                })
                .catch(error => console.error('Error fetching GIFs:', error));
        }

        function insertGifIntoEditor(editor, gifUrl) {
            editor.execCommand('mceInsertContent', false, `<img src="${gifUrl}" alt="GIF" style="max-width:100%;">`);
            closeGiphyModal();
        }
    });
});
document.addEventListener('click', function (event) {
    const target = event.target.closest('.remove-image-reply'); // Ensure it selects the button
    if (!target) return;

    event.preventDefault();

    const replyId = target.getAttribute('data-reply-id'); 
    const imagePath = target.getAttribute('data-image'); 



    if (!replyId || !imagePath) {
        alert("Error: Missing reply ID or image path.");
        return;
    }

    deleteExistingReplyImage(replyId, imagePath);
});



function deleteExistingReplyImage(replyId, imagePath) {
    if (confirm('Are you sure you want to delete this image?')) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        console.log('Attempting to delete:', { replyId, imagePath });

        fetch(`/delete-image-reply-forum/${replyId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                credentials: 'same-origin',
                body: JSON.stringify({ imagePath }) // Pass image path in request body
            })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    console.log(`Image ${imagePath} deleted successfully.`);

                 
                    const buttonElement = document.querySelector(`button[data-image="${imagePath}"]`);
                    if (buttonElement) {
                        buttonElement.closest('.preview-container').remove(); // Remove the parent div
                    } else {
                        console.error('Image element not found in DOM.');
                    }
                } else {
                    console.error('Server error:', data.message);
                    alert(data.message || 'Failed to delete image.');
                }
            })
            .catch((error) => {
                console.error('Error deleting image:', error);
                alert('Failed to delete image.');
            });
    }
}




 
</script>
<script>
  document.querySelectorAll('.edit-btn').forEach(button => {
    button.addEventListener('click', function() {
        const postId = this.getAttribute('data-post-id');
        const postTopic = this.getAttribute('data-post-topic');
        const postContent = this.getAttribute('data-post-content');
        // Keep HTML content as is instead of sanitizing it
        const originalTopic = postTopic;
        const originalContent = postContent;
        
        const modalHTML = `
            <div id="editPostModal" class="p-4 modal mobilemodal" style="display: block; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.4);">
                <div class="modal-content mobilemodalcontent" style="background-color: white; padding: 20px; border-radius: 10px; width: 100%; max-width: 800px;">
                <div>
                <span class="edit-close-btn" style="color: #aaa; float: right; font-size: 28px; font-weight: bold; cursor: pointer;">&times;</span>
                        <p id="media-upload"><strong>Edit Topic</strong></p>
                        <div class="mb-4 form-group">
                            <label for="editTopic" class="form-label" style="font-weight: bold; color: #4A5568;">Title</label>
                            <input type="text" id="editTopic" class="form-control" value="${originalTopic.replace(/"/g, '&quot;')}" 
                                style="border: 2px solid #CBD5E0; border-radius: 8px; padding: 10px; font-size: 16px; color: #2D3748;">
                        </div>
                        <div id="edit-text-area">
                            <textarea id="editContent">${originalContent}</textarea>
                        </div>
                         <p id=""></p>
                         <div class="p-4 upload-area" id="uploadArea">
                            <p>Add your documents here, and you can upload up to 10 files max</p>
                            <p class="subtext">Only support .jpg, .png files (will be converted to WebP)</p>
                            <input type="file" name="media[]" id="fileInput" accept=".jpg, .jpeg, .png" multiple>
                            <label for="fileInput" style="cursor: pointer; display: block; padding: 10px; text-align: center; border: 2px dashed #CBD5E0; border-radius: 8px;">
                                Drag your file(s) or <span style="color: blue; text-decoration: underline;">Browse</span>
                            </label>
                         </div>
                        
                        <p id="media-upload">Existing Media</p>
                        <div id="edit-media-upload-container">
                            
                            <div id="edit-buttons-container">
               
                                 
                                <div id="existing-images-container" class="mt-3 image-preview-grid">
                                     @foreach($forum_post->forumPostMedia as $media)
                                        <div class="preview-container" data-image-id="{{ $media->id }}">
                                            <img src="{{ asset('/images/forum_posts/'.$media->media) }}" alt="Existing Image">
                                            <button type="button" class="remove-image"
                                                data-image-id="{{ $media->id }}">×</button>
                                        </div>
                                    @endforeach
                                   
                                </div>
                                 <div id="uploadProgressContainer" style="display: none; margin-top: 10px;">
                                    <p>Upload Progress:</p>
                                    <div class="progress" style="height: 20px; background-color: #f3f3f3; border-radius: 5px; overflow: hidden;">
                                        <div id="uploadProgressBar" class="progress-bar" style="height: 100%; width: 0%; background-color: #3490dc; text-align: center; line-height: 20px; color: white; transition: width 0.3s;"></div>
                                    </div>
                                    <p id="uploadProgressText" style="text-align: center; margin-top: 5px;">0%</p>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-dark" id="saveEdit">Save Changes</button>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        // Append the modal to the body
        document.body.insertAdjacentHTML('beforeend', modalHTML);
        
        // Initialize TinyMCE for the edit modal
        tinymce.init({
            selector: '#editPostModal textarea',
            menubar: false,
            plugins: [
                'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                'insertdatetime', 'media', 'table', 'help', 'wordcount', 'emoticons'
            ],
            toolbar: 'undo redo | blocks | ' +
                'bold italic forecolor |' +
                'emoticons giphy|image media| bullist numlist outdent indent ' +
                'removeformat | alignright | alignjustify alignleft aligncenter',
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',
            branding: false,
            images_upload_handler: function (blobInfo, progress) {
                return new Promise((resolve, reject) => {
                    let data = new FormData();
                    data.append('file', blobInfo.blob());

                    fetch("/forum/upload/image", {
                        method: 'POST',
                        body: data,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                        }
                    })
                    .then(response => {
                        console.log('Server response:', response);
                        if (!response.ok) {
                            throw new Error('HTTP error! status: ' + response.status);
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Parsed JSON response:', data);
                        if (data && data.location) {
                            resolve(data.location); 
                        } else if (data && data.error) {
                            reject(data.error);
                        } else {
                            reject('Invalid response from server'); 
                        }
                    })
                    .catch(error => {
                        console.error('Image upload failed:', error);
                        reject('Image upload failed: ' + error.message);
                    });
                });
            },
            file_picker_types: 'media',
            file_picker_callback: function (callback, value, meta) {
                if (meta.filetype === 'media') {
                    const input = document.createElement('input');
                    input.setAttribute('type', 'file');
                    input.setAttribute('accept', 'video/*');

                    input.onchange = function () {
                        const file = this.files[0];
                        const formData = new FormData();
                        formData.append('file', file);

                        fetch("/forum/upload/video", {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data && data.location) {
                                callback(data.location, { source: data.location });
                            } else {
                                console.error('Invalid response from server');
                            }
                        })
                        .catch(error => {
                            console.error('Video upload failed:', error);
                        });
                    };

                    input.click();
                }
            },
            setup: function (editor) {
                editor.ui.registry.addButton('giphy', {
                    text: 'GIF',
                    onAction: function () {
                        openGiphyModal(editor);
                    }
                });
            }
        });
        
        // Handle close button click
        document.querySelector('.edit-close-btn').addEventListener('click', () => {
            document.getElementById('editPostModal').remove();
            tinymce.remove('#editContent');
        });
        
        // Function to convert image to WebP format with compression
        async function convertToWebP(file, quality = 0.8) {
            return new Promise((resolve) => {
                const reader = new FileReader();
                reader.onload = function(event) {
                    const img = new Image();
                    img.onload = function() {
                        const canvas = document.createElement('canvas');
                        canvas.width = img.width;
                        canvas.height = img.height;
                        const ctx = canvas.getContext('2d');
                        ctx.drawImage(img, 0, 0);
                        
                        // Convert to WebP
                        canvas.toBlob((blob) => {
                            // Create a new file with WebP extension
                            const webpFile = new File([blob], file.name.split('.')[0] + '.webp', {
                                type: 'image/webp',
                                lastModified: new Date().getTime()
                            });
                            resolve(webpFile);
                        }, 'image/webp', quality);
                    };
                    img.src = event.target.result;
                };
                reader.readAsDataURL(file);
            });
        }
        
        // Handle save button click with progress bar
        document.getElementById('saveEdit').addEventListener('click', async function() {
            console.log('Save button clicked');

            const updatedTopic = document.getElementById('editTopic').value.trim();
            const updatedContent = tinymce.get('editContent').getContent();

            console.log('Updated Topic:', updatedTopic);
            console.log('Updated Content:', updatedContent);

            if (!updatedTopic) {
                alert('Title is required');
                console.warn('Title is missing');
                return;
            }

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            console.log('CSRF Token:', csrfToken);

            // Collect file data for upload
            const formData = new FormData();
            formData.append('topic', updatedTopic);
            formData.append('content', updatedContent);

            // Add files if any - convert to WebP first
            const fileInput = document.getElementById('fileInput');
            let processedFiles = 0;
            let totalFiles = fileInput.files.length;
            
            if (fileInput && totalFiles > 0) {
                console.log('Files to process:', totalFiles);
                
                // Show progress container
                const progressContainer = document.getElementById('uploadProgressContainer');
                const progressBar = document.getElementById('uploadProgressBar');
                const progressText = document.getElementById('uploadProgressText');
                progressContainer.style.display = 'block';
                
                // Process image conversion
                for (let i = 0; i < totalFiles; i++) {
                    const file = fileInput.files[i];
                  
                    
                    // Update progress for conversion phase
                    const conversionProgress = Math.round((i / totalFiles) * 50);
                    progressBar.style.width = conversionProgress + '%';
                    progressText.textContent = ` ${conversionProgress}%`;
                    
                    // Convert image to WebP if it's an image
                    if (file.type.startsWith('image/')) {
                        try {
                            const webpFile = await convertToWebP(file, 0.8);  // 80% quality
                            console.log(`Converted ${file.name} to WebP: ${webpFile.size} bytes`);
                            formData.append('media[]', webpFile);
                        } catch (error) {
                            console.error(`Error converting ${file.name} to WebP:`, error);
                            // Fall back to original file if conversion fails
                            formData.append('media[]', file);
                        }
                    } else {
                        // Not an image, add as is
                        formData.append('media[]', file);
                    }
                    
                    processedFiles++;
                }
                
                // Update progress for conversion complete
                progressBar.style.width = '50%';
                progressText.textContent = '';
            }

            // Show a loading indicator
            const saveButton = document.getElementById('saveEdit');
            saveButton.innerHTML = 'Uploading...';
            saveButton.disabled = true;

            // Create an XMLHttpRequest for upload with progress tracking
            const xhr = new XMLHttpRequest();
            xhr.open('POST', `/forum/${postId}/edit`);
            xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);
            
            // Upload progress event
            xhr.upload.addEventListener('progress', function(e) {
                if (e.lengthComputable) {
                    // Calculate progress (remaining 50% of the process)
                    const percent = Math.round((e.loaded / e.total) * 50) + 50;
                    const progressBar = document.getElementById('uploadProgressBar');
                    const progressText = document.getElementById('uploadProgressText');
                    
                    progressBar.style.width = percent + '%';
                    progressText.textContent = `${percent}%`;
                    
                  
                }
            });
            
            // Handle response
            xhr.onload = function() {
                if (xhr.status === 200) {
                    try {
                        const data = JSON.parse(xhr.responseText);
                        console.log('Server Response:', data);
                        
                        if (data.success) {
                            console.log('Post updated successfully');
                            
                            // Show 100% complete
                            const progressBar = document.getElementById('uploadProgressBar');
                            const progressText = document.getElementById('uploadProgressText');
                            progressBar.style.width = '100%';
                            progressText.textContent = '100%';
                            
                            // Remove the modal
                            setTimeout(() => {
                                document.getElementById('editPostModal').remove();
                                tinymce.remove('#editContent');
                                
                                // Show success message
                                Swal.fire('Success', data.message, 'success').then(() => {
                                    location.reload();
                                });
                            }, 500); // Short delay to show completed progress
                        } else {
                            console.error('Error updating post:', data);
                            Swal.fire('Error', data.message || 'Something went wrong', 'error');
                            saveButton.innerHTML = 'Save Changes';
                            saveButton.disabled = false;
                        }
                    } catch (e) {
                        console.error('Error parsing response:', e);
                        Swal.fire('Error', 'Invalid server response', 'error');
                        saveButton.innerHTML = 'Save Changes';
                        saveButton.disabled = false;
                    }
                } else {
                    console.error('HTTP error:', xhr.status);
                    Swal.fire('Error', `Server error: ${xhr.status}`, 'error');
                    saveButton.innerHTML = 'Save Changes';
                    saveButton.disabled = false;
                }
            };
            
            // Handle network errors
            xhr.onerror = function() {
                console.error('Network error during upload');
                Swal.fire('Error', 'Network error, please try again', 'error');
                saveButton.innerHTML = 'Save Changes';
                saveButton.disabled = false;
            };
            
            // Send the form data
            xhr.send(formData);
        });
     
        const fileInput = document.getElementById('fileInput');
        const previewContainer = document.getElementById('previewContainer');

        fileInput.addEventListener('change', function() {
            if (this.files && this.files.length > 0) {
                if (this.files.length > 10) {
                    alert('You can only upload up to 10 files.');
                    this.value = '';
                    return;
                }
                
                // Clear existing previews in the existing images container
                const existingContainer = document.getElementById('existing-images-container');
                // Only remove preview containers, not the existing image containers
                const previewElements = existingContainer.querySelectorAll('.preview-container:not([data-image-id])');
                previewElements.forEach(el => el.remove());
                
                for (let i = 0; i < this.files.length; i++) {
                    const file = this.files[i];
                    
                    if (file.type.match('image.*')) {
                        const reader = new FileReader();
                        
                        reader.onload = function(e) {
                            // Create a preview container that matches the structure of existing images
                            const previewContainerDiv = document.createElement('div');
                            previewContainerDiv.classList.add('preview-container');
                            previewContainerDiv.style.position = 'relative';
                            previewContainerDiv.style.display = 'inline-block';
                            previewContainerDiv.style.margin = '5px';
                            
                            const img = document.createElement('img');
                            img.src = e.target.result;
                            img.alt = "Preview Image";
                            img.style.width = '100px';
                            img.style.height = '100px';
                            img.style.objectFit = 'cover';
                            img.style.borderRadius = '5px';
                            
                            const removeBtn = document.createElement('button');
                            removeBtn.type = 'button';
                            removeBtn.classList.add('remove-preview');
                            removeBtn.textContent = '×';
                            removeBtn.style.position = 'absolute';
                            removeBtn.style.top = '5px';
                            removeBtn.style.right = '5px';
                            removeBtn.style.background = 'rgba(255, 0, 0, 0.7)';
                            removeBtn.style.color = 'white';
                            removeBtn.style.border = 'none';
                            removeBtn.style.borderRadius = '50%';
                            removeBtn.style.width = '20px';
                            removeBtn.style.height = '20px';
                            removeBtn.style.cursor = 'pointer';
                            removeBtn.style.display = 'flex';
                            removeBtn.style.justifyContent = 'center';
                            removeBtn.style.alignItems = 'center';
                            removeBtn.style.fontSize = '16px';
                            removeBtn.style.padding = '0';
                            removeBtn.style.lineHeight = '1';
                            
                            // Add info label about WebP conversion
                            const infoLabel = document.createElement('div');
                            infoLabel.textContent = '';
                            infoLabel.style.position = 'absolute';
                            infoLabel.style.bottom = '0';
                            infoLabel.style.left = '0';
                            infoLabel.style.right = '0';
                       
                            infoLabel.style.color = 'white';
                            infoLabel.style.fontSize = '10px';
                            infoLabel.style.padding = '2px';
                            infoLabel.style.textAlign = 'center';
                            
                            removeBtn.addEventListener('click', function() {
                                previewContainerDiv.remove();
                            });
                            
                            previewContainerDiv.appendChild(img);
                            previewContainerDiv.appendChild(removeBtn);
                            previewContainerDiv.appendChild(infoLabel);
                            
                            // Insert into the existing images container
                            existingContainer.appendChild(previewContainerDiv);
                        };
                        
                        reader.readAsDataURL(file);
                    }
                }
            }
        });
           
        const uploadArea = document.getElementById('uploadArea');
        
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            uploadArea.addEventListener(eventName, preventDefaults, false);
        });
        
        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }
        
        ['dragenter', 'dragover'].forEach(eventName => {
            uploadArea.addEventListener(eventName, highlight, false);
        });
        
        ['dragleave', 'drop'].forEach(eventName => {
            uploadArea.addEventListener(eventName, unhighlight, false);
        });
        
        function highlight() {
            uploadArea.classList.add('highlight');
        }
        
        function unhighlight() {
            uploadArea.classList.remove('highlight');
        }
        
        uploadArea.addEventListener('drop', handleDrop, false);
        
        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            fileInput.files = files;
            
            // Trigger change event to show previews
            const event = new Event('change');
            fileInput.dispatchEvent(event);
        }
    
        // Function to open Giphy modal (same as in your original code)
        function openGiphyModal(editor) {
            const existingModal = document.getElementById('giphyModal');
            if (existingModal) existingModal.remove(); // Remove old modal if it exists

            const giphyModal = document.createElement('div');
            giphyModal.id = 'giphyModal';
            giphyModal.style.position = 'fixed';
            giphyModal.style.top = '50%';
            giphyModal.style.left = '50%';
            giphyModal.style.transform = 'translate(-50%, -50%)';
            giphyModal.style.background = 'white';
            giphyModal.style.padding = '20px';
            giphyModal.style.borderRadius = '10px';
            giphyModal.style.boxShadow = '0 0 10px rgba(0,0,0,0.2)';
            giphyModal.style.width = '400px';
            giphyModal.style.zIndex = '10000';

            giphyModal.innerHTML = `
                <input type="text" id="giphySearch" placeholder="Search for GIFs..." 
                    style="width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 5px;">
                <div id="giphyResults" style="max-height: 300px; overflow-y: auto; display: flex; flex-wrap: wrap; gap: 5px;"></div>
                <button id="closeGiphy" style="margin-top: 10px; padding: 8px 12px; border: none; background: red; color: white; cursor: pointer; border-radius: 5px;">Close</button>
            `;

            document.body.appendChild(giphyModal);

            document.getElementById('closeGiphy').addEventListener('click', closeGiphyModal);
            document.getElementById('giphySearch').addEventListener('input', function () {
                fetchGiphyGIFs(this.value, editor);
            });
        }

        function closeGiphyModal() {
            const modal = document.getElementById('giphyModal');
            if (modal) modal.remove();
        }

        function fetchGiphyGIFs(query, editor) {
            const API_KEY = 'LoEtBVykwd74rrZOM6oCxaXolWJu8cQn'; 
            const url = `https://api.giphy.com/v1/gifs/search?api_key=${API_KEY}&q=${query}&limit=10`;

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    const resultsDiv = document.getElementById('giphyResults');
                    resultsDiv.innerHTML = '';

                    data.data.forEach(gif => {
                        const img = document.createElement('img');
                        img.src = gif.images.fixed_height_small.url;
                        img.style.cursor = 'pointer';
                        img.style.width = '100px';
                        img.style.height = '100px';
                        img.style.objectFit = 'cover';
                        img.style.borderRadius = '5px';

                        img.addEventListener('click', function () {
                            insertGifIntoEditor(editor, gif.images.original.url);
                        });

                        resultsDiv.appendChild(img);
                    });
                })
                .catch(error => console.error('Error fetching GIFs:', error));
        }

        function insertGifIntoEditor(editor, gifUrl) {
            editor.execCommand('mceInsertContent', false, `<img src="${gifUrl}" alt="GIF" style="max-width:100%;">`);
            closeGiphyModal();
        }
    });
});

</script>
<script>
   document.addEventListener('click', function (event) {
    if (event.target && event.target.classList.contains('remove-image')) {
        event.preventDefault(); // Prevent default behavior if needed
        const imageId = event.target.getAttribute('data-image-id');
        deleteExistingImage(imageId);
    }
});


function deleteExistingImage(imageId) {
    if (confirm('Are you sure you want to delete this image?')) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        console.log('Attempting to delete image ID:', imageId);

        fetch(`/delete-image-forum/${imageId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                credentials: 'same-origin',
            })
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    console.log(`Image ${imageId} deleted successfully.`);

                    // Find and remove the specific image container
                    const imageElement = document.querySelector(`[data-image-id="${imageId}"]`);
                    if (imageElement) {
                        imageElement.remove();
                    } else {
                        console.error('Image element not found in DOM.');
                    }
                } else {
                    console.error('Server error:', data.message);
                    alert(data.message || 'Failed to delete image.');
                }
            })
            .catch((error) => {
                console.error('Error deleting image:', error);
                alert('Failed to delete image.');
            });
    }
}


</script>
<style>
.swal-confirm-btn {
    background-color: #000 !important; 
    color: #fff !important;
    border: none !important;
    padding: 8px 20px !important;
    font-size: 14px !important;
    font-weight: bold !important;
    width: 100px;
    border-radius: 5px !important;
    border: 2px solid #000 !important;
}

.swal-cancel-btn {
    background-color: #fff !important; 
    color: #000 !important; 
    border: 2px solid #000 !important; 
    padding: 8px 20px !important;
    font-size: 14px !important;
    font-weight: bold !important;
    border-radius: 5px !important;
    width: 100px;
}
.custom-swal-popup {
            background-color: white !important;
            width: 300px !important;
            height: 300px !important;
        }

@media (max-width: 768px) {
    .custom-swal-popup {
        width: 90% !important; 
    }
}
</style>
<script>
document.querySelectorAll('.delete-btn_reply').forEach(button => {
    button.addEventListener('click', function() {
        const replyId = this.getAttribute('data-reply-id');

        Swal.fire({
            title: 'Are you sure?',
            icon: 'question',
            showCancelButton: true,
            reverseButtons: true, 
            confirmButtonText: 'Yes',
            cancelButtonText: 'Cancel',
            customClass: {
                popup: 'custom-swal-popup',
                confirmButton: 'swal-confirm-btn',
                cancelButton: 'swal-cancel-btn'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                fetch(`/forum/reply/${replyId}/delete`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
    if (data.success) {
        Swal.fire({
            imageUrl: '{{ asset('assets/trasbiforpaper.png') }}',
            text: 'Your reply has been deleted.',
            imageWidth: 150,
            imageAlt: 'Success',
            showConfirmButton: false,
            timer: 2000,
            customClass: {
                popup: 'custom-swal-popup'
            }
        }).then(() => {
            location.reload();
        });
                        } else {
                            Swal.fire(
                                'Error',
                                data.message || 'Something went wrong',
                                'error'
                            );
                        }
                    })
                    .catch(() => {
                        Swal.fire(
                            'Error',
                            'Failed to delete reply',
                            'error'
                        );
                    });
            }
        });
    });
});


document.querySelectorAll('.delete-btn').forEach(button => {
    button.addEventListener('click', function() {
        const postId = this.getAttribute('data-post-id');
        Swal.fire({
            title: 'Are you sure?',
            icon: 'question',
            showCancelButton: true,
            reverseButtons: true, 
            confirmButtonText: 'Yes',
            cancelButtonText: 'Cancel',
            customClass: {
                popup: 'custom-swal-popup',
                confirmButton: 'swal-confirm-btn',
                cancelButton: 'swal-cancel-btn'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const csrfToken = document.querySelector('meta[name="csrf-token"]')
                    .getAttribute('content');

                fetch(`/forum/${postId}/delete`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            window.location.href = '/forum';
                        } else {
                            Swal.fire('Error', 'Something went wrong', 'error');
                        }
                    })
                    .catch(() => {
                        Swal.fire('Error', 'Failed to delete post', 'error');
                    });
            }
        });
    });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('richTextModal');
    const closeModalBtn = document.querySelector('.close-btn');

    document.body.addEventListener('click', function(event) {
        if (event.target && event.target.id === 'openModal') {
            modal.style.display = 'block';
        }
        if (event.target && event.target.classList.contains('close-btn')) {
            modal.style.display = 'none';
        }
    });

    window.addEventListener('click', (event) => {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });
});

const uploadArea = document.getElementById('uploadArea');
const fileInput = document.getElementById('fileInput');
const previewContainer = document.getElementById('previewContainer');

uploadArea.addEventListener('click', () => {
    fileInput.click();
});

fileInput.addEventListener('change', handleFiles);

uploadArea.addEventListener('dragover', (event) => {
    event.preventDefault();
    uploadArea.style.borderColor = '#00bcd4';
});

uploadArea.addEventListener('dragleave', () => {
    uploadArea.style.borderColor = '#4a90e2';
});

uploadArea.addEventListener('drop', (event) => {
    event.preventDefault();
    handleFiles(event);
});

function handleFiles(event) {
    const files = event.target.files || event.dataTransfer.files;
    if (files.length > 5) {
        alert("You can upload up to 5 files only.");
        return;
    }

    previewContainer.innerHTML = ''; 
    for (let file of files) {
        const reader = new FileReader();
        reader.onload = function(e) {
            if (file.type.startsWith('image/')) {
                const img = document.createElement('img');
                img.src = e.target.result;
                previewContainer.appendChild(img);
            } else if (file.type.startsWith('video/')) {
                const video = document.createElement('video');
                video.src = e.target.result;
                video.controls = true;
                video.width = 200; 
                previewContainer.appendChild(video);
            }
        };
        reader.readAsDataURL(file);
    }
}
</script>
<script>
$(document).ready(function() {
    $('.block-user').on('click', function() {
        const button = $(this);
        const userId = button.data('user-id');
        const isBlocked = button.data('is-blocked');
        const action = isBlocked ? 'unblock' : 'block';

        $.ajax({
            url: `/moderator/users/${action}`,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                user_id: userId
            },
            success: function(response) {
                if (response.success) {
                    button.text(isBlocked ? 'Block User' : 'Unblock User');
                    button.data('is-blocked', !isBlocked);
                    Swal.fire('Success!', response.message, 'success');
                } else {
                    Swal.fire('Error!', response.message, 'error');
                }
            },
            error: function() {
                Swal.fire('Error!', 'An error occurred while performing the action.',
                    'error');
            }
        });
    });
});
</script>

<style>
#settings-dropdown a {
    display: block;
    padding: 8px 12px;
    text-decoration: none;
    color: #333;
}

#settings-dropdown a:hover {
    background-color: #f0f0f0;
}

.like-icon {
    font-size: 20px;
    transition: all 0.3s ease;
}

.dislike-btn {
    font-size: 20px;
    transition: all 0.3s ease;
}

.like-icon.liked {
    color: black;
    font-size: 25px;
}

.like-btn:hover .like-icon {
    transform: scale(1.05);
}

#blockP {
    background-color: white !important;
    border: none !important;
    margin-left: 10px;
}
</style>
<script>
document.addEventListener('DOMContentLoaded', function() {

    const successAlert = document.getElementById('success-alert');
    if (successAlert) {
        setTimeout(function() {
            successAlert.style.transition = 'opacity 0.5s ease';
            successAlert.style.opacity = '0';
            setTimeout(() => successAlert.remove(), 500); // Remove after fading
        }, 2000); 
    }

 
    const dangerAlert = document.getElementById('danger-alert');
    if (dangerAlert) {
        setTimeout(function() {
            dangerAlert.style.transition = 'opacity 0.5s ease';
            dangerAlert.style.opacity = '0';
            setTimeout(() => dangerAlert.remove(), 500); 
        }, 2000); 
    }
});
</script>

<style>
.small-alert {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 1050;
    padding: 10px 15px;
    font-size: 14px;
    border-radius: 5px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.alert-success {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.alert-danger {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}
</style>
<style>
.image-preview-grid {
    display: grid;
    /* For larger screens, keep auto-fill behavior */
    grid-template-columns: repeat(auto-fill, minmax(162px, 1fr));
    gap: 10px;
    margin-top: 20px;
}

/* Add media query for mobile devices */
@media screen and (max-width: 480px) {
    .image-preview-grid {
        /* Force 2 columns on mobile */
        grid-template-columns: repeat(2, 1fr);
        /* Adjust gap for smaller screens */
        gap: 8px;
    }

    .preview-container {
        /* Make containers responsive */
        width: 100px !important;
        height: 100px !important;
        aspect-ratio: 1/1;
    }

    .preview-container img {
        /* Make images responsive */
        max-width: 100px !important;
        height: 100% !important;
    }
}
@media screen and (max-width: 768px) {
    .mobilemodal {
        padding: 0 !important;
    }
    .mobilemodalcontent {
        margin: 0 !important;
        border-radius: 0 !important;
    }
}


.preview-container {
    position: relative;
    width: 162px;
    height: 162px;
    overflow: hidden;
  
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.preview-container img {
    width: 100% !important;  
    height: 100% !important;
    border: 1px solid #ccc;
    border-radius: 5px;
    object-fit: cover !important;
}


.remove-image {
    position: absolute;
    top: 5px !important;
    right: 5px !important;
    background: rgba(255, 0, 0, 0.7);
    color: white;
    border: none;
    border-radius: 50%;
    width: 25px;
    height: 25px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
}
.remove-image-reply {
    position: absolute;
    top: 5px !important;
    right: 5px !important;
    background: rgba(255, 0, 0, 0.7);
    color: white;
    border: none;
    border-radius: 50%;
    width: 25px;
    height: 25px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
}



</style>

@endsection