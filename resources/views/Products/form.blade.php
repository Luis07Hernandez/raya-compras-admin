 <div class="m-portlet__body">
    <div class="form-group m-form__group row">
        <label for="col-lg-2 col-form-label" class="col-2 col-form-label">Nombre de producto</label>
        <div class="col-lg-6">
            {!!Form::text('name',null,['class'=>'form-control m-input', 'placeholder'=>'Ingresar el nombre', 'autocomplete'=>"off", 'id'=>'name', 'maxLength' => 50])!!}
        </div>
    </div>

    <div class="form-group m-form__group row">
        <label for="col-lg-2 col-form-label" class="col-2 col-form-label">Imagen</label>
    <div class="input-group col-lg-6">

        <label class="input-group-btn">
                    <span class="btn btn-info">
                        Subir <i class="fa flaticon-upload"></i> <input type="file" id="image" name="image"style="display: none;" multiple>
                    </span>
        </label>
        {!!Form::text('text',isset($product ) ? explode("/",$product->image)[2] :null,['class'=>'form-control m-input', 'autocomplete'=>"off", 'disabled' => 'disabled'])!!}

        {{--<a data-toggle="popover" title="medida de la imagen"data-content="0x0" class=" colordeicono btn m-btn m-btn--icon btn-sm m-btn--icon-only m-btn--pill">--}}
            {{--<i class="fa fa-exclamation "></i></a>--}}
    </div>
    </div>

    <div class="form-group m-form__group row">

        <label for="col-lg-2 col-form-label" class="col-2 col-form-label">Categoría</label>

        <div class="col-lg-6">
        <select name="category_id" id="category_id" class='form-control col-lg-4 col-form-label'>
            <option value="" disabled selected>Seleccionar</option>
            @foreach($categories as $category)
                <?php $selected = ""; ?>
                @if(isset($product))
                    @if( $product -> category_id == $category->id)
                            <?php $selected = "selected"; ?>
                    @endif
                @endif
                <option value="{{$category->id}}" {{$selected}}>{{$category->name}}</option>
            @endforeach
        </select>
    </div>
    </div>


    <div class="form-group m-form__group row">


        <label for="col-lg-2 col-form-label" class="col-2 col-form-label">Unidad de medida</label>
        <div class="col-lg-6">
            <a class="btn btn-outline-success unitsPrice">Precio por unidad de medida</a>
        </div>
    </div>

    <div class="form-group m-form__group row">
        <label for="col-lg-2 col-form-label" class="col-2 col-form-label">Descripción</label>
        <div class="col-lg-6">
            {!! Form::textarea('description', null, ['class'=>'form-control', 'placeholder'=>'Ingresar Descripción', 'id'=>'description']) !!}
        </div>
    </div>

    <!-- <div class="form-group m-form__group row">
        <label for="col-lg-2 col-form-label" class="col-2 col-form-label">Precio</label>
        <div class="col-lg-6">
            {!! Form::text('price', null, ['class'=>'form-control m-input', 'autocomplete'=>"off" ,'placeholder'=>'Ingresar Precio', 'id'=>'price']) !!}
        </div>
    </div>

    <div class="form-group m-form__group row">
        <label for="col-lg-2 col-form-label" class="col-2 col-form-label">clave</label>
        <div class="col-lg-6">
            {!! Form::text('key', null, ['class'=>'form-control m-input', 'autocomplete'=>"off" ,'placeholder'=>'Ingresar Clave', 'id'=>'key']) !!}
        </div>
    </div>

    <div class="form-group m-form__group row">
        <label for="col-lg-2 col-form-label" class="col-2 col-form-label">Clave de producto en Contpaq</label>
        <div class="col-lg-6">
            {!! Form::text('product_key', null, ['class'=>'form-control', 'placeholder'=>'Ingresar Clave de Producto','autocomplete'=>"off", 'id'=>'product_key']) !!}
        </div>
    </div> -->

    <div class="unitInput">
        @if(isset($productUnits))
            <?php $cont = 0; ?>
            @foreach($productUnits as $productUnit)
                <input type="hidden" name="units[{{$cont}}][unit_id]" value="{{$productUnit->unit_id}}" />
                <input type="hidden" name="units[{{$cont}}][price]" value="{{$productUnit->price}}" />
                <input type="hidden" name="units[{{$cont}}][product_key]" value="{{$productUnit->product_key}}" />
                <input type="hidden" name="units[{{$cont}}][isShow]" value="{{$productUnit->isShow}}" />                
                <?php $cont++; ?>
            @endforeach
        @endif
    </div>


</div>
<div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
    <div class="m-form__actions m-form__actions--solid">
        <div class="row">
            <div class="col-lg-2"></div>
            <div class="col-lg-6">
                <button type="submit" class="btn btn-outline-success">Aceptar</button>
                <a class="btn btn-outline-danger" href="{{URL::route('products.index')}}">Cancelar</a>
            </div>
        </div>
    </div>
</div>
