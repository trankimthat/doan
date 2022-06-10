<!DOCTYPE html>
<html lang="en">

<head>
    @include('home_page.shares.head')
    <style>
        .dropdown-item:hover{
         color: red;
         background: none;
        }
        .navbar .navbar-nav .nav-link{
            padding: 10px 25px;
            color: yellowgreen;
        }
        .dropdown-item{
            color: yellowgreen;
        }
    </style>
</head>

<body>
    <!-- Spinner Start -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" role="status"></div>
    </div>
    <!-- Spinner End -->


    <!-- Navbar Start -->
    @include('home_page.shares.top')
    <!-- Navbar End -->


    <!-- Carousel Start -->
   @include('home_page.shares.slideder')
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
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-0 gx-5 align-items-end">
                <div class="col-lg-6">
                    <div class="section-header text-start mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 500px;">
                        <h1 class="display-5 mb-3">order a drink</h1>
                    </div>
                </div>
                <div class="col-lg-6 text-start text-lg-end wow slideInRight" data-wow-delay="0.1s" style="visibility: visible; animation-delay: 0.1s; animation-name: slideInRight;">
                    <ul class="nav nav-pills d-inline-flex justify-content-end mb-5">
                        @foreach ($menuCha as $key => $value)
                        <li class="nav-item me-2">
                            <a class="btn btn-outline-primary border-2 {{ $key == 0 ? 'active' : '' }}" data-bs-toggle="pill" href="#tab-{{$value->id}}">{{ $value->ten_danh_muc }}</a>
                        </li>
                         @endforeach
                    </ul>
                </div>
            </div>
            <div class="tab-content">
                @foreach ($menuCha as $key => $value)
                    <div id="tab-{{$value->id}}" class="tab-pane fade {{ $key == 0 ? 'active show' : '' }}">
                            <div class="row g-4">

                                @foreach ($allSanPham as $key_sp => $value_sp)
                                @if(in_array($value_sp->id_danh_muc, explode(",", $value->tmp)))

                                    <div class="col-xl-3 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">

                                        <div class="product-item">
                                            <div class="position-relative bg-light overflow-hidden">
                                                <img class="img-fluid w-100" src="{{ $value_sp->anh_dai_dien }}" alt="">
                                            </div>
                                            <div class="text-center p-4">
                                                <a class="d-block h5 mb-2" href="">{{ $value_sp->ten_san_pham }}</a>
                                                <span class="text-primary me-1">{{ $value_sp->gia_khuyen_mai }}</span>
                                                <span class="text-body text-decoration-line-through">{{ $value_sp->gia_ban }}</span>
                                            </div>
                                            <div class="d-flex border-top">
                                                <small class="w-50 text-center border-end py-2">
                                                    <a class="text-body" href=""><i class="fa fa-eye text-primary me-2"></i>View detail</a>
                                                </small>
                                                <small class="w-50 text-center py-2">
                                                    <a class="text-body" href=""><i class="fa fa-shopping-bag text-primary me-2"></i>Add to cart</a>
                                                </small>
                                            </div>
                                        </div>
                                    </div>

                                    @endif
                                @endforeach

                            </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
    <!-- Product End -->


    <!-- Firm Visit Start -->

    <!-- Firm Visit End -->


    <!-- Testimonial Start -->

    <!-- Testimonial End -->


    <!-- Blog Start -->

    <!-- Blog End -->


    <!-- Footer Start -->
    @include('home_page.shares.foot')
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square rounded-circle back-to-top"><i class="bi bi-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    @include('home_page.shares.bottom')
    @yield('js')
</body>

</html>
