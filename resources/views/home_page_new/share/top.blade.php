<div class="container-fluid fixed-top px-0 wow fadeIn" data-wow-delay="0.1s">
    <div class="top-bar row gx-0 align-items-center d-none d-lg-flex">
        <div class="col-lg-6 px-5 text-start">
            <small><i class="fa fa-map-marker-alt me-2"></i>123 Street, New York, USA</small>
            <small class="ms-4"><i class="fa fa-envelope me-2"></i>info@example.com</small>
        </div>
        <div class="col-lg-6 px-5 text-end">
            <small>Follow us:</small>
            <a class="text-body ms-3" href=""><i class="fab fa-facebook-f"></i></a>
            <a class="text-body ms-3" href=""><i class="fab fa-twitter"></i></a>
            <a class="text-body ms-3" href=""><i class="fab fa-linkedin-in"></i></a>
            <a class="text-body ms-3" href=""><i class="fab fa-instagram"></i></a>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg navbar-light py-lg-0 px-lg-5 wow fadeIn" data-wow-delay="0.1s">
        <a href="index.html" class="navbar-brand ms-4 ms-lg-0">
            <h1 class="fw-bold text-primary m-0">Co<span class="text-secondary">ff</span>ee</h1>
        </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                <a style="color: yellowgreen" href="index.html" class="nav-item nav-link active">Home</a>
                @foreach ($menuCha as $value_cha)
                <div class="nav-item dropdown">
                    <a  class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="/danh-muc/{{$value_cha->slug_danh_muc}}-post{{ $value_cha->id }}" >{{ $value_cha->ten_danh_muc }}</a>
                    <div class="dropdown-menu m-0 " style="background: rgba(0, 0,0, 0) ; border: none">
                        @foreach ($menuCon as $value_con)
                            @if($value_con->id_danh_muc_cha == $value_cha->id)
                                <a  class="dropdown-item" href="/danh-muc/{{ $value_con->id }}">{{ $value_con->ten_danh_muc }}</a>
                            @endif
                        @endforeach
                    </div>
                </div>
                @endforeach
                <a href="about.html" class="nav-item nav-link">About Us</a>
                <a href="product.html" class="nav-item nav-link">Products</a>

                <a href="contact.html" class="nav-item nav-link">Contact Us</a>
            </div>
            <div class="d-none d-lg-flex ms-2">

                    <small style="font-size: 30px" class="fa fa-user  text-body">

                        <a href=""><i class="lnr "></i>
                            <span class="fa">
                                <span>
                                    <strong>{{ Auth::guard('agent')->user()->ho_va_ten }}</strong>
                                </span>
                            </span>
                        </a>

                    </small>

                <button style="font-size: 50px" class="btn-sm-square bg-white rounded-circle ms-3 cart" data-idcart="id" >
                    <small class="fa fa-shopping-bag text-body"></small>
                </button>
            </div>
        </div>
    </nav>
</div>

