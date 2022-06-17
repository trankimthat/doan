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
            <div class="card-body"><h5 class="card-title">Table Bàn</h5>
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
@section('js')
<script>
        $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function toSlug(str) {
            str = str.toLowerCase();
            str = str
                .normalize('NFD')
                .replace(/[\u0300-\u036f]/g, '');
            str = str.replace(/[đĐ]/g, 'd');
            str = str.replace(/([^0-9a-z-\s])/g, '');
            str = str.replace(/(\s+)/g, '-');
            str = str.replace(/-+/g, '-');
            str = str.replace(/^-+|-+$/g, '');
            return str;
        }
        function loadTable(){
            $.ajax({
                url     :   '/admin/hoa-don/data',
                type    :   'get',
                success :   function(res) {
                    var content_table = '';

                    $.each(res.dulieu, function(key, value) {
                        content_table += '<tr>';
                        content_table += '<th class="text-center" scope="row">' + (key + 1) +'</th>';
                        content_table += '<td> ' + value.ten_san_pham +' </td>';
                        content_table += '<td> ' + value.so_luong +' </td>';
                        content_table += '<td> ' + value.don_gia +' </td>';
                        content_table += '<td> ' + formatNumber(value.so_luong * value.don_gia) +' </td>';
                        content_table += '<td class="text-center">';
                        content_table += '<button class="btn btn-danger delete mr-1" data-iddelete="'+ value.id +'" data-toggle="modal" data-target="#deleteModal">Delete</button>';
                        content_table += '</td>';
                        content_table += '</tr>';
                    });
                    $("#tableHoaDon tbody").html(content_table);
                    console.log(html);
                },
            })
        }
        loadTable();
    });
</script>
@endsection
