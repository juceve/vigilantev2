<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group">
            {{ Form::label('cajachica_id') }}
            {{ Form::text('cajachica_id', $movimientocaja->cajachica_id, ['class' => 'form-control' . ($errors->has('cajachica_id') ? ' is-invalid' : ''), 'placeholder' => 'Cajachica Id']) }}
            {!! $errors->first('cajachica_id', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('fecha') }}
            {{ Form::text('fecha', $movimientocaja->fecha, ['class' => 'form-control' . ($errors->has('fecha') ? ' is-invalid' : ''), 'placeholder' => 'Fecha']) }}
            {!! $errors->first('fecha', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('tipo') }}
            {{ Form::text('tipo', $movimientocaja->tipo, ['class' => 'form-control' . ($errors->has('tipo') ? ' is-invalid' : ''), 'placeholder' => 'Tipo']) }}
            {!! $errors->first('tipo', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('monto') }}
            {{ Form::text('monto', $movimientocaja->monto, ['class' => 'form-control' . ($errors->has('monto') ? ' is-invalid' : ''), 'placeholder' => 'Monto']) }}
            {!! $errors->first('monto', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('concepto') }}
            {{ Form::text('concepto', $movimientocaja->concepto, ['class' => 'form-control' . ($errors->has('concepto') ? ' is-invalid' : ''), 'placeholder' => 'Concepto']) }}
            {!! $errors->first('concepto', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('categoria') }}
            {{ Form::text('categoria', $movimientocaja->categoria, ['class' => 'form-control' . ($errors->has('categoria') ? ' is-invalid' : ''), 'placeholder' => 'Categoria']) }}
            {!! $errors->first('categoria', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('referencia') }}
            {{ Form::text('referencia', $movimientocaja->referencia, ['class' => 'form-control' . ($errors->has('referencia') ? ' is-invalid' : ''), 'placeholder' => 'Referencia']) }}
            {!! $errors->first('referencia', '<div class="invalid-feedback">:message</div>') !!}
        </div>
        <div class="form-group">
            {{ Form::label('comprobante') }}
            {{ Form::text('comprobante', $movimientocaja->comprobante, ['class' => 'form-control' . ($errors->has('comprobante') ? ' is-invalid' : ''), 'placeholder' => 'Comprobante']) }}
            {!! $errors->first('comprobante', '<div class="invalid-feedback">:message</div>') !!}
        </div>

    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">{{ __('Submit') }}</button>
    </div>
</div>