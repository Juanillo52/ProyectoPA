<?php
    session_start();    
    require_once("cookie_alert.php");

    function comprobarFormulario(){
        $resultado = False; ## le damos este valor para que muestre el login
    
        if(isset($_POST['submit'])){    
            $ok = comprobarDatosFormulario();

            if($ok){
                $resultado = verificarLogin();

                if(!$resultado){
                    echo '<div class="sufee-alert alert with-close alert-danger alert-dismissible fade show alert">
                            <span> Clave incorrecta. </span>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Entendido">
                                <span aria-hidden="true">&times;</span>
                            </button>
                           </div>';
                }
            }         
        }

        if(isset($_POST['forgotpass'])){
            $enviar = true;

            $_POST['email'] = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
            if(!isset($_POST['email']) || $_POST['email'] == '' || !filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL)){
                $enviar = false;
            }

            if($enviar){
                enviarClave($_POST['email']);
            }
        }
        return $resultado;
    }
    
    function comprobarDatosFormulario(){
        if(!isset($_POST['dni']) || $_POST['dni'] == ''){$errores[] = "Introduzca el dni.<br/>";}
        else{$_POST['dni'] = filter_input(INPUT_POST, "dni", FILTER_SANITIZE_STRING);} 
        
        if(!isset($_POST['password']) || $_POST['password'] == ''){$errores[] = "Introduzca la clave de acceso.";}
        else{$_POST['password'] = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING);} 
        
        if(!isset($errores)){
            return True;
        }else {
            return False;
        }
    }
    
    function verificarLogin(){
        $resultado = False;
        $dni = $_POST['dni'];
        $password = $_POST['password'];
    
        $con = mysqli_connect("localhost","root","Pistacho99!");
    
        if (!$con){
            die(' No puedo conectar: ' . mysqli_error($con));
        }
    
        $db_selected = mysqli_select_db($con,"mensabank");
    
        if (!$db_selected){
            die ('No puedo usar la base de datos: ' . mysqli_error($con));
        }
    
        $resQuery = mysqli_query($con, "SELECT dni, clave from cliente WHERE dni = '$dni'");
        if (!$resQuery) {
            die ("Error al ejecutar la consulta: " . mysqli_error($con));
        }else{
            $data = mysqli_fetch_array($resQuery);
            $hash = $data['clave'];
    
            if($data['dni'] == $dni && password_verify($password, $hash)){
                $resultado = True;
            }
        }
        
    
        mysqli_close($con);
        
        return $resultado;
    }
    
    function getUser($dni){
        $nombre = null;
        $dni = $_POST['dni'];
        $con = mysqli_connect("localhost","root","Pistacho99!");
    
        if (!$con){
            die(' No puedo conectar: ' . mysqli_error($con));
        }
    
        $db_selected = mysqli_select_db($con,"mensabank");
    
        if (!$db_selected){
            die ('No puedo usar la base de datos: ' . mysqli_error($con));
        }
    
        $resQuery = mysqli_query($con, "SELECT nombre, dni from cliente WHERE dni='$dni'");

        if (!$resQuery) {
            die ("Error al ejecutar la consulta: " . mysqli_error($con));
        }else{
            $data = mysqli_fetch_array($resQuery);
            $nombre = $data['nombre'];
        }

        mysqli_close($con);
        
        return $nombre;
    }
    
    function redireccionar(){
        $_SESSION['login']= True;
        $_SESSION['user'] = getUser($_POST['dni']);
        $_SESSION['dni'] = $_POST['dni'];
    }

    function enviarClave($email){
        $con = mysqli_connect("localhost","root","Pistacho99!");
        $email = $_POST['email'];
    
        if (!$con){
            die(' No puedo conectar: ' . mysqli_error($con));
        }
    
        $db_selected = mysqli_select_db($con,"mensabank");
    
        if (!$db_selected){
            die ('No puedo usar la base de datos: ' . mysqli_error($con));
        }
    
        $resQuery = mysqli_query($con, "SELECT * from cliente WHERE email='$email'");

        if (!$resQuery) {
            die ("Error al ejecutar la consulta: " . mysqli_error($con));
        }else{
            if($row=mysqli_fetch_array($resQuery)){
                $nombre=$row['nombre'];

                $password= "";
    
                for($i =0 ; $i < 8 ; $i++){
                    $password.= rand(0,9);
                }
                
                $clave = password_hash($password, PASSWORD_DEFAULT);
                $resQuery = mysqli_query($con, "UPDATE cliente SET clave='$clave' WHERE email='$email'");

                if (!$resQuery) {
                    die ("Error al ejecutar la consulta: " . mysqli_error($con));
                }else{
                    ini_set( 'display_errors', 1 );
                    error_reporting( E_ALL );
                    $from = 'infomensabank@gmail.com';
                    $to = $email;
                    $subject = 'Aquí tienes tu nueva clave, '.$nombre;
                    $message = 'Tu nueva clave de acceso es: '.$password;
                    $headers = "From:" . $from;
                    mail($to,$subject,$message, $headers);
                }              
            }else{
                echo '<div class="sufee-alert alert with-close alert-danger alert-dismissible fade show alert">
                            <span> No se han encontrado coincidencias con el email introducido. </span>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Entendido">
                                <span aria-hidden="true">&times;</span>
                            </button>
                           </div>';
            }
        }
        mysqli_close($con);
    }
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
    <title>MensaBank</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link type="text/css" rel="stylesheet" href="../plantilla-boostrap/assets/css/style.css">

    <link rel="apple-touch-icon" href="https://i.imgur.com/QRAUqs9.png">
    <link rel="shortcut icon" href="../images/icon.png">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/normalize.css@8.0.0/normalize.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lykmapipo/themify-icons@0.1.2/css/themify-icons.css">
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/pixeden-stroke-7-icon@1.2.3/pe-icon-7-stroke/dist/pe-icon-7-stroke.min.css">
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
            color: #ffffff !important;
        }

        .traffic-chart {
            min-height: 335px;
        }

        #flotPie1 {
            height: 150px;
        }

        #flotPie1 td {
            padding: 3px;
        }

        #flotPie1 table {
            top: 20px !important;
            right: -10px !important;
        }

        .chart-container {
            display: table;
            min-width: 270px;
            text-align: left;
            padding-top: 10px;
            padding-bottom: 10px;
        }

        #flotLine5 {
            height: 105px;
        }

        #flotBarChart {
            height: 150px;
        }

        #cellPaiChart {
            height: 160px;
        }

        .site-footer{
            padding-right: 13px;
            padding-left: 13px;
        }
        body{
            padding-top:3%;
        }
        .right-panel{
            margin-top:0px;
        }
    </style>

