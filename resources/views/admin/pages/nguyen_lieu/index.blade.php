@extends('admin.master')
@section('title')
    <h3>Quản Lý Nguyên Liệu</h3>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-5">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <h5 class="card-title">Thêm Mới Nguyên Liệu</h5>
                    <form autocomplete="off" id="createNguyenLieu">
                        <div class="position-relative form-group">
                            <label>Tên Nguyên Liệu</label>
                            <input id="ten_nguyen_lieu"  name="ten_nguyen_lieu" placeholder="Nhập vào tên nguyên liệu" type="text" class="form-control">
                        </div>
                        <div class="position-relative form-group">
                            <label>Slug Danh Mục</label>
                            <input id="slug_nguyen_lieu" name="slug_nguyen_lieu" placeholder="Nhập vào slug nguyên liệu" type="text" class="form-control">
                        </div>
                        <div class="position-relative form-group">
                            <label>Đơn Vị</label>
                            <input id="don_vi"   placeholder="Nhập vào đơn vị" type="text" class="form-control">
                        </div>
                        <div class="position-relative form-group">
                            <label>Tình Trạng</label>
                            <select id="is_open"class="form-control">
                                <option value=1>Hiển Thị</option>
                                <option value=0>Tạm Tắt</option>
                            </select>
                        </div>
                        <button class="mt-1 btn btn-primary" id="themNguyenLieu">Thêm Mới Nguyên Liệu</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="main-card mb-3 card">
                <div class="card-body"><h5 class="card-title">Table Nguyên Liệu</h5>
                    <table class="mb-0 table table-bordered" id="tableBan">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Tên Nguyên Liệu</th>
                                <th class="text-center">Đơn Vị</th>
                                <th class="text-center">Tình Trạng</th>
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
          <h5 class="modal-title">Xóa Nguyên Liệu</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            Bạn có chắc chắn muốn xóa? Điều này không thể hoàn tác.
            <input type="text" class="form-control" placeholder="Nhập vào id cần xóa" id="idDeleteNL" hidden>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" id="accpectDelete" class="btn btn-danger" data-dismiss="modal">Xóa Nguyên Liệu</button>
        </div>
      </div>
    </div>
</div>
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Chỉnh Sửa Nguyên Liệu</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <input type="text" id="id_edit" hidden>
            <div class="position-relative form-group">
                <label>Tên Nguyên Liệu</label>
                <input id="ten_nguyen_lieu_edit" placeholder="Nhập vào tên nguyên liệu" type="text" class="form-control">
            </div>
            <div class="position-relative form-group">
                <label>Slug Nguyên Liệu</label>
                <input id="slug_nguyen_lieu_edit" placeholder="Nhập vào slug nguyên liệu" type="text" class="form-control">
            </div>
            <div class="position-relative form-group">
                <label>Đơn Vị</label>
                <input id="don_vi_edit" placeholder="Nhập vào tên nguyên liệu" type="text" class="form-control">
            </div>
            <div class="position-relative form-group">
                <label>Tình Trạng</label>
                <select id="is_open_edit"class="form-control">
                    <option value=1>Hiển Thị</option>
                    <option value=0>Tạm Tắt</option>
                </select>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" id="closeModalUpdate" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" id="accpectUpdate" class="btn btn-success">Cập Nhật Nguyên Liệu</button>
        </div>
      </div>
    </div>
