        <!DOCTYPE html>
        <html lang="es">
                <head>

                            <link href="" rel="stylesheet" type="text/css"/>

                            <style>
                                p{
                                    font-family:sans-serif;
                                    text-align: center;
                                }

                                    .posiciontexto{

                                        margin-left: auto;
                                        margin-right: auto;
                                        width: 41%;
                                    }
                            </style>
                    </head>
        <body style="font-family:sans-serif">



            {{--<header style="    background-image:url('https://admon.rayafrutasyverduras.com.mx/public/images/Header-OK.png');--}}
                {{--height: 100px;">--}}

            {{--</header>--}}


            <div style="width: 100%;height: 250px;">


                    <div style="background: url(https://admon.rayafrutasyverduras.com.mx/images/HeaderOK.png);background-position:center;background-size:contain;background-repeat:no-repeat;width:102%;height:100%;margin-top: -11px;"></div>


            </div>
            <div  style="width: 100%;
                height: 250px;
   margin-top: 5%;
    margin-bottom: -6%;;

">
                <div>
            @if($status == 1 )



                <div class="posiciontexto" >
                <p style="  font-size: 16px; font-weight: bold;">Hola {{$customer->contact_name}}</p>
                <p style="  font-size: 14px;">
                    Tu cuenta fue activada de forma exitosa por el administrador. De ahora en adelante puedes acceder a la plataforma de compras. Felicidades.
                </p>

            </div>
                <div style="    width: 200px; margin-left: auto; margin-right: auto;">

                    <h3 style="font-family:sans-serif  ;  width: 200%;" class="posiciontexto">  Gracias por confiar en Nosotros.</h3>
                </div>

            @else


                <div class="posiciontexto">
                    <p style="  font-size: 16px; font-weight: bold;">Hola {{$customer->contact_name}}</p>


                    <p style=" font-size: 14px;">Tu cuenta fue desactivada por el administrador.
                    </p>
            </div>

            @endif
            </div>
            </div>


            <div style="width: 100%;
                height: 250px;

               ">


                <div style="background: url(https://admon.rayafrutasyverduras.com.mx/images/FooterOK.png);background-position:center;background-size:contain;background-repeat:no-repeat;width:100%;height:100%;margin-top: -11px;"></div>


            </div>

        </body>
        </html>


