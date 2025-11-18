<div>
    @section('title', 'Procesar Sueldos')

    @section('content_header')
        <h1 class="m-0 text-dark">Procesar Sueldos</h1>
    @endsection


    <div class="container-fluid">

        {{-- Info de mes y feriados --}}

        <div class="card bg-light">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-6 mb-3">
                        <h5 class="card-title font-weight-bold">Datos a procesar:</h5> <br>
                        <small>
                            Gestión: <strong>{{ $gestion }}</strong><br>
                            Mes: <strong>{{ str_pad($mes, 2, '0', STR_PAD_LEFT) }}</strong>
                        </small>

                    </div>
                    <div class="col-12 col-md-6">
                        <h5 class="card-title font-weight-bold">Feriados del mes</h5> <br>
                        <ul class="mb-0" style="max-height: 150px; overflow-y: auto; padding-left: 1.2rem;">
                            @forelse($feriados as $feriado)
                                <li class="mb-1">
                                    <small>
                                        <strong>{{ $feriado->nombre }}</strong>
                                        @if ($feriado->fecha)
                                            ({{ \Carbon\Carbon::parse($feriado->fecha)->format('d/m/Y') }})
                                        @elseif($feriado->fecha_inicio && $feriado->fecha_fin)
                                            ({{ \Carbon\Carbon::parse($feriado->fecha_inicio)->format('d/m/Y') }} -
                                            {{ \Carbon\Carbon::parse($feriado->fecha_fin)->format('d/m/Y') }})
                                        @elseif($feriado->recurrente)
                                            @php
                                                $anioActual = now()->year;
                                            @endphp
                                            ({{ \Carbon\Carbon::createFromDate($anioActual, \Carbon\Carbon::parse($feriado->fecha)->month, \Carbon\Carbon::parse($feriado->fecha)->day)->format('d/m/Y') }})
                                        @endif
                                    </small>
                                </li>
                            @empty
                                <li>No hay feriados</li>
                            @endforelse
                        </ul>
                    </div>

                </div>

            </div>
        </div>



        {{-- Tabla de contratos --}}
        <div class="card">
            <div class="card-header bg-primary text-white">
                <div class="row">
                    <div class="col-8">
                        <h3 class="card-title">Contratos listos para proceso</h3>
                    </div>
                    <div class="col-4">
                        <div class="float-right p-0">
                            <button type="button" class="btn btn-success btn-sm" wire:click="procesar"
                                wire:loading.attr="disabled" wire:target="procesar">
                                <i class="fas fa-cogs"></i> Procesar
                            </button>

                        </div>
                    </div>
                </div>


            </div>
            <div class="card-body table-responsive">
                <table class="table table-bordered table-hover text-center table-sm mb-0">
                    <thead class="table-secondary">
                        <tr>
                            <th style="vertical-align: middle">#</th>
                            <th style="vertical-align: middle">Empleado</th>
                            <th style="vertical-align: middle">Salario Base</th>
                            <th style="vertical-align: middle">Detalles</th>
                            <th style="vertical-align: middle">Permisos</th>
                            <th style="vertical-align: middle">Asistencias</th>
                            <th style="vertical-align: middle">Bonos/Descuentos</th>
                            <th style="vertical-align: middle">Adelantos</th>
                            <th style="vertical-align: middle">Liquido Pagable</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($contratos as $index => $contrato)
                            <tr>
                                <td style="vertical-align: middle">{{ $index + 1 }}</td>
                                <td class="text-left" style="vertical-align: middle">
                                    <strong>{{ $contrato['nombres'] }} {{ $contrato['apellidos'] }}</strong>
                                    <br>
                                    <small>
                                        Inicio: {{ \Carbon\Carbon::parse($contrato['fecha_inicio'])->format('d/m/Y') }}
                                        |
                                        Fin:
                                        {{ $contrato['fecha_fin'] == 'Indefinido' ? 'Indefinido' : \Carbon\Carbon::parse($contrato['fecha_fin'])->format('d/m/Y') }}<br>
                                        Tipo: {{ $contrato['tipo_contrato'] ?? 'N/A' }}
                                    </small>
                                </td>

                                {{-- Salario Mes --}}
                                <td style="vertical-align: middle">{{ number_format($contrato['salario_mes'], 2) }}
                                </td>
                                <td style="vertical-align: middle">

                                    @if (isset($contrato['calendario_laboral']))
                                        <button class="btn btn-xs btn-info mt-1" type="button" data-toggle="collapse"
                                            data-target="#calendario-{{ $contrato['id'] }}" aria-expanded="false"
                                            aria-controls="calendario-{{ $contrato['id'] }}">
                                            Ver Detalles
                                        </button>
                                        <div class="collapse mt-2" id="calendario-{{ $contrato['id'] }}">
                                            @php
                                                $anio = $gestion;
                                                $mes_ = $mes;
                                                $fechaInicioMes = \Carbon\Carbon::create(
                                                    $anio,
                                                    $mes_,
                                                    1,
                                                )->startOfMonth();
                                                $fechaFinMes = $fechaInicioMes->copy()->endOfMonth();
                                                $permisos_detalle = collect();
                                                if (isset($contrato['empleado_id'])) {
                                                    $permisos_detalle = \App\Models\Rrhhpermiso::with('rrhhtipopermiso')
                                                        ->where('empleado_id', $contrato['empleado_id'])
                                                        ->where('activo', true)
                                                        ->where(function ($q) use ($fechaInicioMes, $fechaFinMes) {
                                                            $q->whereBetween('fecha_inicio', [
                                                                $fechaInicioMes,
                                                                $fechaFinMes,
                                                            ])
                                                                ->orWhereBetween('fecha_fin', [
                                                                    $fechaInicioMes,
                                                                    $fechaFinMes,
                                                                ])
                                                                ->orWhere(function ($q2) use (
                                                                    $fechaInicioMes,
                                                                    $fechaFinMes,
                                                                ) {
                                                                    $q2->where(
                                                                        'fecha_inicio',
                                                                        '<=',
                                                                        $fechaInicioMes,
                                                                    )->where('fecha_fin', '>=', $fechaFinMes);
                                                                });
                                                        })
                                                        ->get();
                                                }
                                            @endphp
                                            <table class="table table-sm table-bordered mb-0" style="font-size:0.90em;">
                                                <thead>
                                                    <tr>
                                                        <th>Fecha</th>
                                                        <th>Tipo día</th>
                                                        <th>Designación</th>
                                                        <th>Asistencia</th>
                                                        <th>Permiso</th>
                                                        <th>Tipo Permiso</th>
                                                        <th>Factor</th>
                                                        <th>Concepto</th>
                                                        <th>Ajuste</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($contrato['detalle_pago']['detalle_dias'] as $info)
                                                        <tr
                                                            @if (!empty($info['permiso'])) style="background: #e0f7fa" @endif>
                                                            <td>{{ \Carbon\Carbon::parse($info['fecha'])->format('d/m/Y') }}
                                                            </td>
                                                            <td>
                                                                @if ($info['tipo_dia'] === 'feriado')
                                                                    <span class="badge badge-warning">Feriado</span>
                                                                @elseif($info['tipo_dia'] === 'fuera_contrato')
                                                                    <span class="badge badge-secondary">Fuera
                                                                        contrato</span>
                                                                @else
                                                                    <span class="badge badge-light">Normal</span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if ($info['designacion_activa'])
                                                                    <span class="badge badge-success">Sí</span>
                                                                @else
                                                                    <span class="badge badge-danger">No</span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if ($info['estado_asistencia'] === 'completa')
                                                                    Completa
                                                                @elseif($info['estado_asistencia'] === 'media_jornada')
                                                                    Media jornada
                                                                @elseif($info['estado_asistencia'] === 'sin_marca')
                                                                    Sin marca
                                                                @else
                                                                    -
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if (!empty($info['permiso']))
                                                                    <span class="badge badge-info">Sí</span>
                                                                @else
                                                                    <span class="badge badge-light">No</span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                {{ $info['tipo_permiso'] ?? '-' }}
                                                            </td>
                                                            <td>
                                                                {{ $info['factor_permiso'] ?? '-' }}
                                                            </td>
                                                            <td>
                                                                {{ $info['concepto'] ?? '-' }}
                                                            </td>
                                                            <td>
                                                                {{ number_format($info['ajuste'] ?? 0, 2) }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @endif
                                </td>

                                {{-- Permisos: días y ajuste --}}
                                <td style="vertical-align: middle">
                                    @php
                                        // Calcular días de permiso del mes para mostrar
                                        $dias_permiso = 0;
                                        if (isset($contrato['empleado_id'])) {
                                            $anio = $gestion;
                                            $mes_ = $mes;
                                            $fechaInicioMes = \Carbon\Carbon::create($anio, $mes_, 1)->startOfMonth();
                                            $fechaFinMes = $fechaInicioMes->copy()->endOfMonth();
                                            $permisos = \App\Models\Rrhhpermiso::where(
                                                'empleado_id',
                                                $contrato['empleado_id'],
                                            )
                                                ->where('activo', true)
                                                ->where(function ($q) use ($fechaInicioMes, $fechaFinMes) {
                                                    $q->whereBetween('fecha_inicio', [$fechaInicioMes, $fechaFinMes])
                                                        ->orWhereBetween('fecha_fin', [$fechaInicioMes, $fechaFinMes])
                                                        ->orWhere(function ($q2) use ($fechaInicioMes, $fechaFinMes) {
                                                            $q2->where('fecha_inicio', '<=', $fechaInicioMes)->where(
                                                                'fecha_fin',
                                                                '>=',
                                                                $fechaFinMes,
                                                            );
                                                        });
                                                })
                                                ->get();
                                            foreach ($permisos as $permiso) {
                                                $inicio = \Carbon\Carbon::parse($permiso->fecha_inicio)->greaterThan(
                                                    $fechaInicioMes,
                                                )
                                                    ? \Carbon\Carbon::parse($permiso->fecha_inicio)
                                                    : $fechaInicioMes;
                                                $fin = \Carbon\Carbon::parse($permiso->fecha_fin)->lessThan(
                                                    $fechaFinMes,
                                                )
                                                    ? \Carbon\Carbon::parse($permiso->fecha_fin)
                                                    : $fechaFinMes;
                                                $dias_permiso += $inicio->diffInDays($fin) + 1;
                                            }
                                        }
                                    @endphp
                                    <span class="badge badge-info"
                                        title="Cantidad de Dias de Permiso">{{ $dias_permiso }}</span>
                                    <span
                                        class="badge {{ $contrato['total_permisos'] >= 0 ? 'badge-success' : 'badge-danger' }}"
                                        title="Ajuste por permisos">
                                        {{ number_format($contrato['total_permisos'], 2) }}
                                    </span>
                                </td>

                                <td style="vertical-align: middle">
                                    @php
                                        $ajuste_asistencias =
                                            ($contrato['total_ctrlasistencias'] ?? 0) -
                                            ($contrato['total_permisos'] ?? 0);
                                    @endphp
                                    <span
                                        class="badge {{ $ajuste_asistencias >= 0 ? 'badge-success' : 'badge-danger' }}"
                                        title="Ajuste por asistencias">
                                        {{ number_format($ajuste_asistencias, 2) }}
                                    </span>
                                </td>


                                {{-- Bonos/Descuentos --}}
                                <td style="vertical-align: middle">
                                    @php
                                        $bono_valor = $contrato['total_bonos'] ?? 0;
                                        $bono_class =
                                            $bono_valor > 0
                                                ? 'badge-primary'
                                                : ($bono_valor < 0
                                                    ? 'badge-danger'
                                                    : 'badge-secondary');
                                        $bono_sign = $bono_valor > 0 ? '+' : ($bono_valor < 0 ? '-' : '');
                                        $bono_tooltip =
                                            $bono_valor > 0
                                                ? 'Bonos aprobados en el mes'
                                                : ($bono_valor < 0
                                                    ? 'Descuentos aplicados en el mes'
                                                    : 'Sin bonos ni descuentos');
                                    @endphp
                                    <span class="badge {{ $bono_class }}" title="{{ $bono_tooltip }}">
                                        {{ $bono_sign }}{{ number_format(abs($bono_valor), 2) }}
                                    </span>
                                </td>

                                {{-- Adelantos --}}
                                <td style="vertical-align: middle">
                                    <span class="badge badge-warning" title="Adelantos descontados en el mes">
                                        {{ number_format($contrato['total_adelantos'] ?? 0, 2) }}
                                    </span>
                                </td>



                                {{-- Liquido Pagable --}}
                                <td style="vertical-align: middle">
                                    @php
                                        $liquido_color =
                                            $contrato['liquido_pagable'] >= $contrato['salario_mes']
                                                ? 'badge-success'
                                                : 'badge-warning';
                                        $liquido_tooltip =
                                            $contrato['liquido_pagable'] >= $contrato['salario_mes']
                                                ? 'El líquido pagable es igual o mayor al salario del mes (sin descuentos extraordinarios).'
                                                : 'El líquido pagable es menor al salario del mes debido a descuentos por inasistencias o permisos.';
                                    @endphp
                                    <span class="badge {{ $liquido_color }}" title="{{ $liquido_tooltip }}">
                                        {{ number_format($contrato['liquido_pagable'], 2) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9">No hay contratos activos para este mes</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

            </div>

           
                <div class="card-footer">
                    <div class="col-12 col-md-4 float-right">
                        <button type="button" class="btn btn-success btn-block ml-2  @if (!$procesado) d-none @endif" id="btn-registrar-resultados"
                            wire:loading.attr="disabled">
                            <i class="fas fa-save"></i> Registrar Resultados
                        </button>
                    </div>
                </div>
            
        </div>

    </div>

    {{-- Cortina de procesamiento --}}
    <div wire:loading.flex>
        <div
            style="position: fixed; top:0; left:0; width:100%; height:100%; background:rgba(255,255,255,0.7); z-index:1050; display:flex; align-items:center; justify-content:center;">
            <div class="text-center">
                <div class="spinner-border text-primary" style="width:4rem; height:4rem;"></div>
                <h4 class="mt-3 text-dark">Procesando sueldos...</h4>
            </div>
        </div>
    </div>


</div>
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Confirmación antes de guardar
            document.getElementById('btn-registrar-resultados').addEventListener('click', function() {
                Swal.fire({
                    title: '¿Está seguro?',
                    text: '¿Desea registrar los resultados de sueldos? Esta acción no se puede deshacer.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, registrar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.emit('guardarSueldos');
                    }
                });
            });

            
        });
    </script>
@endsection
