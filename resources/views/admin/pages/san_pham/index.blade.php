@extends('admin.master')
@section('title')
<div class="page-title-icon">
    <i class="pe-7s-car icon-gradient bg-mean-fruit"></i>
</div>
<div>
    Quản Lý Sản Phẩm
    <div class="page-title-subheading">
        Thêm Mới Danh Sách Sản Phẩm và Quản Lý Các Loại Sản Phẩm
        {{-- <button class="btn btn-warning" id="nutNew"> NÚT GỌI HÀM CHO VUI</button> --}}
    </div>
</div>

@endsection
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-danger">
            <input type="text" name="" id="idCanXoa" class="form-control" hidden>
            <h5 class="modal-title text-white" id="exampleModalLabel">Xoá Sản Phẩm</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" id="taoChinhLaThangXoa" class="btn btn-danger" data-dismiss="modal">Xóa Sản Phẩm</button>
        </div>
      </div>
    </div>
</div>
<div class="modal fade text-left" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <label class="modal-title text-text-bold-600 text-white" id="myModalLabel33"><h3>Chỉnh Sửa Sản Phẩm</h3></label>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <fieldset class="form-group">
                                        <label>Tên Sản Phẩm</label>
                                        <input type="text" class="form-control" id="ten_san_pham_edit" placeholder="Nhập vào tên sản phẩm">
                                        <input type="number" class="form-control" id="id_edit" hidden>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <fieldset class="form-group">
                                        <label>Slug Sản Phẩm</label>
                                        <input type="text" class="form-control" id="slug_san_pham_edit" placeholder="Nhập vào slug sản phẩm">
                                    </fieldset>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <fieldset class="form-group">
                                        <label>Giá Bán</label>
                                        <input type="number" class="form-control" id="gia_ban_edit" placeholder="Nhập vào giá bán">
                                    </fieldset>
                                </div>
                                <div class="col-md-6">
                                    <fieldset class="form-group">
                                        <label>Giá Khuyến Mãi</label>
                                        <input type="number" class="form-control" id="gia_khuyen_mai_edit" placeholder="Nhập vào giá khuyến mãi">
                                    </fieldset>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <fieldset class="form-group">
                                        <label>Ảnh Đại Diện</label>
                                        <div class="input-group">
                                            <input id="anh_dai_dien_edit" name="anh_dai_dien" class="form-control" type="text">
                                            <input type="button" class="btn-info lfm" data-input="anh_dai_dien_edit" data-preview="holder_edit" value="Upload">
                                        </div>
                                        <img id="holder_edit" style="margin-top:15px;max-height:100px;">
                                    </fieldset>
                                </div>
                            </div>
                            {{-- <div class="row">
                                <div class="col-md-12">
                                    <fieldset class="form-group">
                                        <label for="placeTextarea">Mô Tả Ngắn</label>
                                        <textarea class="form-control" id="mo_ta_ngan_edit" cols="30" rows="5" placeholder="Nhập vào mô tả ngắn"></textarea>
                                    </fieldset>
                                </div>
                            </div>
                            <div class="position-relative form-group">
                                <label>Mô Tả Chi Tiết</label>
                                <input name="mo_ta_chi_tiet_edit" id="mo_ta_chi_tiet_edit" placeholder="Nhập vào mô tả chi tiết" type="text" class="form-control">
                            </div> --}}
                            <div class="row">
                                <div class="col-md-6">
                                    <fieldset class="form-group">
                                        <label>Danh Mục</label>
                                        <select id="id_danh_muc_edit" class="custom-select block">
                                            @foreach ($list_danh_muc as $value)
                                                <option value={{$value->id}}> {{ $value->ten_danh_muc }} </option>
                                            @endforeach
                                        </select>
                                    </fieldset>
                                </div>
                                <div class="col-md-6">
                                    <fieldset class="form-group">
                                        <label>Danh Mục</label>
                                        <select id="is_open_edit" class="custom-select block">
                                            <option value=1>Hiển Thị</option>
                                            <option value=0>Tạm tắt</option>
                                        </select>
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="reset" id="closeModal" class="btn btn-outline-secondary" data-dismiss="modal" value="close">
                    <input type="submit" id="updateSanPham" class="btn btn-outline-primary" data-dismiss="modal" value="Chỉnh sửa">
                </div>
            </form>
        </div>
    </div>
