<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registro_Tareas_{{ date('His') }}</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="{{ asset('vendor/bs3/bootstrap.min.css') }}">
</head>

<body>
    <table class="table" style="width: 100%">
        <tr class="text-center">
            <td style="width: 20%">
                <img class="img-responsive" src="{{ asset('images/blackbird1.png') }}" style="width: 80px;">
                <p>
                    BLACK BIRD <br>
                    <small>Seguridad y Vigilancia</small>
                </p>
            </td>
            <td style="width: 60%; vertical-align: bottom">
                <h4><strong>REGISTRO DE TAREAS</strong></h4>
                <small>Del {{ $parametros[2] }} al {{ $parametros[3] }}</small>
                <br>
                <small><strong>CLIENTE: {{ $cliente->nombre }}</strong></small>
            </td>
            <td style="width: 20%"></td>
        </tr>
    </table>
    {{-- @dump($resultados) --}}

    <br>
    <h5 class="text-center">DETALLES</h5>
    <table class="table table-bordered table-striped" style="vertical-align: middle;font-size: 10px;">
        <thead>
            <tr class="table-info">
                <th class="text-center">ID</th>
                <th>CLIENTE</th>
                <th>GUARDIA</th>
                <th class="text-center" style="width: 80px;">FECHA</th>
                <th>CONTENIDO</th>
                <th>ESTADO</th>
            </tr>
        </thead>
        <tbody>
            @if (!is_null($resultados))

            @forelse ($resultados as $item)
            <tr>
                <td class="text-center">{{$item->id}}</td>
                <td>{{$item->nombrecliente}}</td>
                <td>{{$item->nombreempleado}}</td>
                <td class="text-center">{{$item->fecha}}</td>
                <td>{{$item->contenido}}</td>
                <td>
                    @if ($item->estado)
                    En proceso
                    @else
                    Finalizado
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td class="text-center" colspan="6">No se econtraron resultados.</td>
            </tr>
            @endforelse
            @else
            <tr>
                <td class="text-center" colspan="6">No se econtraron resultados.</td>
            </tr>
            @endif
        </tbody>
    </table>

    <script src="{{ asset('vendor/bs3/bootstrap.min.js') }}"></script>
</body>

</html>