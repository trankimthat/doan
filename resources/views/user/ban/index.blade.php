

@extends('user.master')
@section('content')
    <div class = "row" id="tableBan">
            {{-- <div class="card">
                <div class="card-body text-center">
                    <b>bàn 1</b>
                </div>
              <div class="card-body">
                <form class="form form-vertical">
                  <div class="row">
                    <div class="col-12">
                      <button type="reset" class="btn btn-primary mr-1 waves-effect waves-float waves-light">Submit</button>
                    </div>
                  </div>
                </form>
              </div>
            </div> --}}
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
            function loadTable(){
                $.ajax({
                    url     :   '/user/data',
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
                            content_table += '<button data-idtrangthai="'+ value.id +'" class="doiTrangThai btn '+ class_button +'">';
                            content_table +=  text_button;
                            content_table += '</button></div>';
                            content_table += '</div>';
                            content_table += '</div>';
                        });
                        $("#tableBan").html(content_table);
                    }
                    });
            }
            loadTable();
            $('body').on('click','.table',function(){
                    var id = $(this).data('id');
                    $.ajax({
                        url     :   '/user/ban/' + id,
                        type    :   'get',
                        success :   function(res) {
                            if(res.status) {
                                toastr.success('Trang oder');
                                window.location.replace('/home-page/' + id);
                                // setTimeout(function(){
                                //         $(location).attr('href','http://127.0.0.1:8000/home-page/{id}');
                                //     }, 1000);
                            } else {
                                toastr.error(' Bàn không tồn tại!');
                            }
                        },
                    });
            });
            $('body').on('click','.doiTrangThai',function(){
            var id = $(this).data('idtrangthai');
            var self = $(this);
            $.ajax({
                url     :     '/user/ban/doi-trang-thai/' + id,
                type    :     'get',
                success :     function(res) {
                    if(res.trangThai) {
                        toastr.success('Đã đổi trạng thái thành công!');
                        // Tình trạng mới là true
                        loadTable();
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

