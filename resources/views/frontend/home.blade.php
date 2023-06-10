<!DOCTYPE html>
<html lang="en">
  @php
  use Illuminate\Support\Facades\Session;
  use App\Helpers\ARHelper;
                  
  @endphp
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>ANNUAL REPORT</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link rel="shortcut icon" href="{{asset('assets/img/favicon.png')}}">
  <link rel="icon" type="image/png" href="{{asset('assets/img/apple-touch-icon.png')}}">

  <!-- Vendor CSS Files -->
  <link href="{{asset('assets/vendor/aos/aos.css')}}" rel="stylesheet">
  <link href="{{asset('assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{asset('assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
  <link href="{{asset('assets/vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
  <link href="{{asset('assets/vendor/glightbox/css/glightbox.min.css')}}" rel="stylesheet">
  <link href="{{asset('assets/vendor/swiper/swiper-bundle.min.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <!-- Template Main CSS File -->
  <link href="{{asset('assets/css/style.css')}}" rel="stylesheet">
   <link href="{{asset('assets/css/response.css')}}" rel="stylesheet">

  <!-- =======================================================
  * Template Name: BizLand - v3.7.0
  * Template URL: https://bootstrapmade.com/bizland-bootstrap-business-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

    <!-- ======= Top Bar ======= -->

    @include('frontend.includes.topbar')

    <!-- ======= Header ======= -->

    @include('frontend.includes.header')

    <!-- End Header -->
    <main id="main">
    <!-- ======= Welcome ======= -->

    @include('frontend.includes.about')

    <!-- End Welcome -->

    <!-- ======= Hero Section ======= -->

    @include('frontend.includes.hero_section')

    <!-- End Hero -->

     <!-- Manage-Documents -->

     @include('frontend.includes.resources')
      <!-- end  Manage-Documents -->

    <!-- ======= Frequently Asked Questions Section ======= -->

        {{-- @include('frontend.includes.faq') --}}

    <!-- End Frequently Asked Questions Section -->

    <!-- ======= Contact Section ======= -->

    @include('frontend.includes.contact')

    <!-- End Contact Section -->

    </main>
    <!-- End #main -->

    <!-- ======= Footer ======= -->

    @include('frontend.includes.footer')

    <!-- End Footer -->

  <div id="preloader"></div>
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="{{asset('assets/vendor/purecounter/purecounter.js')}}"></script>
  <script src="{{asset('assets/vendor/aos/aos.js')}}"></script>
  <script src="{{asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('assets/vendor/glightbox/js/glightbox.min.js')}}"></script>
  <script src="{{asset('assets/vendor/isotope-layout/isotope.pkgd.min.js')}}"></script>
  <script src="{{asset('assets/vendor/swiper/swiper-bundle.min.js')}}"></script>
  <script src="{{asset('assets/vendor/waypoints/noframework.waypoints.js')}}"></script>
  <script src="{{asset('assets/vendor/php-email-form/validate.js')}}"></script>

  <!-- Template Main JS File -->
  <script src="{{asset('assets/js/main.js')}}"></script>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
  <script src='https://www.google.com/recaptcha/api.js' async defer></script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> 
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function() {
        var $listElements = $("#list li");
        $listElements.hide();
        $listElements.filter(':lt(5)').show();
        $('#list').append('<div class="row justify-content-center" align="center"><span class="btn-get-started" >More</span><span class="less btn-get-started" align="center">Less</span></div>'); 
        $("#list").find('div:last').click(function(){
            $(this).siblings(':gt(5)').toggle('slow');
            $(this).find('span').toggle();
        });
    });
  </script>

</body>

</html>