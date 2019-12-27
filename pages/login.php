<?php
    session_start();
    if(isset($_SESSION['register'])){
        //mostrar mensaje
    }
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
                    <div class="form-group">';
                    echo '<label>DNI</label>';
                    if(isset($_POST['dni'])){
                       echo'<input type="text" name="dni" value="'. $_POST['dni']. '" class="form-control">';
                    }else{
                       echo '<input type="text" name="dni" class="form-control">';
                    }
                    echo'</div>
                    <div class="form-group">
                        <label>Clave de acceso</label>
                        <input type="password" name="password" class="form-control">
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
            </div>
        </div>
        <div id="divforgotpass">
            <div class="login-content">
                <div class="login-form">
                    <form>
                        <div class="form-group">
                        <label>DNI</label>
                        <input type="text" name="dni" class="form-control"></div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="password" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-main btn-flat m-b-30 m-t-30">Recuperar clave</button>
                    </form>
                </div>
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
                $resultado = verificarLogin();
                if(!$resultado){
                    echo "Clave incorrecta.<br>";
                }
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
        foreach($errores as $e) echo $e;
        return False;
    }
}

function verificarLogin(){
    $resultado = False;
    $dni = $_POST['dni'];
    $password = $_POST['password'];

    $con = mysqli_connect("localhost","root","");

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
    $con = mysqli_connect("localhost","root","");

    if (!$con){
        die(' No puedo conectar: ' . mysqli_error($con));
    }

    $db_selected = mysqli_select_db($con,"mensabank");

    if (!$db_selected){
        die ('No puedo usar la base de datos: ' . mysqli_error($con));
    }

    $resQuery = mysqli_query($con, "SELECT nombre from cliente WHERE dni = '$dni'");
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
    $_SESSION['login']=True;
    $_SESSION['user'] = getUser($_POST['dni']);
    $_SESSION['dni'] = $_POST['dni'];
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
        html {
            min-height: 100%;
            position: relative;
        }

        body {
            margin: 0;
            margin-bottom: 40px;
        }

        footer {
            height: 40px;
        }

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
            redireccionar();
            header('Location: dashboard.php');
        }
        
        require_once("footer.php");
    ?>
    
    <script>
        $(document).ready(function () {
            $("#divforgotpass").hide();

            $("#forgotpass").click(function () {
                $("#divforgotpass").slideToggle(500);
            });

        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.4/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-match-height@0.7.2/dist/jquery.matchHeight.min.js"></script>
    <script src="../plantilla-boostrap/assets/js/main.js"></script>

</body>
</html>
