@extends('layouts.app')

@section('template_title')
    {{ $movimientocaja->name ?? "{{ __('Show') Movimientocaja" }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Movimientocaja</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('movimientocajas.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Cajachica Id:</strong>
                            {{ $movimientocaja->cajachica_id }}
                        </div>
                        <div class="form-group">
                            <strong>Fecha:</strong>
                            {{ $movimientocaja->fecha }}
                        </div>
                        <div class="form-group">
                            <strong>Tipo:</strong>
                            {{ $movimientocaja->tipo }}
                        </div>
                        <div class="form-group">
                            <strong>Monto:</strong>
                            {{ $movimientocaja->monto }}
                        </div>
                        <div class="form-group">
                            <strong>Concepto:</strong>
                            {{ $movimientocaja->concepto }}
                        </div>
                        <div class="form-group">
                            <strong>Categoria:</strong>
                            {{ $movimientocaja->categoria }}
                        </div>
                        <div class="form-group">
                            <strong>Referencia:</strong>
                            {{ $movimientocaja->referencia }}
                        </div>
                        <div class="form-group">
                            <strong>Comprobante:</strong>
                            {{ $movimientocaja->comprobante }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
