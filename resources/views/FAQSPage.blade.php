
@extends('layout.dashboard')
@section('body')

    <section class="FAQSPage">
    <div id="outer-container-faq">
    <p class="faq-heading" style="font-size: 28px !important; font-weight: bold;">FAQ's</p>
    <div id="inner-container">
            <div id="sub-container-1">
                <h2 id="header-1" class="faq-heading">Frequently asked questions</h2>
                <p id="header-2" class="text-center text-md-start">Here, you’ll find answers to the most common questions about our services, policies, and more. If you don’t see what you’re looking for, feel free to reach out—we’re always here to help.</p>
            </div>
            <div id="sub-container-2">
                @foreach($faqs as $faq)
                    <div class="faq">
                        <div class="question" style="display: flex; align-items: center; justify-content: space-between;">
                            <h3>{{ $faq->question }}</h3>
                            <img
                                    src="assets/dropdown.png"
                                    alt=""
                                    class="toggle-answer"
                                    data-index="{{ $loop->index }}"
                                    style="cursor: pointer;">
                        </div>
                        <div class="answer" id="answer-{{ $loop->index }}" style="display: none;">
                            <p>{{ $faq->answer }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

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
