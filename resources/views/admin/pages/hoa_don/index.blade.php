
@extends('admin.master')
@section('content')
<div class="row" >
    <div class="col-md-6" >
        <div class="main-card mb-3 card">
            <div class="card-body">
            <h5><b>BÀN</b></h5>
            <div class="row" id="tableBanLeft">
            </div>
            </div>
        </div>
    </div>
    <div class="col-md-6" >
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
    $(window).on('load',  function(){
      if (feather) {
        feather.replace({ width: 14, height: 14 });
      }
    })
  </script>
  <script>
       $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            function loadtableLeft(){
                $.ajax({
                    url     :   '/admin/hoa-don/page-ban',
                    type    :   'get',
                    success :   function(res) {
                        var content_table = '';
                        $.each(res.dulieu, function(key, value) {
                            if(value.is_open) {
                            var class_button = 'btn-primary';
                            var text_button  = 'Bàn Trống';
                            } else {
                            var text_button  = 'Bàn Đầy';
                            var class_button = 'btn-danger';
                            }
                            if(value.xuat_hoa_don){
                                var class_a = 'btn-danger';
                                var text    = 'Đã oder'
                            }else{
                                var class_a = 'btn-primary';
                                var text = 'Chưa oder';
                            }
                            content_table += '<div class="row col-md-3 ">'
                            content_table += '<div class="col-md-12">';
                            content_table += '<div class="card bg-primary text-white">';
                            content_table += '<div class="card-body text-center">';
                            content_table += '<a data-id="'+ value.id +'" class="table" style="font-size: 50px">';
                            content_table += '<b>'+ value.ma_ban +'</b>';
                            content_table += '</a>';
                            content_table += '</div>';
                            content_table += '</div>';
                            content_table += '</div>';
                            content_table += '<div class = "row col-md-12"'
                            content_table += '<div class="text-center">';
                            content_table += '<button data-idtrangthai="'+ value.id +'" class="doiTrangThai btn '+ class_button +'">';
                            content_table +=  text_button;
                            content_table += '</button></div>';
                            content_table += '</div>';
                            content_table += '</div>';
                        });
                        $("#tableBanLeft").html(content_table);
                    }
                    });
            }
            loadtableLeft();
            function loadTableRight(id){
                $.ajax({
                    url     :   '/admin/hoa-don/data/'+ id,
                    type    :   'get',
                    success :   function(res) {
                        var content_table = '';
                        var tongtienthuc = 0;
                        var tongTienGiam = 0;
                        var tongTienTra = 0;
                        var ma_ban = '';
                        $("#id_ban_thanh_toan").val(id);
                        $.each(res.dulieu, function(key, value) {
                        content_table += '<tr>';
                        content_table += '<th class="text-center" scope="row">' + (key + 1) +'</th>';
                        content_table += '<td> ' + value.ten_san_pham +' </td>';
                        content_table += '<td> ' + value.don_gia + ' </td>';
                        content_table += '<td> ' + value.so_luong + ' </td>';
                        content_table += '<td> ' + value.so_luong * value.don_gia + ' </td>';
                        content_table += '</td>';
                        content_table += '</tr>';
                        tongtienthuc = value.tong_tien;
                        tongTienTra = value.thuc_tra;
                        tongTienGiam = value.tien_giam_gia;
                        ma_ban = value.ma_ban;
                        });
                        $("#tableBanRight tbody").html(content_table);
                        $("#tongTien").text(formatNumber(tongtienthuc));
                        $("#tongTienGiam").text(formatNumber(tongTienGiam));
                        $("#tongTienThucTra").text(formatNumber(tongTienTra));
                        $("#maBan").text(ma_ban);

                    }
                });
            }

            function formatNumber(number)
            {
            return new Intl.NumberFormat('vi-VI', { style: 'currency', currency: 'VND' }).format(number);
            }
            $('body').on('click','.doiTrangThai',function(){
            var id = $(this).data('idtrangthai');
            var self = $(this);
            // console.log(id);
            $.ajax({
                url     :     '/admin/ban/doi-trang-thai/' + id,
                type    :     'get',
                success :     function(res) {
                    if(res.trangThai) {
                        toastr.success('Đã đổi trạng thái thành công!');
                        // Tình trạng mới là true
                        loadtableLeft();
                        if(res.tinhTrangDanhMuc == true){
                            self.html('Bàn Trống');
                            self.removeClass('btn-danger');
                            self.addClass('btn-primary');
                        } else {
                            self.html('Bàn Đầy');
                            self.removeClass('btn-primary');
                            self.addClass('btn-danger');
                        }
                    } else {
                        toastr.error('Vui lòng không can thiệp hệ thống!');
                    }
                },
            });
            });
            $('body').on('click','.table',function(){
                    var id = $(this).data('id');
                    $.ajax({
                        url     :   '/admin/hoa-don/ban/' + id,
                        type    :   'get',
                        success :   function(res) {
                            if(res.status) {
                                loadTableRight(id);
                            } else {
                                toastr.error(' Bàn không tồn tại!');
                            }
                        },
                    });
            });
           $('#inBill').click(function(){
            var id = $("#id_ban_thanh_toan").val();
            $.ajax({
                url     :'/admin/hoa-don/in-bill/'+ id,
                type    : 'get',
                success : function(res) {
                    if(res.status == 1){
                        toastr.success("Đã in bill thành công!");
                        loadTableRight();
                    }else{
                        toastr.warning("Bill Rỗng !")
                    }
                },
            });
           });
        });
  </script>
@endsection

