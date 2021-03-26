@extends ('layouts.main')

@section('content')
    <div class="col-md-12">
        <div class="m-portlet m-portlet--mobile">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                        <h3 class="m-portlet__head-text">
                            tikets
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    <ul class="m-portlet__nav">
                        <li class="m-portlet__nav-item">

                            <a id="print" class="btn btn-accent m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">
												<span>
													<i class="la flaticon-technology"></i>
													<span>IMPRIMIR</span>
												</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="m-portlet__body ">
                <div class="row" style="margin-bottom: 30px">
                    <div class="col-auto">
                        <span class="m-form__help">Pedido</span>
                        <select name="order_id" id="order_id" class='form-control'>
                            <option value="" disabled selected>Seleccionar pedido</option>
                            @foreach($orders as $order)
                                <option value="{{$order->id}}" >{{$order->id}} {{$order->delivery_date}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <span class="m-form__help">Categorias</span>
                        <div class="col-auto">
                            <select class="js-example-basic-multiple form-control col-lg-auto col-form-label" id="categoria" name="categoria[]"  multiple="multiple" >
                            </select>
                        </div>
                    </div>
                    <div class=" col-auto"style="padding-top: 20px">
                        <button onclick="tabletiket()" class="btn btn-accent m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">Buscar</button>
                    </div>
                </div>

            </div>

                <div class="m-portlet__body table-responsive">

                    <table class="table table-striped- table-bordered table-hover table-checkable" id="mtable4">
                        <thead>
                        <tr>
                            <th id="ocultar">Categoria</th>
                            <th>Producto</th>
                            <th>Cantidad</th>
                        </tr>
                        </thead>

                        <tfoot>
                        <tr>
                            <th id="ocultar1"></th>
                            <th  id="foot" style="" >Pedido y ruta</th>
                            <th></th>
                        </tr>
                        </tfoot>
                    </table>


            </div>

        </div>





    </div>


    </div>



@endsection
@section('scripts')

    <script type="text/javascript">

        $(document).ready(function(){
            $('[data-toggle="popover"]').popover();
            $('.js-example-basic-multiple').select2({
                placeholder: "Filtrar por categorias",
                allowClear: true
            });
            $("#ocultar").toggle();
            $("#ocultar1").toggle();
            document.getElementById("btn_Validar").disabled = !document.getElementById("order_id").value.length;

        });
        $('#listMenu').find('.start').removeClass('start');
        $('#tikets').addClass('start');
        $(document).ready(function() {
            $('#mtable4').DataTable( {



                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json"
                }
            } );

        } );




        $('#order_id').on('change',function () {
            var order_id = $(this).val();


            $.ajax({
                url: "/tiketfilter",
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                type: "POST",
                data: {order_id:order_id},
                success: function (data) {

                    console.log(data);

                    $("#categoria").html(data);

                    var optionshtml = '';
                    $.each(data,function (k,v) {
                        optionshtml += '<option value="'+ v.value +'">'+ v.text +'</option>';
                    });
                    $('#categoria').append(optionshtml);


                },
                error: function (data) {

                }
            });
        });
        function tabletiket() {
            var order_id = $('#order_id option:selected').val();
            // var categoria = $('#categoria option:selected').val();
            var categoria = $("#categoria").val();

            // $(".select2-selection__rendered").find("li").each(function(index){
            //
            //     if($(this).text()!=""){
            //         var valorAnterior = categoria[index]
            //         categoria[index] = {
            //             id:valorAnterior,
            //             valor:$(this).text().replace("×","")
            //         }
            //     }
            //
            // })
            //
            console.log(categoria);

                $.ajax({
                    url: "/tabletiket",
                    headers:{'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'},
                    type: "POST",
                    data:{categoria:categoria,order_id:order_id},
                    success: function(data) {

                        console.log(data.order_details);

                        $('#foot').text(data.foot);
                            // $('#foot').css('background-color', '#f4f5f8');
                        $("#print").click(function(){
                            $('#mtable4').DataTable().button('.buttons-print').trigger();
                        });
                        $('#mtable4').DataTable().destroy();
                        $('#mtable4').DataTable(
                            {"data":data.order_details,
                                "columns":[
                                    {"data":"text","bVisible": false},
                                    {"data":"product_name"},
                                    {"data":"qty_unit"},
                                ]

                                ,"order":[
                                    [0,'asc']
                                ], rowGroup: {
                                    dataSrc: 'text',
                                    // dataSrc: 1
                                } ,
                                buttons: [
                                    { extend: 'print', footer: true, exportOptions: {
                                            columns: ':visible',
                                            groupBy:':visible'
                                        }}
                                ],
                                "language": {
                                    "url": "//cdn.datatables.net/plug-ins/1.10.12/i18n/Spanish.json"
                                },



                            });

                    },
                    error: function(data) {

                    }
                });





        }

    </script>
@endsection
