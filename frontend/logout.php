<?php
session_start();

unset($_SESSION["userId"]);
header('Location: ./../frontend/index.php');
