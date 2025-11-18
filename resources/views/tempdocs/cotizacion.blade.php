<!DOCTYPE html>
<html lang="es">

<?php
$data = decodGet($data);
$myArray = explode('^', $data);

$datos1 = explode('|', $myArray[0]);
$citecotizacion;
$detalles;
$datos = [];
if ($datos1[0] != 0) {
    $cite_id = $datos1[0];

    $encryptedId = Crypt::encrypt($cite_id);
    $link = url('/') . '/formulario-cotizacion' . '/' . $encryptedId;
    $qrUrl = 'https://api.qrserver.com/v1/create-qr-code/?data=' . urlencode($link) . '&size=130x130';

    $citecotizacion = traeCitecotizacion($cite_id);
    $detalles = traeDetallesCotizacion($cite_id);
    $datos = [$citecotizacion['cite'], $citecotizacion['fechaliteral'], $citecotizacion['destinatario'], $citecotizacion['cargo'], $citecotizacion['monto']];
} else {
    $datos = explode('|', $myArray[1]);
    $detalles = $data_detalles;
}
?>


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>COTIZACIÓN</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="{{ asset('vendor/bs3/bootstrap.min.css') }}">

    <style>
        body {
            background-size: initial;
            background-image: url("{{ $datos1[0] ? ($citecotizacion['estado'] ? asset('images/background_shield.png') : asset('images/anulado.png')) : asset('images/copia.jpg') }}");
            background-position: center center;
            background-repeat: no-repeat;
            height: 100%;
        }

        .contenido {
            min-height: 75%;
            background: rgba(255, 255, 255, 0.8);
            z-index: -1;
        }
    </style>

</head>

