<html>
    @include('home.layout.header')

    <body class="page-index has-hero">
    <!--Change the background class to alter background image, options are: benches, boots, buildings, city, metro -->
        <div id="background-wrapper" class="buildings" data-stellar-background-ratio="0.1">

               @include('home.layout.top_header')
               @include('home.layout.slider')
        </div>
    <!-- ======== @Region: #content ======== -->
             <div id="content">
               @if (Session::has('success'))
                    <div class="alert alert-info" style='text-align: center;'>{{ Session::get('success') }}</div>
               @endif
               @yield('content')
           </div>
           
    </div>
    @include('home.layout.footer')
</body>
<script>
    window.setTimeout(function () {
                $(".alert").fadeTo(500, 0).slideUp(500, function () {
                   
                });
            }, 3000);
</script>
</html>