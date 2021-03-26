
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
     
        <p style="font-size: 15px;color: #000000;">¡Hola {{$item->commercial_name}}!</p>
     
        <p style="font-size: 15px;color: #000000;">Tu pedido ha sido enviado con éxito y lo recibirás en la fecha seleccionada. Gracias por elegir Distribuidora Raya.</p>
  
        <table align="center">
            <thead>

            <tr>
                <th>Nombre del producto</th>
                <th>Cantidad</th>
                <th>Unidad de medida</th>
            </tr>
            </thead>
            <tbody>
                <?php  $category = "";?>
                <?php  $category2 = "";?>

                <?php  $aux = 1; ?>
                <?php  $cantproduct = 0 ?>
                @foreach($order_products as $order_detail_user) 

                    <?php  $category = $order_detail_user->text;
                        $cantproduct++;
                    ?>

                    @if( $category != $category2 or $aux == 1)
                        <?php  $aux = 0; ?>
                        <tr>
                            <td class="categoria " colspan="4" style="border-collapse: collapse;text-align:left !important;">
                                <b>  <?php echo $category; ?></b>
                            </td>
                        </tr>
                    @endif

                    <tr>
                        <td>{{$order_detail_user->product_name}}</td>
                        <td>{{$order_detail_user->exact_weight > 0 ? $order_detail_user->exact_weight.' '.$order_detail_user->unit_name : $order_detail_user->qty_unit }}</td>
                        <td>{{$order_detail_user->unit_name}}</td>
                    </tr>

                    <?php  $category2 = $order_detail_user->text; ?>
                @endforeach
                
            </tbody>
        </table>
    </div>
</div>


<div style="width: 100%;height: 250px;">


    <div style="background: url(https://admon.rayafrutasyverduras.com.mx/images/FooterOK.png);background-position:center;background-size:contain;background-repeat:no-repeat;width:100%;height:100%;margin-top: -11px;"></div>


</div>

</body>
</html>
