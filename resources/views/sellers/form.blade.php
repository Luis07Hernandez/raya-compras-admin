<div class="m-portlet__body">



     <div class="form-group m-form__group row">
         <label for="col-lg-2 col-form-label" class="col-2 col-form-label">Nombre Completo</label>
         <div class="col-lg-6">
             {!!Form::text('name',null,['class'=>'form-control m-input', 'placeholder'=>'Ingresar nombre', 'autocomplete'=>"off", 'id'=>'name', ])!!}
         </div>
     </div>




         <div class="form-group m-form__group row">
         <label for="col-lg-2 col-form-label" class="col-2 col-form-label">Teléfono</label>
         <div class="col-lg-6">
             {!!Form::text('phone',null,['class'=>'form-control m-input', 'placeholder'=>'Ingresar teléfono', 'autocomplete'=>"off", 'id'=>'phone', ])!!}
         </div>
     </div>


        <div class="form-group m-form__group row">
         <label for="col-lg-2 col-form-label" class="col-2 col-form-label">Clave</label>
         <div class="col-lg-6">
             {!!Form::text('sku',null,['class'=>'form-control m-input', 'placeholder'=>'Ingresar clave', 'autocomplete'=>"off", 'id'=>'sku', ])!!}
         </div>
     </div>



     @if(isset($sellers))
     <div class="form-group m-form__group row">
         <label for="col-lg-2 col-form-label" class="col-2 col-form-label">url</label>
         <div class="col-lg-6">
             <p style="word-wrap: break-word;max-width: 400px;  white-space:inherit;">{{$sellers->url}}</p>
         </div>
     </div>
    @endif

</div>
<div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
    <div class="m-form__actions m-form__actions--solid">
        <div class="row">
            <div class="col-lg-2"></div>
            <div class="col-lg-6">
                <button type="submit" class="btn btn-outline-success">Aceptar</button>
                <a class="btn btn-outline-danger" href="{{URL::route('sellers.index')}}">Cancelar</a>
            </div>
        </div>
    </div>
</div>
