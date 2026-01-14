@extends('layout.layout')
<title>{{ $event->title }} | Pure Car Events</title>
<meta name="description" content="{{ Str::limit(strip_tags($event->content), 160, '') }}">
<!-- facebook tags  -->
<meta property="og:title" content="{{ $meta_title }}" />
<meta property="og:description" content="{{ $meta_description }}" />
<meta property="og:image" content="{{ $meta_image }}" />
<meta property="og:url" content="{{ url()->current() }}" />
<meta property="og:type" content="{{ $meta_type }}" />
<!-- Twitter Meta Tags -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $meta_title }}">
<meta name="twitter:description" content="{{ $meta_description }}">
<meta name="twitter:image" content="{{ $meta_image }}">
@section('body')

<section class="container">

    <div>
      
             
              <div class="hero-event-img-div" style="width: 100%; height:  400px;  position: relative; overflow: hidden;  display:flex; align-items:center; justify-content:center;">
                <img src="{{ asset($event->featured_image) }}" 
                     alt="{{ $event->title }}" 
                     style="width: 100%; height: 100%; object-fit: cover; 
                            position: relative; z-index: 2;">
            </div>



            <div class="event-content">
                <h1 class="fw-bold" style="font-size: 30px; margin-top:10px;">{{ $event->title }}</h1>
                {!! nl2br($event->content) !!}
            </div>

           <div class="event-container-box">
            @foreach($event->gallery_images as $image)
                <div class="event-container-box-img media-thumbnail">
                    <div style="width: 100%; height: 200px; border-radius: 8px; position: relative; overflow: hidden; object-fit:cover;">
                 
                        <img src="{{ asset($image) }}" 
                             alt="{{ $event->title }}" 
                             style="width: 100%; height: 100%;
                                    position: relative; z-index: 2; object-fit:cover;">
                    </div>
                </div>
            @endforeach
        </div>
        

    </div>




</section>

<div id="fullscreenViewer" class="fullscreen-viewer">
    <span class="close-btnmodel" onclick="closeFullScreen()">&times;</span>
    <button class="prev-btn" onclick="changeImage(-1)">&#10094;</button>
    <img id="fullscreenImage" class="fullscreen-image">
    <button class="next-btn" onclick="changeImage(1)">&#10095;</button>
</div>

<style>
   
    .fullscreen-viewer {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.9);
        z-index: 1000;
        justify-content: center;
        align-items: center;
        flex-direction: column;
    }

    .fullscreen-image {
        max-width: 90%;
        max-height: 80vh;

    }

    .close-btnmodel {
        position: absolute;
        top: 20px;
        right: 30px;
        font-size: 30px;
        color: white;
        cursor: pointer;
    }

    .prev-btn, .next-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        font-size: 30px;
        color: white;
        background: none;
        border: none;
        cursor: pointer;
    }

    .prev-btn { left: 20px; }
    .next-btn { right: 20px; }

 
    @media (max-width: 600px) {
        .fullscreen-image {
            max-width: 95%;
            max-height: 70vh;
        }
        .prev-btn, .next-btn { font-size: 25px; }
        .close-btnmodel { font-size: 25px; }
    }
</style>
<script>
    document.getElementById("fullscreenViewer").addEventListener("click", function (event) {
    if (event.target === this) {
        closeFullScreen();
    }
});

 let images = [];
let currentIndex = 0;


document.addEventListener("DOMContentLoaded", function () {
    images = Array.from(document.querySelectorAll('.media-thumbnail'));

  
    images.forEach(img => {
        img.addEventListener("click", function () {
            openFullScreen(img);
        });
        img.addEventListener("touchstart", function (e) {
        this.touchStartX = e.touches[0].clientX;
        this.touchStartY = e.touches[0].clientY;
        }, { passive: true });

        img.addEventListener("touchend", function (e) {
            let deltaX = Math.abs(e.changedTouches[0].clientX - this.touchStartX);
            let deltaY = Math.abs(e.changedTouches[0].clientY - this.touchStartY);

            if (deltaX < 10 && deltaY < 10) {
                openFullScreen(img);
            }
        });

    });
});

