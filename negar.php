<?php
session_start();
if (isset($_GET['email'])) {
    $email = $_GET['email'];
    $cookieName = 'ferias_aprovadas_' . md5($email);
    setcookie($cookieName, '', time() - 3600, '/');
}

if (!isset($_SESSION['senha']) || empty($_SESSION['senha'])) {
    header('Location: banco_de_dados.php');
    exit();
}

$logado = $_SESSION['senha'];

include_once('config.php');

if (isset($_GET['email']) && !empty($_GET['email'])) {
    $email = trim($_GET['email']);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);

    if ($email) {
        $sql = "SELECT * FROM trabalhador WHERE email = '$email'";
        $result = $conexao->query($sql);

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();

            $updateSql = "UPDATE trabalhador SET inicio_ferias = NULL, fim_ferias = NULL, duracao = NULL WHERE email = '$email'";
            $deleteResult = $conexao->query($updateSql);

            if ($deleteResult) {
                echo "
                <!DOCTYPE html>
                <html lang='pt'>
                <head>
                    <meta charset='UTF-8'>
                    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
                    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                    <title>Negação / Eliminação realizada com sucesso</title>
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                            background-color: #f2f2f2;
                            display: flex;
                            justify-content: center;
                            align-items: center;
                            height: 100vh;
                            margin: 0;
                            padding: 0;
                        }

                        .container {
                            text-align: center;
                            padding: 40px;
                            background-color: #fff;
                            border-radius: 8px;
                            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
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

                        .logo {
                            max-width: 200px;
                            margin-bottom: 20px;
                        }

                        h1 {
                            color: #333;
                            font-size: 28px;
                            margin-bottom: 10px;
                        }

                        p {
                            color: #666;
                            font-size: 16px;
                            margin-bottom: 20px;
                        }

                        a {
                            text-decoration: none;
                            color: #333;
                            font-weight: bold;
                        }

                        a:hover {
                            color: #555;
                        }
                    </style>
                </head>
                <body>
                    <div class='container'>
                        <img src='tecnocon.png' class='logo' alt='Logo'>
                        <h1>Férias negadas / eliminadas com sucesso!</h1>
                        <p><a href='banco_de_dados.php'>Voltar</a></p>
                    </div>
                </body>
                </html>";
            } else {
                echo "
                <!DOCTYPE html>
                <html lang='pt'>
                <head>
                    <meta charset='UTF-8'>
                    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
                    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                    <title>Ocorreu um erro ao negar / eliminar as férias</title>
                    <style>
                        body {
                            font-family: Arial, sans-serif;
                            background-color: #f2f2f2;
                            display: flex;
                            justify-content: center;
                            align-items: center;
                            height: 100vh;
                            margin: 0;
                            padding: 0;
                        }

                        .container {
                            text-align: center;
                            padding: 40px;
                            background-color: #fff;
                            border-radius: 8px;
                            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
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

                        .logo {
                            max-width: 200px;
                            margin-bottom: 20px;
                        }

                        h1 {
                            color: #333;
                            font-size: 28px;
                            margin-bottom: 10px;
                        }

                        p {
                            color: #666;
                            font-size: 16px;
                            margin-bottom: 20px;
                        }

                        a {
                            text-decoration: none;
                            color: #333;
                            font-weight: bold;
                        }

                        a:hover {
                            color: #555;
                        }
                    </style>
                </head>
                <body>
                    <div class='container'>
                        <img src='tecnocon.png' class='logo' alt='Logo'>
                        <h1>Ocorreu um erro ao negar / eliminar as férias.</h1>
                        <p><a href='banco_de_dados.php'>Voltar</a></p>
                    </div>
                </body>
                </html>";
            }
        } else {
            echo "
            <!DOCTYPE html>
            <html lang='pt'>
            <head>
                <meta charset='UTF-8'>
                <meta http-equiv='X-UA-Compatible' content='IE=edge'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <title>Email inválido</title>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        background-color: #f2f2f2;
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        height: 100vh;
                        margin: 0;
                        padding: 0;
                    }

                    .container {
                        text-align: center;
                        padding: 40px;
                        background-color: #fff;
                        border-radius: 8px;
                        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
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

                    .logo {
                        max-width: 200px;
                        margin-bottom: 20px;
                    }

                    h1 {
                        color: #333;
                        font-size: 28px;
                        margin-bottom: 10px;
                    }

                    p {
                        color: #666;
                        font-size: 16px;
                        margin-bottom: 20px;
                    }

                    a {
                        text-decoration: none;
                        color: #333;
                        font-weight: bold;
                    }

                    a:hover {
                        color: #555;
                    }
                </style>
            </head>
            <body>
                <div class='container'>
                    <img src='tecnocon.png' class='logo' alt='Logo'>
                    <h1>Email inválido.</h1>
                    <p><a href='banco_de_dados.php'>Voltar</a></p>
                </div>
            </body>
            </html>";
        }
    }
}
?>
