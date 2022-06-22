@extends('home_page_new.master')
@section('content')
<div class="container-xxl py-5">
    {{-- @foreach ($data as $key_tim => $value_tim ) --}}
    <div class="container">
        <div class="row g-0 gx-5 align-items-end">
            <div class="col-lg-2">
                <div class="section-header text-start mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 500px;">
                    <h1 class="display-5 mb-3">order a drink</h1>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="section-header text-start mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 500px;">
                    <fieldset class="form-group position-relative">
                        <input id="searchSanPham" type="text" class="form-control form-control mb-1" placeholder="nhập tên sản phẩm">
                        {{-- <a class="btn-sm-square bg-white rounded-circle ms-3 " href="">
                            <small class="fa fa-search text-body"></small>
                        </a> --}}
                    </fieldset>
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
                                            @if ($value_sp->gia_khuyen_mai == 0)
                                            <span class="text-primary me-1">{{ $value_sp->gia_ban }}</span>
                                            @else
                                            <span class="text-primary me-1">{{ $value_sp->gia_khuyen_mai }}</span>
                                            <span class="text-body text-decoration-line-through">{{ $value_sp->gia_ban }}</span>
                                            @endif

                                        </div>
                                        <div class="d-flex border-top" style="background-color: rgb(164, 160, 216)">
                                            {{-- <small class="w-50 text-center border-end py-2">
                                                <a class="text-body" href=""><i class="fa fa-eye text-primary me-2"></i>Od</a>
                                            </small> --}}
                                            {{-- @foreach ( $allBan as $key_ban=>$value_ban ) --}}
                                            <small class="w-50 text-center py-2" style="margin-left: 73px">
                                                <a   title="Add to Cart"  class="btn addToCart" style="font-size: 1.875em"  data-id="{{ $value_sp->id }} ">ODER</a>
                                            </small>
                                            {{-- @endforeach --}}

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
    {{-- @endforeach --}}

</div>
@endsection
{{-- @section('js')
<script>
    $(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $("#searchSanPham").keyup(function(){
        var search = $("#searchSanPham").val();
        $payload = {
            'tenSanPham': search,
        };
        $.ajax({
            url: '/admin/san-pham/search',
            type: 'post',
            data: $payload,
            success: function (res) {

            }
        });
    });
});
</script>

@endsection --}}


