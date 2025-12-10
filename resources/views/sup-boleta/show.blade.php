@extends('layouts.app')

@section('template_title')
    {{ $supBoleta->name ?? "{{ __('Show') Sup Boleta" }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Sup Boleta</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('sup-boletas.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Fechahora:</strong>
                            {{ $supBoleta->fechahora }}
                        </div>
                        <div class="form-group">
                            <strong>Cliente Id:</strong>
                            {{ $supBoleta->cliente_id }}
                        </div>
                        <div class="form-group">
                            <strong>Empleado Id:</strong>
                            {{ $supBoleta->empleado_id }}
                        </div>
                        <div class="form-group">
                            <strong>Tipoboleta Id:</strong>
                            {{ $supBoleta->tipoboleta_id }}
                        </div>
                        <div class="form-group">
                            <strong>Supervisor Id:</strong>
                            {{ $supBoleta->supervisor_id }}
                        </div>
                        <div class="form-group">
                            <strong>Detalles:</strong>
                            {{ $supBoleta->detalles }}
                        </div>
                        <div class="form-group">
                            <strong>Descuento:</strong>
                            {{ $supBoleta->descuento }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
