<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Foody - Organic Food Website Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500&family=Lora:wght@600;700&display=swap"
        rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="/home_assets/app_assets/lib/animate/animate.min.css" rel="stylesheet">
    <link href="/home_assets/app_assets/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="/home_assets/app_assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="/home_assets/app_assets/css/style.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.26.1/axios.min.js"></script>
    @toastr_css
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        .dropdown-item:hover {
            color: red;
            background: none;
        }

        .navbar .navbar-nav .nav-link {
            padding: 10px 25px;
            color: yellowgreen;
        }

        .dropdown-item {
            color: yellowgreen;
        }

        .navbar-toggler {
            background-color: red;
        }

        a.home {
            cursor: pointer;
        }

        a#cart {
            cursor: pointer;
        }

        a.navbar-brand.ms-4.ms-lg-0 {
            cursor: pointer;
        }

        .card-body {
            display: flex;
        }

        .btn-lg,
        .btn-group-lg>.btn {
            padding: 0.3rem 1rem;
            font-size: 12px;
        }

        article.card-group-item {
            width: 36%;
            margin: auto;
        }
    </style>
</head>

<body>
    <!-- Spinner Start -->
    <div id="spinner"
        class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" role="status"></div>
    </div>
    <!-- Spinner End -->


    <!-- Navbar Start -->
    @include('home_page_new.share.top')
    <!-- Navbar End -->


    <!-- Carousel Start -->
    @include('home_page_new.share.slide')
    <!-- Carousel End -->


    <!-- About Start -->
    <div class="container-xxl py-12">
        <div class="container">
            <div class="row g-12 align-items-center">
                <div style="text-align: center" class="col-lg-12 wow fadeIn" data-wow-delay="0.5s">
                    <h1 class="display-12 mb-4">
                        Thank you for coming to coffee paradise
                    </h1>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->


    <!-- Feature Start -->

    <!-- Feature End -->


    <!-- Product Start -->
    @yield('content')
    <!-- Product End -->


    <!-- Firm Visit Start -->

    <!-- Firm Visit End -->


    <!-- Testimonial Start -->

    <!-- Testimonial End -->


    <!-- Blog Start -->

    <!-- Blog End -->


    <!-- Footer Start -->
    @include('home_page_new.share.foot')
    <!-- Footer End -->


    <!-- Back to Top -->
    {{-- <a href="#" class="btn btn-lg btn-primary btn-lg-square rounded-circle back-to-top"><i class="bi bi-arrow-up"></i></a> --}}


    <!-- JavaScript Libraries -->
    @jquery
    @toastr_js
    @toastr_render
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/home_assets/app_assets/lib/wow/wow.min.js"></script>
    <script src="/home_assets/app_assets/lib/easing/easing.min.js"></script>
    <script src="/home_assets/app_assets/lib/waypoints/waypoints.min.js"></script>
    <script src="/home_assets/app_assets/lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="/assets_admin/app-assets/vendors/js/vendors.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- Template Javascript -->
    <script src="/home_assets/app_assets/js/main.js"></script>
    @yield('js')
    <script>
        $(document).ready(function() {


            $('#cart').click(function() {
                var url = window.location.pathname;
                var id = url.substr(11);
                window.location.href = "/user/cart/" + id;
            });
            $('.home').click(function() {
                var url = window.location.pathname;
                var id = url.substr(11);
                window.location.href = "/home-page/" + id;
            });

        });
    </script>
</body>

</html>
