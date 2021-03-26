@extends ('layouts.main')

@section('content')

    <div class="col-md-12">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            Detalle de pedido
                        </h3>
                    </div>
                </div>
            </div>
            <div class="m-portlet__body table-responsive">
                <p><span style="font-weight: bold;">N° orden:</span> {{$order->id}} <br/>
                <span style="font-weight: bold;">Cliente:</span> {{isset($order->customer->commercial_name) ? $order->customer->commercial_name : ''}}</p>
                <table class="table table-striped- table-bordered table-hover table-checkable" id="mtable1">
                    <thead>
                    <tr>
                        <th>Categoría</th>
                        <th>Nombre de producto</th>
                        <th>Cantidad</th>
                        <th>Unidad de medida</th>
                        <th>Imagen</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($order_details as $order_detail)
                            <tr class="odd gradeX">
                                <td>{{$order_detail->category_name .'-'.$order_detail->orders_id.'-'.$order_detail->category_id}}</td>
                                <td>{{$order_detail->product_name}}</td>
                                <td>{{$order_detail->qty}} </td>
                                <td>{{$order_detail->units_name}} </td>
                                <td><img src="{{$order_detail->product_image}}" alt="" width="100"/></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

    <script type="text/javascript">

        $('#listMenu').find('.start').removeClass('start');
        $('#orders').addClass('start');

        $(document).ready(function() {
            var groupColumn = 0;

            var table = $('#mtable1').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                },"columnDefs": [
                    { "visible": false, "targets": groupColumn },
                ]
                ,"order": [[ groupColumn, 'asc' ]],
                "displayLength": 25,

                "drawCallback": function ( settings ) {
                    var api = this.api();
                    var rows = api.rows( {page:'current'} ).nodes();
                    var last=null;

                    api.column(groupColumn, {page:'current'} ).data().each( function ( group, i ) {
                        if ( last !== group ) {
                            var nameColumn = group.split("-");
                            $(rows).eq( i ).before(
                                '<tr class="group"><td colspan="4">'+
                                ''+nameColumn[0]+ '' +
                                ' ' + 
                                '<a href="/ticket/'+nameColumn[1]+'/'+nameColumn[2]+'" target="_blank" title="Imprimir" class="btn btn-icon-only btn-accent  m-btn m-btn--pill pull-right btn-success"style="margin: -7px;" >' +
                                '<i class="fa flaticon-technology "></i></a>'+'</td></tr>'
                            );

                            last = group;
                        }
                    } );
                }
            } );
        } );
    </script>
@endsection