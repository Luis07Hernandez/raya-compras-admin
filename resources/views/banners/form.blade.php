<div class="m-portlet__body">
    <div class="form-group m-form__group row">
        <label for="col-lg-2 col-form-label" class="col-2 col-form-label">Título</label>
        <div class="col-lg-6">
            {!!Form::text('title',null,['class'=>'form-control m-input', 'placeholder'=>'Ingresar el nombre', 'autocomplete'=>"off", 'id'=>'title'])!!}
        </div>
    </div>
    <div class="form-group m-form__group row">
        <label for="col-lg-2 col-form-label" class="col-2 col-form-label">Descripción</label>
        <div class="col-lg-6">
            {!! Form::textarea('description', null, ['class'=>'form-control', 'placeholder'=>'Ingresar Descripción', 'id'=>'description']) !!}
        </div>
    </div>

    <div class="form-group m-form__group row">
        <label for="col-lg-2 col-form-label" class="col-2 col-form-label">Imagen</label>
        <div class="input-group col-lg-6">

            <label class="input-group-btn">
                    <span class="btn btn-info">
                        Subir <i class="fa flaticon-upload"></i> <input type="file" id="image" name="image"style="display: none;"  multiple>
                    </span>
            </label>
            {!!Form::text('text', isset($banners ) ? explode("/",$banners->image)[2] :null,['class'=>'form-control m-input' , 'autocomplete'=>"off", 'disabled' => 'disabled'])!!}

            {{--<a data-toggle="popover" title="medida de la imagen"data-content="0x0" class=" colordeicono btn m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill">--}}
            {{--<i class="fa fa-exclamation "></i></a>--}}
        </div>
    </div>

</div>
<div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
    <div class="m-form__actions m-form__actions--solid">
        <div class="row">
            <div class="col-lg-2"></div>
            <div class="col-lg-6">
                <button type="submit" class="btn btn-outline-success">Aceptar</button>
                <a class="btn btn-outline-danger" href="{{URL::route('banners.index')}}">Cancelar</a>
            </div>
        </div>
    </div>
</div>
