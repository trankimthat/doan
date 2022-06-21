@extends('admin.master')
@section('content')
<div class="row" >
    <div class="col-md-6" >
        <div class="main-card mb-3 card">
            <div class="card-body">
            <div class="row" id="tableBanLeft">
            </div>
            </div>
        </div>
    </div>
    <div class="col-md-6" >
        <div class="main-card mb-3 card">
            <div class="card-body" style="text-align: center"><h5 class="card-title">HÓA ĐƠN</h5>
                <table class="mb-0 table table-bordered" id="tableBanRight">
                    <thead>
                        <tr>
                            <th class="text-center">Tên sản phẩm</th>
                            <th class="text-center">Gía tiền</th>
                            <th class="text-center">Số Lượng</th>
                            <th class="text-center">Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>


                    </tbody>

                </table>
                <div style="text-align: right" class="col-md-12 col-sm-12">
                    <div class="cart_totals float-md-right text-md-right">
                        <h2>Cart Totals</h2>
                        <div id="price " style="margin-bottom: 20px; font-size: 30px">
                          <span>Tổng tiền hàng: <span id="tongTien" class="text-danger font-weight-bold"></span></span>
                        </div>

                        <div id="price " style="margin-bottom: 20px; font-size: 30px">
                            <span>Tổng tiền giảm: <span id="tongTienGiam" class="text-danger font-weight-bold"></span></span>
                        </div>
                        <div id="price " style="margin-bottom: 20px; font-size: 30px">
                            <span>Tổng tiền thực trả: <span id="tongTienThucTra" class="text-danger font-weight-bold"></span></span>
                        </div>
                        <div class="wc-proceed-to-checkout">
                            <a id="creatHoaDon" class="btn btn-danger " href="#" >INVOICE</a>
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
                    url     :   '/admin/ban/data',
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
                            content_table += '<div class="row col-md-3 ">'
                            content_table += '<div class="col-md-12">';
                            content_table += '<div class="card bg-primary text-white">';
                            content_table += '<div class="card-body text-center">';
                            // content_table += '<a href="/home-page/'+ value.id +'" class="table" style="font-size: 50px">';
                            content_table += '<a data-id="'+ value.id +'" class="table" style="font-size: 50px">';
                            content_table += '<b>'+ value.ma_ban +'</b>';
                            content_table += '</a>';
                            content_table += '</div>';
                            content_table += '</div>';
                            content_table += '</div>';
                            // content_table += '</div>';
                            content_table += '<div class = "row col-md-12"'
                            content_table += '<div class="text-center">';
                            content_table += '<button data-id="'+ value.id +'" class="doiTrangThai btn '+ class_button +'">';
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
            function loadTableRight(){
                $.ajax({
                    url     :   '/admin/hoa-don/data',
                    type    :   'get',
                    success :   function(res) {
                        var content_table = '';
                        $.each(res.dulieu, function(key, value) {
                        content_table += '<tr>';
                        // content_table += '<th class="text-center" scope="row">' + (key + 1) +'</th>';
                        content_table += '<td> ' + value.ten_san_pham +' </td>';
                        content_table += '<td> ' + value.don_gia + ' </td>';
                        content_table += '<td> ' + value.so_luong + ' </td>';
                        content_table += '<td class="text-center">';
                        content_table += '<button class="btn btn-danger delete mr-1" data-iddelete="'+ value.id +'" data-toggle="modal" data-target="#deleteModal">Delete</button>';
                        content_table += '<button class="btn btn-primary edit mr-1" data-idedit=' + value.id + ' data-toggle="modal" data-target="#editModal">Edit</button>';
                        content_table += '</td>';
                        content_table += '</tr>';
                        });
                        $("#tableBanRight").html(content_table);
                    }
                });
            }
            loadTableRight();
            $('body').on('click','.doiTrangThai',function(){
            var idBan = $(this).data('id');
            var self = $(this);
            $.ajax({
                url     :     '/admin/ban/doi-trang-thai/' + idBan,
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
        });
  </script>
@endsection

