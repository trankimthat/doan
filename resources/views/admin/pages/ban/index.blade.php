@extends('admin.master')
@section('title')
<div class="page-title-icon">
    <i class="pe-7s-car icon-gradient bg-mean-fruit"></i>
</div>
<div style="text-align: center">
    <b> Quản Lý Bàn </b>

</div>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-5">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <h5 class="card-title">Thêm Mới Bàn</h5>
                    <form autocomplete="off" id="createBan">
                        <div class="position-relative form-group">
                            <label>Mã Bàn</label>
                            <input id="ma_ban"  name="ma_ban" placeholder="Nhập vào mã bàn" type="text" class="form-control">
                        </div>
                        <div class="position-relative form-group">
                            <label>Tình Trạng</label>
                            <select id="is_open"class="form-control">
                                <option value=1>Hiển Thị</option>
                                <option value=0>Tạm Tắt</option>
                            </select>
                        </div>
                        <button class="mt-1 btn btn-primary" id="themMoiBan">Thêm Mới Bàn</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="main-card mb-3 card">
                <div class="card-body"><h5 class="card-title">Table Bàn</h5>
                    <table class="mb-0 table table-bordered" id="tableBan">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Mã Bàn</th>
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
          <h5 class="modal-title">Xóa Bàn</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            Bạn có chắc chắn muốn xóa? Điều này không thể hoàn tác.
            <input type="text" class="form-control" placeholder="Nhập vào id cần xóa" id="idDeleteBan" hidden>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" id="accpectDelete" class="btn btn-danger" data-dismiss="modal">Xóa Bàn</button>
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
                url     :   '/admin/ban/data',
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
                        content_table += '<td> ' + value.ma_ban +' </td>';
                        content_table += '<td class="text-center">';
                        content_table += '<button data-id="'+ value.id +'" class="doiTrangThai btn '+ class_button +'">';
                        content_table +=  text_button;
                        content_table += '</button></td>';
                        content_table += '<td class="text-center">';
                        content_table += '<button class="btn btn-danger delete mr-1" data-iddelete="'+ value.id +'" data-toggle="modal" data-target="#deleteModal">Delete</button>';
                        content_table += '</td>';
                        content_table += '</tr>';
                    });
                    $("#tableBan tbody").html(content_table);
                },
            });
        }
        loadTable();
        $("#themMoiBan").click(function(e){
            e.preventDefault();
            var val_ma_ban          = $("#ma_ban").val();
            var val_is_open         = $("#is_open").val();

            var payload = {
                'ma_ban'            :   val_ma_ban,
                'is_open'           :   val_is_open,
            };

            $.ajax({
                url     :   '/admin/ban/index',
                type    :   'post',
                data    :    payload,
                success :    function(res) {
                    toastr.success("Đã thêm mới danh mục thành công!");
                    loadTable();
                     $('#createBan').trigger("reset");

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
            var idBan = $(this).data('id');
            var self = $(this);
            $.ajax({
                url     :     '/admin/ban/doi-trang-thai/' + idBan,
                type    :     'get',
                success :     function(res) {
                    if(res.trangThai) {
                        toastr.success('Đã đổi trạng thái thành công!');
                        // Tình trạng mới là true
                        // loadTable();
                        if(res.tinhTrangBan == true){
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
            $("#idDeleteBan").val(getId);
        });

        $("#accpectDelete").click(function(){
            var id = $("#idDeleteBan").val();
            $.ajax({
                url     :   '/admin/ban/delete/' + id,
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
    });
    </script>
@endsection

