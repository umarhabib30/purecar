

@extends('layout.layout')
@section('body')

    <div class="news">
    <section class="Article">
        <div class="container py-5 px-3">
            <header class="text-center mb-5 fw-normal">
                <h2 class="display-6 fw-bold text-dark">{{ $title }}</h2>
                <div class="second mx-auto">
                    <p class="text-muted item">
                        Career Blog serves as a knowledge center for current trends in contemporary work culture.
                    </p>
                </div>
            </header>
            <div class="row g-4 equal-height">
                <div class="col-md-8">
                    <div class="card h-100" style="min-height: 500px;"> <!-- Set a minimum height for large screens -->
                        <div class="imageContainer"><img alt="Two cars racing on a road" class="card-img-top m-0"
                                                         src="https://storage.googleapis.com/a1aa/image/QfDc4fsFVluEC0e8lCn5GRmbRX3FYHChrEiZpREKoSTAMPPnA.jpg"
                                                         width="600"/></div>
                        <div class="card-body">
                            <span class="badgee bg-secondary text-dark py-2 px-3">{{ $blog_most_recent_one->title }}</span>
                            <h3 class="card-title mt-3">Guarding Your Virtual Fortress: A Guide to Online Privacy</h3>
                            <p class="card-text text-muted m-0 first-card">David Miller</p>
                            <p class="card-text text-muted second-card">January 27, 2023</p>
                            <div class="text-end">
                                <a class="btn btn-link text-dark" href="#" style="font-size: 0.875rem;">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <h3 class="card-title">Categories</h3>
                            <ul class="list-unstyled category-list">
                                @foreach($blog_categories as $blog_category)
                                    <li><a class="category-link" href="#" style="color: #a8aebf;">{{ $blog_category->name }}</a></li>
                                @endforeach

                            </ul>
                        </div>
                    </div>
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h3 class="card-title mb-3">Tags</h3>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach($blog_tags as $blog_tag)
                                    <span class="tag-link" style="background-color: #e8e8e8;color: #a8aebf;">{{ $blog_tag->name }}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="ArticleInsignts">
    <div class="container py-5">
        <h1 class="display-6 fw-bold text-dark">Discover our latest articles and insights.</h1>
        <div id="articles-container" class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <!-- Article Cards will be inserted here by JavaScript -->
            <div class="col">
                <div class="card article-card h-100" style="border:none !important;">
                    <div class="imageContainer2">
    <img src="https://www.wallpaperflare.com/static/116/409/313/bentley-flying-spur-w12-s-paris-auto-show-2016-luxury-cars-gray-wallpaper.jpg" class="card-img-top" alt="A car driving on a highway">
   </div>
                    <div class="card-body">
                        <span class="badgee bg-secondary py-2 px-3">Assessments</span>
                        <div class="space"><h6 class="card-titles mt-2">Stargazing 101 Journeying into the Cosmos and Beyond</h6></div>
                        <p class="card-text m-0 mt-5 third-card">David Miller</p>
                        <p class="card-text text-muted second-card">January 27, 2023</p>
                        <div class="text-end">
                            <a class="btn btn-link text-dark" href="#" style="font-size: 0.775rem;font-weight:600">Read More</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card article-card h-100" style="border:none !important;">
                    <div class="imageContainer2">
    <img src="https://www.wallpaperflare.com/static/116/409/313/bentley-flying-spur-w12-s-paris-auto-show-2016-luxury-cars-gray-wallpaper.jpg" class="card-img-top" alt="A car driving on a highway">
</div>
                    <div class="card-body">
                        <span class="badgee bg-secondary py-2 px-3">Assessments</span>
                        <div class="space"><h6 class="card-titles mt-2">Stargazing 101 Journeying into the Cosmos and Beyond</h6></div>
                        <p class="card-text m-0 mt-5 third-card">David Miller</p>
                        <p class="card-text text-muted second-card">January 27, 2023</p>
                        <div class="text-end">
                            <a class="btn btn-link text-dark" href="#" style="font-size: 0.775rem;font-weight:600">Read More</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card article-card h-100" style="border:none !important;">
                    <div class="imageContainer2">
    <img src="https://www.wallpaperflare.com/static/116/409/313/bentley-flying-spur-w12-s-paris-auto-show-2016-luxury-cars-gray-wallpaper.jpg" class="card-img-top" alt="A car driving on a highway">
