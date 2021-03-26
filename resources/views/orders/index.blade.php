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
                            Lista de pedidos
                        </h3>
                    </div>
                </div>

            </div>

            <div class="m-portlet__body ">
                <form class="searchForm">
                    <div class="row" style="margin-bottom: 30px">
                    
                        <div class="col-md-6">
                            <span class="m-form__help">Seleccione un rango de fechas</span>

                            <div class="input-daterange input-group" id="m_datepicker_4_3">
                                <input type="text" class="form-control" value="" name="start" id="start" autocomplete="off" />
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="la la-ellipsis-h"></i></span>
                                </div>
                                <input type="text" class="form-control" value="" name="end" id="end" />
                            </div>

                        </div>
                        <div class="col-md-4">
                            <span class="m-form__help">Cliente</span>
                            <select name="customer_id" id="customer_id" class='form-control'>
                                <option value="" disabled selected>Seleccionar cliente</option>
                                <option value="0" >Todos</option>
                                @foreach($customers as $customer)
                                    <option value="{{$customer->id}}" >{{$customer->commercial_name}} </option>
                                @endforeach
                            </select>
                        </div>
                    

                        <div class="col-md-2"style="padding-top: 20px;">
                            <a class="btn btn-accent m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air" id="searchFilter">Buscar</a>
                        </div>
                    </div>
                </form>

            </div>
                    <div class="m-portlet__body table-responsive">
                <table class="table table-striped- table-bordered table-hover table-checkable" id="mtable4">
                <thead>
                    <tr>
                        <th>Número de orden</th>
                        <th>Fecha de entrega</th>
                        <th>Nombre comercial</th>
                        <th>Estatus de pago</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Actualizar estatus de la order  #<span id="NoOrder"></span></h5>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <div class="modal-body" id="bodyDelete">
                    <select class="form-control" id="statusOrder">
                        <option value="">Selecciona un estatus</option>
                        <option value="0">Pendiente de pago</option>
                        <option value="1">Pagado</option>
                        <option value="2">Enviado</option>
                        <option value="3">Cancelado</option>
                    </select>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
                    <button type="button"  class="btn btn-outline-success" id="updateOrder">Aceptar</button>
                    <button type="button" data-dismiss="modal" class="btn btn-outline-danger">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')

    <script type="text/javascript">
 
        $('#listMenu').find('.start').removeClass('start');
        $('#orders').addClass('start');
        $(document).ready(function() {

            var oldStart = 0;
            $('#mtable4').DataTable( {
                'initComplete': function() {
                    $(".spinner2").css("visibility","hidden");
                    $(".background-loader").css("visibility","hidden");
                },
                stateSave: true,
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
            } );
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
    
       $("#searchFilter").click(function(e){
           e.preventDefault();

            var customer_id = $('#customer_id option:selected').val();
            var start = $('#start').val();
            var end = $('#end').val();
            
            filter(customer_id,start,end);
       });

       function filter(customer_id,start,end){

            var newStart = formatDate(start);
            var newEnd = formatDate(end);
            
             $.ajax({
                url: "/filtro",
                headers:{'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                type: "POST",
                data:{customer_id:customer_id,start:newStart,end:newEnd},
                success: function(data) {
                    $('#total').text(data.total);
                    var oldStart = 0;
                    $('#mtable4').DataTable().destroy();
                    $('#mtable4').DataTable(
                        {
                            "data":data.reports,
                            "columns":[
                                {"data":"order_id"},
                                {"data":"delivery_date"},
                                {"data":"name"},
                                {"data":function(data,type,row){
                                    
                                    var htmlData = "";
                                    switch(data.order_status ){
                                        //0: Pendiente de pago, 1: Pagado, 2: Enviado, 3: Cancelado
                                        case 0:
                                            htmlData = "Pendiente de pago";
                                            break;
                                        case 1:
                                            htmlData = "Pagado";
                                            break;
                                        case 2:
                                            htmlData = "Enviado";
                                            break;
                                        case 3:
                                            htmlData = "Cancelado";
                                            break;
                                        default:
                                            htmlData = "No tiene estatus";
                                            break
                                    }
                                    return htmlData;
                                }},
                                
                                {"data": 'order_id', name:'orders.id', render:function (data, type, row) {
                                        return '<a href="/orders/'+data+'" title="Detalle de pedido" class="btn btn-icon-only btn-accent  m-btn m-btn--pill "style="margin: 2px;" target="_blank"><i class="fa flaticon-clipboard "></i></a>' +
                                            '<a href="/ticket/'+data+'" target="_blank" title="Imprimir" class="btn btn-icon-only btn-accent  m-btn m-btn--pill btn-success "style="margin: 2px;" target="_blank"><i class="fa flaticon-technology "></i></a>'+
                                            '<a  onClick="showUpdateStatusOrder('+data+')" title="Actualizar estatus pedido" class="btn btn-icon-only btn-warning  m-btn m-btn--pill "style="margin: 2px;" ><i class="fa flaticon-edit "></i></a>';
                                    },
                                }
                            ],"order":[
                                [0,'desc']
                            ],
                            "language": {
                                "url": "//cdn.datatables.net/plug-ins/1.10.12/i18n/Spanish.json"
                            },
                            "fnDrawCallback": function ( o) {
                        
                                if ( o._iDisplayStart != oldStart ) {
                                    var targetOffset = $('#page-top').offset().top;
                                    $('html,body').animate({scrollTop: targetOffset}, 500);
                                    oldStart = o._iDisplayStart;                        
                                }
                            },
                        });
                },
                error: function(data) {

                }
            });
       }


    function formatDate(date){
        var partDate1 = date.split('/');
        return partDate1[1] + "/" + partDate1[0] + "/" + partDate1[2];
    }

    function showUpdateStatusOrder(order_id){
        $("#updateOrder").attr("onclick","updateStatusOrder("+order_id+")");
        $("#NoOrder").text(order_id);
        $('#myModal').modal({
            backdrop: 'static',
            keyboard: false
        }); 
    }

    function updateStatusOrder(order_id){
        var statusOrder = $("#statusOrder option:selected").val();

        if(statusOrder === ""){
            Swal.fire({
            type: 'error',
            text: 'Por favor selecciona un estatus',
         });
        }else{
            $.ajax({
                url: "/updatestatusOrder",
                headers: {'X-CSRF-TOKEN':'{{csrf_token()}}'},
                type: "post",
                data:{order_id:order_id, order_status:statusOrder},
                success: function() {

                    var customer_id = $('#customer_id option:selected').val();
                    var start = $('#start').val();
                    var end = $('#end').val();

                    filter(customer_id,start,end);

                    $('#myModal').modal("hide");
                   // window.location = "/orders";
                }
            });
        }
    }

    </script>
@endsection
