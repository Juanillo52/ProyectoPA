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
    <?php require_once("header.php"); ?>

    <?php require_once("nav.php"); ?>

    <div class="content">
        <div class="row card">
        <h1 class="card-header">Cuentas</h1>
            <div class="card-body">
                <div class="card">
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Tipo de cuenta</th>
                                    <th>IBAN</th>
                                    <th>Saldo</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Cuenta nómina</td>
                                    <td>ES6621000418401234567891</td>
                                    <td>10000</td>
                                </tr>
                            </tbody>
                        </table>
                        <br/>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Tarjetas</th>
                                    <th>Tipo</th>
                                    <th>Número tarjeta</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td></td>
                                    <td>Crédito</td>
                                    <td>5657 2019 1840 7869</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>Débito</td>
                                    <td>2187 2020 1671 0869</td>
                                </tr>
                            </tbody>
                        </table>
                        <br/>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Plan de pensiones</th>
                                    <th>Estado</th>
                                    <th>Cantidad depositada</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td></td>
                                    <td>Depositando</td>
                                    <td>13573</td>
                                </tr>
                            </tbody>
                        </table>
                        <br/>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Préstamos</th>
                                    <th>Tipo</th>
                                    <th>Crédito</th>
                                    <th>Cantidad pagada</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td></td>
                                    <td>Personal</td>
                                    <td>5000</td>
                                    <td>3270</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@2.2.4/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.4/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-match-height@0.7.2/dist/jquery.matchHeight.min.js"></script>
    <script src="../plantilla-boostrap/assets/js/main.js"></script>
    <?php require_once("footer.php"); ?>
</body>
</html>
