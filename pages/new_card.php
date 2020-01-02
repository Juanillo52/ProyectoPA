<?php
    require_once("test_log.php");
?>

<?php
    function mostrarFormulario(){
        //Left Panel
        require_once("nav.php");
        //#left-panel
        echo '<!-- Right Panel -->
        <div id="right-panel" class="right-panel">';
            //Header
            require_once("header.php");
            //#header
            echo '<!-- Content -->
            <div class="content">
                <div class="row card">
                <h1 class="card-header">Adquirir nueva tarjeta</h1>
                    <div class="card-body">
                    <p>Para verificar su identidad al adquirir la nueva tarjeta, por favor rellene el siguiente formulario:</p>
                    <form method="POST" enctype="multipart/form-data" onsubmit="return validar()">
                        <label id="labelDNI" class=" form-control-label" for="dni">DNI    </label>
                        <input id="dni" class="form-control" type="text" name="dni">
                        <br/>
                        <label id="labelEmail" class=" form-control-label" for="email">Email    </label>
                        <input id="email" class="form-control" type="text" name="email">
                        <br/>
                        <label id="labelClave" class=" form-control-label" for="clave">Clave    </label>
                        <input id="clave" class="form-control" type="password" name="clave">
                        <br/>
                        <label class=" form-control-label" for="cuenta">Cuenta</label>';

                        echo '<select class="form-control" name="cuenta" id="cuenta">';
                        foreach (obtenerCuentas() as $cuenta) {
                            echo "<option value='$cuenta'>$cuenta</option>";
                        }
                        echo "</select>";

                        echo'
                        <br/>
                        Tipo de tarjeta
                        <select id="select" class="form-control" name="select">
                            <option value="credito">Crédito</option>
                            <option value="debito">Débito</option>
                        </select>

                        <br/>
                        <button class="btn btn-primary btn-sm" type="submit" name="btnSolicitar">Solicitar</button>
                    </form>';

                        echo '
                    </div>
                </div>
            </div>
            <!-- /.content -->';
            //Footer
            require_once("footer.php");
            //.site-footer
        echo '</div>';
    }

    function comprobarNuevaTarjeta(){
        $resultado = False;
        
        if(isset($_POST['btnSolicitar'])){
            $ok = comprobarDatosNuevaTarjeta();
            
            if($ok){
                $resultado = nuevaTarjeta();

                if($resultado){
                    header('Location: cards.php');
                }
            }
        }
        
        return $resultado;
    }

    function comprobarDatosNuevaTarjeta(){
        $resultado = False;

        $_POST['dni'] = filter_input(INPUT_POST, "dni", FILTER_SANITIZE_STRING);
        if(!isset($_POST['dni']) || $_POST['dni'] == '' || !preg_match('/^([0-9]{8})([A-Z])$/', $_POST['dni'])){
            $errores[] = "Introduzca un dni válido. <br/>";
        }

        $_POST['email'] = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
        if(!isset($_POST['email']) || $_POST['email'] == '' || !filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL)){
            $errores[] = "Introduzca un email válido. <br/>";
        }

        $_POST['clave'] = filter_input(INPUT_POST, "clave", FILTER_SANITIZE_STRING);
        if(!isset($_POST['clave']) || $_POST['clave'] == ''){
            $errores[] = "Introduzca una clave válida. <br/>";
        }

        if(!isset($_POST['cuenta'])){
            $errores[] = "Elija la cuenta. <br/>";
        }

        if(!isset($_POST['select'])){
            $errores[] = "Elija el tipo de tarjeta. <br/>";
        }

        if(!isset($errores)){
            $resultado = True;
        }

        return $resultado;
    }

    function nuevaTarjeta(){
        $resultado = False;
        $cliente = $_POST['dni'];
        $email = $_POST['email'];
        $clave = $_POST['clave'];
        $cuenta = $_POST['cuenta'];
        $tipo = $_POST['select'];
        $fecha_actual = date("d-m-Y");
        $fecha_caducidad = date("Y-m-d", strtotime($fecha_actual."+ 4 year"));
        $num_tarjeta = "";
        $cvv = "";
        $pin = "";
        
        for($i =0 ; $i < 16; $i++){
            $num_tarjeta .= rand(0,9);
        }

        for($i =0 ; $i < 4; $i++){
            $cvv .= rand(0,9);
        }

        for($i =0 ; $i < 4; $i++){
            $pin .= rand(0,9);
        }

        $num_tarjeta = intval($num_tarjeta);
        $cvv = intval($cvv);
        $pin = intval($pin);

        $con = mysqli_connect("68.183.69.142", "root", "");
        
        if(!$con){
            die('No puedo conectar: ' . mysqli_error($con));
        }
        
        $db_selected = mysqli_select_db($con, "mensabank");
        
        if(!$db_selected){
            die('No puedo usar la base de datos: ' . mysqli_error($con));
        }

        $resQuery = mysqli_query($con, "SELECT clave, dni, email from cliente WHERE dni='$cliente' AND email='$email'");

        if(!$resQuery){
            mysqli_close($con);
            die('No puedo ejecutar la consulta: ' . mysqli_error($con));
        }else{
            if(mysqli_num_rows($resQuery) != 0){
                $row = mysqli_fetch_array($resQuery);
                
                if(password_verify($clave, $row['clave'])){
                    $resQuery2 = mysqli_query($con, "INSERT INTO tarjeta(numero_tarjeta, cvv, tipo, fecha_caducidad, pin, cliente, cuenta) VALUES ('$num_tarjeta', '$cvv', '$tipo', '$fecha_caducidad', '$pin', '$cliente', '$cuenta')");

                    if(!$resQuery2){
                        mysqli_close($con);
                        die('No puedo ejecutar la consulta: ' . mysqli_error($con));
                    }else{
                        $resultado = True;
                    }
                }
            }
        }

        mysqli_close($con);
        
        return $resultado;
    }

     
    function obtenerCuentas(){
        $cliente = $_SESSION['dni'];
        $cuentas = [];
        $con = mysqli_connect("68.183.69.142","root","");

        if (!$con){
            die(' No puedo conectar: ' . mysqli_error($con));
        }

        $db_selected = mysqli_select_db($con,"mensabank");

        if (!$db_selected){
            die ('No puedo usar la base de datos: ' . mysqli_error($con));
        }

        $result = mysqli_query($con, "SELECT iban from cuenta where cliente = '$cliente'");

        if($result){
            while($row = mysqli_fetch_array($result)) $cuentas[] = $row['iban'];
        }else{
            die ("Error al ejecutar la consulta: " . mysqli_error($con));
        }

        $result = mysqli_query($con, "SELECT iban from cuenta_ahorros where cliente = '$cliente'");

        if($result){
            while($row = mysqli_fetch_array($result)) $cuentas[] = $row['iban'];
        }else{
            die ("Error al ejecutar la consulta: " . mysqli_error($con));
        }

        $result = mysqli_query($con, "SELECT iban from cuenta_nomina where cliente = '$cliente'");

        if($result){
            while($row = mysqli_fetch_array($result)) $cuentas[] = $row['iban'];
        }else{
            die ("Error al ejecutar la consulta: " . mysqli_error($con));
        }
    
        mysqli_close($con);

        return $cuentas;
    }
