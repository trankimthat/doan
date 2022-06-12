@extends('home_page_new.master')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="card-body" style="text-align: center"><h3 class="card-title">Danh Sách Oder Sản Phẩm</h3>
                <table class="mb-0 table table-bordered" id="tableNhanVien">
                    <thead>
                        <tr>
                            <th class="text-center">Image</th>
                            <th class="text-center">Tên Sản Phẩm</th>
                            <th class="text-center">Gía</th>
                            <th class="text-center">Số Lượng</th>
                            <th class="text-center">Tổng cộng</th>
                            <th class="text-center">Remove</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="row">
        <!-- Cart Button Start -->
         {{-- <div class="col-md-8 col-sm-12">

         </div> --}}
         <!-- Cart Button Start -->
         <!-- Cart Totals Start -->
         <div style="text-align: right" class="col-md-12 col-sm-12">
             <div class="cart_totals float-md-right text-md-right">
                 <h2>Cart Totals</h2>
                 <div class="price " style="margin-bottom: 20px; font-size: 30px">
                    <b>Total: </b><b >45.000đ</b>
                 </div>

                 {{-- <table style="text-align: right" class="float-md-right">
                     <tbody>
                         <tr class="order-total">
                             <th>Total</th>
                             <td>
                                 <strong><span class="amount"> 0đ</span></strong>
                             </td>
                         </tr>
                     </tbody>
                 </table> --}}
                 <div class="wc-proceed-to-checkout">
                     <a class="btn btn-danger" href="#" >Proceed to Checkout</a>


                 </div>
             </div>
         </div>
         <!-- Cart Totals End -->
    </div>
</div>

@endsection
@section('js')
<script>
    $(document).ready(function() {
        console.log(123);
        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        function loadTable(){
            $.ajax({
                url     :   '/user/cart/data',
                type    :   'get',
                success :   function(res) {
                    var content_table = '';
                    $.each(res.data, function(key, value) {
                        content_table += '<tr>';
                        content_table += '<td><img style="height: 100px" src="'+value.anh_dai_dien+'" alt=""></td>';
                        content_table += '<td> ' + value.ten_san_pham +' </td>';
                        content_table += ' <td class="product-price">';
                        content_table += ' <span class="amount">'+ value.don_gia +'</span>';
                        content_table += ' </td>';
                        content_table += '<td>';
                        content_table += '<input type="number" min=1 class="form-control qty" value="'+value.so_luong+'" data-id='+ value.id+'>';
                        content_table += '</td>';
                        content_table += '<td >'+ formatNumber(value.so_luong * value.don_gia) +'</td>';
                        content_table += '<td >';
                        content_table += ' <button style="margin-top: calc(100%/6)" class="mg-test btn btn-danger delete mr-1" data-iddelete="'+ value.id +'" data-toggle="modal" data-target="#deleteModal">Delete</button>';
                        content_table += '</td>';
                        content_table += '</tr>';
                    });
                    $("#tableNhanVien tbody").html(content_table);
                },

            });
        }
        loadTable();
        function formatNumber(number)
        {
            return new Intl.NumberFormat('vi-VI', { style: 'currency', currency: 'VND' }).format(number);
        }

    });
</script>


@endsection
