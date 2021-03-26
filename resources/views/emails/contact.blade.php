<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

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
            height: 250px;
            display: table;
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
            position: fixed;
            bottom:0;
            left: 0;
            right: 0;
        }
        @media (min-width: 481px) and (max-width: 767px) {
            .contentdd{
                width: 100%;
                height: 200px;
                display: table;
            }
        }
        @media (min-width: 320px) and (max-width: 480px) {
            .contentdd{
                width: 100%;
                height: 200px;
                display: table;
            }
        }
    </style>
</head>

<body style="height: 750px;">
<div style="width: 100%;height: 250px;">
    <div style="background: url(https://admon.rayafrutasyverduras.com.mx/images/HeaderOK.png);background-position:center;background-size:contain;background-repeat:no-repeat;width:102%;height:100%;margin-top: -11px;"></div>
</div>
<div  class="contentdd">
    <div class="phase">
        <p style=" font-size: 15px; color: #000000;"> ¡Hola Administrador!</p>
        <p style=" font-size: 15px; color: #000000;">Has recibido una solicitud de registro del siguiente usuario:</p>
        <p style=" font-size: 15px; color: #000000;"> <span style="font-weight: bold;">Correo del solicitante:</span> {{$customer->email}}</p>
        @if($password != null)
            <p style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #000000;"> <span style="font-weight: bold;">Accede a la plataforma de administración para darlo de alta
                    (Administración de clientes > Buscar al usuario > Activar con el botón azul)</span></p>
        @endif
    </div>
</div>

<div style="width: 100%; height: 250px;    ">
    <div style="background: url(https://admon.rayafrutasyverduras.com.mx/images/FooterOK.png);background-position:center;background-size:contain;background-repeat:no-repeat;width:100%;height:100%;margin-top: -11px;"></div>
</div>
</body>
</html>
