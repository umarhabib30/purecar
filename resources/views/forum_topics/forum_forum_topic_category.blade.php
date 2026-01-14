@extends('layout.layout')

@section('body')
<title>Pure Car Forum | Engage with Fellow Car Enthusiasts</title>
<meta name="description" content=" Participate in discussions with car lovers in Ni. Share experiences, get advice, and stay updated on the latest automotive trends.">
<link rel="stylesheet" href="{{asset('css/forum_page.css')}}">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
<script src="{{ asset('tinymce/tinymce.min.js') }}"></script>

<script>

</script>

<style>
    @media (max-width: 576px) {
       

        #hello {
                background-color: #e8e8e8;
                padding: 0.75rem !important;
                border-radius: 0.5rem !important;
                font-weight: bold !important;
                height: 45px !important;
                width: 100% !important;
                font-size: 16px !important;

                display: flex !important;
                align-items: center !important;
                justify-content: start; /* Optional: Centers text horizontally */
                margin-bottom: 20px !important;
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
}
#hello1 {
    background-color: #e8e8e8;
    padding:  0 !important; /* Remove right padding */
    margin-top: 10px;

    border-radius: 0.5rem !important;
    font-weight: bold !important;
    height: 45px !important;
    width: 100% !important;
    font-size: 16px !important;
    display: flex !important;
    align-items: center !important;
    justify-content: space-between !important;
    position: relative;
}