</div>
@section('js')
    <script>
         $(document).ready(function(){
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
        $("#ten_nguyen_lieu").keyup(function(){
            var tenNguyenLieu = $("#ten_nguyen_lieu").val();
            var slugNguyenLieu = toSlug(tenNguyenLieu);
            $("#slug_nguyen_lieu").val(slugNguyenLieu);
        });
        function loadTable(){
            $.ajax({
                url     :   '/admin/nguyen-lieu/data',
                type    :   'get',
                success :   function(res) {
                    var content_table = '';
                    $.each(res.dulieu, function(key, value) {
                        if(value.is_open) {
                            var class_button = 'btn-primary';
                            var text_button  = 'Hiển thị';
                        } else {
                            var text_button  = 'Tạm tắt';
                            var class_button = 'btn-danger';
                        }
                        content_table += '<tr>';
                        content_table += '<th class="text-center" scope="row">' + (key + 1) +'</th>';
                        content_table += '<td> ' + value.ten_nguyen_lieu +' </td>';
                        content_table += '<td> ' + value.don_vi +' </td>';
                        content_table += '<td class="text-center">';
                        content_table += '<button data-id="'+ value.id +'" class="doiTrangThai btn '+ class_button +'">';
                        content_table +=  text_button;
                        content_table += '</button></td>';
                        content_table += '<td ">';
                        content_table += '<button class="btn btn-danger delete mr-1" data-iddelete="'+ value.id +'" data-toggle="modal" data-target="#deleteModal">Delete</button>';
                        content_table += '<button class="btn btn-primary edit delete mr-1" data-idEdit="'+ value.id +'" data-toggle="modal" data-target="#editModal">Edit</button>';
                        content_table += '</td>';
                        content_table += '</tr>';
                    });
                    $("#tableBan tbody").html(content_table);
                },
            });
        }
        loadTable();
        $("#themNguyenLieu").click(function(e){
            e.preventDefault();
            var val_ten_nguyen_lieu          = $("#ten_nguyen_lieu").val();
            var val_slug_nguyen_lieu         = $("#slug_nguyen_lieu").val();
            var val_don_vi                   = $("#don_vi").val();
            var val_is_open                  = $("#is_open").val();

            var payload = {
                'ten_nguyen_lieu'            :   val_ten_nguyen_lieu,
                'slug_nguyen_lieu'           :   val_slug_nguyen_lieu,
                'don_vi'                     :   val_don_vi,
                'is_open'                    :   val_is_open,
            };

            $.ajax({
                url     :   '/admin/nguyen-lieu/index',
                type    :   'post',
                data    :    payload,
                success :    function(res) {
                    toastr.success("Đã thêm mới danh mục thành công!");
                    loadTable();
                     $('#createNguyenLieu').trigger("reset");

                },
                error   :    function(res) {
                    var danh_sach_loi = res.responseJSON.errors;
                    $.each(danh_sach_loi, function(key, value){
                        toastr.error(value[0]);
                    });
                }
            });
        });
        $('body').on('click','.doiTrangThai',function(){
            var idNguyenLieu = $(this).data('id');
            var self = $(this);
            $.ajax({
                url     :     '/admin/nguyen-lieu/doi-trang-thai/' + idNguyenLieu,
                type    :     'get',
                success :     function(res) {
                    if(res.trangThai) {
                        toastr.success('Đã đổi trạng thái thành công!');
                        // Tình trạng mới là true
                        // loadTable();
                        if(res.tinhTrangNL == true){
                            self.html('Hiển Thị');
                            self.removeClass('btn-danger');
                            self.addClass('btn-primary');
                        } else {
                            self.html('Tạm Tắt');
                            self.removeClass('btn-primary');
                            self.addClass('btn-danger');
                        }
                    } else {
                        toastr.error('Vui lòng không can thiệp hệ thống!');
                    }
                },
            });
        });
        $('body').on('click','.delete',function(){
            var getId = $(this).data('iddelete');
            $("#idDeleteNL").val(getId);
        });

        $("#accpectDelete").click(function(){
            var id = $("#idDeleteNL").val();
            $.ajax({
                url     :   '/admin/nguyen-lieu/delete/' + id,
                type    :   'get',
                success :   function(res) {
                    if(res.status) {
                        toastr.success('Đã xóa danh mục thành công!');
                        loadTable();
                    } else {
                        toastr.error('Danh mục không tồn tại!');
                    }
                },
            });
        });
        $('body').on('click','.edit',function(){
            var id = $(this).data('idedit');

            $.ajax({
                url     :   '/admin/nguyen-lieu/edit/' + id,
                type    :   'get',
                success :   function(res) {
                    if(res.status) {
                        $("#ten_nguyen_lieu_edit").val(res.data.ten_nguyen_lieu);
                        $("#slug_nguyen_lieu_edit").val(res.data.slug_nguyen_lieu);
                        $("#don_vi_edit").val(res.data.don_vi);
                        $("#is_open_edit").val(res.data.is_open);
                        $("#id_edit").val(res.data.id);
                    } else {
                        toastr.error('Danh mục sản phẩm không tồn tại!');
                        window.setTimeout(function() {
                            $('#closeModal').click();
                        }, 1000 );
                    }
                },
            });
        });
        $("#ten_nguyen_lieu_edit").keyup(function(){
            var tenNguyenLieuEdit = $("#ten_nguyen_lieu_edit").val();
            var slugNguyenLieuEdit = toSlug(tenNguyenLieuEdit);
            $("#slug_nguyen_lieu_edit").val(slugNguyenLieuEdit);
        });
        $("#accpectUpdate").click(function(){
            var val_ten_nguyen_lieu    = $("#ten_nguyen_lieu_edit").val();
            var val_slug_nguyen_lieu   = $("#slug_nguyen_lieu_edit").val();
            var val_don_vi             = $("#don_vi_edit").val();
            var val_is_open            = $("#is_open_edit").val();
            var val_id                 = $("#id_edit").val();
            var payload = {
                'ten_nguyen_lieu'      :   val_ten_nguyen_lieu,
                'slug_nguyen_lieu'     :   val_slug_nguyen_lieu,
                'don_vi'               :   val_don_vi,
                'is_open'              :   val_is_open,
                'id'                   :   val_id,
            };


            // Gửi payload lên trên back-end bằng con đường ajax
            $.ajax({
                url     :   '/admin/nguyen-lieu/update',
                type    :   'post',
                data    :   payload,
                success :   function(res) {
                    if(res.status) {
                        toastr.success('Danh mục sản phẩm đã được cập nhật!');
                        $('#closeModalUpdate').click();
                        loadTable();
                    }
                },
                error   :   function(res) {
                    var danh_sach_loi = res.responseJSON.errors;
                    $.each(danh_sach_loi, function(key, value){
                        toastr.error(value[0]);
                    });
                },
            });
        });
    });
    </script>
@endsection
