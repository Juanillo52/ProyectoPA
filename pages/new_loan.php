<?php
    require_once("test_log.php");
?>


<?php
    function mostrarFormulario(){
        //Left Panel
        require_once("nav.php");
        //#left-panel
        echo '
        <!-- Right Panel -->
        <div id="right-panel" class="right-panel">';
            //Header
            require_once("header.php");
            //#header
            echo '<!-- Content -->
            <div class="content">
                <div class="row card">
                <h1 class="card-header">Crear nueva Cuenta</h1>
                    <div class="card-body">
                    <form action="#" method="POST" enctype="multipart/form-data">
                        Tipo de préstamo
                        <select id="select" class="form-control" name="select">
                            <option value="personal">Personal</option>
                            <option value="hipotecario">Hipotecario</option>
                        </select>
                        <br/>
                        <label class=" form-control-label" for="credito">Cantidad del credito a pedir</label>
                        <input id="credito" class="form-control" type="number" step="1">
                        <br/>
                        <label class=" form-control-label" for="entrada">Entrada para el crédito</label>
                        <input id="entrada" class="form-control" type="number" step="1">
                        <br/>
                        <label class=" form-control-label" for="Tipo">Cuenta</label>
                        <input id="cuenta" class="form-control" type="cuenta">

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

    function comprobarNuevoPrestamo(){
        $resultado = False;
        
        if(isset($_POST['btnSolicitar'])){
            $ok = comprobarDatosNuevoPrestamo();
            
            if($ok){
                $resultado = nuevoPrestamo();
            }
        }
        
        return $resultado;
    }

    function comprobarDatosNuevoPrestamo(){
        $resultado = False;
        
        if(!isset($_POST['select'])){
            $errores[] = "Elija el tipo de préstamo. <br/>";
        }

        $_POST['credito'] = filter_input(INPUT_POST, "credito", FILTER_SANITIZE_NUMBER_INT);
        if(!isset($_POST['credito']) || $_POST['credito'] == '' || filter_input(INPUT_POST, "credito", FILTER_VALIDATE_INT)){
            $errores[] = "Introduzca un crédito válido. <br/>";
        }

        if(isset($_POST['credito']) && ($_POST['credito'] < 1000 || $_POST['credito'] > 100000) && $_POST['select'] == "personal"){
            $errores[] = "La mínima cantidad a solicitar para los préstamos personales son 1000 euros y la máxima 100000 euros. <br/>";
        }

        if(isset($_POST['credito']) && ($_POST['credito'] < 40000 || $_POST['credito'] > 1000000)&& $_POST['select'] == "hipotecario"){
            $errores[] = "La mínima cantidad a solicitar para los préstamos hipotecarios son 40000 euros y la máxima 1000000 euros. <br/>";
        }

        $_POST['entrada'] = filter_input(INPUT_POST, "entrada", FILTER_SANITIZE_NUMBER_INT);
        if($_POST['entrada'] == '' || filter_input(INPUT_POST, "entrada", FILTER_VALIDATE_INT)){
            $errores[] = "Introduzca una entrada válida. <br/>";
        }

        if(isset($_POST['entrada']) && $_POST['entrada'] < 500){
            $errores[] = "Introduzca una entrada mayor a 500 euros. <br/>";
        }

        $_POST['cuenta'] = filter_input(INPUT_POST, "cuenta", FILTER_SANITIZE_STRING);
        if(!isset($_POST['cuenta']) || $_POST['cuenta'] == '' || !preg_match('/^([A-Z]{2})\s*\t*(\d\d)\s*\t*(\d\d\d\d)\s*\t*(\d\d\d\d)\s*\t*(\d\d)\s*\t*(\d\d\d\d\d\d\d\d\d\d)/', $_POST['cuenta'])){
            $errores[] = "Introduzca una cuenta válida. <br/>";
        }

        if(!isset($errores)){
            $resultado = True;
        }else{
            foreach($errores as $e){
                echo $e;
            }
        }

        return $resultado;
    }

    function nuevoPrestamo(){
        $resultado = False;
        $existe = False;
        $tipo = $_POST['select'];
        $credito = $_POST['credito'];
        $entrada = 0;
        $cuenta = $_POST['cuenta'];
        $fecha_actual = date("d-m-Y");

        if($tipo == "personal"){
            $intereses = 4.95;

            if($credito >= 1000 && $credito <= 10000){
                $cuota = $credito/14;
                $fecha_limite = date("Y-m-d", strtotime($fecha_actual."+ 14 month"));
            }elseif($credito > 10000 && $credito <= 20000){
                $cuota = $credito/20;
                $fecha_limite = date("Y-m-d", strtotime($fecha_actual."+ 20 month"));
            }elseif($credito > 20000 && $credito <= 30000){
                $cuota = $credito/26;
                $fecha_limite = date("Y-m-d", strtotime($fecha_actual."+ 26 month"));
            }elseif($credito > 30000 && $credito <= 50000){
                $cuota = $credito/34;
                $fecha_limite = date("Y-m-d", strtotime($fecha_actual."+ 34 month"));
            }elseif($credito > 50000 && $credito <= 70000){
                $cuota = $credito/40;
                $fecha_limite = date("Y-m-d", strtotime($fecha_actual."+ 40 month"));
            }else{
                $cuota = $credito/55;
                $fecha_limite = date("Y-m-d", strtotime($fecha_actual."+ 55 month"));
            }
        }else{
            $intereses = 1.95;

            if($credito >= 40000 && $credito <= 100000){
                $cuota = $credito/34;
                $fecha_limite = date("Y-m-d", strtotime($fecha_actual."+ 34 month"));
            }elseif($credito > 100000 && $credito <= 200000){
                $cuota = $credito/55;
                $fecha_limite = date("Y-m-d", strtotime($fecha_actual."+ 55 month"));
            }elseif($credito > 200000 && $credito <= 300000){
                $cuota = $credito/69;
                $fecha_limite = date("Y-m-d", strtotime($fecha_actual."+ 69 month"));
            }elseif($credito > 300000 && $credito <= 500000){
                $cuota = $credito/75;
                $fecha_limite = date("Y-m-d", strtotime($fecha_actual."+ 75 month"));
            }elseif($credito > 500000 && $credito <= 700000){
                $cuota = $credito/85;
                $fecha_limite = date("Y-m-d", strtotime($fecha_actual."+ 85 month"));
            }elseif($credito > 700000 && $credito <= 1000000){
                $cuota = $credito/110;
                $fecha_limite = date("Y-m-d", strtotime($fecha_actual."+ 110 month"));
            }
        }

        $con = mysqli_connect("localhost", "root", "");
        
        if(!$con){
            die('No puedo conectar: ' . mysqli_error($con));
        }
        
        $db_selected = mysqli_select_db($con, "mensabank");
        
        if(!$db_selected){
            die('No puedo usar la base de datos: ' . mysqli_error($con));
        }
        
        $cliente = $_SESSION['dni'];

        $resQuery1 = mysqli_query($con, "SELECT * from cuenta WHERE cliente='$cliente' AND cuenta='$cuenta'");

        if(!$resQuery1){
            mysqli_close($con);
            die('No puedo ejecutar la consulta: ' . mysqli_error($con));
        }else{
            if(mysqli_num_rows($resQuery1) != 0){
                $row = mysqli_fetch_array($resQuery1);
                
                if($row['saldo'] < $entrada){

                }else{
                    $existe = True;
                }
            }
        }

        $resQuery2 = mysqli_query($con, "SELECT * from cuenta_ahorros WHERE cliente='$cliente' AND cuenta='$cuenta'");

        if(!$resQuery2){
            mysqli_close($con);
            die('No puedo ejecutar la consulta: ' . mysqli_error($con));
        }else{
            if(mysqli_num_rows($resQuery2) != 0){
                $row = mysqli_fetch_array($resQuery2);
                
                if($row['saldo'] < $entrada){
                    
                }else{
                    $existe = True;
                }
            }
        }

        $resQuery3 = mysqli_query($con, "SELECT * from cuenta_nomina WHERE cliente='$cliente' AND cuenta='$cuenta'");

        if(!$resQuery3){
            mysqli_close($con);
            die('No puedo ejecutar la consulta: ' . mysqli_error($con));
        }else{
            if(mysqli_num_rows($resQuery3) != 0){
                $row = mysqli_fetch_array($resQuery3);
                
                if($row['saldo'] < $entrada){
                    
                }else{
                    $existe = True;
                }
            }
        }

        if($existe){
            $resQuery4 = mysqli_query($con, "INSERT INTO mensabank(tipo, credito, cuota, entrada, intereses, fecha_limite, cliente, cuenta, pagado) VALUES ('$tipo', '$credito', '$cuota', '$entrada', '$intereses', '$fecha_limite', '$cliente', '$cuenta', '$entrada')");
            
            if(!$resQuery4){
                mysqli_close($con);
                die('No puedo ejecutar la consulta: ' . mysqli_error($con));
            }else{
                $resultado = True;
            }
        }
        
        mysqli_close($con);
        
        return $resultado;
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
    <link type="text/css" rel="stylesheet" href="../css/footer_style.css">

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
        $ok = comprobarNuevoPrestamo();
            
        if(!$ok){
            mostrarFormulario();
        }
    ?>

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
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.4/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-match-height@0.7.2/dist/jquery.matchHeight.min.js"></script>
    <script src="assets/js/main.js"></script>
</body>
</html>
