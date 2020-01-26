<?php
session_start();

if(!isset($_SESSION['login']) || !$_SESSION['login']){
    $_SESSION['nologin'] = True;
    header('Location: index.php');
}
if(isset($_POST['logout'])){
    $_SESSION['login'] = False;
    session_destroy();
    header('Location: index.php');
}
?>