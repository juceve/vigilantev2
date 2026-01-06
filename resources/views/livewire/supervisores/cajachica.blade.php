<div style="margin-top: 95px">
    @section('title')
        CAJA CHICA
    @endsection



    @if ($cajachica)
        <div class="alert alert-success" role="alert" style="font-size: 13px;">
            <div class="text-secondary">
                <h4>
                    <strong><i class="fas fa-wallet"></i> CAJA CHICA</strong>
                </h4>
                <i class="fas fa-user-secret"></i>
                {{ $cajachica->empleado->nombres . ' ' . $cajachica->empleado->apellidos }}
            </div>
        </div>
    @else
    <br>
       <div class="container">
         <div class="alert alert-warning mb-3" role="alert" style="font-size: 13px;">
            <div class="text-muted">
                <h5 class="text-center">
                    <strong>NO SE CUENTA CON UNA CAJA CHICA ACTIVA</strong>
                </h5>
            </div>
        </div>
        <div class="d-grid">
            <button onclick="history.back();" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> VOLVER
            </button>
        </div>
       </div>
    @endif



</div>
