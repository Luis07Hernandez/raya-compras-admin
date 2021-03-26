 <div class="m-portlet__body">



     <div class="form-group m-form__group row">
         <label for="col-lg-2 col-form-label" class="col-2 col-form-label">Comentario</label>
         <div class="col-lg-6">
             {!!Form::textarea ('comment',null,['class'=>'form-control m-input', 'placeholder'=>'Ingresar nombre', 'autocomplete'=>"off", 'id'=>'comment', ])!!}
         </div>
     </div>

 
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
