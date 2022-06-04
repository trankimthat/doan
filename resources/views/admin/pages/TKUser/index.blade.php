@extends('admin.master')
@section('title')
{{-- <div class="page-title-icon">
    <i class="pe-7s-car icon-gradient bg-mean-fruit"></i>
</div> --}}
{{-- <div style="text-align: center">
    <b> Quản Lý Nhân </b>
</div> --}}
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="main-card mb-3 card">
                <div class="card-body" style="text-align: center"><h5 class="card-title">Table Quản Lý Nhân Viên</h5>
                    <table class="mb-0 table table-bordered" id="tableNhanVien">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Họ Và Tên</th>
                                <th class="text-center">Số Điện Thoại</th>
                                <th class="text-center">Email</th>
                                <th class="text-center">Địa Chỉ</th>
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
          <h5 class="modal-title">Xóa Tài Khoản</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            Bạn có chắc chắn muốn xóa? Điều này không thể hoàn tác.
            <input type="text" class="form-control" placeholder="Nhập vào id cần xóa" id="idDeleteUser" hidden>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" id="accpectDelete" class="btn btn-danger" data-dismiss="modal">Xóa </button>
        </div>
      </div>
    </div>
</div>
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Chỉnh Sửa Tài Khoản Nhân Viên</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <input type="text" id="id_edit" hidden>
            <div class="position-relative form-group">
                <label>Họ Và Tên</label>
                <input id="ho_va_ten_edit" placeholder="Nhập vào họ và tên" type="text" class="form-control">
            </div>
            <div class="position-relative form-group">
                <label>Số Điện Thoại</label>
                <input id="so_dien_thoai_edit" placeholder="Nhập vào số điện thoại" type="text" class="form-control">
            </div>
            <div class="position-relative form-group">
                <label>Email</label>
                <input id="email_edit" placeholder="Nhập vào email" type="text" class="form-control">
            </div>
            <div class="position-relative form-group">
                <label>Password</label>
                <input id="password_edit" placeholder="Nhập vào password" type="password" class="form-control">
            </div>
            <div class="position-relative form-group">
                <label>Địa Chỉ</label>
                <input id="dia_chi_edit" placeholder="Nhập vào địa chỉ" type="text" class="form-control">
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
          <button type="button" id="accpectUpdate" class="btn btn-success">Cập Nhật </button>
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
    function loadTable(){
        $.ajax({
                url     :   '/admin/user/dulieu',
                type    :   'get',
            success :   function(res) {
                    var content_table = '';
                    $.each(res.dulieuNhanVien, function(key, value) {
                    if(value.is_open) {
                            var class_button = 'btn-primary';
                            var text_button  = 'Hiển thị';
                    } else {
                            var text_button  = 'Tạm tắt';
                            var class_button = 'btn-danger';
                    }
                        content_table += '<tr>';
                        content_table += '<th class="text-center" scope="row">' + (key + 1) +'</th>';
                        content_table += '<td> ' + value.ho_va_ten +' </td>';
                        content_table += '<td> ' + value.so_dien_thoai +' </td>';
                        content_table += '<td> ' + value.email +' </td>';
                        content_table += '<td> ' + value.dia_chi +' </td>';
                        content_table += '<td class="text-center">';
                        content_table += '<button data-id="'+ value.id +'" class="doiTrangThai btn '+ class_button +'">';
                        content_table +=  text_button;
                        content_table += '</button></td>';
                        content_table += '<td class="text-center">';
                        content_table += '<button class="btn btn-danger delete mr-1" data-iddelete="'+ value.id +'" data-toggle="modal" data-target="#deleteModal">Delete</button>';
                        content_table += '<button class="btn btn-primary edit mr-1" data-idedit=' + value.id + ' data-toggle="modal" data-target="#editModal">Edit</button>';
                        content_table += '</td>';
                        content_table += '</tr>';
                    });
                    $("#tableNhanVien tbody").html(content_table);
            },
        });
    }
    loadTable();
    $('body').on('click','.doiTrangThai',function(){
            var idUser = $(this).data('id');
            var self = $(this);
            $.ajax({
                url     :     '/admin/user/doi-trang-thai/' + idUser,
                type    :     'get',
                success :     function(res) {
                    if(res.trangThai) {
                        toastr.success('Đã đổi trạng thái thành công!');
                        // Tình trạng mới là true
                        // loadTable();
                        if(res.tinhTrangUser == true){
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
            $("#idDeleteUser").val(getId);
        });

        $("#accpectDelete").click(function(){
            var id = $("#idDeleteUser").val();
            $.ajax({
                url     :   '/admin/user/delete/' + id,
                type    :   'get',
                success :   function(res) {
                    if(res.status) {
                        toastr.success('Đã xóa tài khoản thành công!');
                        loadTable();
                    } else {
                        toastr.error('Tài khoản không tồn tại!');
                    }
                },
            });
        });
        $('body').on('click','.edit',function(){
            var id = $(this).data('idedit');
            $.ajax({
                url     :   '/admin/user/edit/' + id,
                type    :   'get',
                success :   function(res) {
                    if(res.status) {
                        $("#ho_va_ten_edit").val(res.data.ho_va_ten);
                        $("#so_dien_thoai_edit").val(res.data.so_dien_thoai);
                        $("#email_edit").val(res.data.email);
                        // $("#password_edit").val(res.data.password);
                        $("#dia_chi_edit").val(res.data.dia_chi);
                        $("#is_open_edit").val(res.data.is_open);
                        $("#id_edit").val(res.data.id);
                    } else {
                        toastr.error('Tài khoản nhân viên không tồn tại!');
                        window.setTimeout(function() {
                            $('#closeModal').click();
                        }, 1000 );
                    }
                },
            });
        });

        $("#accpectUpdate").click(function(){
            var val_ho_va_ten       = $("#ho_va_ten_edit").val();
            var val_so_dien_thoai   = $("#so_dien_thoai_edit").val();
            var val_email           = $("#email_edit").val();
            var val_password        = $("#password_edit").val();
            var val_dia_chi         = $("#dia_chi_edit").val();
            var val_is_open         = $("#is_open_edit").val();
            var val_id              = $("#id_edit").val();

            var payload = {
                'ho_va_ten'         :   val_ho_va_ten,
                'so_dien_thoai'     :   val_so_dien_thoai,
                'email'             :   val_email,
                'password'          :   val_password,
                'dia_chi'           : val_dia_chi,
                'is_open'           :   val_is_open,
                'id'                :   val_id,
            };

            // Gửi payload lên trên back-end bằng con đường ajax
            $.ajax({
                url     :   '/admin/user/update',
                type    :   'post',
                data    :   payload,
                success :   function(res) {
                    if(res.status) {
                        toastr.success('Tài khoản nhân viên đã được cập nhật!');
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
