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
                                @foreach($clientes as $cliente)
                                    <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Empleado</label>
                            <select class="form-control" wire:model="empleado_id" @if(!$cliente_id) disabled @endif>
                                <option value="">-- Todos --</option>
                                @foreach($empleados as $empleado)
                                    <option value="{{ $empleado->id }}">{{ $empleado->nombres }} {{ $empleado->apellidos }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Fecha Inicio</label>
                            <input type="date" class="form-control" wire:model.defer="fecha_inicio" max="{{ date('Y-m-d') }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Fecha Fin</label>
                            <input type="date" class="form-control" wire:model.defer="fecha_fin" max="{{ date('Y-m-d') }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <button type="button" class="btn btn-primary btn-block" wire:click="generarReporte" wire:loading.attr="disabled">
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
        @if($mostrarResultados && count($resultados) > 0)
            <div class="card">
                <div class="card-header bg-success">
                    <h3 class="card-title">
                        <i class="fas fa-table"></i> Resultados del Reporte ({{ count($resultados) }} empleado{{ count($resultados) != 1 ? 's' : '' }})
                    </h3>
                    <div class="card-tools">
                       @can('admin.hombre_vivo_reportes')
                            <button type="button" class="btn btn-sm btn-light" wire:click="exportarExcel" title="Exportar a Excel">
                            <i class="fas fa-file-excel text-success"></i> Excel
                        </button>
                        <button type="button" class="btn btn-sm btn-light ml-1" wire:click="exportarPdf" title="Exportar a PDF">
                            <i class="fas fa-file-pdf text-danger"></i> PDF
                        </button>
                       @endcan
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered table-striped table-hover">
                            <thead class="table-info">
                                <tr>
                                    <th class="align-middle">Empleado</th>
                                    <th class="text-center align-middle">Total Marcaciones</th>
                                    <th class="text-center align-middle">Total Esperadas</th>
                                    <th class="text-center align-middle">Cumplimiento</th>
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
                                                'diaNombre' => mb_substr($current->translatedFormat('l'), 0, 3)
                                            ];
                                            $current->addDay();
                                        }
                                    @endphp
                                    @foreach($dias as $dia)
                                        <th class="text-center align-middle" style="min-width:60px">
                                            <small>{{ ucfirst($dia['diaNombre']) }}</small><br>
                                            <strong>{{ $dia['dia'] }}</strong><br>
                                            <small>{{ ucfirst($dia['mes']) }}</small>
                                        </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($resultados as $resultado)
                                    <tr>
                                        <td class="align-middle"><strong>{{ $resultado['empleado_nombre'] }}</strong></td>
                                        <td class="text-center align-middle">
                                            <span class="badge badge-primary">{{ $resultado['total_marcaciones'] }}</span>
                                        </td>
                                        <td class="text-center align-middle">
                                            @php $totalEsp = array_sum(array_column($resultado['dias'], 'esperadas')); @endphp
                                            <span class="badge badge-secondary">{{ $totalEsp }}</span>
                                        </td>
                                        <td class="text-center align-middle">
                                            @php
                                                $cump = $totalEsp > 0 ? round(($resultado['total_marcaciones'] / $totalEsp) * 100, 1) : 0;
                                                $badge = $cump >= 90 ? 'success' : ($cump >= 70 ? 'warning' : ($cump > 0 ? 'danger' : 'secondary'));
                                            @endphp
                                            <span class="badge badge-{{ $badge }}">{{ $cump }}%</span>
                                        </td>
                                        @foreach($resultado['dias'] as $dia)
                                            <td class="text-center align-middle p-1">
                                                @if($dia['esperadas'] == 0)
                                                    <span class="badge badge-light" title="Sin Designación">-</span>
                                                @else
                                                    @php
                                                        $pct = $dia['cumplimiento'];
                                                        $cls = $pct >= 90 ? 'success' : ($pct >= 70 ? 'warning' : ($pct > 0 ? 'danger' : 'secondary'));
                                                        $icn = $pct >= 90 ? 'check' : ($pct >= 70 ? 'exclamation' : ($pct > 0 ? 'times' : 'minus'));
                                                    @endphp
                                                    <span class="badge badge-{{ $cls }}" title="{{ $dia['cantidad'] }}/{{ $dia['esperadas'] }} ({{ $pct }}%)">
                                                        <i class="fas fa-{{ $icn }}"></i> <br> {{ $dia['cantidad'] }}/{{ $dia['esperadas'] }}
                                                    </span>
                                                @endif
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-light">
                                <tr>
                                    <th>TOTALES</th>
                                    <th class="text-center">{{ array_sum(array_column($resultados, 'total_marcaciones')) }}</th>
                                    <th class="text-center">
                                        @php
                                            $totEspGen = 0;
                                            foreach($resultados as $r) { $totEspGen += array_sum(array_column($r['dias'], 'esperadas')); }
                                        @endphp
                                        {{ $totEspGen }}
                                    </th>
                                    <th class="text-center">
                                        @php
                                            $totGen = array_sum(array_column($resultados, 'total_marcaciones'));
                                            $cumpTot = $totEspGen > 0 ? round(($totGen / $totEspGen) * 100, 1) : 0;
                                        @endphp
                                        <strong>{{ $cumpTot }}%</strong>
                                    </th>
                                    <th colspan="{{ count($dias) }}"></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Leyenda -->
            <div class="card card-secondary">
                <div class="card-body">
                    <strong><i class="fas fa-info-circle"></i> Leyenda:</strong>
                    <span class="badge badge-success ml-2"><i class="fas fa-check"></i> ≥90%</span>
                    <span class="badge badge-warning ml-2"><i class="fas fa-exclamation"></i> 70-89%</span>
                    <span class="badge badge-danger ml-2"><i class="fas fa-times"></i> <70%</span>
                    <span class="badge badge-light ml-2"><i class="fas fa-minus"></i> Sin turno</span>
                </div>
            </div>
        @elseif($mostrarResultados)
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> No se encontraron registros.
            </div>
        @endif
    </div>
</div>