</div>
@section('content')
    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="card-body"><h5 class="card-title">Thêm mới sản phẩm</h5>
                <form class="" id="formCreate">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="position-relative form-group">
                                <label>Tên Sản Phẩm</label>
                                <input id="ten_san_pham" placeholder="Nhập vào tên sản phẩm" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="position-relative form-group">
                                <label>Slug Sản Phẩm</label>
                                <input id="slug_san_pham" placeholder="Nhập vào slug sản phẩm" type="text" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="position-relative form-group">
                                <label>Giá Bán</label>
                                <input id="gia_ban" placeholder="Nhập vào giá bán" type="number" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="position-relative form-group">
                                <label>Giá Khuyến Mãi</label>
                                <input id="gia_khuyen_mai" placeholder="Nhập vào giá khuyến mãi" type="number" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="position-relative form-group">
                                <label>Ảnh Đại Diện</label>
                                <div class="input-group">
                                    <input id="anh_dai_dien" name="anh_dai_dien" class="form-control" type="text">
                                    <input type="button" class="btn-info lfm" data-input="anh_dai_dien" data-preview="holder" value="Upload">
                                </div>
                                <img id="holder" style="margin-top:15px;max-height:100px;">
                            </div>
                        </div>
                    </div>

                    {{-- <div class="position-relative form-group">
                        <label>Mô Tả Ngắn</label>
                        <textarea class="form-control" id="mo_ta_ngan" cols="30" rows="5" placeholder="Nhập vào mô tả ngắn"></textarea>
                    </div>
                    <div class="position-relative form-group">
                        <label>Mô Tả Chi Tiết</label>
                        <input name="mo_ta_chi_tiet" id="mo_ta_chi_tiet" placeholder="Nhập vào mô tả chi tiết" type="text" class="form-control">
                    </div> --}}

                    <div class="row">
                        <div class="col-md-6">
                            <div class="position-relative form-group">
                                <label>Danh Mục</label>
                                <select id="id_danh_muc" class="form-control">
                                    @foreach ($list_danh_muc as $value)
                                        <option value={{$value->id}}> {{ $value->ten_danh_muc }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="position-relative form-group">
                                <label>Tình Trạng</label>
                                <select id="is_open" class="form-control">
                                    <option value=1>Hiển Thị</option>
                                    <option value=0>Tạm tắt</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <button class="mt-1 btn btn-primary" id="createSanPham">Thêm Mới Sản Phẩm</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="table-response">
            <div class="main-card mb-3 card">
                <div class="card-body"><h5 class="card-title">Table bordered</h5>
                    <table class="mb-0 table table-bordered" id="tableSanPham">
                        <thead>
                        <tr>
                            <th class="text-nowrap text-center">#</th>
                            <th class="text-nowrap text-center">Tên Sản Phẩm</th>
                            <th class="text-nowrap text-center">Slug Sản Phẩm</th>
                            <th class="text-nowrap text-center">Giá Bán</th>
                            <th class="text-nowrap text-center">Giá Khuyến Mãi</th>
                            <th class="text-nowrap text-center">Tình Trạng</th>
                            <th class="text-nowrap text-center">Danh Mục</th>
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
@endsection
@section('js')
<script src="https://cdn.ckeditor.com/4.18.0/standard/ckeditor.js"></script>
<script src="/vendor/laravel-filemanager/js/lfm.js"></script>
<script>
    $('.lfm').filemanager('image');
    var options = {
        filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
        filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
        filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
        filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token='
    };
    CKEDITOR.replace('mo_ta_chi_tiet', options);
    CKEDITOR.replace('mo_ta_chi_tiet_edit', options);
</script>

<script>
    @if(count($errors) > 0)
        @foreach ($errors->all() as $error)
            toastr.error("{{ $error }}");
        @endforeach
    @endif
</script>

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

        $("#ten_san_pham").keyup(function(){
            var tenSanPham = $("#ten_san_pham").val();
            var slugSanPham = toSlug(tenSanPham);
            $("#slug_san_pham").val(slugSanPham);
        });

        function layDuLieu() {
            $.ajax({
                url     :   '/admin/san-pham/danh-sach-san-pham',
                type    :   'get',
                success :   function(res) {
                    var html = '';

                    $.each(res.dulieuneban, function(key, value) {
                        if(value.is_open == true) {
                            var doan_muon_hien_thi = '<button class="btn btn-primary doiTrangThai" data-id="' + value.id + '">Hiển Thị</button>';
                        } else {
                            var doan_muon_hien_thi = '<button class="btn btn-danger doiTrangThai" data-id="' + value.id + '">Tạm Tắt</button>';
                        }

                        html += '<tr>';
                        html += '<th scope="row">' + (key + 1) + '</th>';
                        html += '<td>' + value.ten_san_pham + '</td>';
                        html += '<td>' + value.slug_san_pham + '</td>';
                        html += '<td>' + value.gia_ban + '</td>';
                        html += '<td>' + value.gia_khuyen_mai + '</td>';
                        html += '<td>' + doan_muon_hien_thi + '</td>';
                        html += '<td>' + value.ten_danh_muc + '</td>';
                        html += '<td>';
                        html += '<button class="btn btn-danger nutDelete mr-1" data-iddelete="' + value.id + '" data-toggle="modal" data-target="#exampleModal"> Xóa </button>';
                        html += '<button class="btn btn-success nutEdit" data-idedit="' + value.id + '" data-toggle="modal" data-target="#editModal"> Chỉnh sửa </button>';
                        html += '</td>';
                        html += '</tr>';
                    });
                    $("#tableSanPham tbody").html(html);

                },
            });
        }

        layDuLieu();

        $("#createSanPham").click(function(e){
            e.preventDefault();
            var ten_san_pham        = $("#ten_san_pham").val();
            var slug_san_pham       = $("#slug_san_pham").val();
            var gia_ban             = $("#gia_ban").val();
            var gia_khuyen_mai      = $("#gia_khuyen_mai").val();
            var anh_dai_dien        = $("#anh_dai_dien").val();
            // var mo_ta_ngan          = $("#mo_ta_ngan").val();
            // var mo_ta_chi_tiet      = CKEDITOR.instances['mo_ta_chi_tiet'].getData();
            var id_danh_muc         = $("#id_danh_muc").val();
            var is_open             = $("#is_open").val();

            var thongTinSanPhamCanTao = {
                'ten_san_pham'          :   ten_san_pham,
                'slug_san_pham'         :   slug_san_pham,
                'gia_ban'               :   gia_ban,
                'gia_khuyen_mai'        :   gia_khuyen_mai,
                'anh_dai_dien'          :   anh_dai_dien,
                // 'mo_ta_ngan'            :   mo_ta_ngan,
                // 'mo_ta_chi_tiet'        :   mo_ta_chi_tiet,
                'id_danh_muc'           :   id_danh_muc,
                'is_open'               :   is_open,
            };

            console.log(thongTinSanPhamCanTao);

            $.ajax({
                url     :   '/admin/san-pham/tao-san-pham',
                type    :   'post',
                data    :   thongTinSanPhamCanTao,
                success :   function(res) {
                    console.log(res);
                    if(res.thongBao == 1235) {
                        layDuLieu();
                        $('#formCreate').trigger("reset");
                        // CKEDITOR.instances.mo_ta_chi_tiet.setData('');
                        $('#holder').attr('src', '');
                        toastr.success('Thêm mới sản phẩm thành công!');
                    }
                },
                error   :   function(res) {
                    var errros = res.responseJSON.errors;
                    $.each(errros, function(key, value){
                        toastr.error(value[0]);
                    });
                }
            });
        });


        $('body').on('click', '.doiTrangThai', function(){
            var id = $(this).data('id');
            $.ajax({
                url     :   '/admin/san-pham/doi-trang-thai/' + id,
                type    :   'get',
                success :   function(res) {
                    if(res.status) {
                        layDuLieu();
                    }
                },
            });
        });

        $('body').on('click', '.nutDelete', function(){
            var id_cua_em = $(this).data('iddelete');
            $("#idCanXoa").val(id_cua_em);
        });

        function satThu(id) {
            $.ajax({
				url     :   '/admin/san-pham/xoa-san-pham/' + id,
				type    :   'get',
				success :   function(res) {
					if(res.status) {
						layDuLieu();
					}
				},
			});
        }

        $("#taoChinhLaThangXoa").click(function(){
            var id_can_xoa = $("#idCanXoa").val();
            satThu(id_can_xoa);
        });
        $('body').on('click','.nutEdit',function(){
            var id = $(this).data('idedit');
            // console.log(id);
            $.ajax({
                url     :   '/admin/san-pham/edit/' + id,
                type    :   'get',
                success :   function(res) {
                    console.log(res);
                    if(res.status) {
                        $("#ten_san_pham_edit").val(res.data.ten_san_pham);
                        $("#slug_san_pham_edit").val(res.data.slug_san_pham);
                        $("#gia_ban_edit").val(res.data.gia_ban);
                        $("#gia_khuyen_mai_edit").val(res.data.gia_khuyen_mai);
                        $("#anh_dai_dien_edit").val(res.data.anh_dai_dien);
                        $("#holder_edit").attr("src", res.data.anh_dai_dien);
                        // $("#mo_ta_ngan_edit").val(res.data.mo_ta_ngan);
                        $("#id_edit").val(res.data.id);
                        // CKEDITOR.instances['mo_ta_chi_tiet_edit'].setData(res.data.mo_ta_chi_tiet);
                        $("#id_danh_muc_edit").val(res.data.id_danh_muc);
                        $("#is_open_edit").val(res.data.is_open);
                    } else {
                        toastr.error('Sản phẩm không tồn tại!');
                        window.setTimeout(function() {
                            $('#closeModal').click();
                        }, 1000 );
                    }
                },
            });
        });

        $("#updateSanPham").click(function(){
            var val_ten_san_pham        = $("#ten_san_pham_edit").val();
            var val_slug_san_pham       = $("#slug_san_pham_edit").val();
            var val_gia_ban             = $("#gia_ban_edit").val();
            var val_gia_khuyen_mai      = $("#gia_khuyen_mai_edit").val();
            var val_anh_dai_dien        = $("#anh_dai_dien_edit").val();
            // var val_mo_ta_ngan          = $("#mo_ta_ngan_edit").val();
            // var val_mo_ta_chi_tiet      = $("#mo_ta_ngan_edit").val();
            // var val_mo_ta_chi_tiet      = CKEDITOR.instances['mo_ta_chi_tiet_edit'].getData();
            var val_id_danh_muc         = $("#id_danh_muc_edit").val();
            var val_is_open             = $("#is_open_edit").val();
            var val_id                  = $("#id_edit").val();

            var payload = {
                'ten_san_pham'      :   val_ten_san_pham,
                'slug_san_pham'     :   val_slug_san_pham,
                'gia_ban'           :   val_gia_ban,
                'gia_khuyen_mai'    :   val_gia_khuyen_mai,
                'anh_dai_dien'      :   val_anh_dai_dien,
                // 'mo_ta_ngan'        :   val_mo_ta_ngan,
                // 'mo_ta_chi_tiet'    :   val_mo_ta_chi_tiet,
                'id_danh_muc'       :   val_id_danh_muc,
                'is_open'           :   val_is_open,
                'id'                :   val_id,
            };
            console.log(payload);

            // Gửi payload lên trên back-end bằng con đường ajax
            $.ajax({
                url     :   '/admin/san-pham/update',
                type    :   'post',
                data    :   payload,
                success :   function(res) {
                    if(res.status) {
                        toastr.success('Sản phẩm đã được cập nhật!');
                        layDuLieu();
                        $('#holder_edit').attr('src', '');
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
