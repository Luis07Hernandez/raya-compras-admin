
<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <style>

        {{--@font-face {--}}
            {{--font-family: "Montserrat";--}}
            {{--src: url({{$path."/css/fonts/Montserrat/Montserrat-Light.ttf"}});--}}
        {{--}--}}


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
            /*height: 250px;*/
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

<body style="height: 750px;">
<div class="header">
    <!--<div style="background: url('https://reneadmin.messoft.net/Header-RG.png');background-position:center;background-size:contain;background-repeat:no-repeat;width:auto;height:100%;"></div>-->
</div>
<div  class="contentdd">
    <div class="phase">

            {{--<p style=" font-size: 15px; color: #000000;">  El cliente {{$name}} ha solicitado una devolución de la orden <span style="font-weight: bold;"></span>.</p>--}}
        <p style=" font-size: 15px; color: #000000;">  Has recibido un comentario de {{$name}}.</p>
        <p style=" font-size: 15px; color: #000000;"> Teléfono: {{$phone}}</p>
        <p style=" font-size: 15px; color: #000000;"> Asunto:  {{$subject}}</p>
        <p style=" font-size: 15px; color: #000000;"> Comentario:  {{$comments}}</p>


    </div>

</div>


<div class="footer">
   <!-- <div style="background: url('https://reneadmin.messoft.net/Footer-RG.png');background-position:center; background-size: contain;background-repeat: no-repeat;width: auto;height: 100%"></div> -->
</div>

</body>
</html>
