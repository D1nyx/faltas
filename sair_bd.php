<?php
    session_start();
    unset($_SESSION['senha']);
    header('Location: home.php');
?>