function openFullScreen(img) {
    const viewer = document.getElementById('fullscreenViewer');
    const fullscreenImg = document.getElementById('fullscreenImage');

    const clickedImage = img.querySelector("img"); 

    if (clickedImage) {
        currentIndex = images.indexOf(img);
        fullscreenImg.src = clickedImage.src; 
        viewer.style.display = "flex";
    }
}



let modalOpen = false;
let historyEntryAdded = false;
let handlingPopState = false;

function closeFullScreen(fromPopState = false) {
    const viewer = document.getElementById('fullscreenViewer');
    viewer.style.display = "none";
    
    // Signal that we're manually closing and will handle history
    if (!fromPopState) {
        handlingPopState = true;
        if (historyEntryAdded) {
            history.back();
        }
        setTimeout(() => { 
            handlingPopState = false;
            modalOpen = false;
            historyEntryAdded = false;
        }, 100);
    }
}

function changeImage(direction) {
    currentIndex += direction;

    if (currentIndex < 0) {
        currentIndex = images.length - 1;
    } else if (currentIndex >= images.length) {
        currentIndex = 0;
    }

    const nextImage = images[currentIndex].querySelector("img"); 
    if (nextImage) {
        document.getElementById('fullscreenImage').src = nextImage.src;
    }
}

document.addEventListener('keydown', function(event) {
    const viewer = document.getElementById('fullscreenViewer');
    if (viewer.style.display === 'flex') { 
        if (event.key === 'ArrowLeft') {
            changeImage(-1); 
        } else if (event.key === 'ArrowRight') {
            changeImage(1); 
        } else if (event.key === 'Escape') {
            closeFullScreen(); 
        }
    }
});



</script>


<style>
    
    @media screen and (max-width: 767px) {
        .event-container-box-img{
            width: 100%;
             
            height: 200px; 
            border-radius: 8px; 
            object-fit: cover;
        }
        .hero-event-img{
            width: 100%; 
            height: 300px; 
            object-fit: cover;
        }
        .hero-event-img-div{
      
            width: 100%; 
            height: 300px; 
            object-fit: cover; 
        }
        .event-container-box{ 
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 5px !important;
            padding:20px;
            border-radius: 8px; 
            overflow: hidden; 
            cursor: pointer; 
            text-align: center;
        }
        .event-content{
            padding: 20px;
        }
        .event-container-box-img img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }
        .event-container-box-img div {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .event-container-box-img img {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: auto;
            height: 100%;
            object-fit: cover;
        }
        .event-container-box {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 20px;
            padding: 20px;
            place-items: center; 
        } 
    }
    @media screen and (min-width: 768px) {
        .event-container-box-img{
            width: 100%;
            height: 200px;
            border-radius: 8px;
            object-fit: cover;
        }
        .hero-event-img{
            width: 100%; 
            height: 400px; 
            object-fit: cover;
        }
        .hero-event-img-div{
            width: 100%; 
            height: 400px; 
            object-fit: cover; 
            border-radius: 8px;
        }
        .event-container-box{
            display: grid;
            grid-template-columns: repeat(3,1fr);
            gap: 10px;
            border-radius: 8px;
            overflow: hidden;
            cursor: pointer;
            text-align: center;
        }
        .container{
                    padding-top: 20px;
                }
    }  
</style>
<script>
   // Global variables for history management
let modalOpen = false;
let historyEntryAdded = false;
let handlingPopState = false;

document.getElementById("fullscreenViewer").addEventListener("click", function (event) {
    if (event.target === this) {
        closeFullScreen();
    }
});

let images = [];
let currentIndex = 0;

document.addEventListener("DOMContentLoaded", function () {
    images = Array.from(document.querySelectorAll('.media-thumbnail'));

    images.forEach(img => {
        img.addEventListener("click", function () {
            openFullScreen(img);
        });
        img.addEventListener("touchstart", function (e) {
            this.touchStartX = e.touches[0].clientX;
            this.touchStartY = e.touches[0].clientY;
        }, { passive: true });

        img.addEventListener("touchend", function (e) {
            let deltaX = Math.abs(e.changedTouches[0].clientX - this.touchStartX);
            let deltaY = Math.abs(e.changedTouches[0].clientY - this.touchStartY);

            if (deltaX < 10 && deltaY < 10) {
                openFullScreen(img);
            }
        });
    });
});

