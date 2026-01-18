{{-- filepath: c:\laragon\www\vigilantev2\resources\views\livewire\admin\listado-hv.blade.php --}}
@section('title', 'Registros Hombre Vivo')

<div>
    <div class="container-fluid">
        <!-- Header -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        <h1 class="m-0">Registro de Marcaciones Hombre Vivo</h1>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filtros -->
        <div class="card">
            {{-- <div class="card-header">
                <h3 class="card-title"><i class="fas fa-filter"></i> Filtros de Búsqueda</h3>
            </div> --}}
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Cliente</label>
                            <select class="form-control" wire:model="cliente_id">
                                <option value="">-- Todos --</option>
                                @foreach ($clientes as $cliente)
                                    <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Empleado</label>
                            <select class="form-control" wire:model="empleado_id"
                                @if (!$cliente_id) disabled @endif>
                                <option value="">-- Todos --</option>
                                @foreach ($empleados as $empleado)
                                    <option value="{{ $empleado->id }}">{{ $empleado->nombres }}
                                        {{ $empleado->apellidos }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Fecha Inicio</label>
                            <input type="date" class="form-control" wire:model.defer="fecha_inicio"
                                max="{{ date('Y-m-d') }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Fecha Fin</label>
                            <input type="date" class="form-control" wire:model.defer="fecha_fin"
                                max="{{ date('Y-m-d') }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <button type="button" class="btn btn-primary btn-block" wire:click="generarReporte"
                                wire:loading.attr="disabled">
                                <i class="fas fa-search"></i> Buscar
                            </button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-secondary btn-sm" wire:click="limpiar">
                            <i class="fas fa-eraser"></i> Limpiar
                        </button>
                    </div>
                </div>
            </div>
        </div>


        <!-- Resultados -->
        @if ($mostrarResultados && count($resultados) > 0)
            <div class="card">
                <div class="card-header bg-success">
                    <h3 class="card-title">
                        <i class="fas fa-table"></i> Resultados del Reporte ({{ count($resultados) }}
                        empleado{{ count($resultados) != 1 ? 's' : '' }})
                    </h3>
                    <div class="card-tools">
                        @can('admin.hombre_vivo_reportes')
                            <button type="button" class="btn btn-sm btn-light" wire:click="exportarExcel"
                                title="Exportar a Excel">
                                <i class="fas fa-file-excel text-success"></i> Excel
                            </button>
                            <button type="button" class="btn btn-sm btn-light ml-1" wire:click="exportarPdf"
                                title="Exportar a PDF">
                                <i class="fas fa-file-pdf text-danger"></i> PDF
                            </button>
                        @endcan
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        @php
                            \Carbon\Carbon::setLocale('es');
                            $fechaI = \Carbon\Carbon::parse($fecha_inicio);
                            $fechaF = \Carbon\Carbon::parse($fecha_fin);
                            $dias = [];
                            $current = $fechaI->copy();
                            while ($current <= $fechaF) {
                                $dias[] = [
                                    'fecha' => $current->format('Y-m-d'),
                                    'dia' => $current->format('d'),
                                    'mes' => mb_substr($current->translatedFormat('M'), 0, 3),
                                    'diaNombre' => mb_substr($current->translatedFormat('l'), 0, 3),
                                ];
                                $current->addDay();
                            }
                        @endphp

                        <table class="table table-sm table-bordered table-striped table-hover">
                            <thead class="table-info">
                                <tr>
                                    <th class="align-middle">Empleado</th>
                                    <th class="text-center align-middle">Total Registros</th>
                                    <th class="text-center align-middle">Total Esperadas</th>
                                    <th class="text-center align-middle">Cumplimiento</th>
                                    @foreach ($dias as $dia)
                                        <th class="text-center align-middle" style="min-width:90px">
                                            <small>{{ ucfirst($dia['diaNombre']) }}</small><br>
                                            <strong>{{ $dia['dia'] }}</strong><br>
                                            <small>{{ ucfirst($dia['mes']) }}</small>
                                        </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($resultados as $resultado)
                                    @php
                                        $totalEsp = array_sum(array_column($resultado['dias'], 'esperadas'));
                                        $totalReg = $resultado['total_marcaciones'] ?? 0;
                                        $cumpTotal = $totalEsp > 0 ? round(($totalReg / $totalEsp) * 100, 1) : 0;
                                    @endphp
                                        <tr>
                                        <td class="align-middle"><strong>{{ $resultado['empleado_nombre'] }}</strong></td>
                                        <td class="text-center align-middle"><span class="badge badge-primary">{{ $totalReg }}</span></td>
                                        <td class="text-center align-middle"><span class="badge badge-secondary">{{ $totalEsp }}</span></td>
                                        <td class="text-center align-middle">
                                            @php
                                                if ($totalEsp == 0) {
                                                    $badge = 'light';
                                                    $cumpLabel = '-';
                                                } else {
                                                    $cumpLabel = $cumpTotal . '%';
                                                    if ($cumpTotal == 100) {
                                                        $badge = 'success';
                                                    } elseif ($cumpTotal >= 50) {
                                                        $badge = 'warning';
                                                    } elseif ($cumpTotal > 0) {
                                                        $badge = 'secondary';
                                                    } else {
                                                        $badge = 'danger';
                                                    }
                                                }
                                            @endphp
                                            <span class="badge badge-{{ $badge }}">{{ $cumpLabel }}</span>
                                        </td>

                                        @foreach ($resultado['dias'] as $dia)
                                            @php $pct = $dia['cumplimiento']; @endphp
                                            <td class="text-center align-middle p-1" style="width: 50px;">
                                                @if ($dia['esperadas'] == 0)
                                                    <span class="badge badge-light" title="Sin Designación">-</span>
                                                @else
                                                    @php
                                                        if ($pct == 100) {
                                                            $cls = 'success';
                                                            $icn = 'check';
                                                        } elseif ($pct >= 50) {
                                                            $cls = 'warning';
                                                            $icn = 'exclamation';
                                                        } elseif ($pct > 0) {
                                                            $cls = 'secondary';
                                                            $icn = 'times';
                                                        } else {
                                                            $cls = 'danger';
                                                            $icn = 'times';
                                                        }
                                                    @endphp
                                                    <span class="badge badge-{{ $cls }} d-inline-block text-center"
                                                        style="min-width:50px; width:50px; white-space:normal;" title="Registros: {{ $dia['cant_registros'] }} / Esperadas: {{ $dia['esperadas'] }} ({{ $pct }}%)">
                                                        <i class="fas fa-{{ $icn }}"></i><br>
                                                        <small style="display:block;">{{ $dia['cant_registros'] }}/{{ $dia['esperadas'] }}</small>
                                                        <strong style="display:block;">{{ $pct }}%</strong>
                                                    </span>
                                                @endif
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- Leyenda -->
                    <div class="container mb-3">
                        <strong><i class="fas fa-info-circle"></i> Leyenda:</strong>
                        <span class="badge badge-success ml-2"><i class="fas fa-check"></i> 100%</span>
                        <span class="badge badge-warning ml-2"><i class="fas fa-exclamation"></i> 50-99%</span>
                        <span class="badge badge-secondary ml-2"><i class="fas fa-times"></i>
                            <50% </span>
                                <span class="badge badge-danger ml-2"><i class="fas fa-times"></i> 0% </span>
                                <span class="badge badge-light ml-2"><i class="fas fa-minus"></i> Sin turno</span>
                    </div>


                </div>
            </div>
            <!-- Reporte Detallado: fecha y hora por registro (acordeón) -->
            <div id="accordionHv" class="mt-3">
                <div class="card">
                    <div class="card-header p-0" id="headingHv">
                        <h5 class="mb-0">
                            <button class="btn btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseHv" aria-expanded="false" aria-controls="collapseHv">
                                <i class="fas fa-list"></i> Reporte Detallado de Marcaciones por Empleado
                            </button>
                        </h5>
                    </div>

                    <div id="collapseHv" class="collapse" aria-labelledby="headingHv" data-parent="#accordionHv">
                        <div class="card-body">
                            @foreach ($resultados as $resultado)
                                <div class="mb-3">
                                    <strong>{{ $resultado['empleado_nombre'] }}</strong>
                                    <div class="table-responsive mt-2">
                                        <table class="table table-sm table-bordered">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th style="width:140px">Fecha</th>
                                                    <th>Marcaciones (fecha y hora)</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($resultado['dias'] as $dia)
                                                    <tr>
                                                        <td class="align-middle">{{ $dia['fecha'] }}</td>
                                                        <td>
                                                            @if (!empty($dia['marcaciones']))
                                                                @foreach ($dia['marcaciones'] as $m)
                                                                    <span class="badge badge-light mr-1">{{ $m }}</span>
                                                                @endforeach
                                                            @else
                                                                <span class="text-muted">-</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @elseif($mostrarResultados)
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> No se encontraron registros.
            </div>
        @endif
    </div>
</div>
