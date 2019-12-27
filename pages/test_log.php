<?php
session_start();

if(!isset($_SESSION['login']) || !$_SESSION['login']){
    header('Location: login.php');
}
if(isset($_POST['logout'])){
    session_destroy();
    header('Location: login.php');
}
?>