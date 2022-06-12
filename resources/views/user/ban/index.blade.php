

@extends('user.master')
@section('content')
    <div class="row" id="tableBan">
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
      console.log(123);
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      function loadtale(){
          $.ajax({
              url     :   '/user/data',
              type    :   'get',
              success :   function(res) {
                  var content_table = '';
                  $.each(res.dulieu, function(key, value) {
                      content_table += '<div class="col-md-3">';
                      content_table += '<div class="card bg-primary text-white">';
                      content_table += '<div class="card-body text-center">';
                      content_table += '<a  data-id=' + value.id + ' class="table" style="font-size: 50px">';
                      content_table += '<b>'+ value.ma_ban +'</b>';
                      content_table += '</a>';
                      content_table += '</div>';
                      content_table += '</div>';
                      content_table += '</div>';
                  });
                  $("#tableBan").html(content_table);
                  console.log(content_table);
              }
              })
      }
      loadtale();
      $('body').on('click','.table',function(){
            var id = $(this).data('id');
            $.ajax({
                url     :   '/user/ban/' + id,
                type    :   'get',
                success :   function(res) {
                    if(res.status) {
                        setTimeout(function(){
                                $(location).attr('href','http://127.0.0.1:8000/home-page');
                            }, 1000);
                    } else {
                        toastr.error(' Bàn không tồn tại!');

                    }
                },
            });
        });
  });
  </script>
@endsection