.responsivecategorybutton1 {
    height: 100% !important; /* Make button take full height of the container */
    font-size: 14px;
    padding: 0 !important; 
    border-top-right-radius: 0.5rem !important; /* Optional: Rounds only top-right */
    border-bottom-right-radius: 0.5rem !important; /* Optional: Rounds only bottom-right */
    margin: 0 !important; /* Ensures no extra space */

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
<div class="p-2  forum">
                @auth
                <button class="btn btn-dark open-modal responsivecategorybutton ms-auto mb-2 d-none d-lg-block fixed-bottom-end d-flex justify-content-center align-items-center" id="openModal">
                    <i class="fas fa-pen"></i>  
                </button>

                @endauth
                @auth
                    <button class="btn btn-dark open-modal responsivecategorybutton ms-auto mb-2 d-lg-none fixed-bottom-end-mobile d-flex justify-content-center align-items-center" id="openModal">
                        <i class="fas fa-pen"></i>  
                    </button>
                @endauth
                @guest
                    <a href="{{ route('signup_view') }}" class="btn btn-success open-modal responsivecategorybutton ms-auto mb-2 d-none d-lg-block fixed-bottom-end d-flex justify-content-center align-items-center">
                        <i class="fas fa-user-plus me-2"></i> Signup
                    </a>

                    <a href="{{ route('signup_view') }}" class="btn btn-success open-modal responsivecategorybutton ms-auto mb-2 d-lg-none fixed-bottom-end-mobile d-flex justify-content-center align-items-center">
                        <i class="fas fa-user-plus me-2"></i> Signup
                    </a>
                @endguest

    <div id="forum-container">
        @include('layout.forum_heading')
        <div class="forum-tab">       
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center responsivemobilehead d-md-none">
            <!-- @auth
                <button class="btn btn-dark open-modal responsivecategorybutton ms-auto mb-2 d-md-none" id="openModal">
                <i class="fas fa-pen me-2 p-1"></i>  
                <span class="p-1">Add Topic</span>
                </button>
                @endauth -->
                <p id="hello" class="fw-bold mb-0 mb-2">{{ $forum_topic_category->category }}</p>
            </div>
            
            <div class="row mb-3 mt-3 d-none d-md-block">
                <div class="col-12">
                    <div id="hello1" class="d-flex justify-content-between align-items-center position-relative ">
                    <span class="ps-3">{{ $forum_topic_category->category }}</span>

                        <!-- @auth
                        <button class="btn btn-dark open-modal d-none d-md-block responsivecategorybutton1 px-3 py-2" id="openModal">
                            <i class="fas fa-pen me-2 p-1"></i>  
                            <span class="p-1">Add Topic</span>
                        </button>
                        @endauth -->
                    </div>
                </div>
            </div>


               
          

            @if ($paginatedPosts->isEmpty())
            <p class="text-muted">No posts available. Be the first to contribute to this topic!</p>
            @else
            @foreach($paginatedPosts as $forum_post)
            <div class="p-3 mb-4 rounded post-container d-none d-md-block" style="cursor: pointer;"
                onclick="window.location.href='{{ route('forum.topic.show', $forum_post->slug) }}';">
                <div class="row align-items-center">
                    <!-- Post Content Section -->
                    <div class="col-12 col-md-8 d-flex align-items-center">
                        <div>
                        @if($forum_post->is_pinned && auth()->check())
                            @php
                                $user = auth()->user();
                                $isAdmin = $user->role === 'admin';
                                $isModerator = \App\Models\Moderator::where('user_id', $user->id)
                                                ->where('forum_topic_id', $forum_post->forum_topic_category_id)
                                                ->exists();
                            @endphp

                            @if(!$isAdmin && !$isModerator)
                            <i class="fas fa-thumbtack text-green-500"></i>

                            @endif
                        @endif


                        @if(auth()->check())
                            @php
                                $user = auth()->user();
                                $isPinned = \App\Models\PinPost::where('forum_post_id', $forum_post->id)
                                            ->where('auth_id', $user->id)
                                            ->exists();
                                $isAdmin = $user->role === 'admin';
                                $isModerator = \App\Models\Moderator::where('user_id', $user->id)
                                            ->where('forum_topic_id', $forum_post->forum_topic_category_id)
                                            ->exists();
                            @endphp

                            @if($isAdmin || $isModerator)
                                <form action="{{ route('forum.pin-post') }}" method="POST" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="post_id" value="{{ $forum_post->id }}">
                                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                                    <button type="submit" class="p-0 btn">
                                        <i class="fa fa-thumbtack" 
                                        style="color: {{ $forum_post->is_pinned ? 'green' : 'rgb(130, 130, 130)' }};">
                                        </i>
                                    </button>
                                </form>
                            @endif
                        @endif





                            <a href="{{ route('forum.topic.show', $forum_post->slug) }}"
                                class="topic-name d-block text-decoration-none text-dark fw-bold text-truncate"
                                style="display: block; max-width: 100%; overflow: hidden; word-wrap: break-word; overflow-wrap: break-word; white-space: normal; text-overflow: ellipsis; font-size: 16px;">
                                {!! Str::words(strip_tags(html_entity_decode($forum_post->topic)), 100, '...') !!}
                            </a>

                            <p class="mb-0 text-muted small">
                                {{ $forum_post->userDetails ? $forum_post->userDetails->name : 'Unknown Author' }},
                                {{ $forum_post->created_at->format('d/m/Y') }}
                            </p>
                        </div>
                    </div>

                    <!-- Empty Space -->
                    <!-- <div class="col-12 col-md-4 d-none d-md-block">


                    </div> -->

                    <!-- Replies and Views Count -->
                    <div class="text-center col-12 col-md-1">
                        <p class="mb-0 text-muted small">{{ $forum_post->reply_count ?? 0 }}
                            replies<br>{{ $forum_post->views ?? 0 }} views</p>
                    </div>

                    <!-- Latest Reply Section -->
                    <div class="cursor-pointer col-12 col-md-3 d-flex align-items-center"
                        onclick="window.location.href='{{ route('forum.topic.show', $forum_post->slug) }}'">
                        @if($forum_post->latest_reply)
                        <img src="{{ $forum_post->latest_reply->auth_id
                    ? asset('/images/users/'.$forum_post->latest_reply->author->image)
                    : asset('/images/default.png') }}" alt="Author Image" class="rounded-circle me-2"
                            style="width: 40px; height: 40px;">
                        <div>
                            <p class="mb-0 fw-bold">{{ $forum_post->latest_reply->auth_id
                        ? $forum_post->latest_reply->author->name
                        : 'Unknown Author' }}
                            </p>
                            <span
                                class="text-muted small">{{ $forum_post->latest_reply->created_at->diffForHumans()}}</span>
                        </div>
                        @else
                        <img src="{{ $forum_post->userDetails->id
                    ? asset('/images/users/'.$forum_post->userDetails->image)
                    : asset('/images/default.png') }}" alt="Author Image" class="rounded-circle me-2"
                            style="width: 40px; height: 40px;">
                        <div>
                            <p class="mb-0 fw-bold">{{ $forum_post->userDetails ? $forum_post->userDetails->name : 'Unknown Author' }}
                            </p>
                            <span
                                class="text-muted small">{{ $forum_post->created_at->diffForHumans()}}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
            <!-- for mobile  -->
            @foreach($paginatedPosts as $forum_post)
            <div class="p-3 mb-4 rounded post-container d-md-none" style="cursor: pointer;"
                onclick="window.location.href='{{ route('forum.topic.show', $forum_post->slug) }}';">
                <div class="row align-items-center g-3">
                    <!-- Post Content Section -->
                    <div class="col-12">
                        <div class="w-100">
                            @if($forum_post->is_pinned)
                            <i class="fas fa-thumbtack text-success"></i>
                            @endif
                            @if(auth()->check() && (auth()->user()->role === 'admin' ||
                            App\Models\Moderator::where('user_id', auth()->id())->exists()))
                            <form action="{{ route('forum.pin-post') }}" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="post_id" value="{{ $forum_post->id }}">
                                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                @php
                                $isPinned = \App\Models\PinPost::where('forum_post_id', $forum_post->id)
                                ->where('auth_id', auth()->user()->id)
                                ->exists();
                                @endphp
                                <button type="submit" class="p-0 btn">
                                    <i class="fa fa-thumbtack"
                                    style="color: {{ $isPinned ? 'green' : 'rgb(130, 130, 130)' }};"></i>
                                </button>
                            </form>
                            @endif

                            <a href="{{ route('forum.topic.show', $forum_post->slug) }}"
                            class="topic-name d-block text-decoration-none text-dark fw-bold text-truncate"
                            style="font-size: 16px;">
                                {!! Str::words(strip_tags(html_entity_decode($forum_post->topic)), 100, '...') !!}
                            </a>

                            <p class="mb-0 text-muted small text-truncate">
                                {{ $forum_post->userDetails ? $forum_post->userDetails->name : 'Unknown Author' }},
                                {{ $forum_post->created_at->format('d/m/Y') }}
                            </p>
                        </div>
                    </div>

                    <!-- Replies and Views Count with Icons -->
                    <div class="col-12 d-flex align-items-center mt-2">
                        <div class="me-3">
                            <i class="fas fa-comment text-muted"></i>
                            <span class="text-muted small">{{ $forum_post->reply_count ?? 0 }}</span>
                        </div>
                        <div>
                            <i class="fas fa-eye text-muted"></i>
                            <span class="text-muted small">{{ $forum_post->views ?? 0 }}</span>
                        </div>
                    </div>

                    <!-- Latest Reply Section -->
                    <div class="col-12 d-flex align-items-center mt-2">
                        @if($forum_post->latest_reply)
                        <img src="{{ $forum_post->latest_reply->auth_id
                        ? asset('/images/users/'.$forum_post->latest_reply->author->image)
                        : asset('/images/default.png') }}" alt="Author Image" class="rounded-circle me-2"
                            style="width: 40px; height: 40px; min-width: 40px;">
                        <div class="overflow-hidden">
                            <p class="mb-0 fw-bold text-truncate">
                                {{ $forum_post->latest_reply->auth_id
                                ? $forum_post->latest_reply->author->name
                                : 'Unknown Author' }}
                            </p>
                            <span class="text-muted small">{{ $forum_post->latest_reply->created_at->diffForHumans()}}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach




            @endif
            <div class="pagination-container d-flex justify-content-center justify-content-md-start mt-3 mb-3">
    {{ $paginatedPosts->links() }}
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
    align-items: center;  /* Vertical centering */
    justify-content: flex-start; /* Align items to the start horizontally */
    line-height: 45px !important; /* Ensures text is vertically centered */
}

