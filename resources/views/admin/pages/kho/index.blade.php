@extends('admin.master')
@section('title')
    <h3>Quản Lý Nhập Kho</h3>
@endsection
@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card" style="height: auto">
            <div class="card-header">
                <h4 class="card-title" id="basic-layout-colored-form-control">Nhập Kho Sản Phẩm</h4>
                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                <div class="heading-elements">
                    <ul class="list-inline mb-0">
                        <li><a data-action="collapse"><i class="feather icon-minus"></i></a></li>
                        <li><a data-action="reload"><i class="feather icon-rotate-cw"></i></a></li>
                        <li><a data-action="expand"><i class="feather icon-maximize"></i></a></li>
                        <li><a data-action="close"><i class="feather icon-x"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="card-content collapse show">
                <div class="card-body">
                    <fieldset class="form-group position-relative">
                        <input id="searchSanPham" type="text" class="form-control form-control mb-1" placeholder="Nhập vào tên sản phẩm">
                        <div class="form-control-position">
                            <i id="search" class="feather icon-search info font-medium-4"></i>
                        </div>
                    </fieldset>
                    <table class="table table-bordered mb-0 mt-1" id="tableBenTrai">
                        <thead>
                            <tr class="text-center">
                                <th class="text-center">#</th>
                                <th class="text-center">Tên Sản Phẩm</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header" style="height: auto">
                <h4 class="card-title">Nhập Kho Sản Phẩm</h4>
                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                <div class="heading-elements">
                    <ul class="list-inline mb-0">
                        <li><a data-action="collapse"><i class="feather icon-minus"></i></a></li>
                        <li><a data-action="reload"><i class="feather icon-rotate-cw"></i></a></li>
                        <li><a data-action="expand"><i class="feather icon-maximize"></i></a></li>
                        <li><a data-action="close"><i class="feather icon-x"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="card-content collapse show">
                <div class="card-body">
                    <table class="table table-bordered mb-0" id="tableBenPhai">
                        <thead>
                            <tr class="text-center">
                                <th class="text-center">#</th>
                                <th class="text-center">Tên Sản Phẩm</th>
                                <th class="text-center">Số Lượng</th>
                                <th class="text-center">Đơn Giá</th>
                                <th class="text-center">Thành Tiền</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
            <button id="creatNhapKho" class="m-1 btn btn-primary">Nhập Kho</button>
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
        function tableBenTrai() {
            $.ajax({
                url     :   '/admin/kho/data',
                type    :   'get',
                success :   function(res) {
                    var html = '';

                    $.each(res.dulieu, function(key, value) {

                        html += '<tr>';
                        html += '<th scope="row">' + (key + 1) + '</th>';
                        html += '<td>' + value.ten_san_pham + '</td>';
                        html += '<td>';
                        html += '<button data-idadd="' + value.id + '" class="btn btn-info btn-sm">Add</button>';
                        html += '</td>';
                        html += '</tr>';
                    });
                    $("#tableBenTrai tbody").html(html);

                },
            });
        }

        tableBenTrai();
        $("#searchSanPham").keyup(function()
            {
                var search = $("#searchSanPham").val();
                $payload = {
                    'tenSanPham': search,
                };
                $.ajax({
                    url: '/admin/san-pham/search',
                    type: 'post',
                    data: $payload,
                    success: function (res) {
                        var html = '';

                    $.each(res.dataProduct, function(key, value) {

                        html += '<tr>';
                        html += '<th scope="row">' + (key + 1) + '</th>';
                        html += '<td>' + value.ten_san_pham + '</td>';
                        html += '<td>';
                        html += '<button data-idadd="' + value.id + '" class="btn btn-info btn-sm">Add</button>';
                        html += '</td>';
                        html += '</tr>';
                    });
                    $("#tableBenTrai tbody").html(html);
                        // tableBenTrai();
                        // viewSanPham(res.dataProduct);
                    }

                });
            });

    });
    // new Vue({
    //     el  :   '#app',
    //     data:   {
    //         danhSachSanPham     :   [],
    //         danhSachKhoDangNhap :   [],
    //         inputSearch         :   '',
    //     },
    //     created() {
    //         this.loadSanPham();
    //         this.loadTableBenPhai();
    //     },
    //     methods :   {
    //         loadTableBenPhai() {
    //             axios
    //                 .get('/admin/nhap-kho/loadData')
    //                 .then((res) => {
    //                     this.danhSachKhoDangNhap = res.data.nhapKho;
    //                 });
    //         },
    //         loadSanPham() {
    //             axios
    //                 .get('/admin/san-pham/loadData')
    //                 .then((res) => {
    //                     this.danhSachSanPham = res.data.danhSachSanPham;
    //                 });
    //         },
    //         addKhoHang(id) {
    //             axios
    //                 .get('/admin/nhap-kho/add/' + id)
    //                 .then((res) => {
    //                     if(res.data.status == false) {
    //                         toastr.error("Sản phẩm không tồn tại!");
    //                     } else {
    //                         this.loadTableBenPhai();
    //                     }
    //                 });
    //         },
    //         search() {
    //             var payload = {
    //                 'tenSanPham'    :   this.inputSearch,
    //             };
    //             axios
    //                 .post('/admin/san-pham/search', payload)
    //                 .then((res) => {
    //                     this.danhSachSanPham    = res.data.dataProduct;
    //                 });
    //         },
    //         destroy(id) {
    //             axios
    //                 .get('/admin/nhap-kho/remove/' + id)
    //                 .then((res) => {
    //                     if(res.data.status == false) {
    //                         toastr.error("Sản phẩm không tồn tại!");
    //                     } else {
    //                         this.loadTableBenPhai();
    //                     }
    //                 });
    //         },
    //         update(row) {
    //             axios
    //                 .post('/admin/nhap-kho/update', row)
    //                 .then((res) => {
    //                     this.loadTableBenPhai();
    //                 });
    //         },
    //         createStore() {
    //             axios
    //                 .get('/admin/nhap-kho/create')
    //                 .then((res) => {
    //                     toastr.success("Đã Nhập Kho Thành Công!!!");
    //                     this.loadTableBenPhai();
    //                 });
    //         },
    //     },
    // });
</script>
@endsection



