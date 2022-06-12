@extends('admin.master')
@section('title')
<div class="page-title-icon">
    <i class="pe-7s-car icon-gradient bg-mean-fruit"></i>
</div>
<div style="text-align: center">
    <b> Quản Lý Hóa Đơn </b>
    <div class="page-title-subheading">
       <b>Sửa hóa đơn và xem hóa đơn</b>
    </div>
</div>
@endsection
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="card-body"><h5 class="card-title">Table Hóa Đơn Cafe</h5>
                <table class="mb-0 table table-bordered" id="tableHoaDon">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">Tên Sản Phẩm</th>
                            <th class="text-center">Gía</th>
                            <th class="text-center">Số Lượng</th>
                            <th class="text-center">Tổng Cộng</th>
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
@endsection
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Xóa Hóa Đơn</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            Bạn có chắc chắn muốn xóa? Điều này không thể hoàn tác.
            <input type="text" class="form-control" placeholder="Nhập vào id cần xóa" id="idDeleteDanhMuc" hidden>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" id="accpectDelete" class="btn btn-danger" data-dismiss="modal">Xóa Danh Mục</button>
        </div>
      </div>
    </div>
</div>
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Chỉnh Sửa Hóa Đơn</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <input type="text" id="id_edit" hidden>
            <div class="position-relative form-group">
                <label>Tên Sản Phẩm</label>
                <input id="ten_san_pham_edit" placeholder="Nhập vào tên danh mục" type="text" class="form-control">
            </div>
            <div class="row">
                <div class="col-md-6">
                    <fieldset class="form-group">
                        <label>Giá Bán</label>
                        <input type="number" class="form-control" id="gia_ban_edit" placeholder="Nhập vào giá bán">
                    </fieldset>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <fieldset class="form-group">
                        <label>Số Lượng</label>
                        <input type="number" class="form-control" id="so_luong_edit" placeholder="Nhập vào số lượng">
                    </fieldset>
                </div>
            </div>


        </div>
        <div class="modal-footer">
          <button type="button" id="closeModalUpdate" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" id="accpectUpdate" class="btn btn-success">Cập Nhật Danh Mục</button>
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
            $.ajax({
                url     :   '/admin/hoa-don/data',
                type    :   'get',
                success :   function(res) {
                    var html = '';
                    $.each(res.dulieu, function(key, value) {
                        html += '<tr>';
                        html += '<th scope="row">' + (key + 1) + '</th>';
                        html += '<td>' + value.ten_san_pham + '</td>';
                        html += '<td>' + value.so_luong + '</td>';
                        html += '<td>' + value.don_gia + '</td>';
                        html += '<td>' + formatNumber(value.so_luong * value.don_gia) + '</td>';
                        html += '<td>';
                        html += '<button class="btn btn-danger nutDelete mr-1" data-iddelete="' + value.id + '" data-toggle="modal" data-target="#exampleModal"> Xóa </button>';
                        html += '</td>';
                        html += '</tr>';
                    });
                    $("#tableHoaDon tbody").html(html);
                    console.log(html);
                },
            });
        }
        loadTable();
    });
</script>
@endsection
