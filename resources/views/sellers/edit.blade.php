@extends('layouts.main')

@section('content')

    <div class="col-md-12">
        <div class="m-portlet" style="align: center;">
            <div class="m-portlet__head">
                <div class="m-portlet__head-caption">
                    <div class="m-portlet__head-title">
                    <span class="m-portlet__head-icon m--hide">
                        <i class="la la-gear"></i>
                    </span>
                        <h3 class="m-portlet__head-text">Editar vendedor</h3>
                    </div>
                </div>
            </div>
            {!! Form::model($sellers,['route' => ['sellers.update',$sellers->id], 'method' => 'PUT','files' => true,'enctype'=>'multipart/form-data', 'class' => 'm-form m-form--fit m-form--label-align-right']) !!}
            @include('sellers.form')
            {!! Form::close(); !!}
        </div>
    </div>
@endsection

@section('scripts')

    <script type="text/javascript">

        $('#listMenu').find('.start').removeClass('start');
        $('#sellers').addClass('start');
    </script>

@endsection