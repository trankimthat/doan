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
                <div  style="overflow: scroll;">
                    <table class="table" id="creatNgayHD" >
                        <thead>
                            <tr>
                                <th scope="col" class="text-nowrap">#</th>
                                <th scope="col" class="text-nowrap">Ngày Hóa Đơn</th>
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
    // function loadTableRight(id){
    //             $.ajax({
    //                 url     :   '/admin/doanh-thu/data/'+ id,
    //                 type    :   'get',
    //                 success :   function(res) {
    //                     var content_table = '';
    //                     var tongtienthuc = 0;
    //                     var tongTienGiam = 0;
    //                     var tongTienTra = 0;
    //                     var ma_ban = '';
    //                     $("#id_ban_thanh_toan").val(id);
    //                     $.each(res.dulieu, function(key, value) {
    //                     content_table += '<tr>';
    //                     content_table += '<th class="text-center" scope="row">' + (key + 1) +'</th>';
    //                     content_table += '<td> ' + value.ten_san_pham +' </td>';
    //                     content_table += '<td> ' + value.don_gia + ' </td>';
    //                     content_table += '<td> ' + value.so_luong + ' </td>';
    //                     content_table += '<td> ' + value.so_luong * value.don_gia + ' </td>';
    //                     content_table += '</td>';
    //                     content_table += '</tr>';
    //                     tongtienthuc = value.tong_tien;
    //                     tongTienTra = value.thuc_tra;
    //                     tongTienGiam = value.tien_giam_gia;
    //                     ma_ban = value.ma_ban;
    //                     });
    //                     $("#tableBanRight tbody").html(content_table);
    //                     $("#tongTien").text(formatNumber(tongtienthuc));
    //                     $("#tongTienGiam").text(formatNumber(tongTienGiam));
    //                     $("#tongTienThucTra").text(formatNumber(tongTienTra));
    //                     $("#maBan").text(ma_ban);
    //                 }
    //         });
    // }

});
</script>
@endsection
