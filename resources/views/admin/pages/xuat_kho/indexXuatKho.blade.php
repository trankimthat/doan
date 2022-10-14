@extends('admin.master')
@section('title')
<div style="text-align: center">
    <h3 style="color: red">Quản Lý Xuất Kho</h3>
</div>
@endsection
@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="table-response">
            <div class="main-card mb-3 card">
                <div class="card-body"><h5 class="card-title">Table bordered</h5>
                    <table class="mb-0 table table-bordered" id="tableBenTrai">
                        <thead>
                        <tr>
                            <th class="text-nowrap text-center">#</th>
                            <th class="text-nowrap text-center">Tên Nguyên Liệu</th>
                            <th class="text-nowrap text-center">Số Lượng</th>
                            <th class="text-nowrap text-center">Đơn Vị</th>
                            <th class="text-nowrap text-center">Action</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header" style="height: auto">
                <h4 class="card-title">Nhập Kho Nguyên Liệu</h4>
                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                <div class="heading-elements">
                    <ul class="list-inline mb-0">
                        <li><a data-action="collapse"><i class="feather icon-minus"></i></a></li>
                        <li><a data-action="reload"><i class="feather icon-rotate-cw"></i></a></li>
                        <li><a data-action="expand"><i class="feather icon-maximize"></i></a></li>
                        <li><a data-action="close"><i class="feather icon-x"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="card-content collapse show">
                <div class="card-body">
                    <table class="table table-bordered mb-0" id="tableXuatBenPhai">
                        <thead>
                            <tr class="text-center">
                                <th class="text-center">#</th>
                                <th class="text-center">Tên Nguyên Liệu</th>
                                <th class="text-center">Số Lượng</th>
                                <th class="text-center">Đơn Vị</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
            <button id="creatXuatKho" class="m-1 btn btn-primary">Xuất Kho</button>
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
            <input type="text" class="form-control" placeholder="Nhập vào id cần xóa" id="idDeleteDanhMuc" hidden>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" id="accpectDelete" class="btn btn-danger" data-dismiss="modal">Xóa Nguyên Liệu</button>
        </div>
      </div>
    </div>
</div>
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

            function tableBenTrai(){
                $.ajax({
                    url     :   '/admin/xuat-kho/data',
                    type    :   'get',
                    success :   function(res) {

                        var html = '';

                        $.each(res.data, function(key, value) {

                            html += '<tr>';
                            html += '<th scope="row">' + (key + 1) + '</th>';
                            html += '<td>' + value.ten_nguyen_lieu + '</td>';
                            html += '<td>' + value.so_luong + '</td>';
                            html += '<td>' + value.don_vi + '</td>';
                            html += '<td>';
                            html += '<button data-idadd="' + value.id + '" class="btn btn-info btn-sm add">Add</button>';
                            html += '</td>';
                            html += '</tr>';
                        });
                        $("#tableBenTrai tbody").html(html);
                        // console.log(html);
                    },
                });
            }
            tableBenTrai();
            function tableBenPhai(){
                $.ajax({
                    url     :   '/admin/xuat-kho/data/table-xuat',
                    type    :   'get',
                    success :   function(res) {
                        var html = '';

                        $.each(res.xuatKho, function(key, value) {

                            html += '<tr>';
                            html += '<th scope="row">' + (key + 1) + '</th>';

                            html += '<td>' + value.ten_nguyen_lieu + '</td>';
                            html += '<td>';
                            html += '<input type="number" min=1 class="form-control qty" value="'+value.so_luong+'" data-id='+ value.id+'>';
                            html += '</td>';
                            html += '<td>' + value.don_vi + '</td>';
                            html += '<td>';
                            html += '<button class="btn btn-danger delete mr-1" data-iddelete="'+ value.id +'" data-toggle="modal" data-target="#deleteModal">Delete</button>';
                            html += '</td>';
                            html += '</tr>';
                        });
                        $("#tableXuatBenPhai tbody").html(html);

                    },
                });
            }
            tableBenPhai();
            $('body').on('click', '.add', function(){
                var id_nguyen_lieu = $(this).data('idadd');
                var payload = {
                    'id_nguyen_lieu'   :   id_nguyen_lieu,
                };
                $.ajax({
                    url     :   '/admin/xuat-kho/create',
                    type    :   'post',
                    data    :   payload,
                    success :   function(res) {
                        if(res.hihi){
                            toastr.success("Đã thêm danh muc !");
                            tableBenPhai();

                        }else{
                            toastr.error('Số lương lớn hơn Kho');
                        }
                    },
                    // error   :   function(res) {
                    //     var listError = res.responseJSON.errors;
                    //     $.each(listError, function(key, value) {
                    //         toastr.error(value[0]);
                    //     });
                    // },
                });
            });
            $('body').on('click','.delete',function(){
                var getId = $(this).data('iddelete');
                $("#idDeleteDanhMuc").val(getId);
            });
            $("#accpectDelete").click(function(){
                var id = $("#idDeleteDanhMuc").val();
                $.ajax({
                    url     :   '/admin/xuat-kho/delete/' + id,
                    type    :   'get',
                    success :   function(res) {
                        if(res.status) {
                            toastr.success('Đã xóa danh mục thành công!');
                            tableBenPhai()
                        } else {
                            toastr.error('Danh mục không tồn tại!');
                        }
                    },
                });
            });
            $("body").on('change', '.qty', function(){
                var payload = {
                    'id'       :   $(this).data('id'),
                    'so_luong' :   $(this).val(),
                };

                $.ajax({
                    url     :   '/admin/xuat-kho/updateqty',
                    type    :   'post',
                    data    :   payload,
                    success :   function(res) {
                        if(res.status == false) {
                            toastr.error('Cập nhật thất bại số lượng nhỏ hơn kho');
                            tableBenPhai();
                        } else {
                            toastr.success("Đã cập nhật số lượng sản phẩm!");
                            tableBenPhai();
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
            $('#creatXuatKho').click(function() {
                $.ajax({
                    url: '/admin/xuat-kho/create-xuat-kho',
                    type: 'get',
                    success: function (res) {
                        if(res.status){
                            toastr.success("Đã xuất kho thành công !");
                            tableBenPhai();
                            tableBenTrai();
                        }else{
                            toastr.error("Xuất kho không thành công !");

                        }
                    },

                });
            });
        });
    </script>
@endsection

