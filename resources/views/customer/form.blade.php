 <div class="m-portlet__body">
    <div class="form-group m-form__group row">
        <label for="col-lg-2 col-form-label" class="col-2 col-form-label">ID de cliente para Contpaqi</label>
        <div class="col-lg-6">
            {!!Form::text('contpaqi',null,['class'=>'form-control m-input', 'placeholder'=>'Ingresar el contpaqi', 'autocomplete'=>"off", 'id'=>'contpaqi', ])!!}
        </div>
    </div>


    <div class="form-group m-form__group row">
        <label for="col-lg-2 col-form-label" class="col-2 col-form-label">Nombre de contacto</label>
        <div class="col-lg-6">
            {!!Form::text('contact_name',null,['class'=>'form-control m-input', 'placeholder'=>'Ingresar el nombre', 'autocomplete'=>"off", 'id'=>'contact_name', ])!!}
        </div>
    </div>

    <div class="form-group m-form__group row">
        <label for="col-lg-2 col-form-label" class="col-2 col-form-label">Apellido</label>
        <div class="col-lg-6">
            {!!Form::text('last_name',null,['class'=>'form-control m-input', 'placeholder'=>'Ingresar el Apellido', 'autocomplete'=>"off", 'id'=>'last_name', ])!!}
        </div>
    </div>
 <div class="form-group m-form__group row">
        <label for="col-lg-2 col-form-label" class="col-2 col-form-label">Email</label>
        <div class="col-lg-6">
            {!!Form::text('email',null,['class'=>'form-control m-input', 'placeholder'=>'Ingresar el Email', 'autocomplete'=>"off", 'id'=>'email', ])!!}
        </div>
    </div>
     <div class="form-group m-form__group row">
         <label for="col-lg-2 col-form-label" class="col-2 col-form-label">Nombre comercial<comercial></comercial></label>
         <div class="col-lg-6">
             {!!Form::text('commercial_name',null,['class'=>'form-control m-input', 'placeholder'=>'Ingresar el nombre comercial', 'autocomplete'=>"off", 'id'=>'commercial_name', ])!!}
         </div>
     </div>
     <div class="form-group m-form__group row">
         <label for="col-lg-2 col-form-label" class="col-2 col-form-label">RFC</label>
         <div class="col-lg-6">
             {!!Form::text('rfc',null,['class'=>'form-control m-input', 'placeholder'=>'Ingresar el RFC', 'autocomplete'=>"off", 'id'=>'rfc', ])!!}
         </div>
     </div>

     <div class="form-group m-form__group row">
         <label for="col-lg-2 col-form-label" class="col-2 col-form-label">Teléfono</label>
         <div class="col-lg-6">
             {!! Form::text('phone', null, ['class'=>'form-control', 'placeholder'=>'Ingresar el telefono','autocomplete'=>"off", 'id'=>'phone']) !!}
         </div>
     </div>
     
        <div class="form-group m-form__group row">

                <label for="col-lg-2 col-form-label" class="col-2 col-form-label">Vendedor Asignado</label>

                <div class="col-lg-6">
                <select name="seller_id" id="seller_id" class='form-control col-lg-4 col-form-label'>
                    <option value="" disabled selected>Seleccionar</option>
                    @foreach($sellers as $seller)
                        <?php $selected = ""; ?>
                        @if(isset($customers))
                            @if( $customers -> seller_id == $seller->id)
                                    <?php $selected = "selected"; ?>
                            @endif
                        @endif
                        <option value="{{$seller->id}}" {{$selected}}>{{$seller->name}}</option>
                    @endforeach
                </select>
            </div>
            </div>

     <div class="form-group m-form__group row">
         <label for="inputEmail1" class="col-2 col-form-label"><span class="required" aria-required="true"> * </span> Contraseña:</label>
         <div class="col-sm-7">
             {{Form::password('password', ['class' => 'form-control', 'id' => 'user_password', 'placeholder' => '●●●●●●●●●●●●', 'autocomplete' => 'off'])}}
         </div>
     </div>

     <div class="form-group m-form__group row">
         <label for="confirm_password" class="col-2 col-form-label"><span class="required" aria-required="true"> * </span>Confirmar contraseña:</label>
         <div class="col-sm-7">
             {{Form::password('confirm_password', ['class' => 'form-control', 'id' => 'confirm_password', 'placeholder' => '●●●●●●●●●●●●', 'autocomplete' => 'new-password'])}}
         </div>
     </div>





</div>
<div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
    <div class="m-form__actions m-form__actions--solid">
        <div class="row">
            <div class="col-lg-2"></div>
            <div class="col-lg-6">
                <button type="submit" class="btn btn-outline-success">Aceptar</button>
                <a class="btn btn-outline-danger" href="{{URL::route('customers.index')}}">Cancelar</a>
            </div>
        </div>
    </div>
</div>
