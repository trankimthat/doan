@extends('admin.master')
@push('css')
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.11.5/b-2.2.2/b-colvis-2.2.2/b-html5-2.2.2/b-print-2.2.2/date-1.1.2/fc-4.0.2/fh-3.2.2/r-2.2.9/rg-1.1.4/sc-2.0.5/sb-1.3.2/sl-1.3.4/datatables.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush
@section('title')
    <div style="text-align: center">
        <h3 style="color: red">Quản Lý Nhập Kho</h3>
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card" style="height: auto">
                <div class="card-header">
                    <h4 class="card-title" id="basic-layout-colored-form-control">Nhập Kho Nguyên Liệu</h4>
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
                            <input id="searchDanhMuc" type="text" class="form-control form-control mb-1"
                                placeholder="Nhập vào tên danh mục">
                            {{-- <div class="form-control-position">
                            <i id="search" class="feather icon-search info font-medium-4"></i>
                        </div> --}}
                        </fieldset>
                        <table class="table table-bordered mb-0 mt-1" id="tableBenTrai">
                            <thead>
                                <tr class="text-center">
                                    <th class="text-center">#</th>
                                    <th class="text-center">Tên Nguyên Liệu</th>
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
                    <h4 class="card-title">Nhập Kho Nguyên Liệu</h4>
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
                    {{-- <div class="card-header">
                    <h5>Chi Tiết Hóa Đơn Nhập Hàng</h5>
                    <span>Tổng tiền hàng: <span id="tongTien" class="text-danger font-weight-bold"></span></span>
                    <span>Tổng số sản phẩm: <span id="tongSanPham" class="text-danger font-weight-bold"></span></span>
                </div> --}}
                    <div class="card-body">
                        <table class="table table-bordered mb-0" id="tableBenPhai">
                            <thead>
                                <tr class="text-center">
                                    <th class="text-center">#</th>
                                    <th class="text-center">Tên Sản Phẩm</th>
                                    <th class="text-center">Số Lượng</th>
                                    <th class="text-center">Đơn Vị</th>
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
    {{-- <div style="text-align: center">
    <h3 style="color: red">Quản Lý Xuất Kho</h3>
</div> --}}
    {{-- <div class="row">
    <div class="col-md-6">
        <div class="table-response">
            <div class="main-card mb-3 card">
                <div class="card-body"><h5 class="card-title">Table bordered</h5>
                    <table class="mb-0 table table-bordered" id="tableXuatKho">
                        <thead>
                        <tr>
                            <th class="text-nowrap text-center">#</th>
                            <th class="text-nowrap text-center">Tên Nguyên Liệu</th>
                            <th class="text-nowrap text-center">Số Lượng</th>
                            <th class="text-nowrap text-center">Đơn Vị</th>
                            <th class="text-nowrap text-center">Action</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header" style="height: auto">
                <h4 class="card-title">Nhập Kho Nguyên Liệu</h4>
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
                <div class="card-header">
                    <h5>Chi Tiết Hóa Đơn Nhập Hàng</h5>
                    <span>Tổng tiền hàng: <span id="tongTien" class="text-danger font-weight-bold"></span></span>
                    <span>Tổng số sản phẩm: <span id="tongSanPham" class="text-danger font-weight-bold"></span></span>
                </div>
                <div class="card-body">
                    <table class="table table-bordered mb-0" id="tableXuatBenPhai">
                        <thead>
                            <tr class="text-center">
                                <th class="text-center">#</th>
                                <th class="text-center">Tên Sản Phẩm</th>
                                <th class="text-center">Số Lượng</th>
                                <th class="text-center">Đơn Vị</th>
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
</div> --}}
@endsection
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Xóa </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Bạn có chắc chắn muốn xóa? Điều này không thể hoàn tác.
                <input type="text" class="form-control" placeholder="Nhập vào id cần xóa" id="idDelete" hidden>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="accpectDelete" class="btn btn-danger" data-dismiss="modal">Xóa </button>
            </div>
        </div>
    </div>
