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
                            Lista de banners
                        </h3>
                    </div>
                </div>
                <div class="m-portlet__head-tools">
                    <ul class="m-portlet__nav">
                        <li class="m-portlet__nav-item">
                            <a href="{{URL::route('banners.create')}}" class="btn btn-accent m-btn m-btn--pill m-btn--custom m-btn--icon btn-outline-info">
												<span>
													<i class="la la-plus"></i>
													<span>Nuevo banner</span>
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
                            <th>Id</th>
                            <th>Título</th>
                            <th>Descripción</th>
                            <th>Imagen</th>
                            <th>Estatus</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($banners as $banner)
                        <tr class="odd gradeX">

                            <td>{{$banner->id}}</td>
                            <td>{{$banner->title}}</td>
                            <td>{{$banner->description}}</td>
                            <td><img src="{{$banner->image}}" alt="" width="100"/></td>

                            <td>@if($banner->banner_status  == 1)
                                    <span class="m-badge m-badge--success m-badge--wide"> Activo </span>
                                @else
                                    <span class="m-badge m-badge--danger m-badge--wide"> Inactivo </span>
                                @endif</td>
                            <td>
                                <div class="btn btn-icon-only"style="margin: -15px;" >
                                    <span class="m-switch m-switch--icon m-switch--info" >
                                        <label>
                                            <input type="checkbox" class="switch_{{$banner->id}}"  onclick="changestatus({{$banner->id}})"
                                                {{$banner->banner_status == 1 ? 'checked': ''}}>
                                            <span></span>
                                        </label>
                                    </span>
                                </div>

                                <a href="/banners/{{$banner->id}}/edit" title="Editar" class="btn btn-icon-only btn-warning  m-btn m-btn--pill " style="margin: 2px" ><i class="fa flaticon-edit"></i></a>

                                <a  href="#" data-toggle="modal" data-target="#myModal" data-name="{{$banner->title}}" click=modalDelete data-id="{{$banner->id}}" title="eliminar" style="margin: 2px"  class="btn btn-icon-only btn grey-salt openBtn btn-danger m-btn m-btn--pill "><i class="fa flaticon-close"></i></a>

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
        $('#banners').addClass('start');


        $('.openBtn').on('click',function(){

            id = $(this).data('id');
            var name = $(this).data('id');

            var nodeName=document.createElement("p");
            var nameNode=document.createTextNode("¿Seguro que desea eliminar el banner: #"+ name +"?");
            nodeName.appendChild(nameNode);
            $("#bodyDelete").empty();
            document.getElementById("bodyDelete").appendChild(nodeName);
        });

        function deleteProduct(){
            var token = $("#token").val();

            $.ajax({
                url: "/banners/"+id,
                headers: {'X-CSRF-TOKEN':token},
                type: "DELETE",
                success: function() {
                    window.location = "/banners";
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

        function  changestatus(bannerid) {
            var check = $('.switch_'+bannerid).is(':checked');
            var token = $("#token").val();
            $.ajax({

                url: "/changestatus",
                headers: {'X-CSRF-TOKEN': token},
                type: "POST",
                data:{id:bannerid,status:check},
                success: function(data) {
                    window.location = "/banners";
                }

            });

        }
    </script>
@endsection
