@extends('home_page_new.master')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="card-body" style="text-align: center"><h3 class="card-title">Danh Sách Oder Sản Phẩm</h3>
                <table class="mb-0 table table-bordered" id="tableNhanVien">
                    <thead>
                        <tr>
                            <th class="text-center">Image</th>
                            <th class="text-center">Tên Sản Phẩm</th>
                            <th class="text-center">Gía</th>
                            <th class="text-center">Số Lượng</th>
                            <th class="text-center">Tổng cộng</th>
                            <th class="text-center">Remove</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="row">
        <!-- Cart Button Start -->
         {{-- <div class="col-md-8 col-sm-12">

         </div> --}}
         <!-- Cart Button Start -->
         <!-- Cart Totals Start -->
         <div style="text-align: right" class="col-md-12 col-sm-12">
             <div class="cart_totals float-md-right text-md-right">
                 <h2>Cart Totals</h2>
                 <div id="price " style="margin-bottom: 20px; font-size: 30px">
                    <span>Tổng tiền Thực: <span id="tongTienThuc" class="text-danger font-weight-bold"></span></span>
                  </div>
                  <div id="price " style="margin-bottom: 20px; font-size: 30px">
                    <span>Tổng tiền giảm: <span id="tongTienGiam" class="text-danger font-weight-bold"></span></span>
                </div>
                 <div id="price " style="margin-bottom: 20px; font-size: 30px">
                   <span>Tổng tiền trả: <span id="tongTien" class="text-danger font-weight-bold"></span></span>
                 </div>

                 {{-- <table style="text-align: right" class="float-md-right">
                     <tbody>
                         <tr class="order-total">
                             <th>Total</th>
                             <td>
                                 <strong><span class="amount"> 0đ</span></strong>
                             </td>
                         </tr>
                     </tbody>
                 </table> --}}
                 <div class="wc-proceed-to-checkout">
                     <a id="creatHoaDon" class="btn btn-danger " href="#" >Proceed to Checkout</a>
                 </div>
             </div>
         </div>
         <!-- Cart Totals End -->
    </div>
</div>
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
<script>
    $(document).ready(function() {
        console.log(123);
        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        function loadTable(){
            var url = window.location.pathname;
            var id = url.substr(11);
            $.ajax({
                url     :   '/user/cart/data/'+ id ,
                type    :   'get',
                success :   function(res) {
                    var content_table = '';
                    var tongtien = 0;
                    var tongTienThuc = 0;
                    var tienGiam = 0;
                    $.each(res.data, function(key, value) {
                        content_table += '<tr class="align-middle">';
                        content_table += '<td><img style="height: 100px" src="'+value.anh_dai_dien+'" alt=""></td>';
                        content_table += '<td> ' + value.ten_san_pham +' </td>';
                        content_table += ' <td class="product-price">';
                        content_table += ' <span class="amount">'+ value.don_gia +'</span>';
                        content_table += ' </td>';
                        content_table += '<td>';
                        content_table += '<input type="number" min=1 class="form-control qty" value="'+value.so_luong+'" data-id='+ value.id+'>';
                        content_table += '</td>';
                        content_table += '<td >'+ formatNumber(value.so_luong * value.don_gia) +'</td>';
                        content_table += '<td class="text-center">';
                        content_table += '<button class="btn btn-danger delete mr-1" data-iddelete="'+ value.id +'" data-toggle="modal" data-target="#deleteModal">Delete</button>';
                        content_table += '</td>';
                        content_table += '</tr>';
                        tongtien    = tongtien + value.so_luong * value.don_gia;
                        tongTienThuc =  tongTienThuc + value.gia_ban * value.so_luong;
                        tienGiam = tongTienThuc - tongtien;
                    });
                    $("#tableNhanVien tbody").html(content_table);
                    $("#tongTien").text(formatNumber(tongtien));
                    $("#tongTienThuc").text(formatNumber(tongTienThuc));
                    $("#tongTienGiam").text(formatNumber(tienGiam));
                },

            });
        }
        loadTable();
        function formatNumber(number)
        {
            return new Intl.NumberFormat('vi-VI', { style: 'currency', currency: 'VND' }).format(number);
        }
        $("body").on('change', '.qty', function(){

            var payload = {
                'id'       :   $(this).data('id'),
                'so_luong' :   $(this).val(),
            };

            $.ajax({
                url     :   '/user/updateqty',
                type    :   'post',
                data    :   payload,
                success :   function(res) {
                    if(res.status == false) {
                        toastr.error('Cập nhật thất bại số lượng lớn hơn 0');
                        loadTable();
                    } else {
                        toastr.success("Đã cập nhật số lượng sản phẩm!");
                        loadTable();
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
            $("#idDelete").val(getId);
        });
        $("#accpectDelete").click(function(){
            // var a = [
            //     'id'   : $("#idDelete").val(),
            // ]
            var id = $("#idDelete").val();
            $.ajax({
                url     :   '/user/remove-cart/' + id,
                type    :   'get',
                success :   function(res) {
                    if(res.status) {
                        toastr.success('Đã xóa  thành công!');
                        loadTable();
                    } else {
                        toastr.error('không tồn tại!');
                    }
                },
            });
        });
        $("#creatHoaDon").click(function(){
            var url = window.location.pathname;
            var id = url.substr(11);
            $.ajax({
                url     :'/user/create-bill/'+ id,
                type    : 'get',
                success : function(res) {
                    if(res.status == 1){
                        toastr.success("Đã tạo đơn hàng thành công!");
                        loadTable();
                    }else if(res.status == 0){
                        toastr.success("có lỗi xãy ra");

                    }else{
                        toastr.warning("giỏ hàng bị rỗng !")
                    }
                },
            });
        });
    });
</script>
@endsection
