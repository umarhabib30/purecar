@extends('layout.layout')
<title>Pure Car Ni FAQs | Frequently Asked Questions</title>
<meta name="description" content="Find answers to common questions about buying, selling, and engaging with the Pure Car community.">
@section('body')

<!-- Add this in your blade file -->
<link rel="stylesheet" href="{{ asset('css/faqs_website.css') }}">
<style>
    @media (max-width: 767px) {
        #outer-container {
            margin: 0 !important;
            padding: 0 !important;
        }
        .FAQSPage .faq {
    border-radius: 12px;
    border: 1px solid #a19f9f;
    background-color: #f5f6fa;
    display: flex;
    flex-direction: column;
    padding: 16px;
    justify-content: space-between;
    margin-bottom: 24px;
}
.FAQSPage #sub-container-1 p#header-2 {
    font-size: 16px;
    color: #8D98AF;
    font-weight: 400;
    line-height: 20px;
    margin-bottom: 12px;
    text-align: center!important;
}

        
}
</style>
<section class="FAQSPage mb-0 pb-0">
    <div id="outer-container" class="mb- pb-0">
    <p class="faq-heading d-none d-md-block" style="font-size: 28px !important; font-weight: bold;">FAQ's</p>
        <div id="inner-container">
            <div id="sub-container-1">
                <h2 id="header-1" class="d-none d-md-block">Frequently asked questions</h2>
                <p id="header-2" style="font-size: 16px !important">
                    Quick answers to questions you may have about CarKings. Can't find what you're looking for? Check out our full documentation.
                </p>
            </div>
            <div id="sub-container-2">
                @foreach($faqs as $faq)
                <div class="faq" >
                    <div class="question" data-index="{{ $loop->index }}">
                        <h3>{{ $faq->question }}</h3>
                        <img
                            src="{{ asset('assets/dropdown.png') }}"
                            alt="Toggle"
                            class="toggle-answer">
                    </div>
                    <div class="answer" id="answer-{{ $loop->index }}">
                        <p>{{ $faq->answer }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<script>
    // Add this script for toggling the FAQs
    document.addEventListener('DOMContentLoaded', () => {
        const faqs = document.querySelectorAll('.faq');
        faqs.forEach(faq => {
            faq.querySelector('.question').addEventListener('click', () => {
                const answer = faq.querySelector('.answer');
                const img = faq.querySelector('img');
                if (answer.style.display === 'block') {
                    answer.style.display = 'none';
                    img.style.transform = 'rotate(0deg)';
                } else {
                    answer.style.display = 'block';
                    img.style.transform = 'rotate(180deg)';
                }
            });
        });
    });
</script>

@endsection
