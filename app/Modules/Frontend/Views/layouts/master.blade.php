<!DOCTYPE html>
<html lang="{{get_current_language()}}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        #homey {
            position: relative;
            height: 100vh;
            overflow: hidden;
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center center;
            transition: background-image 500ms ease-in;
        }

        #homey .bg-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            opacity: 0;
            transition: opacity 500ms ease-in;
        }

        #homey:hover .bg-overlay {
            opacity: 1;
        }

        #homey .container {
            position: relative;
            z-index: 1;
            color: #fff;
            text-align: center;
            padding-top: 20%;
        } 
        .dropdown-menu-up {

            position: absolute!important;
            will-change: transform;
            top: auto!important;
            bottom: 100%!important;
            left: 0!important;
            transform: translateY(-10px); /* Adjust as needed */
        }
        #property-search-tab{
            width: max-content;
        }
        @media(max-width:991px){
            #property-search-tab{
            width: auto;
           }
        }

/* Adjusted CSS */

/* Ensure that the copyright and powered-by sections are spaced evenly */
.copyright-social-container {
    display: flex;
    justify-content: space-between;
}

/* Remove any default margin from the social icons */
.social-footer {
    margin: 0;
    padding: 0 0 18px 0!important; 
    list-style: none;
    display: flex;
}

/* Add space between social icons */
.social-footer li {
    margin-left: 10px;
}

/* On smaller screens, stack items vertically and center-align */
@media (max-width: 767px) {
    .copyright-social-container {
        flex-direction: column;
        align-items: center;
    }
}

.set-right {
    display: flex; /* Use flexbox to align items horizontally */
    align-items: center; /* Align items vertically in the center */
}
.text-left {
    text-align: left;
}

.text-center {
    text-align: center;
}

.text-right {
    text-align: right;
}

.all-items__title{
    font-size: 14px;
}

</style>

    @php
        $favicon = get_favicon();
        if($favicon)
            echo '<link rel="shortcut icon" type="image/png" href="'. $favicon .'"/>';
    @endphp


    @php
        $page_title = seo_page_title();
        if($page_title){
            $title_tag =  $page_title;
        }else{
            $site_name = get_translate(get_option('site_name', 'iBooking'));
            $seo_separator_title = get_seo_title_separator();
            $title_tag = $site_name . ' ' . $seo_separator_title;
        }
    @endphp<title>@php echo $title_tag @endphp @yield('title')</title>

    {!! seo_meta(); !!}
    @php init_header(); @endphp
    @stack('css')
</head>
<body class="body @yield('class_body') {{rtl_class()}}">
@include('Frontend::components.admin-bar')
@include('Frontend::components.top-bar-1')
@include('Frontend::components.header')
<div class="site-content">
    @yield('content')
</div>
@include('Frontend::components.footer')
@php init_footer(); @endphp


<script>
    $(document).ready(function(){
    $('#dropdownGuestButton').on('click', function(){
        console.log('clicked');
        //check if the nearest dropdown menu  has show in but it uses bootstrapthe class
        // if it has it add the dropdown-menu-up
        var dropdownMenu = $(this).next('.dropdown-menu');
        dropdownMenu.toggleClass('show dropdown-menu-up');
    });
});

</script>

<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-33YMKDEV04"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-33YMKDEV04');
</script>

<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-218477623-3"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
4
  gtag('config', 'UA-218477623-3');
</script>


@stack('scripts')



<script>
    document.addEventListener('DOMContentLoaded', function () {
        var baseImageUrl = "storage/2024/01/23/";
        var imageNames = [
            "1-1706015857.jpg",
            "2-1706015897.jpg",
            "3-1706015921.jpg"
        ];

        var currentIndex = 0;
        var interval = 15000; // 15 seconds

        function changeBackgroundImage() {
            var imageUrl = baseImageUrl + imageNames[currentIndex];
            var img = new Image();

            img.onload = function () {
                document.getElementById('homey').style.backgroundImage = 'url("' + imageUrl + '")';
            };

            img.src = imageUrl;
            currentIndex = (currentIndex + 1) % imageNames.length;
        }

        // Preload images
        for (var i = 0; i < imageNames.length; i++) {
            var preloadedImage = new Image();
            preloadedImage.src = baseImageUrl + imageNames[i];
        }

        // Initial background image change
        changeBackgroundImage();

        // Set interval for automatic background image change
        setInterval(changeBackgroundImage, interval);
    });
</script>

<script> 
$(document).ready(function(){
    $('#slick-carousel').slick({
        slidesToShow: 6, // Show 8 slides at a time
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 2000,
        dots: false,
        prevArrow: '<button type="button" class="slick-prev">Prev</button>',
        nextArrow: '<button type="button" class="slick-next">Next</button>',
        responsive: [
            {
                breakpoint: 1200,
                settings: {
                    slidesToShow: 6 // Show 6 slides when viewport width is less than 1200px
                }
            },
            {
                breakpoint: 992,
                settings: {
                    slidesToShow: 4 // Show 4 slides when viewport width is less than 992px
                }
            },
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 3 // Show 3 slides when viewport width is less than 768px
                }
            },
            {
                breakpoint: 576,
                settings: {
                    slidesToShow: 2 // Show 2 slides when viewport width is less than 576px
                }
            }
        ]
    });
});


</script>



</body>
</html>
