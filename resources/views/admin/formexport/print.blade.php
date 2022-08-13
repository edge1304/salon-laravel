<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>In phiếu xuất</title>
        <link rel="stylesheet" href="{{asset('/plugins/fontawesome-free/css/all.min.css')}}">
        <link rel="stylesheet" href="{{asset('/css/formexport/print.css')}}">
{{--        <link rel="stylesheet" href="{{asset('/dist/css/adminlte.min.css')}}">--}}
{{--        <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">--}}
    </head>
    <body>
        <div id="div-print" >

            <div class="div-title">
                <h1>H.M - Hair Salon</h1>
                <p>Ngày {{date_format($data['created_at'],"Y/m/d" )}}</p>
            </div>
            <div class="div-customer">
                <div class="div-name">
                    <b>Tên khách hàng:</b>
                    <label>{{$data->customer['name']}}</label>
                </div>
                <div class="div-info-customer">
                    <b>Số điện thoại:</b>
                    <label>{{$data->customer['phone']}}</label>
                    &nbsp;
                    <b>Địa chỉ:</b>
                    <label>{{$data->customer['address']}}</label>
                </div>
            </div>
            <div class="div-service">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Stt</th>
                            <th>Dịch vụ</th>
                            <th>Giá</th>
                            <th>SL</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $stt= 1; ?>
                        @foreach($data['details'] as $product)
                            <tr>
                                <td>{{$stt++}}</td>
                                <td>{{$product['name']}}</td>
                                <td>{{number_format($product['price'])}}</td>
                                <td>{{number_format($product['quantity'])}}</td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
                <div class="div-payment">
                    <div class="row">
                        <div class="col col-md-3">
                            <b>Thành tiền: {{number_format($data['total_money'])}}</b>
                        </div>
                        <div class="col col-md-3">
                            <b class="text-of-money">Bằng chữ: {{$data['text_of_money']}}</b>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col col-md-3">
                            <b>Đã thanh toán: {{number_format($data['receive_money'])}}</b>
                        </div>
                        <div class="col col-md-3">
                            <b>Hình thức: {{$data['fundbook_name']}}</b>
                        </div>
                    </div>
                    <div class="row div-signature">
                        <div class="col col-md-6 item-signature" >
                            <b>Người lập phiếu</b>
                            <br>
                            <label>(Ký và ghi gõ họ tên)</label>
                            <br>
                            <b>{{auth()->user()->name}}</b>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
<script>
    document.body.innerHTML = document.getElementById('div-print').innerHTML;
    window.print();
</script>
