 <div class="m-portlet__body">
    <div class="form-group m-form__group row">
        <label for="col-lg-2 col-form-label" class="col-2 col-form-label">Nombre de categoria</label>
        <div class="col-lg-6">
            {!!Form::text('name',null,['class'=>'form-control m-input', 'placeholder'=>'Ingresar el nombre', 'autocomplete'=>"off", 'id'=>'name', ])!!}
        </div>
    </div>
 </div>
 <div class="form-group m-form__group row">
    <label for="col-lg-2 col-form-label" class="col-2 col-form-label">Estatus</label>
    <div class="col-lg-6">
        <div class="btn btn-icon-only"style="margin: -15px;" >
            <span class="m-switch m-switch--icon m-switch--info" >
                <label>
                    @if(!isset($categories))
                    <input type="checkbox" name="is_enable" class="switch">
                    <span></span>
                    @else
                        <input type="checkbox" name="is_enable" class="switch" {{$categories->is_enable == 1 ? 'checked': ''}}>
                        <span></span>
                    @endif
                </label>
            </span>
        </div>
    </div>
</div>
 <div class="form-group m-form__group row">
    <label for="col-lg-2 col-form-label" class="col-2 col-form-label">Proveedor</label>
    <div class="col-lg-6">
        <select class='js-example-basic-single form-control' name="providers_id" id="id_label_single">
            <option value="">Selecciona</option>
            @foreach($providers as $provider)
                <?php $selected=""; ?>
                @if(isset($providerSelected))
                    @if($provider->id === $providerSelected->providers_id)
                        <?php $selected="selected"; ?>
                    @endif 
                @endif
                <option value="{{$provider->id}}" {{$selected}}>{{$provider->name}}</option>
                @endforeach
        </select>
    </div>
</div>
<div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
    <div class="m-form__actions m-form__actions--solid">
        <div class="row">
            <div class="col-lg-2"></div>
            <div class="col-lg-6">
                <button type="submit" class="btn btn-outline-success">Aceptar</button>
                <a class="btn btn-outline-danger" href="{{URL::route('categories.index')}}">Cancelar</a>
            </div>
        </div>
    </div>
</div>
