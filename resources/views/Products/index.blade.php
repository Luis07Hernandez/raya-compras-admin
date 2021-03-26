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
                            Lista de Productos
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    <ul class="m-portlet__nav">
                        <li class="m-portlet__nav-item">
                            <a href="{{URL::route('products.create')}}" class="btn btn-accent m-btn m-btn--pill m-btn--custom m-btn--icon btn-outline-info">
												<span>
													<i class="la la-plus"></i>
													<span>Nuevo producto</span>
												</span>
                            </a>
                        </li>

                    </ul>
                </div>
            </div>
            <div class="m-portlet__body table-responsive">
                <table class="table table-striped- table-bordered table-hover table-checkable" id="mtable2">
                    <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Imagen</th>
                        <th>Categoría</th>
                        <th>Destacado</th>
                        <th>Estatus</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($products as $product)
                        <tr class="odd gradeX">
                            <td>{{$product->name}}</td>
                            <td>{{$product->description}}</td>
                            <td><img src="{{$product->image}}" alt="" width="100"/></td>
                            <td>{{$product->product_name}}</td>
                        
                            <td>
                                <div class="btn btn-icon-only">
                                    <span class="m-switch m-switch--icon m-switch--info">
                                        <label>
                                            <input type="checkbox" class="switch__{{$product->id}}"  onclick="changestatusOust({{$product->id}})"
                                                    {{$product->product_dest == 1 ? 'checked': ''}}>
                                            <span></span>
                                        </label>
                                    </span>
                                </div>
                            </td>

                            <td>@if($product->status  == 1)
                                    <span class="m-badge m-badge--success m-badge--wide"> Activo </span>
                                @else
                                    <span class="m-badge m-badge--danger m-badge--wide"> Inactivo </span>
                                @endif</td>
                            <td>

                                <div class="btn btn-icon-only" style="margin: -15px;" >
                                    <span class="m-switch m-switch--icon m-switch--info">
                                        <label>
                                            <input type="checkbox" class="switch_{{$product->id}}"  onclick="changestatus2({{$product->id}})"
                                                {{$product->status == 1 ? 'checked': ''}}>
                                            <span></span>
                                        </label>
                                    </span>
                                </div>

                                <a href="/products/{{$product->id}}/edit" title="Editar" class="btn btn-icon-only btn-warning  m-btn m-btn--pill "
                                style="margin: 2px" ><i class="fa flaticon-edit"></i></a>

                                <a href="#" data-toggle="modal" data-target="#myModal" data-name="{{$product->name}}" click=modalDelete data-id="{{$product->id}}"
                                 title="eliminar" style="margin: 2px" class="btn btn-icon-only btn grey-salt openBtn btn-danger m-btn m-btn--pill " >
                                 <i class="fa flaticon-close"></i></a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
               
            </div>
        </div>
    </div>


     <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Eliminar</h5>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <div class="modal-body" id="bodyDelete"></div>
                <div class="modal-footer">
                    <input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
                    <button type="button"  class="btn btn-outline-success" onclick="deleteProduct()">Aceptar</button>
                    <button type="button" data-dismiss="modal" class="btn btn-outline-danger">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')

    <script type="text/javascript">


        $('#listMenu').find('.start').removeClass('start');
        $('#productos').addClass('start');


        $('.openBtn').on('click',function(){

            id = $(this).data('id');
            var name = $(this).data('name');

            var nodeName=document.createElement("p");
            var nameNode=document.createTextNode("¿Seguro que desea eliminar el producto: "+ name +"?");
            nodeName.appendChild(nameNode);
            $("#bodyDelete").empty();
            document.getElementById("bodyDelete").appendChild(nodeName);
        });

        function deleteProduct(){
            var token = $("#token").val();

            $.ajax({
                url: "/products/"+id,
                headers: {'X-CSRF-TOKEN':token},
                type: "DELETE",
                success: function() {
                    window.location = "/products";
                    $("#message").fadeIn();
                }
            });
        }



        $(document).ready(function(){

            var oldStart = 0;
            $("#mtable2").dataTable({
                'initComplete': function() {                    
                    $(".spinner2").css("visibility","hidden");
                    $(".background-loader").css("visibility","hidden");
                },
                stateSave: true,
                bDeferRender: true,
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
                },
                "fnDrawCallback": function (o) {
                
                    var urlsaved = localStorage.getItem("urlPaginate");
                    var path = window.location.pathname;
                    if(urlsaved == null){
                        this.api().state.clear();
                        localStorage.setItem("urlPaginate",path);
                        window.location.reload();

                        $(".spinner2").css("visibility","visible");
                        $(".background-loader").css("visibility","visible");

                    }else{
                        if(path !== urlsaved){
                            this.api().state.clear();
                            localStorage.setItem("urlPaginate",path);
                            window.location.reload();
                        }
                    }

                    if ( o._iDisplayStart != oldStart ) {
                        var targetOffset = $('#page-top').offset().top;
                        $('html,body').animate({scrollTop: targetOffset}, 500);
                        oldStart = o._iDisplayStart;
                    }
                }
            });
        });


        function  changestatus2(productsid) {
            var check = $('.switch_'+productsid).is(':checked');
            var token = $("#token").val();
            $.ajax({

                url: "/changestatus2",
                headers: {'X-CSRF-TOKEN': token},
                type: "POST",
                data:{id:productsid,status:check},
                success: function(data) {
                    window.location = "/products";
                }

            });

        }

        function  changestatusOust(outstandingid) {

            console.log(outstandingid);
            var check = $('.switch__'+outstandingid).is(':checked');
            var token = $("#token").val();
            $.ajax({

                url: "/changestatusOust",
                headers: {'X-CSRF-TOKEN': token},
                type: "POST",
                data:{id:outstandingid,status:check},
                success: function(data) {
                    window.location = "/products";
                }

            });

        }
    </script>
@endsection
