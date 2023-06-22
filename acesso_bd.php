<?php
    session_start();
    include_once('config.php');
    if (!isset($_SESSION['Email']) || $_SESSION['admin'] != 1) {
        header('Location: home.php');
        exit();
    }

    $logado = $_SESSION['Email'];

    if (isset($_POST['submit'])) {
        include_once('config.php');
        $senhaInformada = $_POST['senha'];
        $senhaCorreta = '123456';


        if ($senhaInformada === $senhaCorreta) {
            $_SESSION['senha'] = $senhaInformada;
            header('Location: banco_de_dados.php');
            exit();
        } else {
            $errorMessage = "Senha incorreta. Tente novamente.";
        }
    } else {
        $errorMessage = "Por favor, preencha a senha.";
    }
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acesso ao Banco de Dados</title>
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
            border: 3px solid rgb(220, 110, 20);
        }

        h1 {
            border: 0.5px solid rgb(14, 138, 196);
            padding: 10px;
            text-align: center;
            background-color: rgb(14, 138, 196);
            border-radius: 10px;
            font-weight: bold;
            font-size: 20px;
        }

        form {
            text-align: center;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }

        input[type="password"] {
            padding: 8px 10px;
            font-size: 16px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }

        button[type="submit"] {
            padding: 10px 20px;
            font-size: 18px;
            border: none;
            border-radius: 4px;
            background-image: linear-gradient(to right, rgb(220, 110, 20), rgb(14, 138, 196));
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        a {
            text-decoration: none;
            color: white;
            font-size: 15px;
            opacity: 0.7;
            position: absolute;
            top: 10px;
            left: 10px;
        }

        a:hover {
            opacity: 1;
        }

        button[type="submit"]:hover {
            background-image: linear-gradient(to right, rgb(189, 92, 12), rgb(11, 110, 156));
        }

        .error-message {
            color: #f44336;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="home.php">Voltar</a>
        <?php if (isset($errorMessage)) { ?>
            <p class="error-message"><?php echo $errorMessage; ?></p>
        <?php } ?>
        <img src="tecnocon.png" class="logo">
        <h1>Acesso ao Banco de Dados</h1>
        <form method="POST" action="">
            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" required>
            <button type="submit" name="submit">Acessar Banco de Dados</button>
        </form>
    </div>
</body>
</html>