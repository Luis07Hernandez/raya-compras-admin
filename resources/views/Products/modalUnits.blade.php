<div class="modal fade" id="unitModal" role="dialog">
    <div class="modal-dialog modal-lg">

        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Precio por unidad de medida.</h5>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body" id="bodyDelete">
                <form id="unitsForm">
                    <div class="table-responsive">
                        <table class="table table-striped- table-bordered table-hover table-checkable">
                            <thead>
                                <tr>
                                    <th>Unidad</th>
                                    {{-- <th>Precio</th> --}}
                                    <th>Clave de producto en Contpaqi</th>
                                    <th>Unidad que aparece en portal de pedidos</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($units as $key => $unit)
                                <tr>
                                    <td>{{$unit->name}}
                                        <input type="hidden" name="units[{{$key}}][unit_id]" value="{{$unit->id}}" />
                                    </td>
                                   
                                    <td>
                                    
                                        @if(isset($productUnits))
                                            <?php $code = ""; ?>
                                            @foreach($productUnits as $productUnit)
                                                @if($productUnit->unit_id ===  $unit->id)
                                                <?php $code = $productUnit->product_key; ?>
                                                @break;
                                                @endif
                                            @endforeach
                                            <input type="text" name="units[{{$key}}][product_key]" class="form-control" value="{{$code}}"  placeholder="Ingresar clave de producto"/>   
                                        @else
                                        <input type="text" name="units[{{$key}}][product_key]" class="form-control"  placeholder="Ingresar clave de producto"/>
                                        @endif
                                    </td>
                                    <td>
                                        @if(isset($productUnits))
                                        
                                            <?php $code = ""; ?>
                                            @foreach($productUnits as $productUnit)
                                                @if($productUnit->unit_id ===  $unit->id)
                                                    <?php $code = $productUnit->isShow; ?>
                                                     @break;
                                                @endif
                                            @endforeach

                                            @if($code != "")
                                            
                                            <input type="hidden" name="units[{{$key}}][isShow]" class="isShow_{{$unit->id}} isShow" 
                                                value="{{$code == '' ? 0 : $code}}" />

                                             <input type="radio" class="form-control" name="isShow" value="{{$code}}" 
                                             onChange="setValueIsShow({{$unit->id}})"
                                                {{$code == 1 ? "checked" : "" }}>
                                            @else

                                                <input type="hidden" name="units[{{$key}}][isShow]" class="isShow_{{$unit->id}} isShow" 
                                                value="{{$key == 0 ? 1 : 0 }}" />

                                                <input type="radio" class="form-control " name="isShow"
                                                onChange="setValueIsShow({{$unit->id}})" 
                                                {{$key == 0 ? "checked" : "" }}>
                                            @endif
                                        
                                        @else 

                                            <input type="hidden" name="units[{{$key}}][isShow]" class="isShow_{{$unit->id}} isShow" 
                                            value="{{$key == 0 ? 1 : 0 }}" />

                                            <input type="radio" class="form-control" name="isShow" 
                                            onChange="setValueIsShow({{$unit->id}})"
                                            {{$key == 0 ? "checked" : "" }}>  
                                        @endif
                                        
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
                <button type="button"  class="btn btn-outline-success" onclick="unitForm()">Aceptar</button>
                <button type="button" data-dismiss="modal" class="btn btn-outline-danger">Cancelar</button>
            </div>
        </div>
    </div>
</div>