<?php
session_start();
?>


<?php
function mostrarFormulario(){
    
    echo '<div class="sufee-login d-flex align-content-center flex-wrap">
    <div class="container">
        <div class="login-content">
            <div class="login-logo">
                <a href="index.html">
                    <img class="align-content" src="../images/logo.png" alt="">
                </a>
            </div>
            <div class="login-form">
                <form method="POST">
                    <div class="form-group">
                        <label>Nombre</label>
                        <input type="text" name="nombre" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Apellidos</label>
                        <input type="text" name="apellidos" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>DNI</label>
                        <input type="text" name="dni" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Fecha de nacimiento</label>
                        <input type="date" name="fecha_nacimiento" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Dirección</label>
                        <input type="text" name="direccion" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Ciudad</label>
                        <input type="text" name="ciudad" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Provincia</label>
                        <input type="text" name="provincia" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Código Postal</label>
                        <input type="text" name="cp" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Correo electrónico</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Teléfono</label>
                        <input type="text" name="telefono" class="form-control" required>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="terminos"> Acepto los <a href="#">términos y condiciones</a>
                        </label>
                    </div>
                    <button type="submit" name="submit" class="btn btn-main btn-flat m-b-30 m-t-30">Registrarme</button>                        
                    <div class="register-link m-t-15 text-center">
                        <p>¿Ya eres de MensaBank?<a href="login.php"> Accede aquí</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>';
}

function comprobarFormulario(){
    $resultado = False; ## le damos este valor para que muestre el login

    if(isset($_POST['submit'])){

            $ok = comprobarDatosFormulario();
            if($ok){
                $resultado = !buscarCliente();
            }         
    }
    return $resultado;
}

function comprobarDatosFormulario(){
    
    if(!isset($_POST['nombre']) || $_POST['nombre'] == ''){$errores[] = "Introduzca el nombre.<br/>";}
    else{$_POST['nombre'] = filter_input(INPUT_POST, "nombre", FILTER_SANITIZE_STRING);} 
    
    if(!isset($_POST['apellidos']) || $_POST['apellidos'] == ''){$errores[] = "Introduzca los apellidos.<br/>";}
    else{$_POST['apellidos'] = filter_input(INPUT_POST, "apellidos", FILTER_SANITIZE_STRING);} 

    if(!isset($_POST['dni']) || $_POST['dni'] == ''){$errores[] = "Introduzca el dni.<br/>";}
    else{$_POST['dni'] = filter_input(INPUT_POST, "dni", FILTER_SANITIZE_STRING);} 

    if(!isset($_POST['fecha_nacimiento']) || $_POST['fecha_nacimiento'] == ''){$errores[] = "Introduzca la fecha de nacimiento.<br/>";}
    else{//arreglar
        $fecha_actual = date("d-m-Y");
        $fecha_mayor_edad = strtotime($fecha_actual . "-18 year");
        
        if($fecha_mayor_edad < $_POST['fecha_nacimiento']){
            $errores[] = "Debes ser mayor de edad para poder registrarte.</br>";
        }
    } 

    if(!isset($_POST['direccion']) || $_POST['direccion'] == ''){$errores[] = "Introduzca la dirección.<br/>";}
    else{$_POST['direccion'] = filter_input(INPUT_POST, "direccion", FILTER_SANITIZE_STRING);} 

    if(!isset($_POST['ciudad']) || $_POST['ciudad'] == ''){$errores[] = "Introduzca la ciudad.<br/>";}
    else{$_POST['ciudad'] = filter_input(INPUT_POST, "ciudad", FILTER_SANITIZE_STRING);} 

    if(!isset($_POST['provincia']) || $_POST['provincia'] == ''){$errores[] = "Introduzca la provincia.<br/>";}
    else{$_POST['provincia'] = filter_input(INPUT_POST, "provincia", FILTER_SANITIZE_STRING);} 

    if(!isset($_POST['cp']) || $_POST['cp'] == ''){$errores[] = "Introduzca el código postal.<br/>";}
    else{$_POST['cp'] = filter_input(INPUT_POST, "cp", FILTER_SANITIZE_STRING);}
    
    if(!isset($_POST['email']) || $_POST['email'] == ''){$errores[] = "Introduzca el email.<br/>";}
    else{$_POST['email'] = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);} 
    
    if(!isset($_POST['telefono']) || $_POST['telefono'] == ''){$errores[] = "Introduzca el teléfono.<br/>";}
    else{$_POST['telefono'] = filter_input(INPUT_POST, "telefono", FILTER_SANITIZE_STRING);}

    if(!isset($_POST['terminos'])){$errores[] = "Acepte los términos y condiciones.<br/>";}
    
    if(!isset($errores)){
        return True;
    }else {
        foreach($errores as $e) echo $e;
        return False;
    }
}
function buscarCliente(){
    $enc = False;
    $dni = $_POST['dni'];
    $email = $_POST['email'];

    $con = mysqli_connect("localhost","root","");

    if (!$con){
        die(' No puedo conectar: ' . mysqli_error($con));
    }

    $db_selected = mysqli_select_db($con,"mensabank");

    if (!$db_selected){
        die ('No puedo usar la base de datos: ' . mysqli_error($con));
    }

    $resQuery = mysqli_query($con, "SELECT dni FROM cliente where dni = '$dni'");
    if (!$resQuery) {
        die ("Error al ejecutar la consulta: " . mysqli_error($con));
    }else{
        $data = mysqli_fetch_array($resQuery);
        if(isset($data['dni'])){
            echo "El DNI introducido ya está siendo usado.<br/>";
            $enc = True;
        }
    }

    $resQuery = mysqli_query($con, "SELECT email FROM cliente where email ='$email'");
    if (!$resQuery) {
        die ("Error al ejecutar la consulta: " . mysqli_error($con));
    }else{
        $data = mysqli_fetch_array($resQuery);

        if(isset($data['email'])){
            echo "El email introducido ya está siendo usado.<br/>";
            $enc = True;
        }
    }
    mysqli_close($con);
    
    return $enc;
}

