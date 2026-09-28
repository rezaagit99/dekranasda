<!DOCTYPE html>
<html lang="en" @yield('html_attribute')>
<head>
    @include('layouts.partials/title-meta')

    @include('layouts.partials/head-css')
</head>
<body>
    @include('frontend.layout.header')

    <main class="pt-24">
        @yield('content')
    </main>

    <!-- Footer -->
    @include('frontend.layout.footer')

    @include('layouts.partials/customizer')
</body>
</html>