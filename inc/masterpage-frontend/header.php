<?php
session_start();

if (!isset($_SESSION["userId"])) {
    // TODO: redirect to error page
    header('Location: ./../index.php');
}
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link type="text/css" href="./../resources/bootstrap-4-1-1-dist/css/bootstrap.min.css" rel="stylesheet">

    <!--My CSS-->
    <link type="text/css" href="./../resources/font-awesome-4-7-0/css/font-awesome.min.css" rel="stylesheet">

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script type="text/javascript" src="./../resources/bootstrap-4-1-1-dist/js/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="./../resources/bootstrap-4-1-1-dist/js/bootstrap.bundle.min.js"></script>

    <title>Webware</title>
</head>

<body>
    <!--body container-->
    <div>

        <nav class="navbar navbar-expand-md bg-primary navbar-dark">
            <div class="container">
                <a class="navbar-brand" href="./../frontend/index.php?index">Webware</a>
                <a class="navbar-toggler navbar-toggler-right" type="a" data-toggle="collapse" data-target="#navbar2SupportedContent">
                    <span class="navbar-toggler-icon"></span>
                </a>
                <div class="collapse navbar-collapse text-center justify-content-end" id="navbar2SupportedContent">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link <?php if(isset($_GET['index'])) echo 'active'; ?>" href="./../frontend/index.php?index">
                                <i class="fa fa-file"></i> Ficheiros</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php if(isset($_GET['edit-account'])) echo 'active'; ?>" href="./../frontend/edit-account.php?edit-account">
                                <i class="fa fa-user"></i> Conta</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php if(isset($_GET['contact-us'])) echo 'active'; ?>" href="./../frontend/contact-us.php?contact-us">
                                <i class="fa fa-envelope"></i> Contactos</a>
                        </li>
                    </ul>
                    &nbsp;
                    <a class="btn navbar-btn btn-dark ml-2 text-white" href="./../frontend/signout.php">
                        <i class="fa fa-sign-out"></i> Sair</a>
                </div>
            </div>
        </nav>