function crearPassword(){
    $password = "";

    $longitudPass=8;

    for($i=1 ; $i<=$longitudPass ; $i++){
        $digito=rand(0,9);
        $password .= $digito;
    }

    enviarEmail($password);
    return password_hash($password, PASSWORD_DEFAULT);
}

function altaCliente(){
    $resultado = False;
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $dni = $_POST['dni'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];
    $ciudad = $_POST['ciudad'];
    $provincia =  $_POST['provincia'];
    $cp =  $_POST['cp'];
    $password = crearPassword();
    $clave =  substr(microtime(), 1, 8);

    $con = mysqli_connect("localhost","root","");

    if (!$con){
        die(' No puedo conectar: ' . mysqli_error($con));
    }

    $db_selected = mysqli_select_db($con,"mensabank");

    if (!$db_selected){
        die ('No puedo usar la base de datos: ' . mysqli_error($con));
    }

    $resQuery = mysqli_query($con, "INSERT INTO cliente (nombre, apellidos, dni, direccion, telefono, fecha_nacimiento, email, clave, ciudad, provincia, cp) 
    VALUES ('$nombre','$apellidos','$dni','$direccion','$telefono','$fecha_nacimiento', '$email','$clave', '$ciudad', '$provincia', '$cp')");
    if (!$resQuery) {
        die ("Error al ejecutar la consulta: " . mysqli_error($con));
    }else{
        $rows_affected = mysqli_affected_rows($resQuery);

        if($rows_affected == 1){
            $resultado = True;
        }
    }
    mysqli_close($con);
    
    return $resultado;
}
function enviarEmail($password){
    //ENVIAR EMAIL
}
function redireccionar(){
    $_SESSION["register"] = "Se ha registrado correctamente. La contraseña será enviada a su correo en breves momentos.";
    header("Location: login.php");
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

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>

    <style>
        .site-footer{
            padding-right: 13px;
            padding-left: 13px;
        }
    </style>
</head>
<body class="bg-color">

    <?php 
    $ok = comprobarFormulario();
    if(!$ok){
        mostrarFormulario();
    }else{
        altaCliente();
        redireccionar();
    }
    require_once("footer.php");
    ?>

    <script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.4/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-match-height@0.7.2/dist/jquery.matchHeight.min.js"></script>
    <script src="../plantilla-boostrap/assets/js/main.js"></script>

</body>
</html>
