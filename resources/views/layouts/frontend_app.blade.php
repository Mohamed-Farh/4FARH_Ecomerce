<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    @include('layouts.frontend.head')
    <style>
        .nav-item .nav-link .badge-counter {
            position: absolute;
            transform: scale(0.7);
            transform-origin: top right;
            right: 8.25rem;
            margin-top: -.50rem;
            border-radius: 100%;
        }
    </style>

    @yield('style')

    <livewire:styles />
</head>

<body>
    <div class="page-holder {{ request()->routeIs('frontend.detail') ? ' bg-light' : null }}">

        @include('layouts.frontend.navbar')


        @yield('content')


        @include('layouts.frontend.footer')

        <!-- Scripts -->
        <livewire:frontend.product-modal-shared />

        <livewire:scripts />

        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <x-livewire-alert::scripts />

        @include('sweetalert::alert', ['cdn' => "https://cdn.jsdelivr.net/npm/sweetalert2@9"])
        @include('layouts.frontend.footer_script')



    </div>




    @yield('script')
</body>

</html>
