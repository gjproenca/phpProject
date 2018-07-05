<?php
session_start();

if (!isset($_SESSION["adminId"])) {
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

<!-- body container -->
<div> 
    
    <nav class="navbar navbar-expand-md bg-primary navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="./../backend/index.php">Webware (backend)</a>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbar2SupportedContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse text-center justify-content-end id="navbar2SupportedContent"">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="./../backend/uploads.php">Ficheiros</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./../backend/messages-frontend.php">Mensagens utilizador</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./../backend/messages-public.php">Mensagens públicas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./../backend/users.php.aspx">Permissões/Ativar utilizadores</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="./../backend/index.php">Dados dos utilizadores</a>
                    </li>
                </ul>
                <a class="btn navbar-btn btn-dark ml-2 text-white" href="./../backend/signout.php">
                    <i class="fa fa-sign-out"></i> Sair</a>
            </div>
        </div>
    </nav>