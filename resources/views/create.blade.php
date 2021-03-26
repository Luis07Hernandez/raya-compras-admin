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
                        <h3 class="m-portlet__head-text">Crear</h3>
                    </div>
                </div>
            </div>

           {!! Form::open(['route'=>'products.store','method'=>'POST','files' => true,'enctype'=>'multipart/form-data','class'=>'m-form m-form--fit m-form--label-align-right']) !!}
            @include('Products.form')
            {!! Form::close(); !!}

        </div>
    </div>

    @include('Products.modalUnits')
@endsection
@section('scripts')

    <script type="text/javascript">

        $('#listMenu').find('.start').removeClass('start');
        $('#productos').addClass('start');


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

        $(".unitsPrice").click(function(){
            //unitModal
            $('#unitModal').modal({
                backdrop: 'static',
                keyboard: false
            }); 
        });


        function unitForm(){
            var form = $("#unitsForm").serializeArray();

            $(".unitInput").html('');
            var inputs = "";
            $.each(form,function(k,v){
                if(v.name != "isShow"){
                    inputs += '<input type="hidden" name="'+v.name+'" value="'+v.value+'" />';
                }
                
            });

            $(".unitInput").append(inputs);
            $('#unitModal').modal('hide');

        }


        function setValueIsShow(unit_id){

            $(".isShow").val(0);
            $(".isShow_"+unit_id).val(1);

        }

</script>

    @endsection
