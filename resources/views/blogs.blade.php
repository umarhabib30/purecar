
@extends('layout.layout')
@section('body')

    <div class="blog_container ">
        <h2 class="text-center mb-5">Blogs</h2>
        <div class="row">
            @foreach($blogs as $blog)
                <div class="col-4 col-lg-3">
                    <div class="card border-0">
                        <img src="{{ asset('images/blogs/'. $blog->featured_image) }}" class="card-img-top" alt="...">
                        <div class="card-body ps-0">
                            <h5 class="card-title mb-0">{{ $blog->title }}</h5>
                            <p class="card-text p-0 pe-2 mb-lg-2">{{ strlen($blog->content) > 60 ? substr($blog->content, 0, 90) . '..' : $blog->content }}</p>
                            <a href="{{ route('blog.show', ['blog' => $blog->id]) }}" class="btn mt-0">Read More</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="row g-0 text-center text-sm-start align-items-center mb-4">
            {!! $blogs->links() !!}
        </div><!-- end row -->

    </div>

 @endsection

