@extends('admin.master')
@section('title')
    <h3>Quản Lý Doanh Thu</h3>
@endsection
@section('content')
    <div class="row" >
        <div class="col-md-5" >
            <div>
                <input style="font-size: 30px" id="ngay_hoa_don" type="date">
                <button class=" btn btn-primary" id="timKiem">Tìm Kiếm</button>
            </div>

            <div class="bang mt-3"  >
                <h3 class="card-title">Responsive tables</h3>
                <fieldset class="form-group position-relative">
                    <input id="searchNhanVien" type="text" class="form-control form-control mb-1" placeholder="Nhập vào tên nhân viên">

                </fieldset>
                <div  style="overflow: scroll;">
                    <table class="table" id="creatNgayHD" >
                        <thead>
                            <tr>
                                <th scope="col" class="text-nowrap">#</th>
                                <th scope="col" class="text-nowrap">Bàn</th>
                                <th scope="col" class="text-nowrap">Tên Nhân Viên</th>
                                <th scope="col" class="text-nowrap">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="main-card mb-3 card">
                <div class="card-body" style="text-align: center"><h5 class="card-title">HÓA ĐƠN</h5>
                    <div >
                        <h3 id="maBan"></h3>
                    </div>
                    <table class="mb-0 table table-bordered" id="tableBanRight">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Tên sản phẩm</th>
                                <th class="text-center">Gía tiền</th>
                                <th class="text-center">Số Lượng</th>
                                <th class="text-center">Thành tiền</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>


                        </tbody>

                    </table>
                    <div style="text-align: left" class="col-md-12 col-sm-12">
                        <div class="cart_totals ">
                            <h1>Cart Totals</h1>
                            <div class="row">
                                <div class="cart float-md-left text-md-left" id="TongTienHang " style="margin-bottom: 20px; font-size: 30px">
                                    <span>Tổng tiền hàng: <span id="tongTien" class="text-danger font-weight-bold"></span></span>
                                  </div>
                            </div>

                            <div class="row">
                                <div class="cart float-md-left text-md-left" id="TienGiam " style="margin-bottom: 20px; font-size: 30px">
                                    <span>Tổng tiền giảm: <span id="tongTienGiam" class="text-danger font-weight-bold"></span></span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="cart float-md-left text-md-left" id="TienTra " style="margin-bottom: 20px; font-size: 30px">
                                    <span>Tổng tiền thực trả: <span id="tongTienThucTra" class="text-danger font-weight-bold"></span></span>
                                </div>
                            </div>
                            <div class="cart float-md-right text-md-right" class="wc-proceed-to-checkout">
                                <input type="hidden" id="id_ban_thanh_toan">
                                <a id="inBill" class="btn btn-danger" href="#" >INVOICE</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Xóa Danh Mục Sản Phẩm</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            Bạn có chắc chắn muốn xóa? Điều này không thể hoàn tác.
            <input type="text" class="form-control" placeholder="Nhập vào id cần xóa" id="idDeleteSanPham" hidden>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" id="accpectDelete" class="btn btn-danger" data-dismiss="modal">Xóa Danh Mục</button>
        </div>
      </div>
    </div>
