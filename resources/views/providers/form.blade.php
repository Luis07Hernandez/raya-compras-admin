<div class="m-portlet__body">
    <div class="form-group m-form__group row">
        <label for="col-lg-2 col-form-label" class="col-2 col-form-label">Nombre</label>
        <div class="col-lg-6">
            {!!Form::text('name',null,['class'=>'form-control m-input', 'placeholder'=>'Ingresar el nombre', 'autocomplete'=>"off", 'id'=>'name', ])!!}
        </div>
    </div>
</div>

<div class="m-portlet__body">
    <div class="form-group m-form__group row">
        <label for="col-lg-2 col-form-label" class="col-2 col-form-label">Teléfono</label>
        <div class="col-lg-6">
            {!!Form::text('phone',null,['class'=>'form-control m-input', 'placeholder'=>'Ingresar el teléfono', 'autocomplete'=>"off", 'id'=>'phone','maxlength'=> "10" ])!!}
        </div>
    </div>
</div>

<div class="form-group m-form__group row">
    <label for="col-lg-2 col-form-label" class="col-2 col-form-label">Logo</label>
    <div class="input-group col-lg-6">
        <label class="input-group-btn">
            <span class="btn btn-info">
                Subir <i class="fa flaticon-upload"></i> <input type="file" id="image" name="image"style="display: none;" multiple>
            </span>
        </label>
        @if(isset($providers))
            @if($providers->image != null)
                {!!Form::text('text', explode("/",$providers->image)[2],['class'=>'form-control m-input', 'autocomplete'=>"off", 'disabled' => 'disabled'])!!}
            @else
                {!!Form::text('text',null,['class'=>'form-control m-input', 'autocomplete'=>"off", 'disabled' => 'disabled'])!!}
            @endif
        @else
            {!!Form::text('text',null,['class'=>'form-control m-input', 'autocomplete'=>"off", 'disabled' => 'disabled'])!!}
        @endif
    </div>
</div>

<div class="m-portlet__body">
    <div class="form-group m-form__group row">
        <label for="col-lg-2 col-form-label" class="col-2 col-form-label">Correo electrónico</label>
        <div class="col-lg-6">
            {!!Form::text('email',null,['class'=>'form-control m-input', 'placeholder'=>'Ingresar el correo electrónico', 'autocomplete'=>"off", 'id'=>'email', ])!!}
        </div>
    </div>
</div>

<div class="form-group m-form__group row">
        <label for="col-lg-2 col-form-label" class="col-2 col-form-label"><span class="required" aria-required="true">Contraseña</label>
        <div class="col-lg-6">
            <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Contraseña" name="password" />
        </div>
    </div>

<div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
    <div class="m-form__actions m-form__actions--solid">
        <div class="row">
            <div class="col-lg-2"></div>
            <div class="col-lg-6">
                <button type="submit" class="btn btn-outline-success">Aceptar</button>
                <a class="btn btn-outline-danger" href="{{URL::route('providers.index')}}">Cancelar</a>
            </div>
        </div>
    </div>
</div>
