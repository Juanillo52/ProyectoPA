<header id="header" class="header" style="padding-left: 4px">
    <div class="top-left">
        <div class="navbar-header">                                  
            <a id="menuToggle" class="menutoggle"><i class="fa fa-bars"></i></a>
             
        </div>
    </div>
    <div class="top-right">
        <div class="header-menu">
        <a class="navbar-brand ajustado" href="dashboard.php"><img class="logo" src="../images/logo.png" alt="Logo"></a>
            <div class="header-left">
                <span>Te damos la bienvenida, <?php echo $_SESSION['user']; ?></span>
                <div class="logout"> 
                <form method="POST">
                    <input type="submit" id="logout" name="logout" value="Salir">
                </form>
                </div>
            </div>
        </div>
    </div>
</header>