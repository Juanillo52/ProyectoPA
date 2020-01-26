<?php
    session_start();
    require_once("cookie_alert.php");
?>


<?php
function mostrarFormulario(){
    echo '<div class="sufee-login d-flex align-content-center flex-wrap">
    <div class="container">
        <div class="login-content">
            <div class="login-logo">
                <a href="index.php">
                    <img class="align-content" src="../images/logo.png" alt="">
                </a>
            </div>
            <div class="login-form">
                <form method="POST" onsubmit="return validar()">
                    <div class="form-group col-lg-6">
                        <label id="labelNombre">Nombre  </label>
                        <input type="text" name="nombre" id="nombre"'; 
                        
                        if(isset($_POST['nombre'])){
                            echo 'value="' . $_POST['nombre'] .'"';
                        }
                        
                        echo 'class="form-control" required />
                    </div>

                    <div class="form-group col-lg-6">
                        <label id="labelApellidos">Apellidos    </label>
                        <input type="text" name="apellidos" id="apellidos"'; 
                        
                        if(isset($_POST['apellidos'])){
                            echo 'value="' . $_POST['apellidos'] .'"';
                        }

                        echo 'class="form-control" required />
                    </div>
                    <div class="form-group col-lg-6">
                        <label id="labelDNI">DNI    </label>
                        <input type="text" name="dni" id="dni"';
                        
                        if(isset($_POST['dni'])){
                            echo 'value="' . $_POST['dni'] .'"';
                        }

                        echo 'class="form-control" required />
                    </div>
                    <div class="form-group col-lg-6">
                        <label id="labelFecha">Fecha de nacimiento  </label>
                        <input type="date" name="fecha_nacimiento" id="fecha"';
                        
                        if(isset($_POST['fecha_nacimiento'])){
                            echo 'value="' . $_POST['fecha_nacimiento'] .'"';
                        }
                        
                        echo 'class="form-control" required />
                    </div>

                    
                    <div class="form-group col-lg-12">
                        <label id="labelEmail">Correo electrónico   </label>
                        <input type="email" name="email" id="email"'; 
                        
                        if(isset($_POST['email'])){
                            echo 'value="' . $_POST['email'] .'"';
                        }
                        
                        echo 'class="form-control" required>
                    </div>
                    <div class="form-group col-lg-12">
                        <label id="labelTelefono">Teléfono  </label>
                        <input type="text" name="telefono" id="telefono"'; 
                        
                        if(isset($_POST['telefono'])){
                            echo 'value="' . $_POST['telefono'] .'"';
                        }

                        echo 'class="form-control" required>
                    </div>
                    <div class="form-group col-lg-12">
                    <label id="labelDireccion">Dirección    </label>
                    <input type="text" name="direccion" id="direccion"'; 
                    
                    if(isset($_POST['direccion'])){
                        echo 'value="' . $_POST['direccion'] .'"';
                    }

                    echo 'class="form-control" required />
                </div>

                <div class="form-group col-lg-4">
                    <label id="labelCiudad">Ciudad  </label>
                    <input type="text" name="ciudad" id="ciudad"'; 
                    
                    if(isset($_POST['ciudad'])){
                        echo 'value="' . $_POST['ciudad'] .'"';
                    }
                    
                    echo'class="form-control" required>
                </div>
                <div class="form-group col-lg-4">
                    <label id="labelProvincia">Provincia    </label>
                    <input type="text" name="provincia" id="provincia"'; 
                    
                    if(isset($_POST['provincia'])){
                        echo 'value="' . $_POST['provincia'] .'"';
                    }
                    
                    echo 'class="form-control" required>
                </div>
                <div class="form-group col-lg-4">
                    <label id="labelPostal">Código Postal   </label>
                    <input type="text" name="cp" id="postal"'; 
                    
                    if(isset($_POST['cp'])){
                        echo 'value="' . $_POST['cp'] .'"';
                    }
                    
                    echo 'class="form-control" required>
                </div>

                    <div class="checkbox col-lg-12">
                        <label id="labelTerminos">  
                            <input type="checkbox" name="terminos" id="terminos"> Acepto los <a href="policy.php" target="_blank">términos y condiciones</a>
                        </label>
                    </div>
                    <div class="col-lg-12"> 
                        <button type="submit" name="submit" class="btn btn-main btn-flat m-b-30 m-t-30">Registrarme</button> 
                    </div>
                                           
                    <div class="register-link m-t-15 text-center">
                        <p>¿Ya eres de MensaBank?<a href="index.php"> Accede aquí</a></p>
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
    $resultado = False;

    if(!isset($_POST['nombre']) || $_POST['nombre'] == ''){$errores[] = "Introduzca el nombre.<br/>";}
    else{$_POST['nombre'] = filter_input(INPUT_POST, "nombre", FILTER_SANITIZE_STRING);} 
    
    if(!isset($_POST['apellidos']) || $_POST['apellidos'] == ''){$errores[] = "Introduzca los apellidos.<br/>";}
    else{$_POST['apellidos'] = filter_input(INPUT_POST, "apellidos", FILTER_SANITIZE_STRING);} 

    if(!isset($_POST['dni']) || $_POST['dni'] == '' || !preg_match('/^([0-9]{8})([A-Z])$/', $_POST['dni'])){
        $errores[] = "Introduzca un DNI válido.<br/>";}
    else{$_POST['dni'] = filter_input(INPUT_POST, "dni", FILTER_SANITIZE_STRING);} 

    if(!isset($_POST['fecha_nacimiento']) || $_POST['fecha_nacimiento'] == ''){$errores[] = "Introduzca la fecha de nacimiento.<br/>";}
    else{
        $fecha_actual = date("d-m-Y");
        $fecha_mayor_edad = strtotime($fecha_actual . "-216 months");
        $menor = $fecha_mayor_edad < strtotime($_POST['fecha_nacimiento']);
        if($menor){
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
    
    if(!isset($_POST['email']) || $_POST['email'] == ''|| !filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL)){
        $errores[] = "Introduzca un email válido.<br/>";}
    else{$_POST['email'] = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);}
    
    if(!isset($_POST['telefono']) || $_POST['telefono'] == ''|| !preg_match('/^([0-9]{9})$/', $_POST['telefono']) ){$errores[] = "Introduzca un teléfono válido.<br/>";}
    else{$_POST['telefono'] = filter_input(INPUT_POST, "telefono", FILTER_SANITIZE_STRING);}

    if(!isset($_POST['terminos'])){$errores[] = "Acepte los términos y condiciones.<br/>";}
    
    if(!isset($errores)){
        $resultado = True;
    }

    return $resultado;
}
function buscarCliente(){
    $enc = False;
    $dni = $_POST['dni'];
    $email = $_POST['email'];

    $con = mysqli_connect("localhost","root","Pistacho99!");

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
            echo '<div class="sufee-alert alert with-close alert-danger alert-dismissible fade show alert">
                            <span> El DNI introducido ya está siendo utilizado. </span>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Entendido">
                                <span aria-hidden="true">&times;</span>
                            </button>
                           </div>';
            $enc = True;
        }
    }

    $resQuery = mysqli_query($con, "SELECT email FROM cliente where email ='$email'");
    if (!$resQuery) {
        die ("Error al ejecutar la consulta: " . mysqli_error($con));
    }else{
        $data = mysqli_fetch_array($resQuery);

        if(isset($data['email'])){
            echo '<div class="sufee-alert alert with-close alert-danger alert-dismissible fade show alert">
                            <span> El email introducido ya está siendo utilizado. </span>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Entendido">
                                <span aria-hidden="true">&times;</span>
                            </button>
                           </div>';
            $enc = True;
        }
    }
    mysqli_close($con);
    
    return $enc;
}

