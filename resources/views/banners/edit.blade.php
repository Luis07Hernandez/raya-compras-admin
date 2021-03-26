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
                        <h3 class="m-portlet__head-text">Editar</h3>
                    </div>
                </div>
            </div>
            {!! Form::model($banners,['route' => ['banners.update',$banners->id], 'method' => 'PUT','files' => true,'enctype'=>'multipart/form-data', 'class' => 'm-form m-form--fit m-form--label-align-right']) !!}
            @include('banners.form')
            {!! Form::close(); !!}
        </div>
    </div>
@endsection

@section('scripts')

    <script type="text/javascript">


        $('#listMenu').find('.start').removeClass('start');
        $('#banners').addClass('start');

        $(document).ready(function(){
            $('[data-toggle="popover"]').popover();
        });

        $(function() {

            // We can attach the `fileselect` event to all file inputs on the page
            $(document).on('change', ':file', function() {
                var input = $(this),
                    numFiles = input.get(0).files ? input.get(0).files.length : 1,
                    label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
                input.trigger('fileselect', [numFiles, label]);
            });

            // We can watch for our custom `fileselect` event like this
            $(document).ready( function() {
                $(':file').on('fileselect', function(event, numFiles, label) {

                    var input = $(this).parents('.input-group').find(':text'),
                        log = numFiles > 1 ? numFiles + ' files selected' : label;

                    if( input.length ) {
                        input.val(log);
                    } else {
                        if( log ) alert(log);
                    }

                });
            });

        });
    </script>

@endsection