<?php
    session_start();
?>

<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Mensabank</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link type="text/css" rel="stylesheet" href="../plantilla-boostrap/assets/css/style.css">

        <link rel="apple-touch-icon" href="https://i.imgur.com/QRAUqs9.png">
    <link rel="shortcut icon" href="https://i.imgur.com/QRAUqs9.png">

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

    </style>
    </head>
    <body>
    <div id="right-panel" class="right-panel">    
        <header id="header" class="header">
            <div class="top-left">
                <div class="navbar-header">
                    <a class="navbar-brand" href="./"><img class="logo" src="../images/logo.png" alt="Logo"></a>
                </div>
            </div>
            <div class="top-right">
                <div class="header-menu">
                    <div class="header-left">
                        <button class="btn btn-primary btn-lg" type="button" id="login">Login</button>
                        <button class="btn btn-secondary btn-lg" type="button" id="signin">Registro</button>
                    </div>
                </div>
            </div>
        </header>
    </div>
        <h1>Bienvenido a Mensabank</h1>
        <section>
            <article>
                <h2>¿Qué es Mensabank?</h2>
                <p>
                    Mensabank es un banco online destinado a las personas. <br/> 
                    Nuestra plataforma le permitirá gestionar su dinero de manera fácil, rápida e intuitiva.
                    Sin necesidad de tanto papeleo como en un banco tradicional, solo necesitará registrarse y ya podrá acceder a todos nuestros servicios.
                    Además, con 0 comisiones de apertura y 0 coste de mantenimiento.
                </p>

                <h2>Nuestros servicios</h2>
                <p>Cuando complete el registro, usted tendrá acceso a todos nuestros servicios, los cuales, si lo requiere, le serán explicados a continuación.</p>
                
                <h3>Cuentas</h3>
                    <h4>Cuenta corriente</h4>
                    <p>
                        Una cuenta corriente es la mejor opción para depositar tu dinero y poder disponer libremente de éste de una forma rápida y sencilla. 
                        Además te permite gestionar tus ahorros día a día y realizar transferencias bancarias.
                    </p>

                    <h4>Cuenta nómina</h4>
                    <p>
                        Si estás buscando la cuenta nómina perfecta para domiciliar tu nómina o pensión te ofrecemos lo mejor de nuestra cartera de productos. 
                        Una cuenta adaptada a tus necesidades. Si aún no eres cliente, crea tu cuenta nómina en pocos minutos.
                        <br/>
                        <ol>
                            <li>Sin comisiones.</li>
                            <li>Con tarjetas de débito y crédito gratis.</li>
                        </ol>
                        <strong>No pagas por:</strong>
                        <ol>
                            <li>Mantenimiento y administración de la cuenta.</li>
                            <li>Transferencias.</li>
                        </ol>   
                        <br/>

                        <h5>Condiciones de la cuenta nómina.</h5>
                        <p>Las condiciones de uso y perfil digital, para disfrutar de todas las ventajas, son muy sencillas:</p>
                        <ol>
                            <li>Ser mayor de 18 años.</li>
                            <li>Domiciliar tu nómina o pensión.</li>
                            <li>Toda nuestra correspondencia será a través de email.</li>
                            <li>Informarnos de tu móvil o email para recibir comunicaciones comerciales.</li>
                            <li>Gestión de la cuenta 100% online.</li>
                        </ol>
                    
                    </p>

                    <h4>Cuenta de ahorros</h4>
                    <p>
                        Ahorra sin comisiones, pensando en el futuro. Podrás retirar tu dinero en cualquier momento.<br/>
                        No pagas por nada, ni por matenimiento de la cuenta, ni por las transferencias en el mismo día.....<br/>
                        Disfruta de una rentabilidad del 0,01% TAE y además, disfruta de forma gratuita de asesoramiento digital que te ayudará a 
                        sacar más partido a tus ahorros.
                    </p>


                <h3>Tarjetas</h3>
                    <h4>Tarjeta de crédito</h4>
                    <p>
                        Son la mejor forma para realizar tus compras y aplazar pagos según tus necesidades. 
                        A diferencia de las tarjetas de débito, puedes optar por pagar al finalizar el mes, aplazar o fraccionar el pago con total flexibilidad. 
                        Además, son un medio de pago seguro que te permite controlar tus gastos con el extracto de cada mes.
                    </p>

                    <h4>Tarjeta de débito</h4>
                    <p>
                        La tarjeta de débito es el medio de pago diario para tus compras. 
                        A diferencia de las tarjetas de crédito, todo gasto que hagas con ella se cargará de forma inmediata en tu cuenta corriente sin intereses. 
                        Destacar que esta tarjeta no permite financiación.
                    </p>

                <h3>Transferencias</h3>
                    <p>
                        Permitimos transferencias internacionales entre particulares de forma rápida y segura, ya que llegan al destino el mismo día en la mayoría
                        de los casos o al día siguiente. En caso de transferencias entre cuentas de Mensabank, serán inmediatas y el resto de operaciones con un plazo máximo
                        de 2 días.<br/>
                        También permite a los clientes conocer el importe exacto que llegará en la moneda del destinatario antes de confirmar la transacción y sin comisiones.
                    </p>

                <h3>Préstamos</h3>
                    <h4>Préstamo personal</h4>
                    <p>
                        Si estás pensando en estrenar coche, redecorar tu casa o hacer el viaje de tus sueños,... tenemos la financiación que necesitas de la forma más rápida, fácil y cómoda. 
                        Para hacer frente a cualquier pago.<br/>
                        Accediendo a tu zona de cliente en Mensabank, puedes ver tu crédito disponible, plazos e intereses. Elige el plazo, el importe del préstamo, la cuenta asociada y el día de pago. 
                        Sin más gestiones y en tan solo unos minutos tendrás el dinero en tu cuenta. Sin papeleos.
                        
                        <h5>Condiciones económicas:</h5>
                        <ol>
                            <li>Importe mínimo de 1000 euros.</li>
                            <li>100 % del importe de la inversión (impuestos incluidos). 
                                No se podrán financiar los gastos de formalización del préstamo.
                            </li>
                            <li>Tipo de interés fijo, durante toda la vida del préstamo.</li>
                            <li>Puedes elegir el día del mes en el que quieres pagar los recibos de préstamo: entre el día 1 y el último día del mes.</li>
                            <li>Podrás dar una entrada para así reducir la cuota mensual.</li>
                        </ol>
                    </p>

                    <h4>Préstamo hipotecario</h4>
                    <p>
                        Una hipoteca es un tipo de préstamo que te permite financiar la adquisición de tu vivienda, piso o local.
                        <br/>
                        Sea cual sea tu casa tenemos un hipoteca adaptada para ti.Ahorra tiempo para conocer la mensualidad y los gastos asociados a tu hipoteca.
                        <br/>
                        Para adquirir tu vivienda habitual o tu segunda residencia.
                        <ol>
                            <li>
                                Adquisición de vivienda habitual: El importe máximo será el 80% del valor de tasación de la vivienda. El cliente debe aportar como mínimo, a través de fondos propios, el 20% del coste de la vivienda. 
                                El plazo máximo de la operación será 30 años (el plazo de la hipoteca más la edad del titular a la firma no podrá superar los 80 años de edad).
                            </li>
                            <li>
                                Adquisición de segunda residencia: El importe máximo será el 70% del valor de tasación de la vivienda. El cliente debe aportar como mínimo, a través de fondos propios, el 20% del coste de la vivienda. 
                                Plazo máximo 25 años (el plazo de la hipoteca más la edad del titular a la firma no podrá superar los 80 años de edad).
                            </li>
                        </ol>
                    </p>

                <h3>Plan de Pensiones</h3>
                    <h4>Ventajas:</h4>
                    
                        <ol>
                            <li>
                                <strong>Seguridad</strong><br/>
                                Una alternativa de inversión segura y fiable. Los clientes y sus productos contratados están protegidos por la Dirección General de Seguros y Fondos de Pensiones (DGSFP), el organismo público que supervisa 
                                los planes de pensiones. Asimismo, la sociedad gestora realiza a diario el control de la gestión y los riesgos, emitiendo un informe periódico de gestión. Por su lado, los auditores también vigilan la situación 
                                de los planes de los que nuestros clientes son dueños.
                            </li>
                            <li>
                                <strong>Transparencia</strong>
                                Desde el principio contarás con toda la información necesaria recogida en el documento de Datos Fundamentales para el Inversor, en el que encontrarás todos los datos para comprender de forma clara y sencilla 
                                el plan de pensiones donde invertirás tu patrimonio.
                            </li>
                            <li>
                                <strong>Liquidez</strong>
                                Los planes de pensiones solo se pueden rescatar en determinadas contingencias y supuestos, ya que el objetivo del ahorro invertido en estos productos es ahorrar para la jubilación.
                                <br/>
                                <ol>   
                                    <li>Si te has jubilado.</li>
                                    <li>Si sufres una incapacidad permanente total, absoluta y gran invalidez.</li>
                                    <li>Si falleces.</li>
                                    <li>Si tienes una gran dependencia.</li>
                                    <li>Si sufres una enfermedad grave propia o de familiares directos.</li>
                                    <li>Si eres desempleado de larga duración.</li>
                                </ol>
                            </li>
                            <li>
                                <strong>Diversificación</strong>
                                Todas las categorías de productos tienen diferentes objetivos de inversión, por eso, los planes de pensiones ofrecen:
                                <ol>
                                    <li>Ajuste a tu edad para que automáticamente varíe la inversión.</li>
                                    <li>Esté en línea con el riesgo que estás dispuesto a asumir.</li>
                                </ol>
                            </li>
                        </ol>
            </article>

            <article>
                <h2>¿Quiénes somos?</h2>
                <p>
                   Un grupo de jóvenes de tercer año de Ingenería Infórmatica en Sistemas de Información que se han aventurado a realizar la tarea de hacer un banco online
                   para facilitar la vida de aquellas personas que no tienen tiempo para el papeleo de un banco tradicional. Nuestros perfiles profesionales y académicos son:
                   <br/>
                   <ol>
                       <li>Andrés Manuel Chacón Maldonado: https://es.linkedin.com/in/andr%C3%A9s-manuel-chac%C3%B3n-maldonado-849142172</li>
                       <li>Juan Alberto Gallardo Gómez: https://es.linkedin.com/in/juan-alberto-gallardo-g%C3%B3mez-521213171</li>
                       <li>Héctor Antonio Moreno Martín: https://es.linkedin.com/in/hectormorenomartin</li>
                   </ol>
                </p>
            </article>
        </section>
        
        <?php require("footer.php"); ?>
    </body>
</html>
