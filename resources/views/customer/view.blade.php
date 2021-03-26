@extends ('layouts.main')

@section('content')
    <div class="col-md-12">
        <div class="m-portlet m-portlet--mobile">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                              Datos de cliente
                            </h3>
                        </div>
                    </div>
                    <div class="m-portlet__head-tools">
                    <ul class="m-portlet__nav">
                        <li class="m-portlet__nav-item">
                            <a href="{{URL('customers')}}" class="btn btn-accent m-btn m-btn--pill m-btn--custom m-btn--icon btn-outline-info">
                                <span>
                                    <span>Regresar</span>
                                </span>
                            </a>
                        </li>

                    </ul>
                </div>

                </div>
            <div class="m-portlet__body table-responsive">

                <table class="table table-striped- table-bordered table-hover table-checkable" id="mtable1">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nombre comercial</th>
                        <th>Nombre de contacto</th>
{{--                        <th>Apellido</th>--}}
                        <th>Correo electrónico</th>
                        <th>RFC</th>
                        <th>Estatus</th>
                        <th>Teléfono</th>
                        <th>Celular</th>
                        <th>Domicilio </th>

                    </tr>
                    </thead>
                    <tbody>
                    @foreach($customersdetails as $customersdetail)
                        <tr class="odd gradeX">

                            <td>{{$customersdetail->id}}</td>
                            <td>{{$customersdetail->commercial_name}}</td>
                            <td>{{$customersdetail->customer_name}}</td>
{{--                            <td>{{$customersdetail->last_name}}</td>--}}
                            <td style="width: 18%;">{{$customersdetail->email}}</td>
                            <td>{{$customersdetail->rfc}}</td>
                            <td style="width: 1%;">@if($customersdetail->customer_status  == 1)
                                    <span class="m-badge m-badge--success m-badge--wide"> Activo </span>
                                @else
                                    <span class="m-badge m-badge--danger m-badge--wide"> Inactivo </span>
                                @endif</td>
                            <td>{{$customersdetail->customer_phone}}</td>
                            <td>{{$customersdetail->customer_cellphone}}</td>
                            <td>{{$customersdetail->direction}}</td>



                        </tr>
                    @endforeach
                    </tbody>

                </table>

            </div>












            </div>
    </div>
{{--    <div class="col-md-12">--}}
{{--        <div class="m-portlet m-portlet--mobile">--}}
{{--            <div class="m-portlet__head">--}}
{{--                <div class="m-portlet__head-caption">--}}
{{--                    <div class="m-portlet__head-title">--}}
{{--                        <h3 class="m-portlet__head-text">--}}

{{--                            Direccion--}}
{{--                        </h3>--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--            </div>--}}
{{--            <div class="m-portlet__body table-responsive">--}}

{{--                <table class="table table-striped- table-bordered table-hover table-checkable" id="mtable1">--}}
{{--                    <thead>--}}
{{--                    <tr>--}}
{{--                        <th>calle</th>--}}
{{--                        <th>Nombre de contacto</th>--}}
{{--                        <th>Numero ext</th>--}}
{{--                        <th>Numero int</th>--}}
{{--                        <th>Codigo postal</th>--}}
{{--                        <th>Telefono</th>--}}
{{--                        <th>Celular</th>--}}
{{--                        <th>Colonia</th>--}}
{{--                        <th>Ciudad</th>--}}
{{--                        <th>Calle principal</th>--}}

{{--                    </tr>--}}
{{--                    </thead>--}}
{{--                    <tbody>--}}
{{--                    @foreach($customersdetails as $customersdetail)--}}
{{--                        <tr class="odd gradeX">--}}

{{--                            <td>{{$customersdetail->street}}</td>--}}
{{--                            <td>{{$customersdetail->contact_name}}</td>--}}
{{--                            <td>{{$customersdetail->num_ext}}</td>--}}
{{--                            <td>{{$customersdetail->num_int}}</td>--}}
{{--                            <td>{{$customersdetail->zipcode}}</td>--}}
{{--                            <td>{{$customersdetail->phone}}</td>--}}
{{--                            <td>{{$customersdetail->cellphone}}</td>--}}
{{--                            <td>{{$customersdetail->suburbs_name}}</td>--}}
{{--                            <td>{{$customersdetail->cities_name}}</td>--}}

{{--                            <td style="width: 1%;">--}}
{{--                                @if($customersdetail->is_main  === 1)--}}
{{--                                    <span class="m-badge m-badge--success m-badge--wide"> si </span>--}}

{{--                                    @elseif($customersdetail->is_main  === 0 )--}}

{{--                                    <span class="m-badge m-badge--danger m-badge--wide">no</span>--}}

{{--                                @else--}}

{{--                                @endif</td>--}}

{{--                        </tr>--}}
{{--                    @endforeach--}}
{{--                    </tbody>--}}

{{--                </table>--}}

{{--            </div>--}}












{{--        </div>--}}
{{--    </div>--}}


@endsection


@section('scripts')

    <script type="text/javascript">


        $('#listMenu').find('.start').removeClass('start');
        $('#customers').addClass('start');








    </script>
@endsection
