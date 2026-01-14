@extends('layout.superAdminDashboard')

@section('body')
    <section id="forum-topic-details">
        <div class="forum-topic">
            <h3>Topic - {{ $forum_topic->title }}</h3>

            <h4 class="text-center mt-4"><strong>Categories</strong> </h4>
            <div class="category-cards-container">
                @foreach($forum_topic->forumTopicCategories as $category)
                    <a href="{{ route('forum-category.posts', ['category' => $category->id]) }}">
                        <div class="category-card">
                            <p>{{ $category->category }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
@endsection

<style>
    .category-cards-container {
        display: flex;
        margin-top: 1rem;
        flex-wrap: wrap;
        gap: 20px;
    }

    .category-card {
        display: inline-flex;
        background-color: #fff;
        padding: 15px 25px;
        margin: 10px;
        border-radius: 5px;
        border: 2px solid #ddd;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        text-align: center;
        transition: all 0.3s ease;
        width:200px;
        height: 100px;
        overflow: hidden;
        justify-content: center;
        align-items: center;
        text-transform: uppercase;
    }

    .category-card:hover {
        background-color: #f0f0f0;
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.15);
    }

    .category-card p {
        margin: 0;
        font-size: 16px;
        font-weight: 500;
        color: #333;
    }

   
    @media (max-width: 768px) {
        .category-card {
            width: calc(50% - 20px);
        }
    }

    @media (max-width: 480px) {
        .category-card {
            width: 100%;
        }
    }
</style>