function crearPassword(){
    
    $password= "";
    
    for($i =0 ; $i < 8 ; $i++){
        $password.= rand(0,9);
    }
    enviarEmail($password);

    $password = password_hash($password, PASSWORD_DEFAULT);
    return $password;
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
    $clave = crearPassword();

    $con = mysqli_connect("68.183.69.142:3306","root","Pistacho99!");

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
    ini_set( 'display_errors', 1 );
    error_reporting( E_ALL );
    $from = "infomensabank@gmail.com";
    $to = $_POST['email'];
    $subject = "[noreply] Verifica tu cuenta";
    $message = "Hola, " . $_POST['nombre'] . ", bienvenido a MensaBank:
                La clave de acceso con la que deberá loguearse es: " . $password . "
                Ya puede disfrutar de todos nuestros servicios con total libertad. 
                Un saludo,
                El equipo de soporte de MensaBank.";
    $headers = "From:" . $from;
    mail($to,$subject,$message, $headers);
}

function redireccionar(){
    $_SESSION["register"] = "Se ha registrado correctamente. La clave de acceso será enviada a su correo en breves momentos.";
    header("Location: index.php");
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

<script>
        function validar(){
            var salida = true;

            if(!validarNombre()){
                var spanNombre = document.createElement('span');
                spanNombre.setAttribute("id", "spanNombre");

                if(document.getElementById("spanNombre")){
                    var padre = document.getElementById("spanNombre").parentNode;
                    padre.removeChild(document.getElementById("spanNombre"));
                }

                var txt1 = document.createTextNode('(Nombre no válido)');
                spanNombre.style.color = "red";
                spanNombre.appendChild(txt1);
                document.getElementById("labelNombre").appendChild(spanNombre);
                document.getElementById("nombre").style.borderColor = "red";
                salida = false;
            }else{
                if(document.getElementById("spanNombre")){
                    var padre = document.getElementById("spanNombre").parentNode;
                    padre.removeChild(document.getElementById("spanNombre"));
                    document.getElementById("nombre").style.borderColor = "";
                }
            }

            if(!validarApellidos()){
                var spanApellidos = document.createElement('span');
                spanApellidos.setAttribute("id", "spanApellidos");

                if(document.getElementById("spanApellidos")){
                    var padre = document.getElementById("spanApellidos").parentNode;
                    padre.removeChild(document.getElementById("spanApellidos"));
                }

                var txt1 = document.createTextNode('(Apellidos no válidos)');
                spanApellidos.style.color = "red";
                spanApellidos.appendChild(txt1);
                document.getElementById("labelApellidos").appendChild(spanApellidos);
                document.getElementById("apellidos").style.borderColor = "red";
                salida = false;
            }else{
                if(document.getElementById("spanApellidos")){
                    var padre = document.getElementById("spanApellidos").parentNode;
                    padre.removeChild(document.getElementById("spanApellidos"));
                    document.getElementById("apellidos").style.borderColor = "";
                }
            }

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

            if(!validarFecha()){
                var spanFecha = document.createElement('span');
                spanFecha.setAttribute("id", "spanFecha");

                if(document.getElementById("spanFecha")){
                    var padre = document.getElementById("spanFecha").parentNode;
                    padre.removeChild(document.getElementById("spanFecha"));
                }

                var txt1 = document.createTextNode('(Fecha no válida)');
                spanFecha.style.color = "red";
                spanFecha.appendChild(txt1);
                document.getElementById("labelFecha").appendChild(spanFecha);
                document.getElementById("fecha").style.borderColor = "red";
                salida = false;
            }else{
                if(document.getElementById("spanFecha")){
                    var padre = document.getElementById("spanFecha").parentNode;
                    padre.removeChild(document.getElementById("spanFecha"));
                    document.getElementById("fecha").style.borderColor = "";
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

            if(!validarTelefono()){
                var spanTelefono = document.createElement('span');
                spanTelefono.setAttribute("id", "spanTelefono");

                if(document.getElementById("spanTelefono")){
                    var padre = document.getElementById("spanTelefono").parentNode;
                    padre.removeChild(document.getElementById("spanTelefono"));
                }

                var txt1 = document.createTextNode('(Telefono no válido)');
                spanTelefono.style.color = "red";
                spanTelefono.appendChild(txt1);
                document.getElementById("labelTelefono").appendChild(spanTelefono);
                document.getElementById("telefono").style.borderColor = "red";
                salida = false;
            }else{
                if(document.getElementById("spanTelefono")){
                    var padre = document.getElementById("spanTelefono").parentNode;
                    padre.removeChild(document.getElementById("spanTelefono"));
                    document.getElementById("telefono").style.borderColor = "";
                }
            }

            if(!validarDireccion()){
                var spanDireccion = document.createElement('span');
                spanDireccion.setAttribute("id", "spanDireccion");

                if(document.getElementById("spanDireccion")){
                    var padre = document.getElementById("spanDireccion").parentNode;
                    padre.removeChild(document.getElementById("spanDireccion"));
                }

                var txt1 = document.createTextNode('(Direccion no válida)');
                spanDireccion.style.color = "red";
                spanDireccion.appendChild(txt1);
                document.getElementById("labelDireccion").appendChild(spanDireccion);
                document.getElementById("direccion").style.borderColor = "red";
                salida = false;
            }else{
                if(document.getElementById("spanDireccion")){
                    var padre = document.getElementById("spanDireccion").parentNode;
                    padre.removeChild(document.getElementById("spanDireccion"));
                    document.getElementById("direccion").style.borderColor = "";
                }
            }

            if(!validarCiudad()){
                var spanCiudad = document.createElement('span');
                spanCiudad.setAttribute("id", "spanCiudad");

                if(document.getElementById("spanCiudad")){
                    var padre = document.getElementById("spanCiudad").parentNode;
                    padre.removeChild(document.getElementById("spanCiudad"));
                }

                var txt1 = document.createTextNode('(Ciudad no válido)');
                spanCiudad.style.color = "red";
                spanCiudad.appendChild(txt1);
                document.getElementById("labelCiudad").appendChild(spanCiudad);
                document.getElementById("ciudad").style.borderColor = "red";
                salida = false;
            }else{
                if(document.getElementById("spanCiudad")){
                    var padre = document.getElementById("spanCiudad").parentNode;
                    padre.removeChild(document.getElementById("spanCiudad"));
                    document.getElementById("ciudad").style.borderColor = "";
                }
            }

            if(!validarProvincia()){
                var spanProvincia = document.createElement('span');
                spanProvincia.setAttribute("id", "spanProvincia");

                if(document.getElementById("spanProvincia")){
                    var padre = document.getElementById("spanProvincia").parentNode;
                    padre.removeChild(document.getElementById("spanProvincia"));
                }

                var txt1 = document.createTextNode('(Provincia no válido)');
                spanProvincia.style.color = "red";
                spanProvincia.appendChild(txt1);
                document.getElementById("labelProvincia").appendChild(spanProvincia);
                document.getElementById("provincia").style.borderColor = "red";
                salida = false;
            }else{
                if(document.getElementById("spanProvincia")){
                    var padre = document.getElementById("spanProvincia").parentNode;
                    padre.removeChild(document.getElementById("spanProvincia"));
                    document.getElementById("provincia").style.borderColor = "";
                }
            }

            if(!validarPostal()){
                var spanPostal = document.createElement('span');
                spanPostal.setAttribute("id", "spanPostal");

                if(document.getElementById("spanPostal")){
                    var padre = document.getElementById("spanPostal").parentNode;
                    padre.removeChild(document.getElementById("spanPostal"));
                }

                var txt1 = document.createTextNode('(Código postal no válido)');
                spanPostal.style.color = "red";
                spanPostal.appendChild(txt1);
                document.getElementById("labelPostal").appendChild(spanPostal);
                document.getElementById("postal").style.borderColor = "red";
                salida = false;
            }else{
                if(document.getElementById("spanPostal")){
                    var padre = document.getElementById("spanPostal").parentNode;
                    padre.removeChild(document.getElementById("spanPostal"));
                    document.getElementById("postal").style.borderColor = "";
                }
            }

            if(!validarTerminos()){
                var spanTerminos = document.createElement('span');
                spanTerminos.setAttribute("id", "spanTerminos");

                if(document.getElementById("spanTerminos")){
                    var padre = document.getElementById("spanTerminos").parentNode;
                    padre.removeChild(document.getElementById("spanTerminos"));
                }

                var txt1 = document.createTextNode('(Terminos no válido)');
                spanTerminos.style.color = "red";
                spanTerminos.appendChild(txt1);
                document.getElementById("labelTerminos").appendChild(spanTerminos);
                document.getElementById("terminos").style.borderColor = "red";
                salida = false;
            }else{
                if(document.getElementById("spanTerminos")){
                    var padre = document.getElementById("spanTerminos").parentNode;
                    padre.removeChild(document.getElementById("spanTerminos"));
                    document.getElementById("terminos").style.borderColor = "";
                }
            }

            return salida;
        }

        function validarNombre(){
            var expr = /^([A-Za-zñ\s]+)$/;
            var nombre = document.getElementById("nombre").value;
            return nombre !== undefined && expr.test(nombre);
        }

        function validarApellidos(){
            var expr = /^([A-Za-zñ\s]+)$/;
            var apellidos = document.getElementById("apellidos").value;
            return apellidos !== undefined && expr.test(apellidos);
        }

        function validarDNI(){
            var expr = /^([0-9]{8})([A-Z])$/;
            var dni = document.getElementById("dni").value;
            return dni !== undefined && expr.test(dni);
        }

        function validarFecha(){
            var fecha = document.getElementById("fecha").value;
            return fecha !== undefined;
        }

        function validarEmail(){
            var expr = /^[^@]+@[^@]+\.[a-zA-Z]{2,}$/;
            var email = document.getElementById("email").value;
            return email !== undefined && expr.test(email);
        }

        function validarTelefono(){
            var expr = /^([0-9]{9})$/;
            var telefono = document.getElementById("telefono").value;
            return telefono !== undefined && expr.test(telefono);
        }

        function validarDireccion(){
            var expr = /^([A-Za-zñ\s0-9]+)$/;
            var direccion = document.getElementById("direccion").value;
            return direccion !== undefined && expr.test(direccion);
        }

        function validarCiudad(){
            var expr = /^([A-Za-zñ\s]+)$/;
            var ciudad = document.getElementById("ciudad").value;
            return ciudad !== undefined && expr.test(ciudad);
        }

        function validarProvincia(){
            var expr = /^([A-Za-zñ\s]+)$/;
            var provincia = document.getElementById("provincia").value;
            return provincia !== undefined && expr.test(provincia);
        }

        function validarPostal(){
            var expr = /^([0-9]{5})$/;
            var postal = document.getElementById("postal").value;
            return postal !== undefined && expr.test(postal);
        }

        function validarTerminos(){
            if(document.getElementById("terminos").checked){
                return true;
            }else{
                return false;
            }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.4/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-match-height@0.7.2/dist/jquery.matchHeight.min.js"></script>
    <script src="../plantilla-boostrap/assets/js/main.js"></script>

</body>
</html>
