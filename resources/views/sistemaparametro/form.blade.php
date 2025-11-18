<div class="box box-info padding-1">
    <div class="box-body">

        <div class="form-group">
            {{ Form::label('tolerancia_ingreso') }}
            {{ Form::number('tolerancia_ingreso', $sistemaparametro->tolerancia_ingreso, ['class' => 'form-control' . ($errors->has('tolerancia_ingreso') ? ' is-invalid' : ''), 'placeholder' => 'Tolerancia Ingreso']) }}
            {!! $errors->first('tolerancia_ingreso', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('telefono_panico') }}
            {{ Form::text('telefono_panico', $sistemaparametro->telefono_panico, ['class' => 'form-control' . ($errors->has('telefono_panico') ? ' is-invalid' : ''), 'placeholder' => 'Nro. Telefono con Whatsapp']) }}
            {!! $errors->first('telefono_panico', '<div class="invalid-feedback">:message</div>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">Guardar <i class="fas fa-save"></i></button>
    </div>
</div>