?>

<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>MensaBank</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link type="text/css" rel="stylesheet" href="../plantilla-boostrap/assets/css/style.css">

    <link rel="apple-touch-icon" href="https://i.imgur.com/QRAUqs9.png">
    <link rel="shortcut icon" href="../images/icon.png">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/normalize.css@8.0.0/normalize.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lykmapipo/themify-icons@0.1.2/css/themify-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pixeden-stroke-7-icon@1.2.3/pe-icon-7-stroke/dist/pe-icon-7-stroke.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.2.0/css/flag-icon.min.css">
    <link rel="stylesheet" href="../plantilla-boostrap/assets/css/cs-skin-elastic.css">
    <link rel="stylesheet" href="../plantilla-boostrap/assets/css/style.css">
    <!-- <script type="text/javascript" src="https://cdn.jsdelivr.net/html5shiv/3.7.3/html5shiv.min.js"></script> -->
    <link href="https://cdn.jsdelivr.net/npm/chartist@0.11.0/dist/chartist.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/jqvmap@1.5.1/dist/jqvmap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/weathericons@2.1.0/css/weather-icons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@3.9.0/dist/fullcalendar.min.css" rel="stylesheet" />

   <style>
        #weatherWidget .currentDesc {
            color: #ffffff!important;
        }

        .traffic-chart {
            min-height: 335px;
        }
        #flotPie1  {
            height: 150px;
        }
        #flotPie1 td {
            padding:3px;
        }
        #flotPie1 table {
            top: 20px!important;
            right: -10px!important;
        }
        .chart-container {
            display: table;
            min-width: 270px ;
            text-align: left;
            padding-top: 10px;
            padding-bottom: 10px;
        }
        #flotLine5  {
             height: 105px;
        }

        #flotBarChart {
            height: 150px;
        }
        #cellPaiChart{
            height: 160px;
        }

        .table thead th{
            border: 0;
        }

        .table td {
            border: 0;
        }

        .card {
            border: 1px solid rgba(0,0,0,.125)
        }

        .btn-primary{
            background-color: #6b4996;
            border-color: #6b4996;
        }
    </style>
</head>

<body class="bg-color">
    <?php
        $ok = comprobarNuevaTarjeta();
            
        if(!$ok){
            mostrarFormulario();
        }
    ?>

