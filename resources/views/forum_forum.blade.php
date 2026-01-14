@extends('layout.layout')
@section('body')
<div class="forum">
    <div id="forum-container">
        @include('layout.forum_heading')
        <p id="hello">Hello!</p>


        <div class="post-container">
            <div class="author-details-container">
                <img src="assets/forum-author-pic.png" alt="Post author" class="author-pic">
                <div class="author-details">
                    <p class="author-name">Anya Petrova</p>
                    <p class="author-mail">anya petrova12@gmail.com</p>
                    <div class="post-timestamp">
                        <img src="assets/calendar-png.png" alt="">
                        <p class="date">25 Oct 2021,</p>
                        <p class="time">08:30 PM</p>
                    </div>
                </div>
            </div>
            <p class="comment-title">Uploaded Details:</p>
            <div class="images-container">
                <img src="assets/forum-car-pic.png" alt="">
                <img src="assets/forum-car-pic2.png" alt="">
            </div>
            <p class="comment-text">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ab accusamus, tempora laborum eveniet cum at perferendis, natus tenetur nam quis dolorum ad mollitia nemo, magnam ex explicabo quaerat necessitatibus facere!</p>
            <div class="like-dislike-container ">
                <div class="like-container  pt-0">
                    <img class=""  src="assets/thumb_up.svg" alt="">
                    <p class="like-count ">210</p>
                </div>
                <div class="dislike-container  p-0 m-0">
                    <img  src="assets/thumb_down.svg" alt="">
                    <p class="dislike-count">120</p>
                </div>
            </div>
        </div>




        <div class="post-container">
            <div class="author-details-container">
                <img src="assets/forum-author-pic.png" alt="Post author" class="author-pic">
                <div class="author-details">
                    <p class="author-name">Anya Petrova</p>
                    <p class="author-mail">anya petrova12@gmail.com</p>
                    <div class="post-timestamp">
                        <img src="assets/calendar-png.png" alt="">
                        <p class="date">25 Oct 2021,</p>
                        <p class="time">08:30 PM</p>
                    </div>
                </div>
            </div>
            <p class="comment-title">Uploaded Details:</p>
            <div class="images-container">
                <img src="assets/forum-car-pic.png" alt="">
                <img src="assets/forum-car-pic2.png" alt="">
            </div>
            <p class="comment-text">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ab accusamus, tempora laborum eveniet cum at perferendis, natus tenetur nam quis dolorum ad mollitia nemo, magnam ex explicabo quaerat necessitatibus facere!</p>
            <div class="like-dislike-container">
                <div class="like-container">
                    <img src="assets/thumb_up.svg" alt="">
                    <p class="like-count">210</p>
                </div>
                <div class="dislike-container">
                    <img src="assets/thumb_down.svg" alt="">
                    <p class="dislike-count">120</p>
                </div>
            </div>
        </div>




        <div class="post-container">
            <div class="author-details-container">
                <img src="assets/forum-author-pic.png" alt="Post author" class="author-pic">
                <div class="author-details">
                    <p class="author-name">Anya Petrova</p>
                    <p class="author-mail">anya petrova12@gmail.com</p>
                    <div class="post-timestamp">
                        <img src="assets/calendar-png.png" alt="">
                        <p class="date">25 Oct 2021,</p>
                        <p class="time">08:30 PM</p>
                    </div>
                </div>
            </div>
            <p class="comment-title">Uploaded Details:</p>
            <div class="images-container">
                <img src="assets/forum-car-pic.png" alt="">
                <img src="assets/forum-car-pic2.png" alt="">
            </div>
            <p class="comment-text">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ab accusamus, tempora laborum eveniet cum at perferendis, natus tenetur nam quis dolorum ad mollitia nemo, magnam ex explicabo quaerat necessitatibus facere!</p>
            <div class="like-dislike-container">
                <div class="like-container">
                    <img src="assets/thumb_up.svg" alt="">
                    <p class="like-count">210</p>
                </div>
                <div class="dislike-container">
                    <img src="assets/thumb_down.svg" alt="">
                    <p class="dislike-count">120</p>
                </div>
            </div>
        </div>




        <p id="post-to-reply">Post to reply</p>
        <div id="post-editor-container">
            <div class="text-editor-container">
                <div id="editing-options">
                    <div id="font-style-options">
                        <img src="assets/bold-button.png" alt="">
                        <img src="assets/italic-button.png" alt="">
                        <img src="assets/underline-button.png" alt="">
                    </div>
                    <div id="alignment-options">
                        <img src="assets/center-align.png" alt="">
                        <img src="assets/right-align.png" alt="">
                        <img src="assets/format-button.png" alt="">
                    </div>
                    <div id="bullet-options">
                        <img src="assets/bullet.png" alt="">
                        <img src="assets/numbering.png" alt="">
                    </div>
                    <div id="media-and-link-options">
                        <img src="assets/add-image.png" alt="">
                        <img src="assets/link.png" alt="">
                    </div>
                </div>
                <hr>
                <div id="text-area">
                    <textarea name="comment" id="" placeholder="I am your reach text editor."></textarea>
                </div>
            </div>
        </div>
        <p id="media-upload">Media Upload</p>
        <div id="media-upload-container">
            <p class="media-instructions">Add your documents here, and you can upload up to 5 files max</p>
            <div id="media-upload-box">
                <img src="assets/upload.png" alt="">
                <p>Drag your file(s) or <label for="media-upload-input" id="media-upload-label">Browse</label></p>
                <p id="media-instructions-inside">Max 10 MB files are allowed</p>
                <input type="file" id="media-upload-input" accept=".jpg, .png, .svg, .zip" multiple>
                <div id="media-preview"></div>
                <p id="file-type-error" style="display: none; color: red;">Unsupported file type! Please upload .jpg, .png, .svg, or .zip only.</p>
            </div>

            <div id="buttons-container">
                <p class="media-instructions">Only support .jpg, .png and .svg and zip files</p>
                <div id="buttons">
                    <button id="cancel">Cancel</button>
                    <button id="submit">Submit</button>
                </div>
            </div>
        </div>
    </div>
</div>
    <!-- <script src="script.js"></script> -->
@endsection
