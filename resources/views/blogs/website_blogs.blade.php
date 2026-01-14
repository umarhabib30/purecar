@extends('layout.layout')
<title>Pure Car Blog | Insights and News on Automobiles</title>
<meta name="description" content="Read articles on car reviews, industry news, and automotive tips. Stay informed and inspired by our latest blog posts.">
 <meta name="robots" content="noindex, nofollow">

@section('body')
<body style="background-color: #F6F6FA;">
<link rel="stylesheet" href="{{asset('css/news_articles.css')}}">
<link rel="stylesheet" href="{{asset('css/blog_page.css')}}">
<style>
    @media (max-width: 767px) {
        .responsive-margin {
            margin-left: 0 !important;
            margin-right: 0 !important;
        }
        .responsive_category{
            max-height: 150px !important; 
            overflow-y: auto !important;
        }
        .mobilerespoonsive{
            margin-bottom: 20px;
        }
        .pagination{
            margin-top: -250px !important;
             padding-top: -250px !important;
        }
    }

   
</style>
<div class="blog-container" style="padding: 20px 20px 0px 20px;">
 
<div class="responsive-margin">
    <!-- Header -->
    <header class="blog-header">
        <h1 style="font-size: 30px;"><strong>Top Car News, Tips & Reviews</strong></h1>
        <div>
            <p>Your ultimate source for the latest updates, expert advice, and in-depth reviews on automobile trends.</p>
        </div>
    </header>
    @if ($blog_most_recent_one)
                
               
    <!-- Featured Blog -->
    <section class="featured-blog">
        <div class="featured-content">
            <a href="{{ route('blog.show', ['blog' => $blog_most_recent_one->slug]) }}">
                <img src="{{ asset('images/blogs/'. $blog_most_recent_one->featured_image) }}" alt="Featured Blog Image" style="width: 100%;">
            </a>
            <div class="featured-text">
                <span class="category" style="color: #1A1A1A; background: #E8E8E8; border-radius: 4px;">{{ $blog_most_recent_one->blogCategory ? $blog_most_recent_one->blogCategory->name : 'No Category' }}</span>
                <h3>{{ $blog_most_recent_one->title }}</h3>
                <div class="featured-text-bottom">
                    <div class="featured-text-bottom-profile">
                        <div class="featured-text-bottom-profile-img">
                            <img src="{{ asset('images/authors/'.$blog_most_recent_one->nameAuthor->image) }}"
                                alt="Author Image"
                                class="img-thumbnail"
                                style="">
                        </div>
                        <div class="featured-text-bottom-profile-text">
                            <h6>{{ $blog_most_recent_one->nameAuthor->name }}</h6>
                            <p>{{ $blog_most_recent_one->created_at->format('F d, Y') }}</p>
                        </div>
                    </div>
                    <a class="pt-2 pb-2 text-black read-more" 
   href="{{ route('blog.show', ['blog' => $blog_most_recent_one->slug]) }}" 
   style="display: inline-block; position: relative; padding-bottom: 4px;">
   Read More
   <span style="display: block; width: 80px; height: 1px; background-color: black; margin: 2px auto 0;"></span>
