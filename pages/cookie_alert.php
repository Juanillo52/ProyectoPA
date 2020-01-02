<?php 
if(!isset($_COOKIE['not-first-time'])){
        echo '<div class="sufee-alert alert with-close alert-primary alert-dismissible fade show cookie-alert">
        <span>Utilizamos cookies propias para mejorar la experiencia del usuario a través de su navegación. Si continúas navegando aceptas su uso.
        <a href="policy.php">Política de nuestra web</a></span>
        <button type="button" class="close" data-dismiss="alert" aria-label="Entendido">
            <span aria-hidden="true">&times;</span>
        </button>
        </div>';
        setcookie('not-first-time','True',time()+365*24*3600);
    }
?>