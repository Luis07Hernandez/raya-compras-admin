
<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    {{--<link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">--}}


    <style>

        @font-face {
            font-family: "Montserrat";
            src: url({{$path."/css/fonts/Montserrat/Montserrat-Light.ttf"}});
        }


        p {
            font-family: "Montserrat", Light;
        }

        .header{

            width: 100%;
            height: 200px;
            /*position: fixed;*/
            top: 0;
            left: 0;
            right: 0;
            /*background-color: #CCCCCC;*/
        }

        .contentdd{
            width: 100%;
            height: 270px;
            display: table;
            padding-bottom: 10px;
        }

        .phase{
            display: table-cell;
            vertical-align: middle;
            text-align: center;
        }



        .phase p{
            font-family: Arial, Helvetica, sans-serif;
            color: #000000;
        }

        .footer{
            width: 100%;
            height: 200px;
            /*position: fixed;*/
            bottom:0;
            left: 0;
            right: 0;
        }



        body{
            height: 100%;
        }

        /*
    ##Device = Low Resolution Tablets, Mobiles (Landscape)
    ##Screen = B/w 481px to 767px
*/

        @media (min-width: 481px) and (max-width: 767px) {

            .contentdd{
                width: 100%;
                height: 200px;
                display: table;
            }
        }

        /*
          ##Device = Most of the Smartphones Mobiles (Portrait)
          ##Screen = B/w 320px to 479px
        */

        @media (min-width: 320px) and (max-width: 480px) {
            .contentdd{
                width: 100%;
                height: 200px;
                display: table;
            }

        }



        *{
            -webkit-box-sizing: border-box; /* Safari/Chrome, other WebKit */
            -moz-box-sizing: border-box;    /* Firefox, other Gecko */
            box-sizing: border-box;         /* Opera/IE 8+ */
        }

        table{
            background: #fff;
        }
        table,thead,tbody,tfoot,tr, td,th{
            text-align: center;
            margin: auto;
            border:1px solid #dedede;
            padding: 1rem;
            width: 50%;
        }

    </style>
</head>

<body>
<div style="width: 100%;height: 250px;">



    <div style="background: url(https://admon.rayafrutasyverduras.com.mx/images/HeaderOK.png);background-position:center;background-size:contain;background-repeat:no-repeat;width:102%;height:100%;margin-top: -11px;"></div>


</div>
<div  class="contentdd">
    <div class="phase">
        <p style="font-size: 15px;color: #000000;">¡Hola {{$customer->commercial_name}}!</p>
        <p style="font-size: 15px;color: #000000;">Se actualizo tu pedido con el peso y precio correcto.
        Accede a la plataforma para conocer el detalle y opciones de pago <a href="https://pedidos.rayafrutasyverduras.com.mx">https://pedidos.rayafrutasyverduras.com.mx</a>.</p>

        <table align="center">
            <thead>

            <tr>
                <th>Nombre del producto</th>
                <th>Cantidad</th>
                <th>Total</th>
                <th>Unidad de medida</th>
            </tr>
            </thead>
            <tbody>
            @foreach($products as $product)
                <tr>
                    <td>{{$product->name}}</td>
                    <td>{{$product->exact_weight > 0 ? $product->exact_weight : $product->qty}}</td>
                    <td>${{number_format($product->total_price > 0 ? $product->total_price : $product->total,2,'.','')}}</td>
                    <td>{{$product->units_name}}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="4">
                    <p style="text-align: right;font-weight: bold;">Subtotal: ${{number_format($order->subtotal,2,'.',',')}}</p>
                    <p style="text-align: right;font-weight: bold;">Costo de envío: ${{number_format($order->shipping_cost,2,'.',',')}}</p>
                    <p style="text-align: right;font-weight: bold;">Total: ${{number_format($order->total,2,'.',',')}}</p>
                </td>
            </tr>
            </tbody>
        </table>

    </div>
</div>


<div style="width: 100%;height: 250px;">


    <div style="background: url(https://admon.rayafrutasyverduras.com.mx/images/FooterOK.png);background-position:center;background-size:contain;background-repeat:no-repeat;width:100%;height:100%;margin-top: -11px;"></div>


</div>

</body>
</html>