</div>
@section('js')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript"
        src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.11.5/b-2.2.2/b-colvis-2.2.2/b-html5-2.2.2/b-print-2.2.2/date-1.1.2/fc-4.0.2/fh-3.2.2/r-2.2.9/rg-1.1.4/sc-2.0.5/sb-1.3.2/sl-1.3.4/datatables.min.js">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        < script >
            $(document).ready(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                function tableBenTrai() {
                    $.ajax({
                        dom: 'Blrtip',
                        url: '/admin/nguyen-lieu/data',
                        type: 'get',
                        success: function(res) {
                            var html = '';

                            $.each(res.dulieu, function(key, value) {

                                html += '<tr>';
                                html += '<th scope="row">' + (key + 1) + '</th>';
                                html += '<td>' + value.ten_nguyen_lieu + '</td>';
                                html += '<td>';
                                html += '<button data-idadd="' + value.id +
                                    '" class="btn btn-info btn-sm add">Add</button>';
                                html += '</td>';
                                html += '</tr>';
                            });
                            $("#tableBenTrai tbody").html(html);
                            console.log(html);
                        },
                    });
                }

                tableBenTrai();
                $("#searchDanhMuc").keyup(function() {
                    var search = $("#searchDanhMuc").val();
                    $payload = {
                        'tenNguyenLieu': search,
                    };
                    $.ajax({
                        url: '/admin/nguyen-lieu/search',
                        type: 'post',
                        data: $payload,
                        success: function(res) {
                            var html = '';

                            $.each(res.dataProduct, function(key, value) {

                                html += '<tr>';
                                html += '<th scope="row">' + (key + 1) + '</th>';
                                html += '<td>' + value.ten_nguyen_lieu + '</td>';
                                html += '<td>';
                                html += '<button data-idadd="' + value.id +
                                    '" class="btn btn-info btn-sm add">Add</button>';
                                html += '</td>';
                                html += '</tr>';
                            });
                            $("#tableBenTrai tbody").html(html);
                            // tableBenTrai();
                            // viewSanPham(res.dataProduct);
                        }

                    });
                });

                let table = $('#tableBenPhai').DataTable({
                    dom: 'Blrtip',
                    select: true,
                    lengthMenu: [5, 15, 30, 45, 50, 100],
                    processing: true,
                    serverSide: true,
                });

                function tableBenPhai() {
                    dom: 'Blrtip',
                    $.ajax({
                        url: '/admin/kho/data',
                        type: 'get',
                        success: function(res) {
                            var html = '';

                            $.each(res.nhapKho, function(key, value) {

                                html += '<tr>';
                                html += '<th scope="row">' + (key + 1) + '</th>';

                                html += '<td>' + value.ten_nguyen_lieu + '</td>';
                                html += '<td>';
                                html +=
                                    '<input type="number" min=1 class="form-control qty" value="' +
                                    value.so_luong + '" data-id=' + value.id + '>';
                                html += '</td>';
                                html += '<td>' + value.don_vi + '</td>';
                                html += '<td>';
                                html += '<input type="number" class="form-control price" value="' +
                                    value.don_gia + '" data-id=' + value.id + '>';
                                html += '</td>';
                                html += '<td>' + formatNumber(value.so_luong * value.don_gia) +
                                    '</td>';
                                html += '<td>';
                                html +=
                                    '<button class="btn btn-danger delete mr-1" data-iddelete="' +
                                    value.id +
                                    '" data-toggle="modal" data-target="#deleteModal">Delete</button>';
                                html += '</td>';
                                html += '</tr>';
                            });
                            $("#tableBenPhai tbody").html(html);

                        },
                    });
                }
                tableBenPhai();

                function formatNumber(number) {
                    return new Intl.NumberFormat('vi-VI', {
                        style: 'currency',
                        currency: 'VND'
                    }).format(number);
                }

                $('body').on('click', '.add', function() {
                    var id_nguyen_lieu = $(this).data('idadd');
                    var payload = {
                        'id_nguyen_lieu': id_nguyen_lieu,
                    };
                    $.ajax({
                        url: '/admin/kho/create',
                        type: 'post',
                        data: payload,
                        success: function(res) {
                            toastr.success("Đã thêm danh muc !");
                            tableBenPhai();
                        },
                        error: function(res) {
                            var listError = res.responseJSON.errors;
                            $.each(listError, function(key, value) {
                                toastr.error(value[0]);
                            });
                        },
                    });
                });
                $("body").on('change', '.qty', function() {
                    var payload = {
                        'id': $(this).data('id'),
                        'so_luong': $(this).val(),
                    };

                    $.ajax({
                        url: '/admin/kho/updateqty',
                        type: 'post',
                        data: payload,
                        success: function(res) {
                            if (res.status == false) {
                                toastr.error('Cập nhật thất bại số lượng lớn hơn 1');
                                tableBenPhai();
                            } else {
                                toastr.success("Đã cập nhật số lượng sản phẩm!");
                                tableBenPhai();
                            }
                        },
                        error: function(res) {
                            var listError = res.responseJSON.errors;
                            $.each(listError, function(key, value) {
                                toastr.error(value[0]);
                            });
                        },
                    });
                });
                $("body").on('change', '.price', function() {
                    var payload = {
                        'id': $(this).data('id'),
                        'don_gia': $(this).val(),
                    };

                    $.ajax({
                        url: '/admin/kho/updateprice',
                        type: 'post',
                        data: payload,
                        success: function(res) {
                            toastr.success("Đã cập nhật đơn giá sản phẩm!");
                            tableBenPhai();
                        },
                        error: function(res) {
                            var listError = res.responseJSON.errors;
                            $.each(listError, function(key, value) {
                                toastr.error(value[0]);
                            });
                        },
                    });
                });
                $('#creatNhapKho').click(function() {
                    $.ajax({
                        url: '/admin/kho/createnhapkho',
                        type: 'get',
                        success: function(res) {
                            if (res.status) {
                                toastr.success("Đã nhập kho danh mục !");
                                tableBenPhai();
                                tableXuatKho();
                            } else {
                                toastr.error("không có đơn giá/số lượng danh mục sản phẩm nào !");
                                // tableBenPhai();
                            }
                        },

                    });
                });
                $('body').on('click', '.delete', function() {
                    var getId = $(this).data('iddelete');
                    $("#idDelete").val(getId);
                });

                $("#accpectDelete").click(function() {
                    var id = $("#idDelete").val();
                    $.ajax({
                        url: '/admin/kho/remove/' + id,
                        type: 'get',
                        success: function(res) {
                            if (res.status) {
                                toastr.success('Đã xóa  thành công!');
                                tableBenPhai();
                            } else {
                                toastr.error('không tồn tại!');
                            }
                        },
                    });
                });

                //Xuất Kho
                // function tableXuatKho(){
                //     console.log(123);
                //     $.ajax({
                //         url     :   '/admin/kho/xuat-kho/data',
                //         type    :   'get',
                //         success :   function(res) {
                //             var html = '';
                //             // console.log(res.dataXuat);
                //             $.each(res.dataXuat, function(key, value) {

                //                 html += '<tr>';
                //                 html += '<th scope="row">' + (key + 1) + '</th>';
                //                 html += '<td>' + value.ten_nguyen_lieu + '</td>';
                //                 html += '<td>' + value.so_luong + '</td>';
                //                 html += '<td>' + value.don_vi + '</td>';
                //                 html += '<td>';
                //                 html += '<button data-idXuat="' + value.id + '" class="btn btn-info btn-sm add">Add</button>';
                //                 html += '</td>';
                //                 html += '</tr>';
                //             });
                //             $("#tableXuatKho tbody").html(html);
                //             console.log(html);
                //         },
                //     });
                // }
                // tableXuatKho();
                // function tableXuatBenPhai(){
                //     $.ajax({
                //         url     :   '/admin/kho/data',
                //         type    :   'get',
                //         success :   function(res) {
                //             var html = '';

                //             $.each(res.nhapKho, function(key, value) {

                //                 html += '<tr>';
                //                 html += '<th scope="row">' + (key + 1) + '</th>';

                //                 html += '<td>' + value.ten_nguyen_lieu + '</td>';
                //                 html += '<td>';
                //                 html += '<input type="number" min=1 class="form-control qty" value="'+value.so_luong+'" data-id='+ value.id+'>';
                //                 html += '</td>';
                //                 html += '<td>' + value.don_vi + '</td>';
                //                 html += '<td>';
                //                 html += '<input type="number" class="form-control price" value="'+value.don_gia +'" data-id='+ value.id+'>';
                //                 html += '</td>';
                //                 html += '<td>'+ formatNumber(value.so_luong * value.don_gia) +'</td>';
                //                 html += '<td>';
                //                 html += '<button class="btn btn-danger delete mr-1" data-iddelete="'+ value.id +'" data-toggle="modal" data-target="#deleteModal">Delete</button>';
                //                 html += '</td>';
                //                 html += '</tr>';
                //             });
                //             $("#tableXuatBenPhai tbody").html(html);

                //         },
                //     });
                // }

            });
    </script>
@endsection
