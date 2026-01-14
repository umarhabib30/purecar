@extends('layout.layout')
@section('body')
    <section class="ForumDetails">
    <div class="container forum-container my-4">
        @include('layout.forum_heading')
        <div class="forum-content">
            <h2 class="fw-bold mb-4">CarKing forum</h2>
            <!------------------------------------Car Hub Links----------------------------->
            <div class="forum-category d-flex justify-content-between align-items-center mb-3">
                <span>Car Hub</span>
                <span>Last post</span>
            </div>
            <div class="forum-items">
                <!-----Item 1---->
                <div class="forum-item d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <img src="{{asset('assets/msg.svg')}}" class="icon" alt="comment icon" width="20" height="20">
                        <div>
                            <a class="fw-bold mb-0 text-dark" href="{{route('forum_page')}}" style="text-decoration: none">General car chat</a>
                            <p class="text-muted mb-0 small">0 Topic . 0 Post</p>
                        </div>
                    </div>
                    <span class="text-muted ms-3">No topic yet!</span>
                </div>
                <!-----Item 2---->
                <div class="forum-item d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <img src="{{asset('assets/msg.svg')}}" class="icon" alt="comment icon" width="20" height="20">
                        <div>
                            <p class="fw-bold mb-0">General car chat</p>
                            <p class="text-muted mb-0 small">0 Topic . 0 Post</p>
                        </div>
                    </div>
                    <span class="text-muted ms-3">No topic yet!</span>
                </div>
                <!-----Item 3---->
                <div class="forum-item d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <img src="{{asset('assets/msg.svg')}}" class="icon" alt="comment icon" width="20" height="20">
                        <div>
                            <p class="fw-bold mb-0">General car chat</p>
                            <p class="text-muted mb-0 small">0 Topic . 0 Post</p>
                        </div>
                    </div>
                    <span class="text-muted ms-3">No topic yet!</span>
                </div>
                <!-----Item 4---->
                <div class="forum-item d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <img src="{{asset('assets/msg.svg')}}" class="icon" alt="comment icon" width="20" height="20">
                        <div>
                            <p class="fw-bold mb-0">General car chat</p>
                            <p class="text-muted mb-0 small">0 Topic . 0 Post</p>
                        </div>
                    </div>
                    <span class="text-muted ms-3">No topic yet!</span>
                </div>
                <!-----Item 5---->
                <div class="forum-item d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <img src="{{asset('assets/msg.svg')}}" class="icon" alt="comment icon" width="20" height="20">
                        <div>
                            <p class="fw-bold mb-0">General car chat</p>
                            <p class="text-muted mb-0 small">0 Topic . 0 Post</p>
                        </div>
                    </div>
                    <span class="text-muted ms-3">No topic yet!</span>
                </div>
                <!-----Item 6---->
                <div class="forum-item d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <img src="{{asset('assets/msg.svg')}}" class="icon" alt="comment icon" width="20" height="20">
                        <div>
                            <p class="fw-bold mb-0">General car chat</p>
                            <p class="text-muted mb-0 small">0 Topic . 0 Post</p>
                        </div>
                    </div>
                    <span class="text-muted ms-3">No topic yet!</span>
                </div>
                <!-----Item 7---->
                <div class="forum-item d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <img src="{{asset('assets/msg.svg')}}" class="icon" alt="comment icon" width="20" height="20">
                        <div>
                            <p class="fw-bold mb-0">General car chat</p>
                            <p class="text-muted mb-0 small">0 Topic . 0 Post</p>
                        </div>
                    </div>
                    <span class="text-muted ms-3">No topic yet!</span>
                </div>
            </div>

            <!------------------------------------Classic Car section----------------------------->
            <div class="forum-category d-flex justify-content-between align-items-center mt-4">
                <span>Classic Cars</span>
                <span>Last post</span>
            </div>
            <div class="forum-items">
                <!-----Item 1---->
                <div class="forum-item d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <img src="{{asset('assets/msg.svg')}}" class="icon" alt="comment icon" width="20" height="20">
                        <div>
                            <p class="fw-bold mb-0">General car chat</p>
                            <p class="text-muted mb-0 small">0 Topic . 0 Post</p>
                        </div>
                    </div>
                    <span class="text-muted ms-3">No topic yet!</span>
                </div>
                <!-----Item 2---->
                <div class="forum-item d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <img src="{{asset('assets/msg.svg')}}" class="icon" alt="comment icon" width="20" height="20">
                        <div>
                            <p class="fw-bold mb-0">General car chat</p>
                            <p class="text-muted mb-0 small">0 Topic . 0 Post</p>
                        </div>
                    </div>
                    <span class="text-muted ms-3">No topic yet!</span>
                </div>
                <!-----Item 3---->
                <div class="forum-item d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <img src="{{asset('assets/msg.svg')}}" class="icon" alt="comment icon" width="20" height="20">
                        <div>
                            <p class="fw-bold mb-0">General car chat</p>
                            <p class="text-muted mb-0 small">0 Topic . 0 Post</p>
                        </div>
                    </div>
                    <span class="text-muted ms-3">No topic yet!</span>
                </div>
                <!-----Item 4---->
                <div class="forum-item d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <img src="{{asset('assets/msg.svg')}}" class="icon" alt="comment icon" width="20" height="20">
                        <div>
                            <p class="fw-bold mb-0">General car chat</p>
                            <p class="text-muted mb-0 small">0 Topic . 0 Post</p>
                        </div>
                    </div>
                    <span class="text-muted ms-3">No topic yet!</span>
                </div>
                <!-----Item 5---->
                <div class="forum-item d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <img src="{{asset('assets/msg.svg')}}" class="icon" alt="comment icon" width="20" height="20">
                        <div>
                            <p class="fw-bold mb-0">General car chat</p>
                            <p class="text-muted mb-0 small">0 Topic . 0 Post</p>
                        </div>
                    </div>
                    <span class="text-muted ms-3">No topic yet!</span>
                </div>
                <!-----Item 6---->
                <div class="forum-item d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <img src="{{asset('assets/msg.svg')}}" class="icon" alt="comment icon" width="20" height="20">
                        <div>
                            <p class="fw-bold mb-0">General car chat</p>
                            <p class="text-muted mb-0 small">0 Topic . 0 Post</p>
                        </div>
                    </div>
                    <span class="text-muted ms-3">No topic yet!</span>
                </div>
                <!-----Item 7---->
                <div class="forum-item d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <img src="{{asset('assets/msg.svg')}}" class="icon" alt="comment icon" width="20" height="20">
                        <div>
                            <p class="fw-bold mb-0">General car chat</p>
                            <p class="text-muted mb-0 small">0 Topic . 0 Post</p>
                        </div>
                    </div>
                    <span class="text-muted ms-3">No topic yet!</span>
                </div>
            </div>
           <!------------------------------------Deals----------------------------->
            <div class="forum-category d-flex justify-content-between align-items-center mt-4">
                <span>Deals</span>
                <span>Last post</span>
            </div>
            <div class="forum-items">
                <!-----Item 1---->
                <div class="forum-item d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <img src="{{asset('assets/msg.svg')}}" class="icon" alt="comment icon" width="20" height="20">
                        <div>
                            <p class="fw-bold mb-0">General car chat</p>
                            <p class="text-muted mb-0 small">0 Topic . 0 Post</p>
                        </div>
                    </div>
                    <span class="text-muted ms-3">No topic yet!</span>
                </div>
                <!-----Item 2---->
                <div class="forum-item d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <img src="{{asset('assets/msg.svg')}}" class="icon" alt="comment icon" width="20" height="20">
                        <div>
                            <p class="fw-bold mb-0">General car chat</p>
                            <p class="text-muted mb-0 small">0 Topic . 0 Post</p>
                        </div>
                    </div>
                    <span class="text-muted ms-3">No topic yet!</span>
                </div>
                <!-----Item 3---->
                <div class="forum-item d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <img src="{{asset('assets/msg.svg')}}" class="icon" alt="comment icon" width="20" height="20">
                        <div>
                            <p class="fw-bold mb-0">General car chat</p>
                            <p class="text-muted mb-0 small">0 Topic . 0 Post</p>
                        </div>
                    </div>
                    <span class="text-muted ms-3">No topic yet!</span>
                </div>
                <!-----Item 4---->
                <div class="forum-item d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <img src="{{asset('assets/msg.svg')}}" class="icon" alt="comment icon" width="20" height="20">
                        <div>
                            <p class="fw-bold mb-0">General car chat</p>
                            <p class="text-muted mb-0 small">0 Topic . 0 Post</p>
                        </div>
                    </div>
                    <span class="text-muted ms-3">No topic yet!</span>
                </div>
                <!-----Item 5---->
                <div class="forum-item d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <img src="{{asset('assets/msg.svg')}}" class="icon" alt="comment icon" width="20" height="20">
                        <div>
                            <p class="fw-bold mb-0">General car chat</p>
                            <p class="text-muted mb-0 small">0 Topic . 0 Post</p>
                        </div>
                    </div>
                    <span class="text-muted ms-3">No topic yet!</span>
                </div>
                <!-----Item 6---->
                <div class="forum-item d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <img src="{{asset('assets/msg.svg')}}" class="icon" alt="comment icon" width="20" height="20">
                        <div>
                            <p class="fw-bold mb-0">General car chat</p>
                            <p class="text-muted mb-0 small">0 Topic . 0 Post</p>
                        </div>
                    </div>
                    <span class="text-muted ms-3">No topic yet!</span>
                </div>
                <!-----Item 7---->
                <div class="forum-item d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <img src="{{asset('assets/msg.svg')}}" class="icon" alt="comment icon" width="20" height="20">
                        <div>
                            <p class="fw-bold mb-0">General car chat</p>
                            <p class="text-muted mb-0 small">0 Topic . 0 Post</p>
                        </div>
                    </div>
                    <span class="text-muted ms-3">No topic yet!</span>
                </div>
            </div>
             <!------------------------------------MotorBikes----------------------------->
            <div class="forum-category d-flex justify-content-between align-items-center mt-4">
                <span>MotorBikes</span>
                <span>Last post</span>
            </div>
            <div class="forum-items">
                <!-----Item 1---->
                <div class="forum-item d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <img src="{{asset('assets/msg.svg')}}" class="icon" alt="comment icon" width="20" height="20">
                        <div>
                            <p class="fw-bold mb-0">General car chat</p>
                            <p class="text-muted mb-0 small">0 Topic . 0 Post</p>
                        </div>
                    </div>
                    <span class="text-muted ms-3">No topic yet!</span>
                </div>
                <!-----Item 2---->
                <div class="forum-item d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <img src="{{asset('assets/msg.svg')}}" class="icon" alt="comment icon" width="20" height="20">
                        <div>
                            <p class="fw-bold mb-0">General car chat</p>
                            <p class="text-muted mb-0 small">0 Topic . 0 Post</p>
                        </div>
                    </div>
                    <span class="text-muted ms-3">No topic yet!</span>
                </div>
                <!-----Item 3---->
                <div class="forum-item d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <img src="{{asset('assets/msg.svg')}}" class="icon" alt="comment icon" width="20" height="20">
                        <div>
                            <p class="fw-bold mb-0">General car chat</p>
                            <p class="text-muted mb-0 small">0 Topic . 0 Post</p>
                        </div>
                    </div>
                    <span class="text-muted ms-3">No topic yet!</span>
                </div>
                <!-----Item 4---->
                <div class="forum-item d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <img src="{{asset('assets/msg.svg')}}" class="icon" alt="comment icon" width="20" height="20">
                        <div>
                            <p class="fw-bold mb-0">General car chat</p>
                            <p class="text-muted mb-0 small">0 Topic . 0 Post</p>
                        </div>
                    </div>
                    <span class="text-muted ms-3">No topic yet!</span>
                </div>
                <!-----Item 5---->
                <div class="forum-item d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <img src="{{asset('assets/msg.svg')}}" class="icon" alt="comment icon" width="20" height="20">
                        <div>
                            <p class="fw-bold mb-0">General car chat</p>
                            <p class="text-muted mb-0 small">0 Topic . 0 Post</p>
                        </div>
                    </div>
                    <span class="text-muted ms-3">No topic yet!</span>
                </div>
                <!-----Item 6---->
                <div class="forum-item d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <img src="{{asset('assets/msg.svg')}}" class="icon" alt="comment icon" width="20" height="20">
                        <div>
                            <p class="fw-bold mb-0">General car chat</p>
                            <p class="text-muted mb-0 small">0 Topic . 0 Post</p>
                        </div>
                    </div>
                    <span class="text-muted ms-3">No topic yet!</span>
                </div>
                <!-----Item 7---->
                <div class="forum-item d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <img src="{{asset('assets/msg.svg')}}" class="icon" alt="comment icon" width="20" height="20">
                        <div>
                            <p class="fw-bold mb-0">General car chat</p>
                            <p class="text-muted mb-0 small">0 Topic . 0 Post</p>
                        </div>
                    </div>
                    <span class="text-muted ms-3">No topic yet!</span>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
