
@extends('layout.layout')
@section('body')
<body style="background-color: #F6F6FA;">
<link rel="stylesheet" href="{{asset('css/news_articles.css')}}">
<link rel="stylesheet" href="{{asset('css/blog_page.css')}}">
<meta name="robots" content="noindex, nofollow">

<style>
    /* @media (min-width: 768px) {
        .responsive-margin {
            margin-left: 30px;
            margin-right: 30px;
        }
    }

    @media (max-width: 767px) {
        .responsive-margin {
            margin-left: 0;
            margin-right: 0;
        }
    } */
    @media (max-width: 767px) {
        .responsive-margin {
            margin-left: 0 !important;
            margin-right: 0 !important;
        }
    }

    /* .responsive-margin{
        margin-right: 40px;
        margin-left: 40px;
    } */
</style>
<div class="blog-container" style="padding: 20px 20px 0px 20px;">
<div class="responsive-margin">
    <!-- Header -->
    <header class="blog-header">
        <h1 style="font-size: 30px;"><strong>{{$title}}</strong></h1>

    </header>



    <div class="main-content">

        <!-- Latest Articles -->
        <section class="latest-articles ">
            <div class="articles-grid "style="justify-content: center;">
                @foreach($blogs as $blog)
                    <div class="article-card">
                        <div class="article-card-img-div">
                            <a href="{{ route('blog.show', ['blog' => $blog->slug]) }}">
                                <img src="{{ asset('images/blogs/'. $blog->featured_image) }}" alt="Blog Image">
                            </a>
                        </div>
                        <div class="article-text">
                            <div class="article-text-category-tag">
                                <span class="category" style="color: #1A1A1A; background: #E8E8E8; border-radius: 4px;">{{ $blog->blogCategory ? $blog->blogCategory->name : 'No Category' }}</span>
                            </div>
                            <h5>{{ $blog->title }}</h5>
                            <div class="article-text-bottom">
                                <div class="article-text-bottom-profile">
                                    <div class="article-text-bottom-profile-img">
                                        <img
                                            src="{{ asset('images/authors/'.$blog->nameAuthor->image) }}"
                                            alt="Author Image"
                                            class="img-thumbnail me-3"
                                            style="">
                                    </div>
                                    <div>
                                        <h6>{{ $blog->nameAuthor->name }}</h6>
                                        <p>{{ $blog->created_at->format('F d, Y') }}</p>

                                    </div>
                                </div>
                                <div class="">
                                    <a class="read-more" href="{{ route('blog.show', ['blog' => $blog->slug]) }}">Read More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <!-- <div class="pagination">
                {{ $blogs->links('vendor.pagination.custom-pagination') }}
            </div> -->
            <div class="p-0 pt-4  row align-items-center ps-lg-3">
                    <div class="p-0 col d-flex justify-content-start">
                        <!-- Previous Button -->
                        <a href="{{ $blogs->previousPageUrl() . '&' . http_build_query(request()->except('page')) }}" class="btn white_color  border {{ !$blogs->onFirstPage() ? '' : 'disabled' }}" style="color: #344054">Previous</a>
                        <!-- Next Button -->
                        <a href="{{ $blogs->nextPageUrl() . '&' . http_build_query(request()->except('page')) }}" class="btn white_color  border ms-2 {{ $blogs->hasMorePages() ? '' : 'disabled' }}" style="color: #344054">Next</a>
                    </div>
                    <div class="col d-flex justify-content-end">
                        <span class="pt-2 pb-2 border white_color ps-2 pe-2" style="color: #1A1A1A;">Page {{ $blogs->currentPage() }} of {{ $blogs->lastPage() }}</span>
                    </div>
             </div>
        </section>

    </div>
</div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
    const images = document.querySelectorAll('.clickable-image');
    images.forEach(function (image) {
        image.addEventListener('click', function () {
            const url = this.closest('a').getAttribute('href');
            window.location.href = url; // Redirect to the specified URL
        });
    });
});

</script>

<style>

    .clickable-image {
    cursor: pointer;
    }

</style>


 @endsection

