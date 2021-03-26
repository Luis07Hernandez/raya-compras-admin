@extends ('layouts.main')
@section('styles')
    {!! Html::style('/css/spinner.css') !!}
@endsection

@section('content')
    <div class="col-md-12" id="page-top">
        <div class="background-loader"></div>
        <div class="spinner2"></div>
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            Reportes
                        </h3>
                    </div>
                </div>

                <!-- <div class="m-portlet__head-tools">
                    <ul class="m-portlet__nav">
                        <li class="m-portlet__nav-item">
                            <a href="javascript:;" id="print" class="btn btn-accent m-btn m-btn--pill m-btn--custom m-btn--icon btn-outline-info">
                                <span>
                                    <i class="la flaticon-interface-11"></i>
                                    <span>Imprimir</span>
                                </span>
                            </a>
                        </li>

                    </ul>
                </div> -->
            </div>

            <div class="m-portlet__body ">
                <div class="row" style="margin-bottom: 30px">

                    <div class="col-md-4">
                        <span class="m-form__help">Seleccione un rango de fechas</span>
                        <div class="input-daterange input-group" id="m_datepicker_4_3">

                            <input value="<?php //echo date("d/m/yy",strtotime( date("d-m-Y")."- 1 days")); ?>" 
                            type="text" class="form-control m-input" name="start" id="start"/>
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="la la-ellipsis-h"></i></span>
                            </div>
                            <input type="text" class="form-control"value="<?php //echo date("d/m/yy"); ?>" name="end" id="end" />
                        </div>

                    </div>

                    <div class="input-group-append" style="float: left;">
                    <div class="col-auto">

                        <span class="m-form__help">Categoría</span>
                        <select name="categories_id" id="categories_id" class='form-control'>
                            <option value="" disabled selected>Seleccionar categoría</option>
                            <option value="0" >Todos</option>
                            @foreach($categories as $category)
                                <option value="{{$category->id}}" >{{$category->name}}  </option>
                            @endforeach
                        </select>
                    </div>
                    <div class=" col-auto"style="padding-top: 20px">
                        <button onclick="filtro()" class="btn btn-accent m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">Buscar</button>
                    </div>
                </div>
                </div>
        </div>

                <div class="m-portlet__body table-responsive">

                <table class="table table-striped- table-bordered table-hover table-checkable" id="mtable4">
                    <thead>
                    <tr>                        
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Unidad de medida</th>
                        <th style="display: none;">Categoría</th>
                    </tr>
                    </thead>
                </table>
        </div>

        </div>

    </div>

@endsection
@section('scripts')

    <script type="text/javascript">

        $('#listMenu').find('.start').removeClass('start');
        $('#reports').addClass('start');
        $(document).ready(function() {
            var oldStart = 0;
            var printCounter = 0;
            $('#mtable4').DataTable( {
                'initComplete': function() {
                    $(".spinner2").css("visibility","hidden");
                    $(".background-loader").css("visibility","hidden");
                },
                stateSave: true,
                dom: 'Bfrtip',
                buttons: [
                        'copy',
                        {
                            extend: 'excel',
                            messageTop: 'Reporte Concentrado '+ $('#start').val() + ' - '+  $('#end').val()
                        },
                        {
                            extend: 'pdf',
                            messageTop: 'Reporte Concentrado '+ $('#start').val() + ' - '+  $('#end').val()
                        },
                        {
                            extend: 'print',
                            messageTop: function () {
                                printCounter++;
            
                                if ( printCounter === 1 ) {
                                    return 'Reporte Concentrado '+ $('#start').val() + ' - '+  $('#end').val();
                                }
                                else {
                                    return 'Reporte Concentrado '+ $('#start').val() + ' - '+  $('#end').val();
                                }
                            },
                            messageBottom: null
                        }
                    ],
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                },
                "fnDrawCallback": function (o) {
                    $(".spinner2").css("visibility","visible");
                    $(".background-loader").css("visibility","visible");

                    if ( o._iDisplayStart != oldStart ) {
                        var targetOffset = $('#page-top').offset().top;
                        $('html,body').animate({scrollTop: targetOffset}, 500);
                        oldStart = o._iDisplayStart;
                    }
                }
            });
        } );

        var d = new Date();
        var currDay = d.getDate();
        var currMonth = d.getMonth();
        var currYear = d.getFullYear();
        var startDate = new Date(currYear, currMonth, currDay - 1);
        var endDate = new Date(currYear, currMonth, currDay);


        $("#start").datepicker({
            format: 'dd/mm/yyyy'
        }).datepicker('setDate',startDate);

        $("#end").datepicker({
            format: 'dd/mm/yyyy'
        }).datepicker('setDate',endDate);
    

        // $("#excel").click(function() {
        //     $('#mtable4').DataTable().button('.buttons-excel').trigger();
        // });

        // $("#print").click(function(){
        //     $('#mtable4').DataTable().button('.buttons-print').trigger();
        // });

        function filtro() {

            var categories_id = $('#categories_id option:selected').val();
            var start = $('#start').val();
            var end = $('#end').val();
            if ((start==null) || (end==null)){

            }else {

                var newStart = formatDate(start);
                var newEnd = formatDate(end);

                $.ajax({
                    url: "/filtroCategorias",
                    headers:{'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                    type: "POST",
                    data:{categories_id:categories_id,start:newStart,end:newEnd},
                    success: function(data) {

                        $('#total').text(data.total);
                        var oldStart = 0;
                        $('#mtable4').DataTable().destroy();
                        var printCounter = 0;
                        $('#mtable4').DataTable(
                            {   
                                "data":data.reports,
                                "columns":[
                                    {"data":"product_name"},
                                    {"data":"qty"},
                                    {"data":"units"},
                                    {"data":"category_name", "bVisible": false},

                                ],"order":[
                                    [3,'asc']
                                ], rowGroup: {
                                    dataSrc: 'category_name',
                                    color:'black'
                                },
                                dom: 'Bfrtip',
                                buttons: [
                                    'copy',
                                    {
                                        extend: 'excel',
                                        messageTop: 'Reporte Concentrado '+ $('#start').val() + ' - '+  $('#end').val()
                                    },
                                    {
                                        extend: 'pdf',
                                        messageTop: 'Reporte Concentrado '+ $('#start').val() + ' - '+  $('#end').val()
                                    },
                                    {
                                        extend: 'print',
                                        messageTop: function () {
                                            printCounter++;
                        
                                            if ( printCounter === 1 ) {
                                                return 'Reporte Concentrado '+ $('#start').val() + ' - '+  $('#end').val();
                                            }
                                            else {
                                                return 'Reporte Concentrado '+ $('#start').val() + ' - '+  $('#end').val();
                                            }
                                        },
                                        messageBottom: null
                                    }
                                ],"language": {
                                    "url": "//cdn.datatables.net/plug-ins/1.10.12/i18n/Spanish.json"
                                },
                                "fnDrawCallback": function (o) {
                                    if ( o._iDisplayStart != oldStart ) {
                                        var targetOffset = $('#page-top').offset().top;
                                        $('html,body').animate({scrollTop: targetOffset}, 500);
                                        oldStart = o._iDisplayStart;
                                    }
                                }
                            });

                        $("#print").click(function(){
                            $('#mtable4').DataTable().button('.buttons-print').trigger();
                        });

                    },
                    error: function(data) {

                    }
                });
            }
        }

        function formatDate(date){
            var partDate1 = date.split('/');
            return partDate1[1] + "/" + partDate1[0] + "/" + partDate1[2];
        }
    </script>
@endsection
