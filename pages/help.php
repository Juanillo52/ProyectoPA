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
                        <label>Asunto de su duda</label>
                        <input type="text" name="subject" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>¿En qué le podemos ayudar?</label>
                        <textarea type="text" name="help" class="form-control" required></textarea>
                    </div>
                    <div class="form-group">
                        <label>Correo electrónico</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <button type="submit" name="submit" class="btn btn-main btn-flat m-b-30 m-t-30">Enviar</button>                        
                    <div class="register-link m-t-15 text-center">
                        <p>¿Eres de MensaBank?<a href="login.php"> Accede aquí</a></p>
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
    }
    return $resultado;
}

function comprobarDatosFormulario(){
    
    if(!isset($_POST['subject']) || $_POST['subject'] == ''){$errores[] = "Introduzca el asunto.<br/>";}
    else{$_POST['subject'] = filter_input(INPUT_POST, "subject", FILTER_SANITIZE_STRING);} 
    
    if(!isset($_POST['help']) || $_POST['help'] == ''){$errores[] = "Introduzca un mensaje explicando su problema.<br/>";}
    else{$_POST['help'] = filter_input(INPUT_POST, "help", FILTER_SANITIZE_STRING);} 
    
    if(!isset($_POST['email']) || $_POST['email'] == ''){$errores[] = "Introduzca el email.<br/>";}
    else{$_POST['email'] = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);} 
    
    if(!isset($errores)){
        return True;
    }else {
        foreach($errores as $e) echo $e;
        return False;
    }
}

function enviarEmail(){
    ini_set( 'display_errors', 1 );
    error_reporting( E_ALL );
    $from = $_POST['email'];
    $to = "jagalgom@alu.upo.es";
    $subject = $_POST['subject'];
    $message = $_POST['help'];
    $headers = "From:" . $from;
    mail($to,$subject,$message, $headers);
    echo "The email message was sent.";
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
</head>
<body class="bg-color">

    <?php 
    $ok = comprobarFormulario();
    if(!$ok){
        mostrarFormulario();
    }else{
        enviarEmail();
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
