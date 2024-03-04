<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!--  UNICONS  -->
    <link
    rel="stylesheet"
    href="https://unicons.iconscout.com/release/v4.0.0/css/line.css"
    />

    <!--  SWIPER CSS  -->
    <link rel="stylesheet" href="{{asset('assets/css/swiper-bundle.min.css')}}" />
    <!--  CSS  -->
    <link rel="stylesheet" href="{{asset('assets/css/styles.css')}}" />

    <title>@yield('title')</title>
</head>
<body>
        <!--  HEADER  -->
        @include ('partials.header')


        <!--  MAIN   -->
        <main class="main">
        <section class="home section" id="home">
            @yield('content')
        </section>
        </main>
        <!-- MAIN FIN -->

        <!-- FOOTER -->
        @include('partials.footer')
        <!-- FOOTER FIN -->

        <!-- SCROLL TOP  -->
        <a href="#" class="scrollup" id="scroll-up">
        <i class="uil uil-arrow-up scrollup_icon"></i>
        </a>
        <!-- SCROLL TOP FIN -->

        <!--  SWIPER JS  -->
        <script src="{{asset('assets/js/swiper-bundle.min.js')}}"></script>
        <!--  MAIN JS  -->
        <script src="{{asset('assets/js/main.js')}}"></script>
        <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
