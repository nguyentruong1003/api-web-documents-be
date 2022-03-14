<!DOCTYPE html>
<html lang="en">
@include('layouts.partials._head')
@yield('css')
<body>
    <div class="wrapper">
        <!-- #section:basics/navbar.layout -->
        @include('layouts.partials._header')
        @include('layouts.partials._sidebar')
        <div class="content-wrapper">
            @yield('content')
        </div>
        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
@include('layouts.partials._footer')
<!-- /.main-main-container -->
@include('layouts.partials._script')
@yield('js')
</body>
</html>
