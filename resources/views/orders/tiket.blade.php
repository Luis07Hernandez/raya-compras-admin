
        <!DOCTYPE html>
<html>
        <head>

<style type="text/css">

    * {
        font-size: 12px;
        font-family: 'Times New Roman';
    }

    td,
    th,
    tr,
    /*table {*/
        /*border-top: 1px solid black;*/
        /*border-collapse: collapse;*/

    /*}*/

    td.producto,
    th.producto {
        /* width: 145px; */
        width: 125px;
        max-width: 250px;
    }

    td.cantidad,
    th.cantidad {
        width: 45px;
        max-width: 70px;
        word-break: break-all;
    }

    
    td.price,
    th.price {
        width: 25px;
        max-width: 70px;
        word-break: break-all;
    }

    /*td.categoria,*/
    /*th.categoria {*/
        /*width: 75px;*/
        /*max-width: 75px;*/
        /*word-break: break-all;*/
    /*}*/

    .centrado {
        text-align: center;
        align-content: center;
    margin-left: 30%;
    }

    .ticket {
        width: 155px;
        max-width: 155px;
        position: CENTER;
        /*top: 50px;*/
        /*left: 50%;*/

    }

    img {
        margin-top: -40px;
        max-width: inherit;
        width: inherit;
        margin-left: 25px;
    }
</style>

            <link rel="stylesheet" href="style.css">


            <script src="script.js">
                <?php

                date_default_timezone_set("America/Mexico_City");

                ?>



            </script>
        </head>
        <body>
        <div class="ticket">
            <img src="http://admon.rayafrutasyverduras.com.mx/images/flech2.png" alt=""   style="   width:100%;max-width:700px;  " alt="Logotipo" />


            <p class="centrado">Plataforma de pedidos Raya

                    {{--<br>{{$order_detail->order_route}}--}}


                <br><?php   echo  isset($order_details[0]-> delivery_date) ? $order_details[0]-> delivery_date : date("d/m/Y  H:i:s"); ?></p>
                <table class="ticket" id="mtableticket">
                <thead>
                <tr>
                    <th class="cantidad" >CANT</th>
                    <th class="producto" colspan="2">PRODUCTO</th>
                    {{--<th class="categoria">SERVICIO</th>--}}
                    <!-- <th class="price">Precio</th> -->
                </tr>
                </thead>
                <tbody class="ticket">

                    {{--<tr>--}}
                        {{--<td colspan="3">Sum: $180</td>--}}
                    {{--</tr>--}}

                    <?php  $category = ""?>
                    <?php  $category2 = ""?>

                    <?php  $aux = 1 ?>
                    <?php  $cantproduct = 0 ?>

                    @foreach($order_details as $order_detail)

                        <?php  $category = $order_detail->text;
                        $cantproduct++;
                        ?>



                        @if( $category != $category2 or $aux == 1)
                            <?php  $aux = 0 ?>

                            <tr>

                        <td class="categoria " colspan="4" style="  border-bottom: 1px solid black; border-collapse: collapse; "><b>  <?php echo $category   ?></b></td>

                    </tr>

                        @endif

                            <tr>
                                <td class="cantidad" >{{$order_detail->qty_unit }}</td>
                                <td class="producto" colspan="2">{{$order_detail->product_name}}</td>
                                <!-- <td class="price">${{number_format($order_detail->total,2,'.','')}}</td>                                 -->
                            </tr>

                        <?php  $category2 = $order_detail->text; ?>
                @endforeach



                </tbody>
            </table>


            <br><div class="content"style="width: 140%"> Comentario: <?php echo  $order_detail['comments']; ?> </div>

            <!-- <br /> Subtotal: <?php echo "$". number_format($order_detail['subtotal'],2,'.',''); ?>
            <br /> Costo de envió: <?php echo "$". number_format($order_detail['shipping_cost'],2,'.',''); ?>
            <br /> Total:    <?php echo  "$". number_format($order_detail['order_total'],2,'.',''); ?> -->
            <br />
            <br />Cliente: <?php echo  $order_detail['commercial_name']; ?>

            <br />Orden:      <?php echo  $order_detail['id_order']; ?>

            <br />Ruta:    <?php echo  $order_detail['route_name']; ?>
          
            <br />Productos totales: <?php echo $cantproduct ; ?>
            <br />Dirección de entrega:    <?php echo  $order_detail['name_address']; ?>
            <br />Teléfono:    <?php echo  $order_detail['contact_cellphone']; ?>
  
  <!-- <br />Tipo de pago:{{ $order_detail['payment'] === 1 ? 'Tarjeta de crédito/debito ' : ' Efectivo '}}    -->

            <p class="centrado">¡GRACIAS POR SU COMPRA!
            <br /></p>
        </div>




</body>




        </html>