.upergreybar p{
    padding-top:18px !important; 
    padding-left: 10px !important
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



@auth
<div id="richTextModal" class="p-4 modal mobilemodal">
    <div class="modal-content mobilemodalcontent">
        <span class="close-btn">&times;</span>
        @if(auth()->user()->role != 'admin')
        <div>
            <p id="media-upload"><strong>Create New Topic</strong></p>
            <form action="{{ route('forum-post.create', ['forum_topic_category' => $forum_topic_category->id]) }}"
                method="post" enctype="multipart/form-data" id="uploadForm">
                @csrf
                <div class="mb-4 form-group">
                    <label for="topic" class="form-label" style="font-weight: bold; color: #4A5568;">Title</label>
                    <input type="text" name="topic" id="topic" class="form-control" placeholder="Enter the topic here."
                        style="border: 2px solid #CBD5E0; border-radius: 8px; padding: 10px; font-size: 16px; color: #2D3748;">
                </div>
                <div id="text-area">
                    <textarea name="content" placeholder="Enter details here"></textarea>
                </div>
                <p id="media-upload">Media Upload</p>
                <div id="media-upload-container">
                    <div class="p-4 upload-area" id="uploadArea">
                        <p>Add your documents here, and you can upload up to {{ $maxFiles}} files max</p>
                        <p class="subtext">Only support .jpg, .png files (will be converted to WebP format)</p>
                        <input type="file" name="original_media[]" id="fileInput" accept=".jpg, .jpeg, .png" multiple>
                        <p>Drag your file(s) or <span>Browse</span></p>
                        <div id="previewContainer" class="preview-container" style="display: flex; flex-wrap: wrap; gap: 10px; margin-top: 15px;"></div>
                    </div>
                    <div class="pt-2" id="progressContainer" style="display: none; text-align: center;">
                        <div style="width: 100%; background-color: #e0e0e0; border-radius: 8px; position: relative;">
                            <div id="progressBar" style="width: 0%; height: 20px; background-color: #4A90E2; border-radius: 8px; position: relative; text-align: center; line-height: 20px; color: white; font-weight: bold;">
                                <span id="progressText" style="position: absolute; width: 100%; left: 0; top: 0;">0%</span>
                            </div>
                        </div>
                    </div>
                    <div id="buttons-container">
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-dark" id="submit">Submit</button>
                        </div>
                    </div>
                </div>
                <!-- Hidden container for WebP files -->
                <div id="webpFilesContainer" style="display: none;"></div>
            </form>
        </div>
        @endif
    </div>
</div>

@endauth

      
        <!-- <script>
    document.getElementById('fileInput').addEventListener('change', function () {
        let progressContainer = document.getElementById('progressContainer');
        let progressBar = document.getElementById('progressBar');
        let progressText = document.getElementById('progressText');
        
        // Show the progress container when an image is selected
        progressContainer.style.display = 'block';
        progressBar.style.width = '0%';
        progressText.innerText = '0%';
        
        let files = this.files;
        if (files.length > 0) {
            let progress = 0;
            let interval = setInterval(() => {
                if (progress >= 100) {
                    clearInterval(interval);
                    // Hide the progress container when upload is complete
                    progressContainer.style.display = 'none';
                } else {
                    progress += 10;
                    progressBar.style.width = progress + '%';
                    progressText.innerText = progress + '%';
                }
            }, 200);
        }
    });
</script> -->

   <script>
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('fileInput');
        const previewContainer = document.getElementById('previewContainer');
        const progressContainer = document.getElementById('progressContainer');
        const progressBar = document.getElementById('progressBar');
        const progressText = document.getElementById('progressText');
        const webpFilesContainer = document.getElementById('webpFilesContainer');
        const uploadForm = document.getElementById('uploadForm');
        
        
        const MAX_FILES = {{ $maxFiles}};
        let selectedFiles = [];
        
        // Listen for file selection
        fileInput.addEventListener('change', function(e) {
            const newFiles = Array.from(this.files);
            
            // Check if too many files selected
            if (selectedFiles.length + newFiles.length > MAX_FILES) {
                alert(`You can only upload up to ${MAX_FILES} files in total.`);
                return;
            }
            
            if (newFiles.length > 0) {
                // Add new files to the collection
                selectedFiles = [...selectedFiles, ...newFiles];
                
                // Show progress bar
                progressContainer.style.display = 'block';
                progressBar.style.width = '0%';
                progressText.innerText = '0%';
                
                // Update preview for all files
                updatePreviews();
                
                // Convert files to WebP
                convertAllToWebP();
            }
            
           
            fileInput.value = '';
        });
        
        // Update all previews
        function updatePreviews() {
            // Clear preview container
            previewContainer.innerHTML = '';
            
            // Add preview for each file
            selectedFiles.forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    // Create preview item
                    const previewItem = document.createElement('div');
                    previewItem.className = 'preview-item';
                    previewItem.style.position = 'relative';
                    previewItem.style.width = '150px';
                 
                    previewItem.style.borderRadius = '4px';
                    previewItem.style.padding = '5px';
                    previewItem.style.textAlign = 'center';
                    
                    // Create image
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.width = '150px';
                    img.style.height = '150px';
                    img.style.objectFit = 'cover';
                    img.style.borderRadius = '3px';
                    previewItem.appendChild(img);
                    
                  
                    
                    // Create remove button
                    const removeBtn = document.createElement('button');
                    removeBtn.innerHTML = '&times;';
                    removeBtn.style.position = 'absolute';
                    removeBtn.style.top = '15px';
                    removeBtn.style.right = '-5px';
                    removeBtn.style.backgroundColor = 'rgba(255, 0, 0, 0.7)';
                    removeBtn.style.color = 'white';
                    removeBtn.style.border = 'none';
                    removeBtn.style.borderRadius = '50%';
                    removeBtn.style.width = '20px';
                    removeBtn.style.height = '20px';
                    removeBtn.style.fontSize = '14px';
                    removeBtn.style.cursor = 'pointer';
                    removeBtn.style.display = 'flex';
                    removeBtn.style.alignItems = 'center';
                    removeBtn.style.justifyContent = 'center';
                    removeBtn.dataset.index = index;
                    removeBtn.addEventListener('click', function() {
                        // Remove file from array
                        selectedFiles.splice(index, 1);
                        
                        // Update previews and convert to WebP again
                        updatePreviews();
                        convertAllToWebP();
                    });
                    previewItem.appendChild(removeBtn);
                    
                    previewContainer.appendChild(previewItem);
                };
                reader.readAsDataURL(file);
            });
        }
        
       // Convert all files to WebP
