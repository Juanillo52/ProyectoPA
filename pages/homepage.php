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
        <link type="text/css" rel="stylesheet" href="../plantilla-boostrap/assets/css/style.css">
    </head>
    <body>
        <header id="header" class="header">
            <div class="top-right">
                <button class="btn btn-primary btn-lg" type="button" id="login">Login</button>
                <button class="btn btn-secondary btn-lg" type="button" id="signin">Registro</button>
            </div>
            <div class="top-left">
                <img src="../images/logo.png" alt="Logo de Mensabank">
            </div>
        </header>

        <h1>Bienvenido a Mensabank</h1>

        <h2>¿Qué es Mensabank?</h2>
        <p>
            Mensabank es un banco online destinado a las personas. <br/> 
            Nuestra plataforma le permitirá gestionar su dinero de manera fácil, rápida e intuitiva.
            Sin necesidad de tanto papeleo como en un banco tradicional, solo necesitará registrarse y ya podrá acceder a todos nuestros servicios.
        </p>

        <h2>Nuestros servicios</h2>

        <h3>Cuentas</h3>

        <h3>Tarjetas</h3>

        <h3>Transferencias</h3>

        <h3>Préstamos</h3>

        <h3>Plan de Pensiones</h3>

        <h2>¿Quíenes somos?</h2>

        <?php require("footer.php"); ?>
    </body>
</html>
