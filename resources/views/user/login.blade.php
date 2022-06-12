<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @toastr_css
    <style>
        .vh-100 {
            /* background-attachment:  fixed; */
            /* background-repeat: no-repeat; */
            background-size: cover;
            background-image: url(https://allimages.sgp1.digitaloceanspaces.com/photographercomvn/2020/12/1608673166_Top-50-hinh-anh-ly-Cafe-buoi-sang-dep-tuyet.jpg)
        }
        .bg {
            background: rgba(0,0,0,0);
            border: none;
        }
    </style>
</head>

<body>

    <section class="vh-100" style="background-color: #eee;">
        <div class="container h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-lg-12 col-xl-11">
                    <div class="card text-black bg" style="border-radius: 25px;">
                        <div class="card-body p-md-5">
                            <div class="row justify-content-center">
                                <div class="col-md-10 col-lg-6 col-xl-5 order-2 order-lg-1">
                                    <p class="text-center h1 fw-bold mb-2 mx-1 mx-md-4 mt-2"><b>Login</b></p>

                                    <form class="mx-1 mx-md-4" autocomplete="off">
                                        <div class="d-flex flex-row align-items-center mb-2">
                                            <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <input type="email" id="email" class="form-control" />
                                                <label class="form-label"><b>Email</b></label>
                                            </div>
                                        </div>
                                        <div class="d-flex flex-row align-items-center mb-2">
                                            <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                                            <div class="form-outline flex-fill mb-0">
                                                <input type="password" id="password" class="form-control" />
                                                <label class="form-label"><b>Mật Khẩu</b></label>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-end mx-4 mb-3 mb-lg-4">
                                            <button id="login" type="button"
                                                class="btn btn-dark btn-lg">Login</button>
                                        </div>
                                    </form>

                                </div>
                                {{-- <div class="col-md-10 col-lg-6 col-xl-7 d-flex align-items-center order-1 order-lg-2">

                                    <img src="https://hipbcoffee.com:8443/storage/public/12161-1602822113.jpg"
                                        class="img-fluid" alt="Sample image">

                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @jquery
    @toastr_js
    @toastr_render
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function(e) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $("#login").click(function(e) {
                e.preventDefault();
                var email = $("#email").val();
                var password = $("#password").val();
                var payload = {
                    'email'     : email,
                    'password'  : password,
                };
                $.ajax({
                    url     :   '/login',
                    data    :   payload,
                    type    :   'post',
                    success :   function(res) {
                        if(res.status == 2) {
                            toastr.success('Bạn đã login thành công!');
                            setTimeout(function(){
                                $(location).attr('href','http://127.0.0.1:8000/user/ban/index');
                            }, 2000);

                        } else if(res.status == 1) {
                            toastr.warning("Đăng nhập thất bại");
                        }
                         else {
                            toastr.error("Đăng nhập thất bại!");
                        }
                    },
                    error   :   function(res) {
                        var danh_sach_loi = res.responseJSON.errors;
                        $.each(danh_sach_loi, function(key, value){
                            toastr.error(value[0]);
                        });
                    }
                });
            });
        });
    </script>
</body>

</html>