function convertAllToWebP() {
    // Clear WebP files container
    webpFilesContainer.innerHTML = '';
    
    if (selectedFiles.length === 0) {
        progressContainer.style.display = 'none';
        return;
    }
    
    // Initialize conversion progress
    let processedFiles = 0;
    const totalFiles = selectedFiles.length;
    
    // Convert each file
    selectedFiles.forEach((file, index) => {
        convertToWebP(file, index)
            .then(() => {
                processedFiles++;
                updateProgress(processedFiles, totalFiles);
            })
            .catch(error => {
                console.error('Error converting file:', error);
                processedFiles++;
                updateProgress(processedFiles, totalFiles);
            });
    });
}

// Function to convert image to WebP with size reduction
function convertToWebP(file, index) {
    return new Promise((resolve, reject) => {
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = new Image();
            img.onload = function() {
                // Calculate new dimensions - target max dimension of 1200px
                let width = img.width;
                let height = img.height;
                const MAX_DIMENSION = 1200;
                
                // Resize if larger than max dimension while maintaining aspect ratio
                if (width > MAX_DIMENSION || height > MAX_DIMENSION) {
                    if (width > height) {
                        height = Math.round(height * (MAX_DIMENSION / width));
                        width = MAX_DIMENSION;
                    } else {
                        width = Math.round(width * (MAX_DIMENSION / height));
                        height = MAX_DIMENSION;
                    }
                }
                
                // Create canvas for resizing and conversion
                const canvas = document.createElement('canvas');
                canvas.width = width;
                canvas.height = height;
                const ctx = canvas.getContext('2d');
                
                // Apply image smoothing for better quality when downsizing
                ctx.imageSmoothingEnabled = true;
                ctx.imageSmoothingQuality = 'high';
                
                // Draw image with resize
                ctx.drawImage(img, 0, 0, width, height);
                
                // Convert to WebP with aggressive compression
                canvas.toBlob(function(blob) {
                    if (blob) {
                        // Check if size is still large (more than 300KB)
                        if (blob.size > 300 * 1024) {
                            // Create a second pass with stronger compression
                            const secondPassCanvas = document.createElement('canvas');
                            
                            // Further reduce dimensions if still large
                            let secondWidth = width;
                            let secondHeight = height;
                            
                            if (blob.size > 1024 * 1024) { // If over 1MB, reduce more aggressively
                                secondWidth = Math.round(width * 0.7);
                                secondHeight = Math.round(height * 0.7);
                            } else {
                                secondWidth = Math.round(width * 0.85);
                                secondHeight = Math.round(height * 0.85);
                            }
                            
                            secondPassCanvas.width = secondWidth;
                            secondPassCanvas.height = secondHeight;
                            
                            const secondCtx = secondPassCanvas.getContext('2d');
                            secondCtx.imageSmoothingEnabled = true;
                            secondCtx.imageSmoothingQuality = 'high';
                            secondCtx.drawImage(img, 0, 0, secondWidth, secondHeight);
                            
                            // Convert with even lower quality
                            secondPassCanvas.toBlob(function(secondBlob) {
                                if (secondBlob) {
                                    finishConversion(secondBlob);
                                } else {
                                    // If second pass fails, use first blob
                                    finishConversion(blob);
                                }
                            }, 'image/webp', 0.6); // More aggressive quality reduction
                        } else {
                            finishConversion(blob);
                        }
                    } else {
                        reject(new Error('Blob creation failed'));
                    }
                }, 'image/webp', 0.75); // First pass with 75% quality
                
                // Helper function to finish the conversion process
                function finishConversion(finalBlob) {
                    // Create a file from the blob
                    const webpFile = new File([finalBlob], `${file.name.split('.')[0]}.webp`, {
                        type: 'image/webp',
                        lastModified: new Date().getTime()
                    });
                    
                    // Display size reduction info in console
                    console.log(`File ${file.name}: Original ${(file.size/1024).toFixed(2)}KB → WebP ${(finalBlob.size/1024).toFixed(2)}KB (${Math.round((1 - finalBlob.size/file.size) * 100)}% reduction)`);
                    
                    // Create a file input for the backend
                    const fileInput = document.createElement('input');
                    fileInput.type = 'file';
                    fileInput.name = `media[]`;
                    fileInput.style.display = 'none';
                    
                    // Create DataTransfer to assign file to input
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(webpFile);
                    fileInput.files = dataTransfer.files;
                    
                    webpFilesContainer.appendChild(fileInput);
                    resolve();
                }
            };
            img.onerror = reject;
            img.src = e.target.result;
        };
        reader.onerror = reject;
        reader.readAsDataURL(file);
    });
}
        
        // Update progress bar
        function updateProgress(processed, total) {
            const percent = Math.round((processed / total) * 100);
            progressBar.style.width = percent + '%';
            progressText.innerText = percent + '%';
            
            if (processed === total) {
                // Hide progress after a delay
                setTimeout(() => {
                    progressContainer.style.display = 'none';
                }, 1000);
            }
        }
        
        // Handle form submission
        uploadForm.addEventListener('submit', function(e) {
            // Check if we have any valid files
            if (selectedFiles.length > 0 && webpFilesContainer.children.length < selectedFiles.length) {
                e.preventDefault();
                alert('Please wait for image conversion to complete');
                return false;
            }
        });
    });
