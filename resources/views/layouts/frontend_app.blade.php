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
        @include('layouts.frontend.footer_script')



    </div>


    <livewire:frontend.product-modal-shared />

    @livewireScripts
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10">
    </script>
    <x-livewire-alert::scripts />

    @yield('script')
</body>

</html>
