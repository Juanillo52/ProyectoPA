<?php
    require_once("test_log.php");
?>

<?php
    function mostrarPrestamos(){
        //Left Panel -->
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
                    <h1 class="card-header">Préstamos</h1>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Importe</th>
                                        <th>Tipo</th>
                                        <th>Cuenta</th>
                                        <th>Cuota</th>
                                        <th>Interés</th>
                                        <th>Pagado</th>
                                        <th>Fecha límite</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>';

                                $con = mysqli_connect("localhost","root","Pistacho99!");

                                if (!$con){
                                    die(' No puedo conectar: ' . mysqli_error($con));
                                }
                            
                                $db_selected = mysqli_select_db($con, "mensabank");
                            
                                if (!$db_selected){
                                    die ('No puedo usar la base de datos: ' . mysqli_error($con));
                                }
                            
                                $dni = $_SESSION['dni'];


                                    $resQuery = mysqli_query($con, "SELECT * from prestamo WHERE cliente = '$dni'");
                                    
                                    if (!$resQuery) {
                                        die ("Error al ejecutar la consulta: " . mysqli_error($con));
                                    }else{
                                        if(mysqli_num_rows($resQuery) != 0){

                                            while($row = mysqli_fetch_array($resQuery)){
                                                echo '<tr>
                                                    <td>'. $row['credito'] .' euros</td>
                                                    <td>'. $row['tipo'] .'</td>
                                                    <td>'. $row['cuenta'] .'</td>
                                                    <td>'. $row['cuota'] .' euros</td>
                                                    <td>'. $row['intereses'] .'</td>
                                                    <td>'. $row['pagado'] .'</td>
                                                    <td>'. $row['fecha_limite'] .'</td>
                                                    <td>'. $row['estado'] .'</td>';
                                                    if($row['estado']=='En proceso'){
                                                        echo '<td><input class="btn btn-main" type="submit" name="'. $row['id'] .'" value="Pagar"></input></td>';
                                                    }else{
                                                        echo '<td><input class="btn btn-main" type="submit" name="'. $row['id'] .'" value="Pagar" disabled></input></td>';
                                                    }
                                                echo '</tr>';
                                            }
                                        }
                                    }

                                    echo '</tbody>
                                    </table>
                                </form>';
                                
                                mysqli_close($con);

                            echo '
                        </div>
                </div>
            </div>
            <!-- /.content -->';
            //Footer
            require_once("footer.php");
            //.site-footer
        
        echo'</div>';
    }

    function comprobarBoton(){
        $con = mysqli_connect("localhost", "root", "Pistacho99!");

        if (!$con){
            die(' No puedo conectar: ' . mysqli_error($con));
        }
    
        $db_selected = mysqli_select_db($con, "mensabank");
    
        if (!$db_selected){
            die ('No puedo usar la base de datos: ' . mysqli_error($con));
        }
    
        $dni = $_SESSION['dni'];

        $resQuery = mysqli_query($con, "SELECT * from prestamo WHERE cliente = '$dni'");
        
        if (!$resQuery) {
            die ("Error al ejecutar la consulta: " . mysqli_error($con));
        }else{
            while($row = mysqli_fetch_array($resQuery)){
                $id = $row['id'];

                if(isset($_POST[$id])){
                    $estado = $row['estado'];
                    $fechaActual = date("Y-m-d");

                    if($estado == "En proceso" && $fechaActual < $row['fecha_limite']){
                        $cuenta = $row['cuenta'];
                        $enc = False;

                        $resQuery2 = mysqli_query($con, "SELECT * from cuenta WHERE cliente = '$dni' and iban='$cuenta'");

                        if (!$resQuery2) {
                            die ("Error al ejecutar la consulta: " . mysqli_error($con));
                        }else{
                            if($row2 = mysqli_fetch_array($resQuery2)){
                                $enc = True;
                                $credito = $row['credito'];
                                $cuota = $row['cuota'];
                                $pagado = $row['pagado'];
                                $saldo = $row2['saldo'];
                                
                                if($saldo > $cuota){
                                    if(($cuota + $pagado) >= $credito){
                                        $resQuery3 = mysqli_query($con, "UPDATE prestamo SET pagado=pagado+'$cuota', estado='Pagado' WHERE id='$id'");
                                        
                                        if (!$resQuery3) {
                                            die ("Error al ejecutar la consulta: " . mysqli_error($con));
                                        }
                                    }else{
                                        $resQuery3 = mysqli_query($con, "UPDATE prestamo SET pagado=pagado+'$cuota' WHERE id='$id'");
                                        
                                        if (!$resQuery3) {
                                            die ("Error al ejecutar la consulta: " . mysqli_error($con));
                                        } 
                                    }
                                    
                                    $resQuery4 = mysqli_query($con, "UPDATE cuenta SET saldo=saldo-'$cuota' WHERE iban='$cuenta'");

                                    if (!$resQuery4) {
                                        die ("Error al ejecutar la consulta: " . mysqli_error($con));
                                    }
                                }else{                                    
                                    echo '<div class="sufee-alert alert with-close alert-danger alert-dismissible fade show alert">
                                    <span> No hay saldo suficiente en la cuenta asociada al préstamo para pagar una cuota. </span>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Entendido">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>';                                    
                                }                               
                            }
                        }
                        
                        if(!$enc){
                            $resQuery2 = mysqli_query($con, "SELECT * from cuenta_ahorros WHERE cliente = '$dni' and iban='$cuenta'");

                            if (!$resQuery2) {
                                die ("Error al ejecutar la consulta: " . mysqli_error($con));
                            }else{
                                if($row2 = mysqli_fetch_array($resQuery2)){
                                    $enc = True;
                                    $credito = $row['credito'];
                                    $cuota = $row['cuota'];
                                    $pagado = $row['pagado'];
                                    $saldo = $row2['saldo'];
                                    
                                    if($saldo > $cuota){
                                        if(($cuota + $pagado) >= $credito){
                                            $resQuery3 = mysqli_query($con, "UPDATE prestamo SET pagado=pagado+'$cuota', estado='Pagado' WHERE id='$id'");
                                            
                                            if (!$resQuery3) {
                                                die ("Error al ejecutar la consulta: " . mysqli_error($con));
                                            }
                                        }else{
                                            $resQuery3 = mysqli_query($con, "UPDATE prestamo SET pagado=pagado+'$cuota' WHERE id='$id'");
                                            
                                            if (!$resQuery3) {
                                                die ("Error al ejecutar la consulta: " . mysqli_error($con));
                                            } 
                                        }
                                        
                                        $resQuery4 = mysqli_query($con, "UPDATE cuenta_ahorros SET saldo=saldo-'$cuota' WHERE iban='$cuenta'");

                                        if (!$resQuery4) {
                                            die ("Error al ejecutar la consulta: " . mysqli_error($con));
                                        }
                                    }else{                                    
                                        echo '<div class="sufee-alert alert with-close alert-danger alert-dismissible fade show alert">
                                        <span> No hay saldo suficiente en la cuenta asociada al préstamo para pagar una cuota. </span>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Entendido">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        </div>';                                    
                                    } 
                                }
                            }
                        }
                        
                        if(!$enc){
                            $resQuery2 = mysqli_query($con, "SELECT * from cuenta_nomina WHERE cliente = '$dni' and iban='$cuenta'");

                            if (!$resQuery2) {
                                die ("Error al ejecutar la consulta: " . mysqli_error($con));
                            }else{
                                if($row2 = mysqli_fetch_array($resQuery2)){
                                    $enc = True;
                                    $credito = $row['credito'];
                                    $cuota = $row['cuota'];
                                    $pagado = $row['pagado'];
                                    $saldo = $row2['saldo'];
                                    
                                    if($saldo > $cuota){
                                        if(($cuota + $pagado) >= $credito){
                                            $resQuery3 = mysqli_query($con, "UPDATE prestamo SET pagado=pagado+'$cuota', estado='Pagado' WHERE id='$id'");
                                            
                                            if (!$resQuery3) {
                                                die ("Error al ejecutar la consulta: " . mysqli_error($con));
                                            }
                                        }else{
                                            $resQuery3 = mysqli_query($con, "UPDATE prestamo SET pagado=pagado+'$cuota' WHERE id='$id'");
                                            
                                            if (!$resQuery3) {
                                                die ("Error al ejecutar la consulta: " . mysqli_error($con));
                                            } 
                                        }
                                        
                                        $resQuery4 = mysqli_query($con, "UPDATE cuenta_nomina SET saldo=saldo-'$cuota' WHERE iban='$cuenta'");

                                        if (!$resQuery4) {
                                            die ("Error al ejecutar la consulta: " . mysqli_error($con));
                                        }
                                    }else{                                    
                                        echo '<div class="sufee-alert alert with-close alert-danger alert-dismissible fade show alert">
                                        <span> No hay saldo suficiente en la cuenta asociada al préstamo para pagar una cuota. </span>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Entendido">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        </div>';                                    
                                    } 
                                }
                            }
                        }         
                    }elseif($estado == 'En proceso' && $fechaActual > $row['fecha_limite']){
                        $resQuery3 = mysqli_query($con, "UPDATE prestamo SET estado='Fuera de plazo' WHERE id='$id'");
                                        
                        if (!$resQuery3) {
                            die ("Error al ejecutar la consulta: " . mysqli_error($con));
                        } 
                    }           
                }
            }
        }

        mysqli_close($con);
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
    </style>
</head>

<body class="bg-color">
    <?php
        comprobarBoton();


        mostrarPrestamos();
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