</script>

<style>
    @media screen and (max-width: 768px) {
   

    .modal-content {
        width: 100% !important;
        padding: 16px;
    }
    .preview-container img {
    width: 100px !important;
    height: 100px !important;
    object-fit: cover ;
    margin: 5px;
    border-radius: 8px;
    border: 2px solid #ddd;
}
   
}

.preview-container img {
    width: 200px;
    height: 200px;
    object-fit: cover;
    margin: 5px;
    border-radius: 8px;
    border: 2px solid #ddd;
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
</style>


</div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.getElementById('forum-tab').addEventListener('click', function() {
    // Set active tab
    document.getElementById('forum-tab').classList.add('active');
    document.getElementById('activity-tab').classList.remove('active');

    // Show forum heading and hide activity heading
    document.querySelector('.forum-tab').style.display = 'block';
    document.querySelector('.activity-tab').style.display = 'none';
});

document.getElementById('activity-tab').addEventListener('click', function() {
    // Set active tab
    document.getElementById('activity-tab').classList.add('active');
    document.getElementById('forum-tab').classList.remove('active');

    // Show activity heading and hide forum heading
    document.querySelector('.forum-tab').style.display = 'none';
    document.querySelector('.activity-tab').style.display = 'block';
});
</script>
<script>
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

// function handleFiles(event) {
//     const files = event.target.files || event.dataTransfer.files;
//     if (files.length > 10) {
//         alert("You can upload up to 10 files only.");
//         return;
//     }

//     previewContainer.innerHTML = '';
//     for (let file of files) {
//         if (file.type.startsWith('image/')) {
//             const reader = new FileReader();
//             reader.onload = function(e) {
//                 const img = document.createElement('img');
//                 img.src = e.target.result;
//                 previewContainer.appendChild(img);
//             };
//             reader.readAsDataURL(file);
//         }
//     }
// }


</script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('richTextModal');
    const closeModalBtn = document.querySelector('.close-btn');

    // Event delegation to handle modal open on multiple pages
    document.body.addEventListener('click', function(event) {
        if (event.target && event.target.id === 'openModal') {
            modal.style.display = 'block';
        }
        if (event.target && event.target.classList.contains('close-btn')) {
            modal.style.display = 'none';
        }
    });

    // Close modal when clicking outside of it
    window.addEventListener('click', (event) => {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    });
});
</script>
<style>
.pin-btn {
    border: none;
    background: none;
    cursor: pointer;
}

.fa-thumbtack {
    font-size: 16px;
    margin-right: 5px;
}

/* Style for pinned posts (Green when pinned) */
.pinned {
    color: rgb(62, 191, 15);
}

/* Style for unpinned posts (Gray when unpinned) */
.unpinned {
    color: rgb(130, 130, 130);
}
</style>

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

.like-icon.liked {
    color: blue;
    font-size: 25px;
}

.like-btn:hover .like-icon {
    transform: scale(1.05);
}

.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.5);
}

.modal-content {
    background-color: #fff;
    margin: 5% auto;
    padding: 20px;
    border-radius: 10px;
    width: 80%;
    max-width: 800px;
    position: relative;
}

.close-btn {
    position: absolute;
    top: 10px;
    right: 20px;
    font-size: 20px;
    color: #000;
    cursor: pointer;
}
</style>
<style>
.clickforumreply {
    cursor: pointer;
}
</style>
@endsection