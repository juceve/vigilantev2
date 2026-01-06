@extends('layouts.app')

@section('template_title')
    {{ $cajachica->name ?? "{{ __('Show') Cajachica" }}
@endsection

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Cajachica</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('cajachicas.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body">
                        
                        <div class="form-group">
                            <strong>Empleado Id:</strong>
                            {{ $cajachica->empleado_id }}
                        </div>
                        <div class="form-group">
                            <strong>Gestion:</strong>
                            {{ $cajachica->gestion }}
                        </div>
                        <div class="form-group">
                            <strong>Fecha Apertura:</strong>
                            {{ $cajachica->fecha_apertura }}
                        </div>
                        <div class="form-group">
                            <strong>Fecha Cierre:</strong>
                            {{ $cajachica->fecha_cierre }}
                        </div>
                        <div class="form-group">
                            <strong>Estado:</strong>
                            {{ $cajachica->estado }}
                        </div>
                        <div class="form-group">
                            <strong>Observacion:</strong>
                            {{ $cajachica->observacion }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
