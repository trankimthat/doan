@extends('admin.master')
@push('css')
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.11.5/b-2.2.2/b-colvis-2.2.2/b-html5-2.2.2/b-print-2.2.2/date-1.1.2/fc-4.0.2/fh-3.2.2/r-2.2.9/rg-1.1.4/sc-2.0.5/sb-1.3.2/sl-1.3.4/datatables.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <h5 class="card-title">CHI TIẾT HÓA ĐƠN</h5>
                    <table style="text-align: center" class="mb-0  table table-bordered" id="loadTableRight">
                        <thead>
                            <tr>
                                <th rowspan="5">Mã Hoá Đơn</th>
                                <th>Tên sản phẩm</th>
                                <th>Số lượng</th>
                                <th>Đơn giá</th>
                                <th>Bàn</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        {{-- <div class="col-md-6">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <h5><b>BÀN</b></h5>
                    <div class="row" id="tableBanLeft">
                    </div>
                </div>
            </div>
        </div> --}}
        <div class="col-md-12">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <h5 class="card-title">HÓA ĐƠN</h5>
                    <div class="form-group">
                        <select id="select-name"></select>
                    </div>
                    <table style="text-align: center" class="mb-0  table table-bordered" id="table-index">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>ma_hoa_don</th>
                                <th>tong_tien</th>
                                <th>tien_giam_gia</th>
                                <th>thuc_tra</th>
                                <th>id_ban</th>
                                <th>created_at</th>
                                <th>updated_at</th>
                                <th>Xem chi tiết</th>
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
    <script>
        $(window).on('load', function() {
            if (feather) {
                feather.replace({
                    width: 14,
                    height: 14
                });
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

            $("#select-name").select2({
                ajax: {
                    url: "{{ route('hoa-don.api.search_HD') }}",
                    dataType: 'json',
                    data: function(params) {
                        return {
                            q: params.term
                        };
                    },
                    processResults: function(data, params) {
                        // dd(data);
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    text: item.ma_hoa_don,
                                    id: item.id
                                }
                            })
                        };
                    }
                },
                placeholder: 'Tìm kiếm mã hoá đơn'
            });
            var buttonCommon = {
                exportOptions: {
                    columns: ':visible :not(.not-export)'
                }
            };
            let table = $('#table-index').DataTable({
                dom: 'lrtip',
                // select: true,
                lengthMenu: [5, 15, 30, 45, 50, 100],
                processing: true,
                serverSide: true,
                ajax: '{!! route('hoa-don.api_HD') !!}',
                // columnDefs: [{
                //     className: "not-export",
                //     "targets": [3]
                // }],
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'ma_hoa_don',
                        name: 'ma_hoa_don'
                    },
                    {
                        data: 'tong_tien',
                        name: 'tong_tien'
                    },
                    {
                        data: 'tien_giam_gia',
                        name: 'tien_giam_gia'
                    },
                    {
                        data: 'thuc_tra',
                        name: 'thuc_tra'
                    },
                    {
                        data: 'id_ban',
                        name: 'ban'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'updated_at',
                        name: 'updated_at'
                    },
                    {
                        data: 'details',
                        targets: 8,
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row, meta) {
                            return `<a class=" table_Show_chi_tiet btn btn-primary" id= "show_chi_tiet" idban="${row.id}">
                                Details
                            </a>`;
                            // console.log(row.id);
                        }
                    },
                ]
            });

            $('#select-name').change(function() {
                table.column(0).search(this.value).draw();
            });

            function loadTableRight(id) {
                $.ajax({
                    url: '/admin/hoa-don/doanh-thu/' + id,
                    type: 'get',
                    success: function(res) {
                        var content_table = '';
                        $("#id_ban_thanh_toan").val(id);
                        // console.log($hihi);
                        $.each(res.dataNe, function(key, value) {
                            content_table += '<tr>';
                            content_table += '<th class="text-center" scope="row">' + (key +
                                1) + '</th>';
                            content_table += '<td> ' + value.ten_san_pham + ' </td>';
                            content_table += '<td> ' + value.don_gia + ' </td>';
                            content_table += '<td> ' + value.so_luong + ' </td>';
                            content_table += '<td> ' + value.so_luong * value.don_gia +
                                ' </td>';
                            content_table += '</td>';
                            content_table += '</tr>';

                        });
                        $("#loadTableRight tbody").html(content_table);
                    }
                });
            }

            function formatNumber(number) {
                return new Intl.NumberFormat('vi-VI', {
                    style: 'currency',
                    currency: 'VND'
                }).format(number);
            }

            $('body').on('click', '.doiTrangThai', function() {
                var id = $(this).data('idtrangthai');
                var self = $(this);
                $.ajax({
                    url: '/admin/ban/doi-trang-thai/' + id,
                    type: 'get',
                    success: function(res) {
                        if (res.trangThai) {
                            toastr.success('Đã đổi trạng thái thành công!');
                            // Tình trạng mới là true
                            loadtableLeft();
                            if (res.tinhTrangDanhMuc == true) {
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
            })

            $('body').on('click', '.table_Show_chi_tiet', function() {
                // console.log($(this).data('idban'));
                // console.log($(this).attr('idban'));
                var select = $(this);
                var id = select.attr('idban');
                // console.log(id);
                // console.log(id);
                $.ajax({
                    url: '/admin/hoa-don/ban/' + id,
                    type: 'get',
                    success: function(res) {
                        if (res.status) {
                            loadTableRight(id);
                        } else {
                            toastr.error(' Bàn không tồn tại!');
                        }
                    },
                });
            })

            $('body').on('click', '#inBill', function() {
                var id = $("#id_ban_thanh_toan").val();
                // console.log(id);
                $.ajax({
                    url: '/admin/hoa-don/in-bill/' + id,
                    type: 'post',
                    success: function(res) {
                        if (res.status == 1) {
                            toastr.success("Đã in bill thành công!");
                            loadTableRight();
                        } else {
                            toastr.warning("Bill Rỗng !")
                        }
                    },
                });
            })

        })
    </script>
@endsection
@push('js')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript"
        src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.11.5/b-2.2.2/b-colvis-2.2.2/b-html5-2.2.2/b-print-2.2.2/date-1.1.2/fc-4.0.2/fh-3.2.2/r-2.2.9/rg-1.1.4/sc-2.0.5/sb-1.3.2/sl-1.3.4/datatables.min.js">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    {{-- <script>
        // $(function() {
        //     $("#select-name").select2({
        //         ajax: {
        //             url: "{{ route('hoa-don.api.search_HD') }}",
        //             dataType: 'json',
        //             data: function(params) {
        //                 return {
        //                     q: params.term
        //                 };
        //             },
        //             processResults: function(data, params) {
        //                 return {
        //                     results: $.map(data, function(item) {
        //                         return {
        //                             text: item.ma_hoa_don,
        //                             id: item.id
        //                         }
        //                     })
        //                 };
        //             }
        //         },
        //         placeholder: 'Tìm kiếm mã hoá đơn hoặc bàn'
        //     });

        //     var buttonCommon = {
        //         exportOptions: {
        //             columns: ':visible :not(.not-export)'
        //         }
        //     };

        //     $('#table-index').DataTable({
        //         dom: 'Blrtip',
        //         lengthMenu: [5, 15, 30, 45, 50, 100],
        //         select: true,
        //         processing: true,
        //         serverSide: true,
        //         ajax: '{!! route('hoa-don.api_HD') !!}',
        //         columns: [{
        //             data: 'id',
        //             name: 'id'
        //         }, {
        //             data: 'ma_hoa_don',
        //             name: 'ma_hoa_don'
        //         }, {
        //             data: 'tong_tien',
        //             name: 'tong_tien'
        //         }, {
        //             data: 'tien_giam_gia',
        //             name: 'tien_giam_gia'
        //         }, {
        //             data: 'thuc_tra',
        //             name: 'thuc_tra'
        //         }, {
        //             data: 'id_ban',
        //             name: 'ban'
        //         }, {
        //             data: 'xuat_hoa_don',
        //             name: 'xuat_hoa_don'
        //         }, {
        //             data: 'created_at',
        //             name: 'created_at'
        //         }, {
        //             data: 'updated_at',
        //             name: 'updated_at'
        //         }, ]
        //     });

        //     $('#select-name').change(function() {
        //         table.column(0).search(this.value).draw();
        //     });
        // });

        $(function() {
            $("#select-name").select2({
                ajax: {
                    url: "{{ route('hoa-don.api.search_HD') }}",
                    dataType: 'json',
                    data: function(params) {
                        return {
                            q: params.term
                        };
                    },
                    processResults: function(data, params) {
                        // dd(data);
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    text: item.ma_hoa_don,
                                    id: item.id
                                }
                            })
                        };
                    }
                },
                placeholder: 'Tìm kiếm mã hoá đơn'
            });
            var buttonCommon = {
                exportOptions: {
                    columns: ':visible :not(.not-export)'
                }
            };
            let table = $('#table-index').DataTable({
                dom: 'lrtip',
                select: true,
                lengthMenu: [5, 15, 30, 45, 50, 100],
                processing: true,
                serverSide: true,
                ajax: '{!! route('hoa-don.api_HD') !!}',
                // columnDefs: [{
                //     className: "not-export",
                //     "targets": [3]
                // }],
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'ma_hoa_don',
                        name: 'ma_hoa_don'
                    },
                    {
                        data: 'tong_tien',
                        name: 'tong_tien'
                    },
                    {
                        data: 'tien_giam_gia',
                        name: 'tien_giam_gia'
                    },
                    {
                        data: 'thuc_tra',
                        name: 'thuc_tra'
                    },
                    {
                        data: 'id_ban',
                        name: 'ban'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'updated_at',
                        name: 'updated_at'
                    },
                    {
                        data: 'details',
                        targets: 8,
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row, meta) {
                            return `<a class="btn btn-primary" idban=${row.id}">
                                Details
                            </a>`;
                            // console.log(row.id);
                        }
                    },
                ]
            });

            $('#select-name').change(function() {
                table.column(0).search(this.value).draw();
            });
        });
    </script> --}}
@endpush
