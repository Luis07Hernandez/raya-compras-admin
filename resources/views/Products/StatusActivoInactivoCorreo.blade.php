
<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    {{--<link href="https://fonts.googleapis.com/css?family=Montserrat&display=swap" rel="stylesheet">--}}


    <style>

    


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
     
        <p style="font-size: 15px;color: #000000;">¡Hola {{$item->contact_name}}!</p>
      @if($status === 1)
        <p style="font-size: 15px;color: #000000;">El producto {{$item->name_product}} esta nuevamente disponible</p>
    @else
            <p style="font-size: 15px;color: #000000;">El producto {{$item->name_product}} esta agotado..</p>
             @endif   
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
            @foreach($order_products as $order_detail_user) 
                <tr>
                    <td>{{$order_detail_user->name}}</td>
                    <td>{{$order_detail_user->qty}}</td>
                    <td>${{number_format($order_detail_user->total,2,'.','')}}</td>
                    <td>{{$order_detail_user->unit_name}}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="4">
                    <p style="text-align: right;font-weight: bold;">Subtotal: ${{number_format($resultsubtotal,2,'.',',')}}</p>
                    <p style="text-align: right;font-weight: bold;">Costo de envío: ${{number_format($item->shipping_cost,2,'.',',')}}</p>
                   
                    <p style="text-align: right;font-weight: bold;">Total: ${{number_format($resulttotal,2,'.',',')}}</p>
                
                  @if($status === 1)
        <p style="font-size: 8px;color: #000000;">El producto {{$item->name_product}} se a sumado nuevamente..  </p>
    @else
            <p style="font-size: 8px;color: #000000;">El producto {{$item->name_product}} se a restado..</p>
             @endif  
                
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
