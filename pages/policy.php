!doctype html>
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
        p {
            color: black;
        }
        .table {
            width: 60%;
        }
    </style>
</head>

<body class="bg-color">
    <!-- Left Panel -->
    <?php require_once("nav.php"); ?>
    <!-- /#left-panel -->
    <!-- Right Panel -->
    <div id="right-panel" class="right-panel">
        <!-- Header-->
        <?php require_once("header.php"); ?>
        <!-- /#header -->
        <!-- Content -->
        <div class="content">
            <div class="row card">
                <h1 class="card-header">Cookies</h1>
                    <div class="card-body">
                        <p><strong>¿Qué son las cookies?</strong><br/>
                            Una cookie es un archivo que se descarga en su equipo terminal con la finalidad de almacenar datos que podrán ser actualizados y recuperados por la entidad responsable de su instalación. 
                            <br/>
                            <br/><strong>Consentimiento</strong><br/>
                            Le informamos de que podemos utilizar cookies en su equipo a condición de que Usted haya dado su consentimiento, salvo en los supuestos en los que las cookies sean necesarias para la navegación 
                            por nuestro sitio web. En caso de que Usted preste su consentimiento, podremos utilizar cookies que nos permitirán tener más información acerca de sus preferencias y personalizar nuestro sitio web 
                            de conformidad con sus intereses individuales.<br/>

                            <br/><strong>¿Para qué se utilizan las cookies en este sitio web?</strong><br/>
                            Utilizamos cookies propias y de terceros para mejorar nuestros servicios, personalizar nuestro sitio web, facilitar la navegación de nuestros usuarios, proporcionarle una mejor experiencia en el uso 
                            del sitio web, identificar problemas para mejorar el mismo, hacer mediciones y estadísticas de uso y mostrarle publicidad relacionada con sus preferencias mediante el análisis del uso del sitio web.
                            <br/>

                            <br/><strong>Cambios en la política</strong><br/>
                            La presente Política de Cookies se podrá modificar cuando así lo exija la legislación vigente en cada momento o cuando hubiera alguna variación en el tipo de cookies utilizadas en el sitio web. 
                            Por ello, le recomendamos revisar esta política cada vez que acceda a nuestro sitio web con el objetivo de estar adecuadamente informado sobre cómo y para qué usamos las cookies.
                        </p>
                    </div>
            </div>

            <div class="row card">
                <h1 class="card-header">Tratamiento de datos personales</h1>
                    <div class="card-body">
                        <p><strong>¿Qué finalidad tiene esta Política de Protección de Datos Personales?</strong><br/>
                            Esta política de protección de datos personales (“Política de Protección de Datos Personales”) tiene por objeto dar a conocer el modo en que obtenemos, 
                            tratamos y protegemos los datos personales que facilites o recojamos a través de nuestro sitio web por medio de cookies para que puedas decidir libre y voluntariamente si deseas que los tratemos. 
                            <br/>
                            <br/>Cuando contrates productos o servicios con MensaBank el tratamiento de datos personales se realizará de conformidad con lo establecido en el documento correspondiente.
                            <br/>
                            <br/>En este documento te informamos sobre el tratamiento de la información que Mensabank obtiene a través del Sitio Web pero no es aplicable a la que pueda ser obtenida por 
                            terceros en otras páginas web, incluso si éstas se encuentran enlazadas por el Sitio Web.
                            <br/>
                            <br/>Te recordamos la importancia de leer esta Política de Protección de Datos Personales en cada una de las ocasiones en que vayas a utilizar el Sitio Web, ya que ésta puede sufrir modificaciones.
                            <br/>
                            <br/>En MensaBank tenemos implementados y mantenemos los más altos niveles de seguridad exigidos por la legislación para proteger  tus datos de carácter personal frente a pérdidas fortuitas y accesos, 
                            tratamientos o revelaciones no autorizados, habida cuenta del estado de la tecnología, la naturaleza de los datos almacenados y los riesgos a que están expuestos.
                            <br/>
                            <br/><strong>¿A quién comunicaremos tus datos?</strong><br/>
                            No cederemos tus datos personales a terceros, salvo que estemos obligados por una ley o que tú lo consientas.<br/>
                            <br/>
                            Cuando sea necesario tu consentimiento para comunicar tus datos personales a terceros, en los formularios de recogida de datos te informaremos de la finalidad del tratamiento, de los datos objeto de 
                            comunicación así como de la identidad o sectores de actividad de los posibles cesionarios de tus datos personales.<br/>
                        
                            <br/><strong>¿MensaBank utiliza enlaces a otras páginas web?</strong><br/>
                            <br/>El Sitio Web puede contener enlaces a otras páginas web. Ten en cuenta que MensaBank no es responsable de la privacidad y el tratamiento de datos personales de otras páginas web. 
                            Este documento de Política de Protección de Datos Personales se aplica exclusivamente a la información que se recaba en el Sitio Web por MensaBank. Te recomendamos que leas las políticas tratamiento de 
                            datos personales de otras páginas web con las que enlaces desde nuestro Sitio Web o que visites de cualquier otro modo.
                        </p>
                    </div>
            </div>

            <div class="row card">
                <h1 class="card-header">Negocio Responsable</h1>
                    <div class="card-body">
                        <p><strong>Hacemos Negocio Responsable y esto implica hacer nuestra actividad diaria poniendo a las personas en el centro.</strong></br>
                        <br/>Somos conscientes de que hay muchas cosas que mejorar, pero tenemos claro que ser rentables no pasa por hacer negocio de cualquier modo.
                        <br/>
                        <br/>Por eso hablamos de rentabilidad ajustada a los <strong>principios de integridad, prudencia y transparencia</strong>.

                        <br/>En España, Negocio responsable significa principalmente:

                        <ul>
                            <li>Ofrecer soluciones a todas las familias con dificultades en el pago de sus préstamos hipotecarios.</li>
                            <li>Apoyar la generación de empleo y crecimiento de la economía española, fundamentalmente a través del apoyo a la pequeña y mediana empresa.</li>
                            <li>Tener una relación con los clientes basada en la claridad y la transparencia.</li>
                        <ul>
                        </p>
                    </div>
            </div>
        </div>
        <!-- /.content -->
        <!-- Footer -->
        <?php require_once("footer.php"); ?>
        <!-- /.site-footer -->
    </div>
    <!-- /#right-panel -->

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