<body>

    <div class="contenido">
        <img src="{{ asset('images/flayer.jpg') }}" style="width: 100%; height: 100%">
        <div class="row" style="width: 100%;margin-right: 3rem">
            <div class="col-xs-5 text-center">
                <br>
                <small>
                    <strong>
                        EMPRESA DE SEGURIDAD Y VIGILANCIA <br>
                        {{ config('app.name') }} <br>
                        BOLIVIA
                    </strong>
                </small>
            </div>

            <div class="col-xs-3 text-right">

            </div>
            <div class="col-xs-4 text-center">
                <img class="img-responsive" src="{{ asset('images/logo_shield.png') }}" style="width: 90px;">
            </div>
        </div>
        <div class="row" style="margin-top: 5rem">
            <div class="col-xs-6"></div>
            <div class="col-xs-6">
                <strong>
                    CITE: {{ $datos1[0] ? $datos[0] : '0000/00' }} <br>
                    Santa Cruz, {{ $datos[1] }}
                </strong>
            </div>
        </div>
        <br><br>
        <p style="margin-left: 3rem">
            Señores: <br>
            <strong>
                {{ $datos[2] }} <br>
                {{ $datos[3] }} <br>
            </strong>
            Presente.-
        </p>
        <h5 style="margin-left: 3rem;margin-right: 3rem; margin-top: 3rem;text-align: center;">
            <u>
                <strong>REF.: CARTA DE PRESENTACION Y COTIZACION</strong>
            </u>
        </h5>
        <p style="margin-left: 3rem;margin-right: 3rem; margin-top: 2rem;text-align: justify;">


            De nuestra consideración: <br><br>
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
            <b>BLACK BIRD</b>, se constituye como una empresa de Seguridad Física y Vigilancia Privada creada con el fin
            de marcar la diferencia en el Rubro, brindando un servicio de Calidad para lograr la Tranquilidad y
            Seguridad de sus Clientes en sus actividades cotidianas.
        </p>
        <p style="margin-left: 3rem;margin-right: 3rem; margin-top: 2rem;text-align: justify;">
            <b>SERVICIO DE SEGURIDAD Y VIGILANCIA “BLACK BIRD”</b>, actualmente se encuentra presente en el Departamento
            de Santa Cruz y sus Provincias, con proyección a una expansión de nuestros servicios a Nivel Nacional.
        </p>
        <p style="margin-left: 3rem;margin-right: 3rem; margin-top: 2rem;text-align: justify;">
            <b><u>Nuestro Objetivo</u></b><br>
            Brindar un servicio de Calidad en Seguridad y Vigilancia, mediante una verdadera selección y capacitación de
            nuestro personal para poder: <br>
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- Establecer las relaciones que el nuevo personal mantendrá con su
            Empresa. <br>
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- Dar a conocer al personal la Filosofía y Políticas de su Empresa. <br>
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- Dar a conocer al personal las normas de Disciplina y Seguridad que su
            Empresa requiera. <br>
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- Lograr la Integración Grupal en su Empresa. <br>
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- Optimizar los Procesos de Comunicación. <br>
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- Crear una actitud favorable hacia su Empresa. <br>
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- Lograr que el personal este identificado con la Visión y Objetivos de su
            Empresa. <br>

        </p>
        <p style="margin-left: 3rem;margin-right: 3rem; margin-top: 2rem;text-align: justify;">
            <b><u>Asesoramiento Personalizado</u></b><br>
            La distorsión de conceptos de honestidad y profesionalismo engrandecidos a la necesidad de conseguir a como
            de lugar empleo, ha propiciado que personas o grupos dedicados a actividades ilícitas, falsifiquen o
            adulteren variadas formas de documentos, no solamente de identidad.
        </p>
        <p style="margin-left: 3rem;margin-right: 3rem; margin-top: 2rem;text-align: justify;">
            Por ello <b>“BLACK BIRD”</b>, cuenta con un área responsable de <b>Seguridad Patrimonial</b>, la cual
            estudia a todos los postulantes que se incorporen a nuestra empresa, analizando su Honestidad y Capacidades,
            así como también de la verificación de toda la documentación e información provista, antes de incorporarlos
            como guardias a su domicilio, empresa u otros.
        </p>
        <p style="margin-left: 3rem;margin-right: 3rem; margin-top: 2rem;text-align: justify;">
            <b>La información a verificar, corresponderá a los siguientes documentos: </b><br> <br>
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- Curriculum Vitae: Veracidad y Calidad de los datos del postulante. <br>
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- Certificados de Trabajo: Veracidad y Calidad de datos del postulante.
            <br>
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- Certificado de Antecedentes Policiales y Judiciales: Autenticidad y
            vigencia. <br>
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- Libreta de Servicio Militar. <br>
        </p>
        <p style="margin-left: 3rem;margin-right: 3rem; margin-top: 2rem;text-align: justify;">
            <b>Brindamos a nuestros Cliente Sin Costo Adicional los siguientes Servicios: </b><br> <br>
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- Charlas de Seguridad y Prácticas de tiro, para ejecutivos. <br>
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- Estudio de Seguridad de Instalaciones. <br>
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- Apoyo con personal de agentes en casos de emergencias. <br>
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- Investigaciones especiales. <br>
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- Planes de contingencias. <br>
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- Planes de emergencia como ser: Incendios, Sismos, etc. <br>


        </p>
        <p style="margin-left: 3rem;margin-right: 3rem; margin-top: 2rem;text-align: justify;">
            <b><u>Nuestro Personal</u></b><br>
            Los aspirantes son reclutados y provenientes principalmente de: <br> <br>
            Personal Militar, en fase de licenciamiento, convocatoria mediante avisos en diarios de mayor circulación,
            Ministerio de Trabajo o empresas privadas dedicadas a procesos de reclutamiento y selección de personal.
            <br><br>
            Los perfiles de los postulantes varían en función de las especificaciones establecidas en el documento
            regulador vigente que rige el funcionamiento de las empresas de seguridad en el País, esto es: Manual de
            Organización y Funciones en el que se hallan precisados con claridad Datos Particulares, Misión, Relaciones
            de Trabajo, Perfil Requerido y Funciones del Puesto.

        </p>
        <p style="margin-left: 3rem;margin-right: 3rem; margin-top: 2rem;text-align: justify;">
            <b><u>Como los seleccionamos</u></b><br>
            La evaluación de candidatos se realiza mediante el cumplimiento estricto de las siguientes fases, cada una
            de las cuales es eliminatoria: <br>
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- Examen Psicológico. <br>
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- Examen Médico. <br>
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- Examen de Conocimientos Generales. <br>
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- Entrevista Final y Apreciación de Personalidad, donde se evalúa la
            consistencia de solidos <br>
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;conocimientos de: Identidad y Madurez, Confianza, Iniciativa,
            Laboriosidad, Perspectiva y Panorama, <br>
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;Experiencia en el ramo, Aprendizaje, Liderazgo y Adhesión, Compromiso
            Ideológico y Seguridad<br>
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;en si mismo.<br>
        </p>
        <p style="margin-left: 3rem;margin-right: 3rem; text-align: justify;">


        </p>
        <p style="margin-left: 3rem;margin-right: 3rem; margin-top: 2rem;text-align: justify;">
            <b><u>Capacitación Específica</u></b><br>
            Teniendo en cuenta el alto nivel de compromiso que adquiere BLACK BIRD con todos sus Clientes, su filosofía
            de capacitación estriba en Mejorar y Optimizar permanentemente la preparación de su fuerza de Vigilantes,
            por ello lleva a cabo programas regulares de Cursos de Formación y Capacitación, para Nuevos y de
            Reentrenamiento para su personal experimentado.

        </p>
        <p style="margin-left: 3rem;margin-right: 3rem; margin-top: 2rem;text-align: left;">
            En estos se cubren diversos aspectos, entre los que destacan: <br>
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;• Normas y Procedimientos de Seguridad. <br>
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;• Apoyo y Control de Incendios. <br>
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;• Reacción inmediata ante robos. <br>
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;• Primeros Auxilios. <br>
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;• Seguridad de Instalaciones Privadas. <br>
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;• Control de Riesgo en entidades financieras. <br>
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;• Vigilancia de Maquinaria y Medios. <br>
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;• Seguridad Aeroportuaria Privada. <br>
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;• Psicología del Delincuente. <br>
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;• Defensa Personal. <br>
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;• Custodia de Valores. <br>
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;• Armamento y Tiro Real <br>

        </p>
        <p style="margin-left: 3rem;margin-right: 3rem; margin-top: 2rem;text-align: justify;">
            <b>{{ config('app.name') }}</b>, cuenta con entrenadores experimentados y la interacción, es permanente,
            propiciándose el
            trabajo en equipo, a lo largo de todo el año calendario.
            Innovando con la selección de nuestros Recursos Humanos, demostrando eficiencia y seriedad empresarial, para
            alcanzar un nivel de prestigio, rentabilidad, y un crecimiento superior al promedio del mercado.
        </p>
        <p style="margin-left: 3rem;margin-right: 3rem; margin-top: 2rem;text-align: justify;">
            <b><u>COTIZACIÓN</u></b><br><br>

            “BLACK BIRD” Empresa de Seguridad y Vigilancia le ofrece:
            Seguridad y Vigilancia las 24 hrs. con Supervisión o Rondas continuas por parte de la Empresa, Controlando
            Asistencia, Calidad y Cumplimiento de nuestros Guardias. <br><br>
            A continuación se detalla lo solicitado:
        </p>
        @php
            $i = 0;
        @endphp
        @if (count($detalles) > 0)
            <div style="margin-left: 3rem;margin-right: 3rem; margin-top: 2rem;text-align: justify;">
                <table class="table table-bordered" style="font-size: 12px;">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 8%">N°</th>
                            <th>DETALLE</th>
                            <th class="text-right" style="width: 15%">PRECIO UNIT.</th>
                            <th class="text-center" style="width: 15%">CANTIDAD</th>
                            <th class="text-right" style="width: 15%">SUBTOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($detalles as $detalle)
                            <tr>
                                <td class="text-center">{{ ++$i }}</td>
                                <td>{{ $detalle['detalle'] }}</td>
                                <td class="text-right">{{ number_format($detalle['precio'], 2, '.') }}</td>
                                <td class="text-center">{{ $detalle['cantidad'] }}</td>
                                <td class="text-right">
                                    {{ number_format($detalle['cantidad'] * $detalle['precio'], 2, '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        {{-- <h4 style="margin-left: 3rem;margin-right: 3rem; margin-top: 3rem;text-align: center;">
            <u>
                <strong>Costo Mensual por Guardia de Seguridad turno de 12 Hrs</strong>
            </u>
        </h4> --}}
        <p style="margin-left: 3rem;margin-right: 3rem; margin-top: 2rem;text-align: justify;">
            <strong>COSTO TOTAL: {{ $datos[4] }} Bs. - <i>{{ numLiteral($datos[4]) }}</i></strong>
        </p>
        <p style="margin-left: 3rem;margin-right: 3rem; margin-top: 1rem;text-align: center;">

        </p>

        <p style="margin-left: 3rem;margin-right: 3rem; margin-top: 2rem;text-align: left;">
            <u>
                <strong>
                    REFERENCIAS
                </strong>
            </u> <br>
            A continuación, le detallamos alguna de las empresas a las que actualmente brindamos nuestros servicios:
            <br>
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- Red Uno de Bolivia <br>
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- Muebles Inti <br>
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- Universidad Católica Boliviana San Pablo <br>
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- Sociales Vip <br>
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- Village Bolivia <br>
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- Condominio Andrea <br>
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- Condominio Lautaro <br>
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- Condominio Toborochi <br>
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- Condominio Andrea <br>
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- Condominio Sirari <br>
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- Condominio Tajibos <br>
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- Urbanizaciones Nuevo Amanecer <br>
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- Urbanizaciones Lautaro <br>
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- Condominio Residencial Las Palmas <br>
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- Condominio Vista del Urubo <br>
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- Urbanizaciones Terreno <br>
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- Condominio Virgen de Guadalupe <br>
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- DBI SRL. <br>
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- RIGMASTER PETROLEUM. <br>
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- FARMACORP S.A. <br>
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- Supermercados A-Market <br>
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- Condominio Jordania <br>
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- Condominio Urubari House <br>
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- AGRODVA <br>
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- TUPPERWARE <br>
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- JHALEA SRL. <br>
            &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- PERCAMP SRL <br>

        </p>

        <p style="margin-left: 3rem;margin-right: 3rem; margin-top: 2rem;text-align: left;">
            Esperando una respuesta, me despido cordialmente. <br><br>
            Atentamente, <br><br>
            <b>{{ config('app.name') }}</b>

        </p>
        <p style="margin-left: 3rem;margin-right: 3rem; margin-top: 8rem;text-align: center;">
            @if ($encryptedId != '' && $datos1[1] > 0)
                <img src="{{ $qrUrl }}" alt="QR Code"><br>
            @endif

            <br>
            <strong>
                GERENTE ADMINISTRATIVO </strong>
        </p>

    </div>

    <script src="{{ asset('vendor/bs3/bootstrap.min.js') }}"></script>
</body>

</html>
