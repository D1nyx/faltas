<?php
    session_start();
    unset($_SESSION['Email']);
    unset($_SESSION['Password']);
    header('Location: login_cadastro.php');
?>