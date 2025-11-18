<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CONTRATO LABORAL</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="{{ asset('vendor/bs3/bootstrap.min.css') }}">
    <style>
        @page {
            size: 21.59cm 33cm;
            /* Tamaño de página y orientación */
            margin-left: 2.7cm;
            /* Margen izquierdo */
            margin-right: 2.8cm;
            /* Margen derecho */
            margin-top: 2.5cm;
            /* Margen superior */
            margin-bottom: 1.8cm;
            /* Margen inferior */
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 9.5pt;
            text-align: justify;
            /* Justificado opcional */
            margin: 0;
            /* Evitar márgenes extra del body */
            padding: 0;
        }

        .lista-hanging {
            list-style: none;
            /* quita los puntitos */
            padding-left: 0;
            /* quitar margen default de ul */
        }

        .lista-hanging li {
            margin-bottom: 0.5em;
            /* espacio entre ítems */
            padding-left: 3em;
            /* espacio para sangría colgante */
            text-indent: -2.5em;
            /* hace que el número quede “fuera” del texto */
        }
    </style>
</head>

<body>
    <div class="container">
        <p class="text-center"><strong><u>CONTRATO DE TRABAJO A CONCLUSION DE SERVICIO</u></strong></p>
        <p>
            Conste por el presente Contrato Individual de Trabajo, una relación laboral que surtirá efectos legales
            entre las partes que lo formalizan de acuerdo a las siguientes cláusulas: <br>
            <strong>PRIMERA. - (De las Partes)</strong><br>
        <ul class="lista-hanging">
            <li>1.1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                La Empresa "RIALTO PATROL SRL", representando legalmente por el Sr. DAVID MANZANO SOUZA, mayor de edad,
                hábil por Ley, con C.I. No. 5369074 SCZ. Vecino de esta ciudad, con domicilio laboral en la Av. Cumavi
                No. 4305, Zona de la Villa 1ro. De Mayo, a quien se lo denominara <strong>el EMPLEADOR y/o LA
                    EMPRESA</strong>.
            </li>
            <li>1.2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                El Sr. {{$empleado->nombres.' '.$empleado->apellidos}} mayor de edad, hábil por Ley, con cédula de
                identidad No. {{$empleado->cedula}} {{$empleado->expedido}}, con
                domicilio en {{$empleado->direccion}}, que en adelante se denominará el <strong>TRABAJADOR</strong>
            </li>
        </ul>
        </p>

        <p>
            <strong>SEGUNDA. - (Naturaleza del Contrato)</strong>
        <ul class="lista-hanging">
            <li>2.1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                La naturaleza jurídica del presente contrato es de carácter estrictamente laboral, regulado por los
                artículos 5º y 6º de la Ley General del Trabajo, concordantes con los artículos 5º, 6º y 7º del Decreto
                Reglamentario.
            </li>
            <li>2.2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                El presente contrato de acuerdo con lo establecido por la Resolución Administrativa No.650/07 de fecha
                27 de marzo de 2007, se encuentra suscrito en base al contrato principal suscrito entre la empresa
                "RIALTO PATROL" de seguridad y vigilancia y la empresa ENDE ANDINA S.A.M, de fecha 01 de Junio del 2023,
                el mismo que tiene una duración de un año.
            </li>



        </ul>
        </p>
        <p>
            <strong>TERCERA. - (Duración del Contrato)</strong><br>
            El presente <strong>Contrato de Trabajo</strong> se inicia el {{fechaEs($contrato->fecha_inicio)}} a
            conclusión de servicio,
            como también
            cuya duración se encuentra sujeto a la vigencia del contrato principal por un año, que se señala en el punto
            2.2 de la cláusula segunda.
        </p>
        <p>
            <strong>CUARTA. - (Cargo Laboral)</strong><br>
            EL TRABAJADOR desempeñará las funciones propias de GUARDIA O VIGILANTE DE SEGURIDAD, en la empresa
            mencionada en
            la Cláusula Segunda, de acuerdo a las instrucciones que al efecto sean impartidas por el EMPLEADOR, se
            establece
            que por razones de estrategia o de mejor servicio, el EMPLEADOR podrá realizar los cambios de turnos, ya sea
            a
            diurno o nocturno, al TRABAJADOR previa notificación y acuerdos de partes.
        </p>
        <p>
            <strong>QUINTA. - (DE LA CONFIDENCIALIDAD)</strong><br>
            Una de las responsabilidades bases, por la naturaleza del trabajo, es la CONFIDENCIALIDAD que guardará el
            TRABAJADOR, en su calidad de guardia con respecto al movimiento del personal, uso de los equipos de
            seguridad y
            cuidado, al igual queda totalmente prohibido efectuar cualquier tipo de comentario que involucre al personal
            ejecutivo, empleados y/o dependientes tanto de la empresa a la cual se presta el servicio como de la empresa
            para la cual trabaja, <strong>el incurrir en esta falta, será catalogada como muy grave</strong>, misma que
            dará lugar a
            sanciones.
        </p>

        <p>
            <strong>SEXTA. - (Funciones Laborales)</strong> <br>
            El <strong>TRABAJADOR</strong>, tiene como principales funciones laborales las siguientes:

        <ul class="lista-hanging">
            <li>6.1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                Conocer y cumplir estrictamente los manuales de funciones, procedimientos, así como todas las normas y
                disposiciones relacionadas con la organización y funcionamiento de LA EMPRESA.
            </li>
            <li>6.2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                Guardar y observar obediencia, disciplina y lealtad para con LA EMPRESA en sus dependencias y fuera de
                ellas.
            </li>
            <li>6.3&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                Asistir puntualmente al trabajo ajustándose al horario establecido salvo circunstancias de fuerza mayor
                debidamente justificadas.
            </li>
            <li>6.4&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                Efectuar con responsabilidad, eficiencia, honradez, diligencia y celeridad, el trabajo inherente a su
                cargo o cualquier otro que sea encomendado por sus superiores.
            </li>
            <li>6.5&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                Hacer uso adecuado de los equipos de comunicación, instrumentos, linternas, ponchos de agua, etc…, que
                se les confía observan do rigurosamente las normas, medidas y precauciones de seguridad para su manejo,
                responsabilizándose por todo deterioro, destrucción o perdida que se ocasionen en dichos instrumentos,
                si después de las investigaciones pertinentes resultaren culpables.
            </li>
            <li>6.6&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                Cumplir estrictamente las normas de higiene y seguridad industrial establecidas, precautelando su vida,
                salud e integridad física.
            </li>
            <li>6.7&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                Observar una conducta y/o comportamiento dentro de la moral, las buenas costumbres y respetuosas para
                sus superiores y compañeros de trabajo.
            </li>
            <li>6.8&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                Dispensar a las autoridades, clientes y otros dando excelente atención, respeto, cortesía y amabilidad.
            </li>
            <li>6.9&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                Velar por la seguridad y comodidad de los señores clientes guardando compostura y respeto con ellos,
                atendiendo sus requerimientos con prontitud, amabilidad, gentileza y diligencia, evitando demoras
                inmotivas, preservando el buen nombre de LA EMPRESA.
            </li>
            <li>6.10&nbsp;&nbsp;&nbsp;
                Permanecer en su puesto y/o áreas durante la jornada de trabajo retirándose al concluir y no permanecer
                en LA EMPRESA, salvo instrucciones emitidas por escrito.
            </li>
            <li>6.11&nbsp;&nbsp;&nbsp;
                Observar y cumplir estrictamente los horarios, roles, turnos de trabajo establecidos por LA EMPRESA,
                conforme a las necesidades de ésta.
            </li>
            <li>6.12&nbsp;&nbsp;&nbsp;
                Cumplir las instrucciones emanadas del personal ejecutivo o el personal autorizado para ello.
            </li>
            <li>6.13&nbsp;&nbsp;&nbsp;
                No abandonar su puesto de trabajo o su trabajo sin que sus reemplazantes hayan llegado.
            </li>
            <li>6.14&nbsp;&nbsp;&nbsp;
                Guardar absoluta reserva sobre cualquier información relacionada a los sistemas de trabajo,
                administración y organización de la EMPRESA, y en general a su documentación y archivos muy
                especialmente estará obligado a NO DIVULGAR secretos relativos a la seguridad de LA EMPRESA, los cuales
                le hubieran sido confiados a razón de su cargo en la misma como códigos de activación de alarmas o
                sistemas de seguridad, de archivos, contabilidad, etc.
            </li>
            <li>6.15&nbsp;&nbsp;&nbsp;
                En caso de solicitar retiro voluntario deberá de hacerlo por escrito con al menos 15 dias de
                anticipación para permitir encontrar una persona que pueda reemplazar el puesto vacante. Los daños y
                perjuicios en caso de abandono de su puesto serán cargados al vigilante como retiro intempestivo.
            </li>
            <li>6.16&nbsp;&nbsp;&nbsp;
                El vigilante se compromete a mantener una presencia impecable referente a la limpieza personal, corte de
                cabello, uso de uniformes, mantenimiento y cuidado de equipos en los predios asignados.
            </li>
        </ul>
        </p>
        <p>
            <strong>SEPTIMA. (Jornada Laboral)</strong><br>
            Se considera las establecidas para el rubro de vigilancia según el artículo 46 párrafo II de la Ley General
            del Trabajo y de acuerdo con el contrato con el cliente al que prestamos servicios será bajo el siguiente
            horario de 7:00 am a 19:00 pm o de 19:00 pm a 7:00 am u horario bajo acuerdo de partes o horarios
            establecidos de acuerdo a requerimiento de ENDE ANDINA S.A.M.

        </p>
        <p>
            <strong>OCTAVA. - (Remuneración)</strong> <br>
            El <strong>EMPLEADOR</strong> pagará al <strong>TRABAJADOR</strong> la suma de Bs.-
            {{$contrato->salario_basico}} <strong>({{numeroALetras($contrato->salario_basico)}})</strong>, en forma
            mensual, monto del cual se efectuarán los correspondientes descuentos de ley
            en los que el <strong>EMPLEADOR</strong> actúa en calidad de Agente de Retención ante la GESTORA PUBLICA el
            monto de 300,27 Bs.-, mas bonos que suman 337,77 Bs.-, vacaciones, finiquitos y aguinaldo o duodécimas
            sujeto a lo que establece la ley general del trabajo. Percibiendo un salario liquido pagable de 2400 de
            forma mensual a cancelarse cada 10 de cada mes en caso de caer día inhábil se cancelará el siguiente día
            hábil mediante transferencia bancaria.

        </p>
        <p>
            <strong>NOVENA. - (Derechos del EMPLEADOR)</strong>
        <ul class="lista-hanging">
            <li>9.1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                Rescisión del Contrato en caso de infracción de parte del <strong>TRABAJADOR</strong> a las
                prohibiciones contenidas en
                el artículo 16º de Ley General del Trabajo y 9º de su Decreto Reglamentario.
            </li>
            <li>9.2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                Rescindir los servicios del <strong>TRABAJADOR</strong>, honrando el pago de los derechos laborales
                emergentes de la
                relación de trabajo conforme a ley.
            </li>
            <li>9.3&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                Exigir al <strong>TRABAJADOR</strong> el cumplimiento de las tareas y funciones que le han sido
                asignadas.
            </li>
            <li>9.4&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                Recibir trato respetuoso de los trabajadores.
            </li>
            </p>
            <p>
                <strong> DECIMA. - (Obligaciones del EMPLEADOR)</strong>
            <ul class="lista-hanging">
                <li>10.1&nbsp;&nbsp;&nbsp;
                    Pagar al <strong>TRABAJADOR</strong> la remuneración mensual acordada en moneda de curso legal y
                    oficial, de acuerdo con lo establecido por el artículo 53 de la Ley General del Trabajo
                </li>
                <li>10.2&nbsp;&nbsp;
                    Dotar el material de trabajo necesario para el adecuado desarrollo de las tareas del
                    <strong>TRABAJADOR</strong>.
                </li>
                <li>10.3&nbsp;&nbsp;&nbsp;
                    Cumplir con todas las disposiciones laborales vigentes.
                </li>
            </ul>
            </p>
            <p>
                <strong>DECIMA PRIMERA. - (Derechos del TRABAJADOR)</strong>
            <ul class="lista-hanging">
                <li>11.1.&nbsp;&nbsp;&nbsp;A recibir trato respetuoso y colaboración de parte de sus superiores</li>
                <li>11.2.&nbsp;&nbsp;&nbsp;A percibir su remuneración en moneda de curso legal y corriente.</li>
                <li>11.3.&nbsp;&nbsp;&nbsp;A ser dotado de todos los elementos de protección física y otros con relación
                    a las tareas a desarrollar.</li>
                <li>11.4.&nbsp;&nbsp;&nbsp;Al ejercicio pleno de derechos de acuerdo a la Ley General del Trabajo y
                    disposiciones conexas vigentes.</li>
            </ul>

            </p>
            <p>
                <strong>DECIMA SEGUNDA. - (Obligaciones del TRABAJADOR)</strong>
            <ul class="lista-hanging">
                <li>12.1.&nbsp;&nbsp; Acatar instrucciones y responsabilidades, obligándose a su fiel y estricto
                    cumplimiento.</li>
                <li>12.2.&nbsp;&nbsp; Trabajar con eficiencia, puntualidad, responsabilidad y lealtad a la empresa.</li>
                <li>12.3.&nbsp;&nbsp; Demostrar buena y conducta moral y funcionaria, respetando a su EMPLEADOR y a sus
                    colegas de trabajo.</li>
                <li>12.4.&nbsp;&nbsp; Dar uso adecuado y racional a los materiales e instrumentos que le sean entregados
                    a efecto de
                    facilitar sus labores.</li>
                <li>12.5.&nbsp;&nbsp; Utilizar los equipos y ropa de trabajo dotados por el EMPLEADOR para protección de
                    su salud y vida.</li>
            </ul>

            </p>

            <p>
                <strong>DECIMA TERCERA. - (prohibiciones y sanciones).</strong><br>
                Cuando el Trabajador en su función de guardia de seguridad sea sorprendido infraganti en la comisión de
                alguna de las prohibiciones, el infractor, sin necesidad de proceso será destituido del cargo. Las
                transgresiones a las prohibiciones establecidas en este punto, darán lugar a prescindir de los servicios
                del infractor conforme lo dispuesto por el Art.16 de la Ley General del Trabajo, 9º de su Decreto
                Reglamento en sus incisos respectivos, así mismo quede expresamente prohibido:
            <ul class="lista-hanging">
                <li>13.1&nbsp;&nbsp; Utilizar o disponer los bienes de LA EMPRESA en beneficio propio o de terceras
                    personas salvo autorización escrita del empleador</li>
                <li>13.2&nbsp;&nbsp; Aceptar y recibir dadivas y dinero y/o cualquier otra forma de compensaciones por
                    servicios que preste el trabajador con el motivo de las operaciones de la misma empresa.</li>
                <li>13.3&nbsp;&nbsp; Hacer cualquier tipo de inscripciones en las paredes, puertas, ventanas, muebles o
                    movilidades y en general sobre cualquier superficie sea contra LA EMPRESA, personas jurídicas o
                    naturales.</li>
                <li>13.4.&nbsp;&nbsp; Presentarse a su fuente de trabajo en estado de ebriedad, o bajo influencias de
                    drogas, sustancias químicas, tóxicas, así como ingerir bebidas alcohólicas en sus dependencias de
                    trabajo, o de la empresa.</li>
                <li>13.5.&nbsp;&nbsp; Faltar de palabra, obra o por escrito a sus superiores, clientes, compañeros de
                    trabajo en general o a cualquier persona.</li>
                <li>13.6.&nbsp;&nbsp; Sustraer cualquier equipo, objeto o bienes de LA EMPRESA, del personal o de los
                    clientes.</li>
                <li>13.7.&nbsp;&nbsp; Realizar actividades, asociarse, dirigir, asesora y/o prestar servicios a otras
                    empresas.</li>
                <li>13.8.&nbsp;&nbsp; Arrogarse la representación de la empresa sin estar legalmente facultado para
                    ello, comprometiéndola u obteniendo cualquier beneficio actuando en su nombre.</li>
                <li>13.9.&nbsp;&nbsp; Dejar de cumplir total, parcialmente el presente contrato, así como las
                    prescripciones de la Ley General de Trabajo, su Reglamento y otras legalmente vigentes.</li>
                <li>13.10.&nbsp;&nbsp; Causar perjuicio material intencionalmente en los equipos, materiales,
                    motorizados y en general, dándole uso inadecuado en cada caso.</li>
                <li>13.11.&nbsp;&nbsp; Inasistencia al trabajo por más de 6 días hábiles consecutivos
                    injustificadamente.</li>
                <li>13.12. Sustraer útiles o bienes de propiedad de LA EMPRESA o de los CLIENTES (empresas o
                    particulares), cometiendo de esta manera abuso de confianza e incumpliendo a su compromiso de
                    trabajo.</li>

                <li>
                    13.13&nbsp;&nbsp; Amenazar o agredir en cualquier forma a sus superiores, compañeros de trabajo o a
                    terceros.
                </li>
                <li>
                    13.14&nbsp;&nbsp; Realizar dentro de las dependencias de LA EMPRESA, actividades ajenas que no sean
                    inherentes al
                    trabajo, ya sean religiosos, proselitistas, políticos, sociales o de cualquier otra índole, salvo
                    sea
                    autorización expresa de LA EMPRESA por escrito.
                </li>
                <li>
                    13.15&nbsp;&nbsp; Disminuir intencionalmente el ritmo de trabajo, realizarlo a desgano o suspenderlo
                    o inducir a esa
                    conducta a los demás compañeros de trabajo.
                </li>
                <li>
                    13.17&nbsp;&nbsp; Ejecutar en horas de trabajo asambleas o cualquier otro tipo de reuniones ajenas a
                    las habituales
                    de LA EMPRESA, que no esté debida o previamente autorizadas expresamente por ejecutivos de la misma
                    por
                    escrito.
                </li>
                <li>
                    13.19&nbsp;&nbsp; Faltar al trabajo sin causa justificada.
                </li>
                <li>
                    13.20&nbsp;&nbsp; Dormir durante la jornada de trabajo.
                </li>
                <li>
                    13.21&nbsp;&nbsp; Usar los servicios aéreos o de transporte de la empresa o el cliente con otro fin.
                </li>
                <li>
                    13.22&nbsp;&nbsp; Usar las líneas telefónicas o cualquier medio de comunicación de la empresa para
                    asuntos
                    personales u otros ajenos al servicio.
                </li>
                <li>
                    13.23&nbsp;&nbsp; Permanecer en las dependencias de la empresa fuera de su jornada laboral, salvo
                    autorización escrita de la misma.
                </li>

                <li>
                    13.24&nbsp;&nbsp; Abandonar sus labores sin conocimiento ni autorización de LA EMPRESA.
                </li>
                <li>
                    13.25&nbsp;&nbsp; Poner reemplazante o sustituto sin el conocimiento y autorización de LA EMPRESA,
                    por que el
                    contrato de trabajo es intuito personal.
                </li>
                <li>
                    13.26&nbsp;&nbsp; Permitir el ingreso de personas extrañas, de dudosa o mala reputación a los
                    centros de trabajo,
                    menos consentir permanencia de los mismos en sus dependencias.
                </li>
                <li>
                    13.27&nbsp;&nbsp; Efectuar durante la jornada de trabajo labores particulares, sea para sí o para
                    terceros.
                </li>
                <li>
                    13.28&nbsp;&nbsp; Marcar la tarjeta o firmar la planilla de control de asistencia de otro
                    trabajador.
                </li>
                <li>
                    13.29&nbsp;&nbsp; Fomentar conversaciones, corrillos, discusiones o comentarios distrayendo la
                    atención de los
                    compañeros de trabajo y perjudicando el normal desenvolvimiento de sus funciones.
                </li>
                <li>
                    13.30&nbsp;&nbsp; Manejar u operar equipos, vehículos que no le hubiesen sido asignados para
                    aquellos que no tengan
                    ninguna autorización.
                </li>
                <li>
                    13.32&nbsp;&nbsp; Dejar basura y/o desperdicios en sus puestos o áreas de trabajo o materiales,
                    equipos, aparatos,
                    enseres de trabajo en sitios o lugares distintos de los que no corresponde.
            </ul>
            </p>
            <p>
                <strong>DECIMA CUARTA. - (Rescisión del contrato)</strong> <br>
                No habrá derecho a desahucio e indemnización por el tiempo de servicio, cuando se produzca el despido y
                el Contrato de Trabajo sea rescindido o resuelto por: <br>
                a) Las causales previstas en el Art. 16 de la Ley General del Trabajo. <br>
                b) Las causales señaladas en el Art. 9 del Reglamento de la Ley General del Trabajo.

            </p>
            <p>
                <strong>DECIMA QUINTA. - (Obligaciones de la empresa)</strong> <br>
                La Empresa, esta sujeta al cumplimiento de los siguientes deberes: <br>
                a) Proteger los derechos personales y profesionales del Trabajador dignificando su condición. <br>
                b) Garantizar la estabilidad laboral de acuerdo con la Constitución Política del Estado, el Decreto
                Supremo 28699, y de toda influencia política, racial, cultural, religiosa, de género, sexo o edad, de
                acuerdo con la Ley 045 en contra del Racismo y la Discriminación y su Decreto Reglamentario. <br>
                c) Desarrollar una cultura organizacional de servicio y responsabilidad, orientando las actividades
                hacia el fortalecimiento ético moral de quienes toman decisiones y de quienes cumplen órdenes. <br>
                e) Proveer los mecanismos de Seguridad Ocupacional, Higiene y Bienestar. <br>
                f) Dotar al Trabajador del material necesario para el cumplimiento de sus actividades.

            </p>
            <p>
                <strong>DECIMA SEXTA. - (ALIMENTACION)</strong><br>
                La empresa RIALTO PATROL SRL cubrirá los gastos emergentes de la alimentación del personal de vigilancia
                como ser: desayuno, almuerzo y cena según corresponda a los horarios de trabajo.

            </p>
            <p>
                <strong>DECIMA SEPTIMA. - (ROL DE TURNOS)</strong><br>
                La modalidad de trabajo se establece 25 días de trabajo y 5 días de descanso para cada vigilante según
                cronograma y rol de turnos elaborado y consensuado con el encargado asignado por la empresa RIALTO
                PATROL SRL, en <strong>{{$designacione->turno->cliente->nombre}}</strong>.

            </p>

            <p>
                <strong>DECIMA NOVENA. - (DE LA ACEPTACIÓN)</strong><br>
                En plena conformidad a las cláusulas precedentes las partes intervinientes suscriben el presente
                Contrato De Trabajo para el desempeño del cargo de <strong>{{$contrato->rrhhcargo->nombre}}</strong>.

            </p>
            <p>
                Santa Cruz de la Sierra, {{fechaEs($fecha)}}
            </p>
    </div>
    <br><br><br><br>
    <div class="row">
        <div class="col-xs-6 text-center">
            ___________________________________<br>
           <strong>DAVID MANZANO SOUZA</strong><br>
           <strong>EMPLEADOR</strong>
        </div>
        <div class="col-xs-6 text-center">
            ___________________________________<br>
           <strong>{{ $empleado->nombres.' '.$empleado->apellidos }}</strong><br>
           <strong>TRABAJADOR</strong>
        </div>
    </div>


    </div>


    <div class="manual-footer">

    </div>
    </div>
    </div>

    <script src="{{ asset('vendor/bs3/bootstrap.min.js') }}"></script>
</body>

</html>