<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    @include('layouts.frontend.head')

    @yield('style')

    @livewireStyles
</head>

<body>
    <div class="page-holder {{ request()->routeIs('frontend.detail') ? ' bg-light' : null }}">

        @include('layouts.frontend.navbar')


        @yield('content')


        @include('layouts.frontend.footer')

        <!-- Scripts -->
        <livewire:frontend.product-modal-shared />

        <livewire:scripts />
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
        <x-livewire-alert::scripts />
        @include('sweetalert::alert', ['cdn' => "https://cdn.jsdelivr.net/npm/sweetalert2@9"])


        @include('layouts.frontend.footer_script')



    </div>




    @yield('script')
</body>

</html>
