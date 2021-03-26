 <div class="m-portlet__body">



     <div class="form-group m-form__group row">
         <label for="col-lg-2 col-form-label" class="col-2 col-form-label">Ingresar ruta</label>
         <div class="col-lg-6">
             {!!Form::text('name',null,['class'=>'form-control m-input', 'placeholder'=>'Ingresar el ruta', 'autocomplete'=>"off", 'id'=>'name', ])!!}
         </div>
     </div>




     <div class="form-group m-form__group row">

         <label for="col-lg-2 col-form-label" class="col-2 col-form-label">Seleccione clientes</label>
         <div class="col-lg-6">
             {{--{{$routes->customers}}--}}
     <select class="js-example-basic-multiple form-control col-lg-auto col-form-label" id="customers" name="customers[]" multiple="multiple" >
         @foreach($customers as $customer)
             <?php $selected = ""; ?>
             @if(isset($routes))
                 @foreach($routes->customers as $item)
                     @if( $item -> pivot->customer_id == $customer->id)
                         <?php $selected = "selected"; ?>
                     @endif
                @endforeach
             @endif
             <option value="{{$customer->id}}" {{$selected}}>{{$customer->contact_name}} {{$customer->last_name}}</option>
         @endforeach

     </select>
         </div>
     </div>


</div>
<div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
    <div class="m-form__actions m-form__actions--solid">
        <div class="row">
            <div class="col-lg-2"></div>
            <div class="col-lg-6">
                <button type="submit" class="btn btn-outline-success">Aceptar</button>
                <a class="btn btn-outline-danger" href="{{URL::route('routes.index')}}">Cancelar</a>
            </div>
        </div>
    </div>
</div>
