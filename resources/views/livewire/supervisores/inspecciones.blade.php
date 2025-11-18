<div>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr class="bg-success text-white text-center">
                    <th colspan="2">
                        CLIENTES ASIGNADOS
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($designaciones->designacionsupervisorclientes as $item)
                    <tr>
                        <td class="align-middle">
                            <strong>{{ $item->cliente->nombre }}</strong> <br>
                            <span style="font-size: 11px;">Última revisión:</span>
                            <span class="badge rounded-pill text-bg-primary" style="font-size: 9px;">01/01/2025
                                15:00H</span>
                        </td>
                        <td class="align-middle text-end">
                            @if (Session::get('inspeccion_activa'))
                                @if (Session::get('inspeccion_activa')->cliente_id === $item->cliente_id)
                                    <button class="btn btn-secondary text-white" style="width: 95px"
                                        onclick="finalizarInsp()">
                                        <i class="fas fa-user-times"></i> <br> Finalizar
                                    </button>
                                @else
                                    <button class="btn btn-primary text-white" style="width: 95px"
                                        onclick="iniciarInsp({{ $item->cliente_id }})">
                                        <i class="fas fa-user-secret"></i> <br> Iniciar
                                    </button>
                                @endif
                            @else
                                <button class="btn btn-primary text-white" style="width: 95px"
                                    onclick="iniciarInsp({{ $item->cliente_id }})">
                                    <i class="fas fa-user-secret"></i> <br> Iniciar
                                </button>
                            @endif




                        </td>
                    </tr>
                @empty
                @endforelse
            </tbody>
        </table>
    </div>


</div>
@section('js')
    <script>
        function iniciarInsp(cliente_id) {
            Swal.fire({
                title: 'Iniciar Inspección',
                text: "¿Está seguro de realizar esta operación?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#1abc9c',
                cancelButtonColor: '#1e293b',
                confirmButtonText: 'Sí, iniciar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emit('iniciarInspeccion', cliente_id);
                }
            });
        }
        function finalizarInsp(cliente_id) {
            Swal.fire({
                title: 'Finalizar Inspección',
                text: "¿Está seguro de realizar esta operación?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#1abc9c',
                cancelButtonColor: '#1e293b',
                confirmButtonText: 'Sí, iniciar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emit('finalizar');
                }
            });
        }
    </script>
@endsection
