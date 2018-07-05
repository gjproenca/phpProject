<?php
session_start();

unset($_SESSION["adminId"]);
header('Location: ./../frontend/index.php');