</a>

                </div>
            </div>
        </div>
        <div class="categories-tags">
            <div class="categories">
                <h3>Categories</h3>
                <div class="responsive_category" style="max-height: 250px; overflow-y: auto;">
                    <ul style="padding: 0; margin: 0; color: #E8E8E8">
                        @foreach($blog_categories as $blog_category)
                            <li style="margin-left: 15px;"><a href="{{ route('blog.categoryWise', ['category' => $blog_category->id]) }}" style="font-size: 18px; color: #A8AEBF;">{{ $blog_category->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="tags">
                <h3>Tags</h3>
                <div class="responsive_category" style="max-height: 250px; overflow-y: auto;">

               
                <ul class="p-2">
                    @foreach($blog_tags as $blog_tag)
                        <li><a href="{{ route('blog.tagWise', ['tag' => $blog_tag->name]) }}" style="font-size: 18px; color: black; background: #E8E8E8">{{ $blog_tag->name }}</a></li>
                    @endforeach
                </ul>
                </div>
            </div>
         



        </div>
    </section>
    
    <!-- Sidebar and Latest Articles -->
    <div class="main-content">

        <!-- Latest Articles -->
        <section class="latest-articles ">
            <h1><strong>Discover our latest articles and insights.</strong></h1>
         
   <div class="container-fluid"> 
    <div class="row">
        @foreach($blogs as $blog)
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4 d-flex">
                <div class="article-card mobilerespoonsive w-100 d-flex flex-column">
                    <div class="article-card-img-div">
                        <a href="{{ route('blog.show', ['blog' => $blog->slug]) }}">
                            <img src="{{ asset('images/blogs/'. $blog->featured_image) }}" alt="Blog Image" class="img-fluid w-100 article-image">
                        </a>
                    </div>
                    <div class="article-text d-flex flex-column flex-grow-1">
                        <div class="article-text-category-tag mb-2">
                                                           <span class="category" style="color: #1A1A1A; background: #E8E8E8; border-radius: 4px;">{{ $blog->blogCategory ? $blog->blogCategory->name : 'No Category' }}</span>

                        </div>
                        <h5 class="article-title">{{ $blog->title }}</h5>
                        <div class="article-text-bottom mt-auto">
                            <div class="article-text-bottom-profile d-flex align-items-center">
                                <div class="article-text-bottom-profile-img me-2">
                                    <img src="{{ asset('images/authors/'.$blog->nameAuthor->image) }}" alt="Author Image" class="img-thumbnail author-image">
                                </div>
                                <div>
                                    <h6 class="mb-0">{{ $blog->nameAuthor->name }}</h6>
                                    <p class="mb-0" style="font-size: 0.85rem;">{{ $blog->created_at->format('F d, Y') }}</p>
                                </div>
                            </div>
                            <div class="mt-2 text-end">
                                <a class="read-more" href="{{ route('blog.show', ['blog' => $blog->slug]) }}">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

            <!-- <div class="pagination">
                {{ $blogs->links('vendor.pagination.custom-pagination') }}
            </div> -->
           <div style="display: flex; justify-content: center; margin: 20px 0; margin-bottom:0px; padding-bottom: 0px;">
                <div class="pagination" style="display: flex; align-items: center; gap: 15px; font-family: Arial, sans-serif; flex-wrap: wrap; justify-content: center;">
                    
                    <!-- Pagination Buttons -->
                    <div class="pagination-buttons" style="display: flex; gap: 10px;">
                        @if($blogs->onFirstPage())
                            <span style="padding: 8px 16px; color: #999; cursor: not-allowed;">Previous</span>
                        @else
                            <a href="{{ $blogs->appends(request()->query())->previousPageUrl() }}" 
                            style="padding: 8px 16px; background-color: rgb(8, 8, 8); color: white; text-decoration: none; border-radius: 4px; transition: background-color 0.3s;">
                                Previous
                            </a>
                        @endif

                        @if($blogs->hasMorePages())
                            <a href="{{ $blogs->appends(request()->query())->nextPageUrl() }}" 
                            style="padding: 8px 16px; background-color: rgb(8, 8, 8); color: white; text-decoration: none; border-radius: 4px; transition: background-color 0.3s;">
                                Next
                            </a>
                        @else
                            <span style="padding: 8px 16px; color: #999; cursor: not-allowed;">Next</span>
                        @endif
                    </div>

                    <!-- Pagination Info -->
                    <div class="pagination-info" style="font-size: 14px; color: #333;">
                        <span>
                            {{ $blogs->currentPage() }} of {{ $blogs->lastPage() }}
                        </span>
                    </div>
                </div>
            </div>

             
        </section>

    </div>
    @else
                <p>No  blogs available.</p>
    @endif
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
