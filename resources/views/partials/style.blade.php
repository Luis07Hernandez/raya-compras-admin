<!-- begin::Head -->
<head>
    {{--<meta charset="utf-8" />--}}
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Administrador Raya Compras</title>
    <meta name="description" content="Latest updates and statistic charts">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">

    <!--begin::Web font -->
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
    {{--{!! Html::script('https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js') !!}--}}
    <script>
        WebFont.load({
            google: {"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]},
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>
    <style>
        .required-val{
            color: #b9d881;
        }
        th {
            text-align: center !important;
        }

        .countNotifications{
            position: relative;
            padding: 0 15px 0 0;
            margin: 0 10px 1px 0;
            display: inline-block;
            vertical-align: middle;
        }

        .m-nav__link-badge{
            background: #ff3100;
            display: block;
            text-align: center;
            position: absolute;
            top: -9px;
            right: 0;
            border-radius: 30px;
            width: 20px;
            height: 20px;
            line-height: 20px;
            font-size: 12px;
            color: #fff;
            font-weight: 700;
        }

    .datepicker{
        z-index: 1000 !important; 
        }
    </style>


    {{--faficon--}}

    <link rel="shortcut icon" href="/images/favicon2.ico" />
        <link rel=”shortcut icon” type=”image/png” href=”/images/product-varios.png”/>
    <!--end::Web font -->

    <!--begin::Global Theme Styles -->
    {!! Html::style('assets/vendors/base/vendors.bundle.css') !!}
    {!! Html::style('assets/demo/default/base/style.bundle.css') !!}

    <!--end::Global Theme Styles -->

    <!--begin::Page Vendors Styles -->
    {!! Html::style('assets/vendors/custom/fullcalendar/fullcalendar.bundle.css') !!}

    <!--end::Page Vendors Styles -->

    {{-- <base href="/assets/demo/default/media/img/logo/favicon.ico"> --}}
     <base href="/images/product-varios.png">
    {!! Html::style('assets/vendors/custom/datatables/datatables.bundle.css') !!}
    {!! Html::style('https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css') !!}

    @yield('styles')
  <style>


      /*color de hover, after y span en botones e imputs*/

      .m-subheader .m-subheader__breadcrumbs.m-nav>.m-nav__item>.m-nav__link:hover>.m-nav__link-icon {
          color: #a8d860;
      }
      .m-subheader .m-subheader__breadcrumbs.m-nav>.m-nav__item>.m-nav__link:hover>.m-nav__link-text {
          color: #a8d860;
      }
      .m-menu__item:hover{

          background-color: #a8d860;

      }
      .start{

          background-color: #a8d860;
      }
      th{
          color: #000000;
      }
      
      .dropzone .dz-preview .dz-image img {

          width: 120px;
          height: 120px;
      }
      /*.form-control:hover{     border: 1px solid #ff0000;!important;}*/
      /*.select2-results__option:before{background-color:#ff0000;!important;}*/

      .select2-dropdown--above {
          border: 1px solid #a8d860 !important;
          border-bottom: none !important;

      }


      .select2-dropdown--below{
          border: 1px solid #a8d860 !important;;
          border-top: none !important;

      }

      span.select2-selection--multiple[aria-expanded=true] {
          border-color: #a8d860 !important;
      }
      span.select2-selection--multiple[aria-expanded=true] {
          border-color: #a8d860 !important;
      }
          .form-control:focus{
          border: 1px solid #a8d860;!important;
      }
      .m-brand.m-brand--skin-dark .m-brand__tools .m-brand__toggler:hover span::before, .m-brand.m-brand--skin-dark .m-brand__tools .m-brand__toggler:hover span::after {
          background: #a8d860;
      }
      .m-brand.m-brand--skin-dark .m-brand__tools .m-brand__toggler.m-brand__toggler--active span::before, .m-brand.m-brand--skin-dark .m-brand__tools .m-brand__toggler.m-brand__toggler--active span::after
      {     background: #a8d860;}

      .m-brand.m-brand--skin-dark .m-brand__tools .m-brand__toggler.m-brand__toggler--active span
      {  background: #a8d860;}

      .m-brand.m-brand--skin-dark .m-brand__tools .m-brand__toggler:hover span{

          background: #a8d860;
      }

      .dataTables_wrapper .pagination .page-item.active>.page-link {
          background: #a8d860;
          color: #fdffee;
      }
.start{
    background-color: #a8d860;

}

      .colordeicono{
          color: #fff;
          background-color: #a8d860;
          border-color: #a8d860;}

      .colordeicono:hover{
          color: #fff;
          background-color: #a8d860;
          border-color: #a8d860;}
      .colordeicono:active{

          background-color: #a8d860;!important;
          border-color: #a8d860;!important;}
      .m-switch input:empty ~ span {

          margin: 0px 0;

          margin-top: 10px;
      }

      .dataTables_wrapper .pagination .page-item.next>.page-link:hover{

          background: #a8d860;
      }
      .dataTables_wrapper .pagination .page-item.previous>.page-link:hover{
          background: #a8d860;
      }

/*color de selec2*/

      .select2-container--default.select2-container--focus .select2-selection--multiple {
          border: solid #a8d860 1px;

      }

      /*colores para los calendarios*/
      .datepicker tbody tr > td.day.today {
          background:
                  #a8d860;
          color:
                  #fff;
      }
      .datepicker tbody tr > td.day.selected, .datepicker tbody tr > td.day.selected:hover, .datepicker tbody tr > td.day.active, .datepicker tbody tr > td.day.active:hover {
          background: #a8d860;
          color:
                  #fff;
      }

      .select2-container--default .select2-selection--multiple .select2-selection__rendered {

          margin: 5px;

      }
      .select2-container--default .select2-selection--multiple {

          border: 1px solid #ebedf2;

      }


      tr.group,
      tr.group:hover {
          background-color: #ddd !important;
      }

      /*table{*/
          /*table-layout: fixed;*/
          /*width: 250px;*/
      /*}*/

      /*th, td {*/
          /*border: 1px solid blue;*/
          /*width: 100px;*/
          /*word-wrap: break-word;*/
      /*}*/
      td,
      th,
      tr,


      td.producto,
      th.producto {
          width: 75px;
          max-width: 75px;
          color: #000000;
      }

      td.cantidad,
      th.cantidad {
          width: 110px;
          max-width: 110px;
          word-break: break-all;
      }

      td.categoria,
      th.categoria {
          width: 110px;
          max-width: 110px;
          word-break: break-all;
      }

      .centrado {
          text-align: center;
          align-content: center;
      }

      .ticket {
          width: 155px;
          max-width: 155px;
          position: sticky;
          top: 50px;
          left: 50%;
      }

.m-topbar .m-topbar__nav.m-nav>.m-nav__item>.m-nav__link .m-nav__link-icon>i:before {
    background: -webkit-gradient(linear, left top, left bottom, color-stop(25%, #ad5beb), color-stop(50%, #c678db), color-stop(75%, #da6ea9), to(#e76e92));
    background: linear-gradient(180deg, #212529 25%, #212529 50%, #212529 75%, #212529 100%);
    background-clip: text;
    text-fill-color: transparent;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}
  </style>

    @yield('styles')
</head>

<!-- end::Head -->