</div>
@section('js')
<script>
$(document).ready(function() {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $("#timKiem").click(function(){
            var ngay_hoa_don    = $("#ngay_hoa_don").val();

            var payload = {
                'ngay_hoa_don'  : ngay_hoa_don,
            };
            $.ajax({
                url     :   '/admin/doanh-thu/data',
                type    :   'post',
                data    :    payload,
                success :    function(res) {
                    var html = '';
                    $.each(res.ngay_hoa_don, function(key, value) {
                        html += '<tr>';
                        html += '<th scope="row">' + (key + 1) + '</th>';
                        html += '<td>';
                        html += '<button class="btn btn-primary date" data-idNgay=' + value.id + '>' + value.ngay_hoa_don + '  bàn  ' + value.ma_ban + '</button>'
                        html += '</td>';
                        html += '<td> ' + value.ho_va_ten +' </td>';
                        html += '<td class="text-center">';
                        html += '<button class="btn btn-danger mr-1 show" data-idshow="'+ value.id +'" data-toggle="modal" >Xem</button>';
                        html += '</td>';
                        html += '</tr>';
                    });
                    $("#creatNgayHD tbody").html(html);
                },
                error   :    function(res) {
                    var danh_sach_loi = res.responseJSON.errors;
                    $.each(danh_sach_loi, function(key, value){
                        toastr.error(value[0]);
                    });
                }
            });

    });
    function loadtableRight(id){
        $.ajax({
                url     :   '/admin/doanh-thu/hoa-don/'+ id,
                type    :   'get',
                success :   function(res) {
                    if(res.status){
                        var content_table = '';
                        var tongtienthuc = 0;
                        var tongTienGiam = 0;
                        var tongTienTra = 0;
                        var ma_ban = '';
                        $("#id_ban_thanh_toan").val(id);
                        $.each(res.dataNe, function(key, value) {
                            content_table += '<tr>';
                            content_table += '<th class="text-center" scope="row">' + (key + 1) +'</th>';
                            content_table += '<td> ' + value.ten_san_pham +' </td>';
                            content_table += '<td> ' + value.don_gia + ' </td>';
                            content_table += '<td>';
                            content_table += '<input type="number" min=1 class="form-control qty" value="'+value.so_luong+'" data-id='+ value.id+'>';
                            content_table += '</td>';
                            content_table += '<td class="total" data-id="'+value.id+'"> ' + value.so_luong * value.don_gia + ' </td>';
                            content_table += '</td>';
                            content_table += '<td class="text-center">';
                            content_table += '<button class="btn btn-danger delete mr-1" data-iddelete="'+ value.id_chi_tiet +'" data-toggle="modal" data-target="#deleteModal">Delete</button>';
                            content_table += '</td>';
                            content_table += '</tr>';
                            tongtienthuc = value.tong_tien;
                            tongTienTra = value.thuc_tra;
                            tongTienGiam = value.tien_giam_gia;
                            // ma_ban = value.ma_ban;
                        });
                            $("#tableBanRight tbody").html(content_table);
                            $("#tongTien").text(formatNumber(tongtienthuc));
                            $("#tongTienGiam").text(formatNumber(tongTienGiam));
                            $("#tongTienThucTra").text(formatNumber(tongTienTra));
                            // $("#maBan").text(ma_ban);
                    }else{
                        toastr.error('Ngày không có');
                    }
                }
        });
    }
    $('body').on('click', '.show', function(){
        var id = $(this).data('idshow');
        // console.log(id);
        // $.ajax({
        //         url     :   '/admin/doanh-thu/hoa-don/'+ id,
        //         type    :   'get',
        //         success :   function(res) {
        //             if(res.status){
        //                 var content_table = '';
        //                 var tongtienthuc = 0;
        //                 var tongTienGiam = 0;
        //                 var tongTienTra = 0;
        //                 var ma_ban = '';
        //                 $.each(res.dataNe, function(key, value) {
        //                     content_table += '<tr>';
        //                     content_table += '<th class="text-center" scope="row">' + (key + 1) +'</th>';
        //                     content_table += '<td> ' + value.ten_san_pham +' </td>';
        //                     content_table += '<td> ' + value.don_gia + ' </td>';
        //                     content_table += '<td>';
        //                     content_table += '<input type="number" min=1 class="form-control qty" value="'+value.so_luong+'" data-id='+ value.id+'>';
        //                     content_table += '</td>';
        //                     content_table += '<td> ' + value.so_luong * value.don_gia + ' </td>';
        //                     content_table += '</td>';
        //                     content_table += '<td class="text-center">';
        //                     content_table += '<button class="btn btn-danger delete mr-1" data-iddelete="'+ value.id +'" data-toggle="modal" data-target="#deleteModal">Delete</button>';
        //                     content_table += '</td>';
        //                     content_table += '</tr>';
        //                     tongtienthuc = value.tong_tien;
        //                     tongTienTra = value.thuc_tra;
        //                     tongTienGiam = value.tien_giam_gia;
        //                     // ma_ban = value.ma_ban;
        //                 });
        //                     $("#tableBanRight tbody").html(content_table);
        //                     $("#tongTien").text(formatNumber(tongtienthuc));
        //                     $("#tongTienGiam").text(formatNumber(tongTienGiam));
        //                     $("#tongTienThucTra").text(formatNumber(tongTienTra));
        //                     // $("#maBan").text(ma_ban);
        //             }else{
        //                 toastr.error('Ngày không có');
        //             }
        //         }
        // });
        $.ajax({
            url     :   '/admin/doanh-thu/ngay-hoa-don/' + id,
            type    :   'get',
            success :   function(res) {
                if(res.status) {
                    loadtableRight(id);
                    // toastr.success("de de de");
                } else {
                    toastr.error(' Bàn không tồn tại!');
                    }
                },
        });
    });
    function formatNumber(number){
        return new Intl.NumberFormat('vi-VI', { style: 'currency', currency: 'VND' }).format(number);
    }
    $("#searchNhanVien").keyup(function(){
                var search = $("#searchNhanVien").val();
                var ngay_hoa_don    = $("#ngay_hoa_don").val();
                $payload = {
                    'tenNhanVien': search,
                    'ngay_hoa_don'  : ngay_hoa_don,
                };
                $.ajax({
                    url: '/admin/doanh-thu/search',
                    type: 'post',
                    data: $payload,
                    success: function (res) {
                        var html = '';

                    $.each(res.dataProduct , function(key, value) {

                        html += '<tr>';
                        html += '<th scope="row">' + (key + 1) + '</th>';
                        html += '<td>';
                        html += '<button class="btn btn-primary date" data-idNgay=' + value.id + '>' + value.ngay_hoa_don + '  bàn  ' + value.ma_ban + '</button>'
                        html += '</td>';
                        html += '<td>' + value.ho_va_ten + '</td>';
                        html += '<td class="text-center">';
                        html += '<button class="btn btn-danger mr-1 show" data-idshow="'+ value.id +'" data-toggle="modal" >Xem</button>';
                        html += '</td>';
                        html += '</tr>';
                    });
                    $("#creatNgayHD tbody").html(html);
                    }

                });
    });
    $("body").on('change', '.qty', function(){
            var payload = {
                'id'       :   $(this).data('id'),
                'so_luong' :   $(this).val(),
            };

            $.ajax({
                url     :   '/admin/doanh-thu/updateqty',
                type    :   'post',
                data    :   payload,
                success :   function(res) {
                    if(res.status == false) {
                        toastr.error('Cập nhật thất bại số lượng lớn hơn 1');

                    } else {
                        toastr.success("Đã cập nhật số lượng sản phẩm!");
                        loadtableRight(res.kho_hang.hoa_don_id);
                    }

                },
                error   :   function(res) {
                    var listError = res.responseJSON.errors;
                    $.each(listError, function(key, value) {
                        toastr.error(value[0]);
                    });
                },
            });
    });
    $('body').on('click','.delete',function(){
            var getId = $(this).data('iddelete');
            $("#idDeleteSanPham").val(getId);
    });

    $("#accpectDelete").click(function(){
        var id = $("#idDeleteSanPham").val();
        $.ajax({
            url     :   '/admin/doanh-thu/delete/' + id,
            type    :   'get',
            success :   function(res) {
                if(res.status) {
                    toastr.success('Đã xóa sản phẩm thành công!');
                    loadtableRight(res.kho_hang.hoa_don_id);
                } else {
                    toastr.error('sản phẩm không tồn tại!');
                }
            },
        });
    });
    $('body').on('click','#inBill',function(){
        var id = $("#id_ban_thanh_toan").val();
        // console.log(id);
            $.ajax({
                url     :'/admin/doanh-thu/in-bill/'+ id,
                type    : 'post',
                success : function(res) {
                    if(res.status == 1){
                        toastr.success("Đã in bill thành công!");
                        loadTableRight();
                    }else{
                        toastr.warning("Bill Rỗng !")
                    }
                    },
                });
    })
});
</script>
@endsection
