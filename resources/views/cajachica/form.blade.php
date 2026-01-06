<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
            {{ Form::label('empleado_id') }}
            {{ Form::text('empleado_id', $cajachica->empleado_id, ['class' => 'form-control' . ($errors->has('empleado_id') ? ' is-invalid' : ''), 'placeholder' => 'Empleado Id']) }}
            {!! $errors->first('empleado_id', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('gestion') }}
            {{ Form::text('gestion', $cajachica->gestion, ['class' => 'form-control' . ($errors->has('gestion') ? ' is-invalid' : ''), 'placeholder' => 'Gestion']) }}
            {!! $errors->first('gestion', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('fecha_apertura') }}
            {{ Form::text('fecha_apertura', $cajachica->fecha_apertura, ['class' => 'form-control' . ($errors->has('fecha_apertura') ? ' is-invalid' : ''), 'placeholder' => 'Fecha Apertura']) }}
            {!! $errors->first('fecha_apertura', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('fecha_cierre') }}
            {{ Form::text('fecha_cierre', $cajachica->fecha_cierre, ['class' => 'form-control' . ($errors->has('fecha_cierre') ? ' is-invalid' : ''), 'placeholder' => 'Fecha Cierre']) }}
            {!! $errors->first('fecha_cierre', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('estado') }}
            {{ Form::text('estado', $cajachica->estado, ['class' => 'form-control' . ($errors->has('estado') ? ' is-invalid' : ''), 'placeholder' => 'Estado']) }}
            {!! $errors->first('estado', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('observacion') }}
            {{ Form::text('observacion', $cajachica->observacion, ['class' => 'form-control' . ($errors->has('observacion') ? ' is-invalid' : ''), 'placeholder' => 'Observacion']) }}
            {!! $errors->first('observacion', '<div class="invalid-feedback">:message</div>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>