@extends('admin.master')
@push('css')
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.11.5/b-2.2.2/b-colvis-2.2.2/b-html5-2.2.2/b-print-2.2.2/date-1.1.2/fc-4.0.2/fh-3.2.2/r-2.2.9/rg-1.1.4/sc-2.0.5/sb-1.3.2/sl-1.3.4/datatables.min.css" />
@endpush
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <h5 class="card-title">CHI TIẾT HÓA ĐƠN</h5>
                    <table style="text-align: center" class="mb-0  table table-bordered" id="table-index">
                        <thead>
                            <tr>
                                <th rowspan="5">Mã Hoá Đơn</th>
                                <th>Tên sản phẩm</th>
                                <th>Số lượng</th>
                                <th>Đơn giá</th>
                                <th>Bàn</th>
                                <th>created_at</th>
                                <th>updated_at</th>
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
@push('js')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript"
        src="https://cdn.datatables.net/v/dt/jszip-2.5.0/dt-1.11.5/b-2.2.2/b-colvis-2.2.2/b-html5-2.2.2/b-print-2.2.2/date-1.1.2/fc-4.0.2/fh-3.2.2/r-2.2.9/rg-1.1.4/sc-2.0.5/sb-1.3.2/sl-1.3.4/datatables.min.js">
    </script>
    {{-- {{ dd($id) }} --}}
    <script>
        $(function() {
            let table = $('#table-index').DataTable({
                dom: 'Blrtip',
                select: true,
                lengthMenu: [5, 15, 30, 45, 50, 100],
                processing: true,
                serverSide: true,
                ajax: '{!! route('hoa-don.getData') !!}',
                columns: [{
                        data: 'ma_hoa_don',
                        name: 'ma_hoa_don'
                    },
                    {
                        data: 'ten_san_pham',
                        name: 'ten_san_pham'
                    },
                    {
                        data: 'so_luong',
                        name: 'so_luong'
                    },
                    {
                        data: 'don_gia',
                        name: 'don_gia'
                    },
                    {
                        data: 'id_ban',
                        name: 'id_ban'
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
                ]
            });
        });
    </script>
@endpush