function openFullScreen(img) {
    const viewer = document.getElementById('fullscreenViewer');
    const fullscreenImg = document.getElementById('fullscreenImage');

    const clickedImage = img.querySelector("img"); 

    if (clickedImage) {
        currentIndex = images.indexOf(img);
        fullscreenImg.src = clickedImage.src; 
        viewer.style.display = "flex";
    }
}

function closeFullScreen(fromPopState = false) {
    const viewer = document.getElementById('fullscreenViewer');
    viewer.style.display = "none";
    
    // Only manipulate history if we're not already handling a popstate event
    if (!fromPopState) {
        handlingPopState = true;
        modalOpen = false;
        if (historyEntryAdded) {
            history.back();
            historyEntryAdded = false;
        }
        setTimeout(() => { 
            handlingPopState = false;
        }, 100);
    } else {
        modalOpen = false;
        historyEntryAdded = false;
    }
}

function changeImage(direction) {
    currentIndex += direction;

    if (currentIndex < 0) {
        currentIndex = images.length - 1;
    } else if (currentIndex >= images.length) {
        currentIndex = 0;
    }

    const nextImage = images[currentIndex].querySelector("img"); 
    if (nextImage) {
        document.getElementById('fullscreenImage').src = nextImage.src;
    }
}

document.addEventListener('keydown', function(event) {
    const viewer = document.getElementById('fullscreenViewer');
    if (viewer.style.display === 'flex') { 
        if (event.key === 'ArrowLeft') {
            changeImage(-1); 
        } else if (event.key === 'ArrowRight') {
            changeImage(1); 
        } else if (event.key === 'Escape') {
            closeFullScreen(); 
        }
    }
});

// Container class handler
document.addEventListener("DOMContentLoaded", function () {
    function handleContainerClass() {
        let section = document.querySelector("section.container");
        if (section) {
            if (window.innerWidth < 768) {
                section.classList.remove("container");
            } else {
                section.classList.add("container");
            }
        }
    }
    handleContainerClass();
    window.addEventListener("resize", handleContainerClass);
});

// History management for modals
(function() {
    const modalSelectors = [
        '#fullscreenViewer',
    ];

    function isAnyModalOpen() {
        return modalSelectors.some(selector => {
            const modal = document.querySelector(selector);
            return modal && (modal.style.display === 'flex' || modal.style.display === 'block');
        });
    }

    function handleModalOpen() {
        if (!modalOpen && isAnyModalOpen()) {
            modalOpen = true;
            if (!historyEntryAdded) {
                history.pushState({ modalOpen: true }, '', window.location.href);
                historyEntryAdded = true;
            }
        }
    }

    function handleModalClose() {
        if (modalOpen && !isAnyModalOpen() && !handlingPopState) {
            modalOpen = false;
            historyEntryAdded = false;
        }
    }

    const observer = new MutationObserver(mutations => {
        mutations.forEach(mutation => {
            if (mutation.attributeName === 'style' && 
                modalSelectors.some(selector => mutation.target.matches(selector))) {
                if (isAnyModalOpen()) {
                    handleModalOpen();
                } else {
                    handleModalClose();
                }
            }
        });
    });

    modalSelectors.forEach(selector => {
        const elements = document.querySelectorAll(selector);
        elements.forEach(el => {
            observer.observe(el, { attributes: true });
        });
    });

    window.addEventListener('popstate', function(event) {
        handlingPopState = true;
        
        if (isAnyModalOpen()) {
            modalSelectors.forEach(selector => {
                const modal = document.querySelector(selector);
                if (modal && (modal.style.display === 'flex' || modal.style.display === 'block')) {
                    if (selector === '#fullscreenViewer' && window.closeFullScreen) {
                        window.closeFullScreen(true);
                    } else {
                        modal.style.display = 'none';
                    }
                }
            });
            
            modalOpen = false;
            historyEntryAdded = false;
        }
        
        setTimeout(() => { handlingPopState = false; }, 100);
    });
})();
</script>

@endsection