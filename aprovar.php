<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aprovação realizado com sucesso</title>
</head>
<body>
    <div class="container">
        <img src="tecnocon.png" class="logo" alt="Logo">
        <h1>Férias aprovadas com sucesso!</h1>
        <?php
            if (isset($_GET['email'])) {
                $email = $_GET['email'];
                $cookieName = 'ferias_aprovadas_' . md5($email);

                if (!isset($_COOKIE[$cookieName])) {
                    $expirationTime = time() + (365 * 24 * 60 * 60);
                    setcookie($cookieName, 1, $expirationTime, '/');
                }
            }
            header('Location: banco_de_dados.php');
            exit();
            ?>
    </div>
</body>
</html>
