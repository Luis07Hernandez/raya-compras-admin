
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Administrador Raya Compras</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />

    {!! Html::style('https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all') !!}

    {!! Html::style('assetslogin/global/plugins/font-awesome/css/font-awesome.min.css') !!}
    {!! Html::style('assetslogin/global/plugins/simple-line-icons/simple-line-icons.min.css') !!}
    {!! Html::style('assetslogin/global/plugins/bootstrap/css/bootstrap.min.css') !!}
    {!! Html::style('assetslogin/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css') !!}
    {!! Html::style('assetslogin/global/plugins/select2/css/select2.min.css') !!}
    {!! Html::style('assetslogin/global/plugins/select2/css/select2-bootstrap.min.css') !!}
    {!! Html::style('assetslogin/global/css/components-rounded.css') !!}
    {!! Html::style('assetslogin/global/css/plugins.min.css') !!}
    {!! Html::style('assetslogin/pages/css/login.css') !!}

    <link rel="shortcut icon" href="/images/product-varios.png" />

    <style>

        .login .content h3{

            color: #a8d860;

        }

        .btn.green:not(.btn-outline) {
            color: #FFFFFF;
            background-color: #a8d860;
            border-color: #a8d860;

        }
        .btn.green:start{
            background-color: #a8d860;

        }
        .btn.green:focus{
            background-color: #a8d860 !important;
            color: #a8d860;
            border-color: #a8d860;
        }
        .btn.green:not(.btn-outline):hover {
             color: #FFFFFF;
             background-color: #a8d860;
             border-color: #a8d860;
         }

         .login .content {
 
    margin-top:  8%;
}

    </style>

</head>

<body class=" login">
<div class="logo">
 
    <img src="{{url('/images/flech2.png')}}" alt=""  style="margin-bottom: -50px; width: 35%;"
/>
</div>

<div class="content">
    @yield('content')
</div>

{{--<div class="copyright"> 2019 © Messoft Systems. </div>--}}

{!! Html::script('assetslogin/global/plugins/respond.min.js') !!}
{!! Html::script('assetslogin/global/plugins/excanvas.min.js') !!}
{!! Html::script('assetslogin/global/plugins/ie8.fix.min.js') !!}

{!! Html::script('assetslogin/global/plugins/jquery.min.js') !!}
{!! Html::script('assetslogin/global/plugins/bootstrap/js/bootstrap.min.js') !!}
{!! Html::script('assetslogin/global/plugins/js.cookie.min.js') !!}
{!! Html::script('assetslogin/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js') !!}
{!! Html::script('assetslogin/global/plugins/jquery.blockui.min.js') !!}
{!! Html::script('assetslogin/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js') !!}

{!! Html::script('assetslogin/global/plugins/jquery-validation/js/jquery.validate.min.js') !!}
{!! Html::script('assetslogin/global/plugins/jquery-validation/js/additional-methods.min.js') !!}
{!! Html::script('assetslogin/global/plugins/select2/js/select2.full.min.js') !!}

{!! Html::script('assetslogin/global/scripts/app.min.js') !!}
{!! Html::script('assetslogin/pages/scripts/login.min.js') !!}
</body>
</html>