<script>
        function validar(){
            var salida = true;

            if(!validarDNI()){
                var spanDNI = document.createElement('span');
                spanDNI.setAttribute("id", "spanDNI");

                if(document.getElementById("spanDNI")){
                    var padre = document.getElementById("spanDNI").parentNode;
                    padre.removeChild(document.getElementById("spanDNI"));
                }

                var txt1 = document.createTextNode('(DNI no válido)');
                spanDNI.style.color = "red";
                spanDNI.appendChild(txt1);
                document.getElementById("labelDNI").appendChild(spanDNI);
                document.getElementById("dni").style.borderColor = "red";
                salida = false;
            }else{
                if(document.getElementById("spanDNI")){
                    var padre = document.getElementById("spanDNI").parentNode;
                    padre.removeChild(document.getElementById("spanDNI"));
                    document.getElementById("dni").style.borderColor = "";
                }
            }

            if(!validarEmail()){
                var spanEmail = document.createElement('span');
                spanEmail.setAttribute("id", "spanEmail");

                if(document.getElementById("spanEmail")){
                    var padre = document.getElementById("spanEmail").parentNode;
                    padre.removeChild(document.getElementById("spanEmail"));
                }

                var txt1 = document.createTextNode('(Email no válido)');
                spanEmail.style.color = "red";
                spanEmail.appendChild(txt1);
                document.getElementById("labelEmail").appendChild(spanEmail);
                document.getElementById("email").style.borderColor = "red";
                salida = false;
            }else{
                if(document.getElementById("spanEmail")){
                    var padre = document.getElementById("spanEmail").parentNode;
                    padre.removeChild(document.getElementById("spanEmail"));
                    document.getElementById("email").style.borderColor = "";
                }
            }

            if(!validarClave()){
                var spanClave = document.createElement('span');
                spanClave.setAttribute("id", "spanClave");

                if(document.getElementById("spanClave")){
                    var padre = document.getElementById("spanClave").parentNode;
                    padre.removeChild(document.getElementById("spanClave"));
                }

                var txt1 = document.createTextNode('(Clave no válida)');
                spanClave.style.color = "red";
                spanClave.appendChild(txt1);
                document.getElementById("labelClave").appendChild(spanClave);
                document.getElementById("clave").style.borderColor = "red";
                salida = false;
            }else{
                if(document.getElementById("spanClave")){
                    var padre = document.getElementById("spanClave").parentNode;
                    padre.removeChild(document.getElementById("spanClave"));
                    document.getElementById("clave").style.borderColor = "";
                }
            }

            return salida;
        }

        function validarDNI(){
            var expr = /^([0-9]{8})([A-Z])$/;
            var dni = document.getElementById("dni").value;
            return dni !== undefined && expr.test(dni);
        }

        function validarEmail(){
            var expr = /^[^@]+@[^@]+\.[a-zA-Z]{2,}$/;
            var email = document.getElementById("email").value;
            return email !== undefined && expr.test(email);
        }

        function validarClave(){
            var expr = /^([0-9]{8})$/;
            var clave = document.getElementById("clave").value;
            return clave !== undefined && expr.test(clave);
        }
    </script>
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.4/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-match-height@0.7.2/dist/jquery.matchHeight.min.js"></script>
    <script src="../plantilla-boostrap/assets/js/main.js"></script>

    <!--  Chart js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.7.3/dist/Chart.bundle.min.js"></script>

    <!--Chartist Chart-->
    <script src="https://cdn.jsdelivr.net/npm/chartist@0.11.0/dist/chartist.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartist-plugin-legend@0.6.2/chartist-plugin-legend.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/jquery.flot@0.8.3/jquery.flot.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flot-pie@1.0.0/src/jquery.flot.pie.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flot-spline@0.0.1/js/jquery.flot.spline.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/simpleweather@3.1.0/jquery.simpleWeather.min.js"></script>
    <script src="assets/js/init/weather-init.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/moment@2.22.2/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@3.9.0/dist/fullcalendar.min.js"></script>
    <script src="../plantilla-boostrap/assets/js/init/fullcalendar-init.js"></script>

    <!--Local Stuff-->
    <script>
        jQuery(document).ready(function($) {
            "use strict";

            // Pie chart flotPie1
            var piedata = [
                { label: "Desktop visits", data: [[1,32]], color: '#5c6bc0'},
                { label: "Tab visits", data: [[1,33]], color: '#ef5350'},
                { label: "Mobile visits", data: [[1,35]], color: '#66bb6a'}
            ];

            $.plot('#flotPie1', piedata, {
                series: {
                    pie: {
                        show: true,
                        radius: 1,
                        innerRadius: 0.65,
                        label: {
                            show: true,
                            radius: 2/3,
                            threshold: 1
                        },
                        stroke: {
                            width: 0
                        }
                    }
                },
                grid: {
                    hoverable: true,
                    clickable: true
                }
            });
            // Pie chart flotPie1  End
            // cellPaiChart
            var cellPaiChart = [
                { label: "Direct Sell", data: [[1,65]], color: '#5b83de'},
                { label: "Channel Sell", data: [[1,35]], color: '#00bfa5'}
            ];
            $.plot('#cellPaiChart', cellPaiChart, {
                series: {
                    pie: {
                        show: true,
                        stroke: {
                            width: 0
                        }
                    }
                },
                legend: {
                    show: false
                },grid: {
                    hoverable: true,
                    clickable: true
                }

            });
            // cellPaiChart End
            // Line Chart  #flotLine5
            var newCust = [[0, 3], [1, 5], [2,4], [3, 7], [4, 9], [5, 3], [6, 6], [7, 4], [8, 10]];

            var plot = $.plot($('#flotLine5'),[{
                data: newCust,
                label: 'New Data Flow',
                color: '#fff'
            }],
            {
                series: {
                    lines: {
                        show: true,
                        lineColor: '#fff',
                        lineWidth: 2
                    },
                    points: {
                        show: true,
                        fill: true,
                        fillColor: "#ffffff",
                        symbol: "circle",
                        radius: 3
                    },
                    shadowSize: 0
                },
                points: {
                    show: true,
                },
                legend: {
                    show: false
                },
                grid: {
                    show: false
                }
            });
            // Line Chart  #flotLine5 End
            // Traffic Chart using chartist
            if ($('#traffic-chart').length) {
                var chart = new Chartist.Line('#traffic-chart', {
                  labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                  series: [
                  [0, 18000, 35000,  25000,  22000,  0],
                  [0, 33000, 15000,  20000,  15000,  300],
                  [0, 15000, 28000,  15000,  30000,  5000]
                  ]
              }, {
                  low: 0,
                  showArea: true,
                  showLine: false,
                  showPoint: false,
                  fullWidth: true,
                  axisX: {
                    showGrid: true
                }
            });

                chart.on('draw', function(data) {
                    if(data.type === 'line' || data.type === 'area') {
                        data.element.animate({
                            d: {
                                begin: 2000 * data.index,
                                dur: 2000,
                                from: data.path.clone().scale(1, 0).translate(0, data.chartRect.height()).stringify(),
                                to: data.path.clone().stringify(),
                                easing: Chartist.Svg.Easing.easeOutQuint
                            }
                        });
                    }
                });
            }
            // Traffic Chart using chartist End
            //Traffic chart chart-js
            if ($('#TrafficChart').length) {
                var ctx = document.getElementById( "TrafficChart" );
                ctx.height = 150;
                var myChart = new Chart( ctx, {
                    type: 'line',
                    data: {
                        labels: [ "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul" ],
                        datasets: [
                        {
                            label: "Visit",
                            borderColor: "rgba(4, 73, 203,.09)",
                            borderWidth: "1",
                            backgroundColor: "rgba(4, 73, 203,.5)",
                            data: [ 0, 2900, 5000, 3300, 6000, 3250, 0 ]
                        },
                        {
                            label: "Bounce",
                            borderColor: "rgba(245, 23, 66, 0.9)",
                            borderWidth: "1",
                            backgroundColor: "rgba(245, 23, 66,.5)",
                            pointHighlightStroke: "rgba(245, 23, 66,.5)",
                            data: [ 0, 4200, 4500, 1600, 4200, 1500, 4000 ]
                        },
                        {
                            label: "Targeted",
                            borderColor: "rgba(40, 169, 46, 0.9)",
                            borderWidth: "1",
                            backgroundColor: "rgba(40, 169, 46, .5)",
                            pointHighlightStroke: "rgba(40, 169, 46,.5)",
                            data: [1000, 5200, 3600, 2600, 4200, 5300, 0 ]
                        }
                        ]
                    },
                    options: {
                        responsive: true,
                        tooltips: {
                            mode: 'index',
                            intersect: false
                        },
                        hover: {
                            mode: 'nearest',
                            intersect: true
                        }

                    }
                } );
            }
            //Traffic chart chart-js  End
            // Bar Chart #flotBarChart
            $.plot("#flotBarChart", [{
                data: [[0, 18], [2, 8], [4, 5], [6, 13],[8,5], [10,7],[12,4], [14,6],[16,15], [18, 9],[20,17], [22,7],[24,4], [26,9],[28,11]],
                bars: {
                    show: true,
                    lineWidth: 0,
                    fillColor: '#ffffff8a'
                }
            }], {
                grid: {
                    show: false
                }
            });
            // Bar Chart #flotBarChart End

            $("select").change(function(){
                alert("The text has been changed.");
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.4/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-match-height@0.7.2/dist/jquery.matchHeight.min.js"></script>
    <script src="assets/js/main.js"></script>
</body>
</html>