</head>

<body class="bg-color">
    <?php
        if(comprobarFormulario()){
            redireccionar();
            header('Location: dashboard.php');
        }
    ?>

    <div id="right-panel" class="right-panel">
        <header id="header" class="header">
        
            <div class="top-left">
                <div class="navbar-header">
                <a class="navbar-brand" href="index.php"><img class="logo" src="../images/logo.png" alt="Logo"></a>
                </div>
            </div>
            <div class="top-right">
            
                <div class="header-menu">
                
                    <div class="header-left">
                        <button class="btn btn-main btn-lg" type="button" id="login">Login</button>
                        <button class="btn btn-secondary btn-lg" type="button" id="signup">Registro</button>
                    </div>
                </div>
            </div>
        </header>
    </div>

    <div id="divlogin">
        <div class="login-content">
            <div class="login-form">
                <form method="POST" onsubmit="return validar()">
                    <div class="form-group">
                    <label id="labelDNI">DNI    </label>
                    <input type="text" name="dni" id="dni" class="form-control"></div>
                    <div class="form-group">
                        <label id="labelClave">Clave de acceso  </label>
                        <input type="password" name="password" id="clave" class="form-control">
                    </div>
                    <div class="checkbox">
                        <label class="pull-right">
                            <a href="#" id="forgotpass">¿Olvidaste tu clave?</a>
                        </label>
                    </div>
                    <button type="submit" name="submit" class="btn btn-main btn-flat m-b-30 m-t-30">Acceder</button>
                    <div class="register-link m-t-15 text-center">
                        <p>¿Todavía no eres cliente de MensaBank? <a href="register.php"> Regístrate aquí</a></p>
                    </div>
                </form>

                <form method="POST">
                    <div id="divforgotpass">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-main btn-flat m-b-30 m-t-30" name="forgotpass">Recuperar clave</button>                
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php 
        if(isset($_SESSION['nologin']) && $_SESSION['nologin']){
            echo '<div class="sufee-alert alert with-close alert-danger alert-dismissible fade show alert">
            <span> Usted no está logueado, por lo que no podrá acceder a nuestros servicios hasta que lo haga. Gracias.</span>
            <button type="button" class="close" data-dismiss="alert" aria-label="Entendido">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>';
        }
    ?>
        
    <section class="content">
        <article class="row card">
            <h1 class="card-header">¿Qué es MensaBank?</h1>
            <div class="card-body">
                <p id="p-logo">
                    Mensabank es un banco online destinado a las personas.
                    Nuestra plataforma le permitirá gestionar su dinero de manera fácil, rápida e intuitiva.
                    Sin necesidad de tanto papeleo como en un banco tradicional, solo necesitará registrarse y ya podrá
                    acceder a todos nuestros servicios.
                    Además, con 0 comisiones de apertura y 0 coste de mantenimiento.
                </p>
                <img class="logo" src="../images/logo.png" alt="Logo" id="logo-grande" />
            </div>
        </article>
           
      
        <article class="row card">
            <h2 class="card-header">Nuestros servicios</h2>
            <div class="card-body">
                <p>Cuando complete el registro, usted tendrá acceso a todos nuestros servicios, los cuales, si lo
                    requiere, le serán explicados a continuación.</p>
                <div class="custom-tab">
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="custom-nav-cuentas-tab" data-toggle="tab"
                                href="#custom-nav-cuentas" role="tab" aria-controls="custom-nav-cuentas"
                                aria-selected="true">Cuentas</a>
                            <a class="nav-item nav-link" id="custom-nav-tarjetas-tab" data-toggle="tab"
                                href="#custom-nav-tarjetas" role="tab" aria-controls="custom-nav-tarjetas"
                                aria-selected="false">Tarjetas</a>
                            <a class="nav-item nav-link" id="custom-nav-transferencias-tab" data-toggle="tab"
                                href="#custom-nav-transferencias" role="tab" aria-controls="custom-nav-transferencias"
                                aria-selected="false">Transferencias</a>
                            <a class="nav-item nav-link" id="custom-nav-prestamos-tab" data-toggle="tab"
                                href="#custom-nav-prestamos" role="tab" aria-controls="custom-nav-prestamos"
                                aria-selected="false">Préstamos</a>
                            <a class="nav-item nav-link" id="custom-nav-pensiones-tab" data-toggle="tab"
                                href="#custom-nav-pensiones" role="tab" aria-controls="custom-nav-pensiones"
                                aria-selected="false">Plan de pensiones</a>
                        </div>
                    </nav>
                    <div class="tab-content pl-3 pt-2" id="nav-tabContent">
                        <div class="tab-pane fade active show" id="custom-nav-cuentas" role="tabpanel"
                            aria-labelledby="custom-nav-cuentas-tab">
                            <h4>Cuenta corriente</h4>
                            <p>
                                Una cuenta corriente es la mejor opción para depositar tu dinero y poder disponer
                                libremente de éste de una forma rápida y sencilla.
                                Además te permite gestionar tus ahorros día a día y realizar transferencias bancarias.
                            </p>

                            <h4>Cuenta nómina</h4>
                            <p>
                                Si estás buscando la cuenta nómina perfecta para domiciliar tu nómina o pensión te
                                ofrecemos lo mejor de nuestra cartera de productos.
                                Una cuenta adaptada a tus necesidades. Si aún no eres cliente, crea tu cuenta nómina en
                                pocos minutos.
                                <br />
                                <ul type="disc">
                                    <li>Sin comisiones.</li>
                                    <li>Con tarjetas de débito y crédito gratis.</li>
                                </ul>
                                <strong>No pagas por:</strong>
                                <ul type="disc">
                                    <li>Mantenimiento y administración de la cuenta.</li>
                                    <li>Transferencias.</li>
                                </ul>
                                <br />

                                <h5>Condiciones de la cuenta nómina.</h5>
                                <p>Las condiciones de uso y perfil digital, para disfrutar de todas las ventajas, son
                                    muy sencillas:</p>
                                <ul type="disc">
                                    <li>Ser mayor de 18 años.</li>
                                    <li>Domiciliar tu nómina o pensión.</li>
                                    <li>Toda nuestra correspondencia será a través de email.</li>
                                    <li>Informarnos de tu móvil o email para recibir comunicaciones comerciales.</li>
                                    <li>Gestión de la cuenta 100% online.</li>
                                </ul>

                            </p>

                            <h4>Cuenta de ahorros</h4>
                            <p>
                                Ahorra sin comisiones, pensando en el futuro. Podrás retirar tu dinero en cualquier
                                momento.<br />
                                No pagas por nada, ni por matenimiento de la cuenta, ni por las transferencias en el
                                mismo día.....<br />
                                Disfruta de una rentabilidad del 0,01% TAE y además, disfruta de forma gratuita de
                                asesoramiento digital que te ayudará a
                                sacar más partido a tus ahorros.
                            </p>
                        </div>
                        <div class="tab-pane fade" id="custom-nav-tarjetas" role="tabpanel"
                            aria-labelledby="custom-nav-tarjetas-tab">
                            <h4>Tarjeta de crédito</h4>
                            <p>
                                Son la mejor forma para realizar tus compras y aplazar pagos según tus necesidades.
                                A diferencia de las tarjetas de débito, puedes optar por pagar al finalizar el mes,
                                aplazar o fraccionar el pago con total flexibilidad.
                                Además, son un medio de pago seguro que te permite controlar tus gastos con el extracto
                                de cada mes.
                            </p>

                            <h4>Tarjeta de débito</h4>
                            <p>
                                La tarjeta de débito es el medio de pago diario para tus compras.
                                A diferencia de las tarjetas de crédito, todo gasto que hagas con ella se cargará de
                                forma inmediata en tu cuenta corriente sin intereses.
                                Destacar que esta tarjeta no permite financiación.
                            </p>
                        </div>
                        <div class="tab-pane fade" id="custom-nav-transferencias" role="tabpanel"
                            aria-labelledby="custom-nav-transferencias-tab">
                            <p>
                                Permitimos transferencias internacionales entre particulares de forma rápida y segura,
                                ya que llegan al destino el mismo día en la mayoría
                                de los casos o al día siguiente. En caso de transferencias entre cuentas de MensaBank,
                                serán inmediatas y el resto de operaciones con un plazo máximo
                                de 2 días.<br />
                                También permite a los clientes conocer el importe exacto que llegará en la moneda del
                                destinatario antes de confirmar la transacción y sin comisiones.
                            </p>
                        </div>
                        <div class="tab-pane fade" id="custom-nav-prestamos" role="tabpanel"
                            aria-labelledby="custom-nav-prestamos-tab">
                            <h4>Préstamo personal</h4>
                            <p>
                                Si estás pensando en estrenar coche, redecorar tu casa o hacer el viaje de tus
                                sueños,...
                                tenemos la financiación que necesitas de la forma más rápida, fácil y cómoda.
                                Para hacer frente a cualquier pago.<br />
                                Accediendo a tu zona de cliente en MensaBank, puedes ver tu crédito disponible, plazos e
                                intereses. Elige el plazo, el importe del préstamo, la cuenta asociada y el día de pago.
                                Sin más gestiones y en tan solo unos minutos tendrás el dinero en tu cuenta. Sin
                                papeleos.

                                <h5>Condiciones económicas:</h5>
                                <ul type="disc">
                                    <li>Importe mínimo de 1000 euros.</li>
                                    <li>
                                        100 % del importe de la inversión (impuestos incluidos).
                                        No se podrán financiar los gastos de formalización del préstamo.
                                    </li>
                                    <li>Tipo de interés fijo, durante toda la vida del préstamo.</li>
                                    <li>Puedes elegir el día del mes en el que quieres pagar los recibos de préstamo:
                                        entre el
                                        día 1 y el último día del mes.</li>
                                    <li>Podrás dar una entrada para así reducir la cuota mensual.</li>
                                </ul>
                            </p>

                            <h4>Préstamo hipotecario</h4>
                            <p>
                                Una hipoteca es un tipo de préstamo que te permite financiar la adquisición de tu
                                vivienda, piso
                                o local.
                                <br />
                                Sea cual sea tu casa tenemos un hipoteca adaptada para ti.Ahorra tiempo para conocer la
                                mensualidad y los gastos asociados a tu hipoteca.
                                <br />
                                Para adquirir tu vivienda habitual o tu segunda residencia.
                                <ul type="disc">
                                    <li>
                                        Adquisición de vivienda habitual: El importe máximo será el 80% del valor de
                                        tasación de
                                        la vivienda. El cliente debe aportar como mínimo, a través de fondos propios, el
                                        20% del
                                        coste de la vivienda.
                                        El plazo máximo de la operación será 30 años (el plazo de la hipoteca más la
                                        edad del
                                        titular a la firma no podrá superar los 80 años de edad).
                                    </li>
                                    <li>
                                        Adquisición de segunda residencia: El importe máximo será el 70% del valor de
                                        tasación
                                        de la vivienda. El cliente debe aportar como mínimo, a través de fondos propios,
                                        el 20%
                                        del coste de la vivienda.
                                        Plazo máximo 25 años (el plazo de la hipoteca más la edad del titular a la firma
                                        no
                                        podrá superar los 80 años de edad).
                                    </li>
                                </ul>
                            </p>
                        </div>
                        <div class="tab-pane fade" id="custom-nav-pensiones" role="tabpanel"
                            aria-labelledby="custom-nav-pensiones-tab">
                            <h4>Ventajas:</h4>

                            <ul type="disc">
                                <li>
                                    <strong>Seguridad</strong><br />
                                    Una alternativa de inversión segura y fiable. Los clientes y sus productos
                                    contratados están
                                    protegidos por la Dirección General de Seguros y Fondos de Pensiones (DGSFP), el
                                    organismo
                                    público que supervisa
                                    los planes de pensiones. Asimismo, la sociedad gestora realiza a diario el control
                                    de la gestión
                                    y los riesgos, emitiendo un informe periódico de gestión. Por su lado, los auditores
                                    también
                                    vigilan la situación
                                    de los planes de los que nuestros clientes son dueños.
                                </li>
                                <li>
                                    <strong>Transparencia</strong>
                                    Desde el principio contarás con toda la información necesaria recogida en el
                                    documento de Datos
                                    Fundamentales para el Inversor, en el que encontrarás todos los datos para
                                    comprender de forma
                                    clara y sencilla
                                    el plan de pensiones donde invertirás tu patrimonio.
                                </li>
                                <li>
                                    <strong>Liquidez</strong>
                                    Los planes de pensiones solo se pueden rescatar en determinadas contingencias y
                                    supuestos, ya
                                    que el objetivo del ahorro invertido en estos productos es ahorrar para la
                                    jubilación.
                                    <br />
                                    <ul type="disc">
                                        <li>Si te has jubilado.</li>
                                        <li>Si sufres una incapacidad permanente total, absoluta y gran invalidez.</li>
                                        <li>Si falleces.</li>
                                        <li>Si tienes una gran dependencia.</li>
                                        <li>Si sufres una enfermedad grave propia o de familiares directos.</li>
                                        <li>Si eres desempleado de larga duración.</li>
                                    </ul>
                                </li>
                                <li>
                                    <strong>Diversificación</strong>
                                    Todas las categorías de productos tienen diferentes objetivos de inversión, por eso,
                                    los planes
                                    de pensiones ofrecen:
                                    <ul type="disc">
                                        <li>Ajuste a tu edad para que automáticamente varíe la inversión.</li>
                                        <li>Esté en línea con el riesgo que estás dispuesto a asumir.</li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </article>

        <article class="row card">
            <h2 class="card-header">¿Quiénes somos?</h2>
            <p class="card-body">
                Un grupo de jóvenes de tercer año de Ingenería Informática en Sistemas de Información que se han
                aventurado a realizar la tarea de hacer un banco online
                para facilitar la vida de aquellas personas que no tienen tiempo para el papeleo de un banco
                tradicional. Nuestros perfiles profesionales y académicos son:
                <br />
                
                    <div class="father-profile-cards">
                        <div class="col-md-4 profile-cards">
                            <div class="card">
                                <div class="card-body">
                                    <div class="mx-auto d-block">
                                        <img class="rounded-circle mx-auto d-block" src="../images\andresmanuelchaconmaldonado.jpeg" style="width:300px;height:290px"
                                            alt="Card image cap">
                                        <h5 class="text-sm-center mt-2 mb-1">Andrés Manuel Chacón Maldonado</h5>
                                        <div class="location text-sm-center"><i class="fa fa-map-marker"></i>
                                            Sevilla, España</div>
                                    </div>
                                    <hr>
                                    <div class="card-text text-sm-center">
                                        <a href="https://twitter.com/Andres_CH_?s=09"><i class="fa fa-twitter pr-1"></i></a>
                                        <a
                                            href="https://es.linkedin.com/in/andr%C3%A9s-manuel-chac%C3%B3n-maldonado-849142172"><i
                                                class="fa fa-linkedin pr-1"></i></a>
                                        <a href="https://github.com/AndresManuelCH"><i class="fa fa-github pr-1"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 profile-cards">
                            <div class="card">
                                <div class="card-body">
                                    <div class="mx-auto d-block">
                                        <img class="rounded-circle mx-auto d-block" src="../images\juanalbertogallardogomez.jpeg" style="width:300px;height:290px"
                                            alt="Card image cap">
                                        <h5 class="text-sm-center mt-2 mb-1">Juan Alberto Gallardo Gómez</h5>
                                        <div class="location text-sm-center"><i class="fa fa-map-marker"></i>
                                            Utrera, España</div>
                                    </div>
                                    <hr>
                                    <div class="card-text text-sm-center">
                                        <a href="https://twitter.com/Juanillo_52" target="_blank"><i class="fa fa-twitter pr-1"></i></a>
                                        <a href="https://es.linkedin.com/in/juan-alberto-gallardo-g%C3%B3mez-521213171" target="_blank"><i class="fa fa-linkedin pr-1"></i></a>
                                        <a href="https://github.com/Juanillo52" target="_blank"><i class="fa fa-github pr-1"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 profile-cards">
                            <div class="card">
                                <div class="card-body">
                                    <div class="mx-auto d-block">
                                        <img class="rounded-circle mx-auto d-block" src="../images/hectorantoniomorenomartin.jpg" style="width:300px;height:290px"
                                            alt="Card image cap">
                                        <h5 class="text-sm-center mt-2 mb-1">Héctor Antonio Moreno Martín</h5>
                                        <div class="location text-sm-center"><i class="fa fa-map-marker"></i>
                                            Dos Hermanas, España</div>
                                    </div>
                                    <hr>
                                    <div class="card-text text-sm-center">
                                        <a href="https://twitter.com/HectorAMM13" target="_blank"><i class="fa fa-twitter pr-1"></i></a>
                                        <a href="https://es.linkedin.com/in/hectormorenomartin" target="_blank"><i class="fa fa-linkedin pr-1"></i></a>
                                        <a href="https://github.com/EichZz" target="_blank"><i class="fa fa-github pr-1"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
               
            </p>
        </article>
    </section>
    
    </h2>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
            $("#divlogin").hide();
            $("#divforgotpass").hide();
                        
            $("#signup").click(function(){
                window.location.href = "register.php";

            });

            $("#login").click(function () {
                $("#divforgotpass").hide(500);
                $("#divlogin").slideToggle(500);
            });

            $("#forgotpass").click(function () {
                $("#divforgotpass").slideToggle(500);
            });

        });
    </script>

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

        function validarClave(){
            var expr = /^([0-9]{8})$/;
            var clave = document.getElementById("clave").value;
            return clave !== undefined && expr.test(clave);
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.4/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-match-height@0.7.2/dist/jquery.matchHeight.min.js"></script>
    <script src="../plantilla-boostrap/assets/js/main.js"></script>
    <?php      
        require_once("footer.php"); 
    ?>
</body>

</html>