@extends('home_page_new.master')
@section('content')
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-0 gx-5 align-items-end">
                <div class="col-lg-2">
                    <div class="section-header text-start mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 500px;">
                        <h1 class="display-5 mb-3">order a drink</h1>
                    </div>
                </div>
                <div class="col-lg-4">

                    {{-- <div class="section-header text-start mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 500px;">
                        <fieldset class="form-group position-relative">

                            <input id="searchSanPham" name="search_sp" type="text" class="form-control form-control mb-1"
                                placeholder="nhập tên sản phẩm">

                        </fieldset>
                    </div> --}}
                    {{-- </form> --}}
                </div>
                <div class="col-lg-6 text-start text-lg-end wow slideInRight" data-wow-delay="0.1s"
                    style="visibility: visible; animation-delay: 0.1s; animation-name: slideInRight;">
                    <ul class="nav nav-pills d-inline-flex justify-content-end mb-5">
                        @foreach ($menuCha as $key => $value)
                            <li class="nav-item me-2">
                                <a class="btn btn-outline-primary border-2 choose {{ $key == 0 ? 'active' : '' }}"
                                    data-bs-toggle="pill" href="#tab-{{ $value->id }}">{{ $value->ten_danh_muc }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="tab-content">
                @foreach ($menuCha as $key => $value)
                    <div id="tab-{{ $value->id }}" class="tab-pane fade {{ $key == 0 ? 'active show' : '' }}">
                        <div class="row g-4">
                            <form name="frmTimKiem" id="frmTimKiem" method="GET" action="">
                                <article class="card-group-item">
                                    <div class="filter-content">
                                        <div class="card-body">
                                            <!--
                                          Thuộc tính name="" cần có trong các thành phần Nhập liệu (input, select, ...)
                                          FORM sẽ đóng gói dữ liệu người dùng (End User) nhập liệu vào đúng tên được đặt trong thuộc tính name=""
                                          Ví dụ: đặt tên là name="keyword_tensanpham"
                                        -->
                                            <input  class="form-control" type="text" placeholder="Tìm kiếm"
                                                aria-label="Search" name="keyword_tensanpham" value="">
                                                <button class="btn btn-primary btn-lg" name="btnTimKiem" id="btnTimKiem">Tìm</button>
                                        </div> <!-- card-body.// -->
                                    </div>
                                </article>
                                @foreach ($allSanPham as $key_sp => $value_sp)
                                    @if (in_array($value_sp->id_danh_muc, explode(',', $value->tmp)))
                                        {{-- <div class="row" id="tablePage"> --}}
                                        <div class="col-xl-3 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                                            <div class="product-item">
                                                <div class="position-relative bg-light overflow-hidden">
                                                    <img class="img-fluid w-100" src="{{ $value_sp->anh_dai_dien }}"
                                                        alt="">
                                                </div>
                                                <div class="text-center p-4">
                                                    <a class="d-block h5 mb-2"
                                                        href="">{{ $value_sp->ten_san_pham }}</a>
                                                    @if ($value_sp->gia_khuyen_mai == 0)
                                                        <span class="text-primary me-1">{{ $value_sp->gia_ban }}</span>
                                                    @else
                                                        <span
                                                            class="text-primary me-1">{{ $value_sp->gia_khuyen_mai }}</span>
                                                        <span
                                                            class="text-body text-decoration-line-through">{{ $value_sp->gia_ban }}</span>
                                                    @endif

                                                </div>
                                                <div class="d-flex border-top" style="background-color: rgb(164, 160, 216)">

                                                    <small class="w-50 text-center py-2" style="margin-left: 73px">
                                                        <a title="Add to Cart" class="btn addToCart"
                                                            style="font-size: 1.875em"
                                                            data-id="{{ $value_sp->id }} ">ODER</a>
                                                    </small>


                                                </div>
                                            </div>
                                        </div>
                                        {{-- </div> --}}
                                    @endif
                                @endforeach
                            </form>


                        </div>
                    </div>
                @endforeach

            </div>
        </div>


    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('.addToCart').click(function() {
                var id_san_pham = $(this).data('id');
                var url = window.location.pathname;

                var id_ban = url.substr(11);
                // console.log(id_ban);
                var payload = {
                    'san_pham_id': id_san_pham,
                    'id_ban': id_ban,
                    'so_luong': 1,
                };
                axios
                    .post('/user/add-to-cart', payload)
                    .then((res) => {
                        if (res.data.status) {
                            toastr.success("Đã thêm vào giỏ hàng!");
                        } else {
                            toastr.error("Bạn thêm vào giỏ thất bại !");
                        }
                    })
                    .catch((res) => {
                        var danh_sach_loi = res.response.data.errors;
                        $.each(danh_sach_loi, function(key, value) {
                            toastr.error(value[0]);
                        });
                    });

            });


            // function loadTable(){
            //     var url = window.location.pathname;
            //     var id = url.substr(11);
            //     $.ajax({
            //             url     :   '/home-page/data/'+ id,
            //             type    :   'get',
            //             success :   function(res) {
            //                 var html = '';

            //             $.each(res.data, function(key, value) {
            //                 html +='<div class="col-xl-3 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">';
            //                 html +='<div class="product-item">';
            //                 html +='<div class="position-relative bg-light overflow-hidden">';
            //                 html +='<img class="img-fluid w-100" src="'+ value.anh_dai_dien +'" alt="">';
            //                 html +='</div>';
            //                 html +='<div class="text-center p-4">';
            //                 html +='<a class="d-block h5 mb-2" href="">'+ value.ten_san_pham +'</a>';
            //                 html +='<span class="text-primary me-1">'+ value.gia_khuyen_mai +'</span>';
            //                 html +='<span class="text-body text-decoration-line-through">'+ value.gia_ban +'</span>';
            //                 html +='</div>';
            //                 html +='<div class="d-flex border-top" style="background-color: rgb(164, 160, 216)">';
            //                 html +='<small class="w-50 text-center py-2" style="margin-left: 73px">';
            //                 html +='<a  title="Add to Cart"  class="btn addToCart" style="font-size: 1.875em"  data-id="'+ value.id +'">ODER</a>';
            //                 html +='</small>';
            //                 html +='</div>';
            //                 html +='</div>';
            //                 html +='</div>';
            //             });
            //             $("#tablePage").html(html);
            //             },
            //     });
            // }
            // loadTable();
            // $("body").on('click', '.choose', function(){
            //     // var url = window.location.pathname;
            //     // var idban = url.substr(11);
            //     var id = $(this).data('id');

            //     // var self = $(this);
            //     var payload = {
            //         'id'    : id,
            //     }
            //     // console.log(id);
            //     $.ajax({
            //         url: '/home-page/data/'+ id,
            //         type: 'get',
            //         // data: payload,
            //         success: function (res) {
            //             var html = '';
            //             $.each(res.data, function(key, value) {
            //                 html +='<div class="col-xl-3 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">';
            //                 html +='<div class="product-item">';
            //                 html +='<div class="position-relative bg-light overflow-hidden">';
            //                 html +='<img class="img-fluid w-100" src="'+ value.anh_dai_dien +'" alt="">';
            //                 html +='</div>';
            //                 html +='<div class="text-center p-4">';
            //                 html +='<a class="d-block h5 mb-2" href="">'+ value.ten_san_pham +'</a>';
            //                 html +='<span class="text-primary me-1">'+ value.gia_khuyen_mai +'</span>';
            //                 html +='<span class="text-body text-decoration-line-through">'+ value.gia_ban +'</span>';
            //                 html +='</div>';
            //                 html +='<div class="d-flex border-top" style="background-color: rgb(164, 160, 216)">';
            //                 html +='<small class="w-50 text-center py-2" style="margin-left: 73px">';
            //                 html +='<a  title="Add to Cart"  class="btn addToCart" style="font-size: 1.875em"  data-id="'+ value.id +'">ODER</a>';
            //                 html +='</small>';
            //                 html +='</div>';
            //                 html +='</div>';
            //                 html +='</div>';
            //             });
            //             $("#tablePage").html(html);
            //             // loadTable();
            //         },
            //     });

            // });

            $("#searchSanPham").keyup(function() {
                // var url = window.location.pathname;
                // var id = url.substr(11);
                var search = $("#searchSanPham").val();
                $payload = {
                    'tenSanPham': search,
                };
                $.ajax({
                    url: '/admin/san-pham/search',
                    type: 'post',
                    data: $payload,
                    success: function(res) {
                        var html = '';
                        $.each(res.dataProduct, function(key, value) {
                            html +=
                                '<div class="col-xl-3 col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">';
                            html += '<div class="product-item">';
                            html +=
                                '<div class="position-relative bg-light overflow-hidden">';
                            html += '<img class="img-fluid w-100" src="' + value
                                .anh_dai_dien + '" alt="">';
                            html += '</div>';
                            html += '<div class="text-center p-4">';
                            html += '<a class="d-block h5 mb-2" href="">' + value
                                .ten_san_pham + '</a>';
                            html += '<span class="text-primary me-1">' + value
                                .gia_khuyen_mai + '</span>';
                            html +=
                                '<span class="text-body text-decoration-line-through">' +
                                value.gia_ban + '</span>';
                            html += '</div>';
                            html +=
                                '<div class="d-flex border-top" style="background-color: rgb(164, 160, 216)">';
                            html +=
                                '<small class="w-50 text-center py-2" style="margin-left: 73px">';
                            html +=
                                '<a  title="Add to Cart"  class="btn addToCart" style="font-size: 1.875em"  data-id="' +
                                value.id + '">ODER</a>';
                            html += '</small>';
                            html += '</div>';
                            html += '</div>';
                            html += '</div>';
                        });
                        $("#tablePage").html(html);

                    }
                });
            });
        });
    </script>
@endsection

{{-- @section('js')
    <script>
        $(document).ready(function(){
            $('.addToCart').click(function(){
            var id_san_pham = $(this).data('id');
            var url = window.location.pathname;
            var id_ban = url.substr(11);
            // console.log(id_ban);
                var payload = {
                    'san_pham_id'   : id_san_pham,
                    'id_ban'        : id_ban,
                    'so_luong'      : 1,
                };
                axios
                    .post('/user/add-to-cart', payload)
                    .then((res) => {
                         if(res.data.status) {
                            toastr.success("Đã thêm vào giỏ hàng!");
                        } else {
                            toastr.error("Bạn thêm vào giỏ thất bại !");
                        }
                    })
                    .catch((res) => {
                        var danh_sach_loi = res.response.data.errors;
                        $.each(danh_sach_loi, function(key, value){
                            toastr.error(value[0]);
                        });
            });

        });
        });
    </script>

@endsection --}}