</div>
                    <div class="card-body">
                        <span class="badgee bg-secondary py-2 px-3">Assessments</span>
                        <div class="space"><h6 class="card-titles mt-2">Stargazing 101 Journeying into the Cosmos and Beyond</h6></div>
                        <p class="card-text m-0 mt-5 third-card">David Miller</p>
                        <p class="card-text text-muted second-card">January 27, 2023</p>
                        <div class="text-end">
                            <a class="btn btn-link text-dark" href="#" style="font-size: 0.775rem;font-weight:600">Read More</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card article-card h-100" style="border:none !important;">
                    <div class="imageContainer2">
    <img src="https://www.wallpaperflare.com/static/116/409/313/bentley-flying-spur-w12-s-paris-auto-show-2016-luxury-cars-gray-wallpaper.jpg" class="card-img-top" alt="A car driving on a highway">
</div>
                    <div class="card-body">
                        <span class="badgee bg-secondary py-2 px-3">Assessments</span>
                        <div class="space"><h6 class="card-titles mt-2">Stargazing 101 Journeying into the Cosmos and Beyond</h6></div>
                        <p class="card-text m-0 mt-5 third-card">David Miller</p>
                        <p class="card-text text-muted second-card">January 27, 2023</p>
                        <div class="text-end">
                            <a class="btn btn-link text-dark" href="#" style="font-size: 0.775rem;font-weight:600">Read More</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card article-card h-100" style="border:none !important;">
                    <div class="imageContainer2">
    <img src="https://www.wallpaperflare.com/static/116/409/313/bentley-flying-spur-w12-s-paris-auto-show-2016-luxury-cars-gray-wallpaper.jpg" class="card-img-top" alt="A car driving on a highway">
</div>
                    <div class="card-body">
                        <span class="badgee bg-secondary py-2 px-3">Assessments</span>
                        <div class="space"><h6 class="card-titles mt-2">Stargazing 101 Journeying into the Cosmos and Beyond</h6></div>
                        <p class="card-text m-0 mt-5 third-card">David Miller</p>
                        <p class="card-text text-muted second-card">January 27, 2023</p>
                        <div class="text-end">
                            <a class="btn btn-link text-dark" href="#" style="font-size: 0.775rem;font-weight:600">Read More</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card article-card h-100" style="border:none !important;">
                    <div class="imageContainer2">
    <img src="https://www.wallpaperflare.com/static/116/409/313/bentley-flying-spur-w12-s-paris-auto-show-2016-luxury-cars-gray-wallpaper.jpg" class="card-img-top" alt="A car driving on a highway">
</div>
                    <div class="card-body">
                        <span class="badgee bg-secondary py-2 px-3">Assessments</span>
                        <div class="space"><h6 class="card-titles mt-2">Stargazing 101 Journeying into the Cosmos and Beyond</h6></div>
                        <p class="card-text m-0 mt-5 third-card">David Miller</p>
                        <p class="card-text text-muted second-card">January 27, 2023</p>
                        <div class="text-end">
                            <a class="btn btn-link text-dark" href="#" style="font-size: 0.775rem;font-weight:600">Read More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-between align-items-center mt-4">
            <nav>
                <ul class="pagination mb-0">
                    <ul class="pagination mb-0">
                        <li class="page-item">
                            <a class="page-link custom-page-link1" href="#" id="previous-button">Previous</a>
                        </li>
                        <li class="page-item">
                            <a class="page-link custom-page-link2" href="#" id="next-button">Next</a>
                        </li>
                    </ul>
                </ul>
            </nav>

            <div class="pageno"><span id="page-info" class="text-muted" style="font-size: 0.775rem;font-weight: 700;">Page 1 of 10</span></div>
        </div>
    </div>
</section>
</div>

@endsection
