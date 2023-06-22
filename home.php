<?php
    session_start();
    include_once('config.php');
    if (!isset($_SESSION['Email']) || !isset($_SESSION['Password'])) {
        header('Location: tela_de_login.php');
        exit();
    }

    $logado = $_SESSION['Email'];

    if (!$conexao) {
        die('Erro ao conectar ao banco de dados: ' . mysqli_connect_error());
    }

    $admin = 0;
    $query = "SELECT admin FROM trabalhador WHERE email = '$logado'";
    $result = mysqli_query($conexao, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);

        if ($row) {
            $admin = $row['admin'];
            $_SESSION['admin'] = $admin;
        }
    }

    mysqli_close($conexao);

?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marcação de Férias</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-image: linear-gradient(to right, rgb(220, 110, 20), rgb(14, 138, 196));
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            padding: 0;                                        
        }
        
        .container {
            color: white;
            background-color: rgba(0, 0, 0, 0.6);
            padding: 30px;
            border-radius: 15px;
            width: 30%;
            text-align: center;
        }

        h1 {
            font-size: 28px;
            font-weight: bold;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid rgb(14, 138, 196);
        }

        .logo {
            max-width: 100%;
            height: auto;
            margin-top: 30px;
        }

        .box {
            margin-top: 30px;
        }

        a {
            display: inline-block;
            text-decoration: none;
            color: white;
            background-image: linear-gradient(to right, rgb(220, 110, 20), rgb(14, 138, 196));
            border: 2px solid linear-gradient(to right, rgb(220, 110, 20), rgb(14, 138, 196));
            border-radius: 10px;
            padding: 12px 24px;
            margin: 10px;
            font-size: 18px;
            transition: background-color 0.3s ease;
        }

        a:hover {
            background-image: linear-gradient(to right, rgb(189, 92, 12), rgb(11, 110, 156)); 
        }

        .logout-button {
            display: inline-block;
            color: white;
            font-size: 15px;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
            background-color: #f44336;
            position: absolute; 
            top: 10px; 
            right: 10px; 
        }

        .logout-button:hover {
            background-color: #d32f2f;
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="tecnocon.png" class="logo" alt="Logo">
        <a href="sair.php" class="logout-button">Sair</a>
        <h1>HOME</h1>
        <?php          
            if ($_SESSION['Email'] === $logado && $_SESSION['admin'] == 1) {
                echo '<a href="acesso_bd.php">Banco de Dados</a>';
            }
            echo '<a href="ver_ferias.php">Ver férias</a>';
            echo '<a href="ferias_marcacao.php">Marcação de férias</a>';
            echo '<a href="pdf.php">Download</a>';
        ?>
    </div>
</body>
</html>
