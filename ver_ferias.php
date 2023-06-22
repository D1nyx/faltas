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

$query = "SELECT * FROM trabalhador WHERE email = '$logado'";
$result = mysqli_query($conexao, $query);

if (!$result) {
    die('Erro na consulta: ' . mysqli_error($conexao));
}

$feriasArray = array();

while ($user_data = mysqli_fetch_assoc($result)) {
    $inicio_ferias = isset($user_data['inicio_ferias']) ? urlencode($user_data['inicio_ferias']) : '';
    $fim_ferias = isset($user_data['fim_ferias']) ? urlencode($user_data['fim_ferias']) : '';
    $numeroID = $user_data['numeroID'];
    $email = $user_data['email'];
    $nome_completo = $user_data['nome_completo'];

    if (!empty($inicio_ferias) && !empty($fim_ferias) ) {
        $feriasArray[] = array(
            'inicio_ferias' => $inicio_ferias,
            'fim_ferias' => $fim_ferias,
            'email' => $email,
            'nome_completo' => $nome_completo,
            'numeroID' => $numeroID,
        );
    }
}

mysqli_free_result($result);
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Base de Dados</title>
    <style>
        body {
            background: linear-gradient(to right, rgb(20,147,220), rgb(17,54,71));
            color: white;
            text-align: center;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        
        .navbar {
            background-color: #1e88e5;
            padding: 10px;
        }

        a {
            color: white;
            text-decoration: none;
        }

        .table-bg {
            background: rgba(0, 0, 0, 0.3);
            border-radius: 12px 12px 0 0;
        }

        .logo {
            max-width: 300px;
            margin-bottom: 20px;
        }

        .table {
            margin: auto;
            width: 80%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            padding: 15px;
            text-align: center;
        }

        .table thead th {
            background-color: #1e88e5;
            color: white;
        }

        .table tbody tr:nth-child(even) {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .table tbody tr:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }

        .back-button,
        .logout-button{
            display: inline-block;
            color: white;
            font-size: 15px;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .back-button {
            background-color: #f44336;
            position: absolute;
            top: 10px;
            left: 10px;
        }

        .back-button:hover {
            background-color: #d32f2f;
        }

        .logout-button {
            background-color: #f44336;
            position: absolute;
            top: 10px;
            right: 10px;
        }

        .logout-button:hover {
            background-color: #d32f2f;
        }

        .logo-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 40px;
        }

        .main-content {
            padding: 20px;
        }
        
        .details-button {
            color: white;
            text-decoration: none;
            background-color: #4caf50;
            padding: 8px 16px;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        .details-button:hover {
            background-color: #45a049;
        }
        .details_negar-button {
            color: white;
            text-decoration: none;
            background-color: #f44336;
            padding: 8px 16px;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        .details_negar-button:hover {
            background-color: #d32f2f;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg"></nav>
    <a href="sair_bd.php" class="logout-button">Sair</a>
    <a href="home.php" class="back-button">Voltar</a>
    <div class="logo-container">
        <img src="tecnocon.png" class="logo">
    </div>
    <div class="main-content">
        <table class="table text-white table-bg">
            <thead>
                <tr>
                    <th scope="col">NumeroID</th>
                    <th scope="col">Nome Completo</th>
                    <th scope="col">Início</th>
                    <th scope="col">Fim</th>
                    <th scope="col">Aprovação</th>
                </tr>
            </thead>
            <tbody>
            <?php
                if (!empty($feriasArray)) {
                    foreach ($feriasArray as $user_data) {
                        echo "<tr>";
                        echo "<td>".$user_data['numeroID']."</td>";
                        echo "<td>".$user_data['nome_completo']."</td>";
                        echo "<td>".$user_data['inicio_ferias']."</td>";
                        echo "<td>".$user_data['fim_ferias']."</td>";

                        $email = $user_data['email'];
                        $cookieName = 'ferias_aprovadas_' . md5($email);
                        $feriasAprovadas = isset($_COOKIE[$cookieName]);
                        
                        if ($user_data['inicio_ferias'] && $user_data['fim_ferias']) {
                            if ($feriasAprovadas) {
                                echo "<td>Férias Aprovadas</td>";
                            }
                            else {
                                echo "<td>Pendente</td>";
                            }
                        }
                    }
                } else {
                    echo "<tr><td colspan='5'>Nenhum registro de férias encontrado.</td></tr>";
                }
            ?>

            </tbody>
        </table>
    </div>
</body>
</html>
