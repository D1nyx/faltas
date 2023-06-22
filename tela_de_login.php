<?php
session_start();

if(isset($_POST['submit']) && !empty($_POST['Email']) && !empty($_POST['Password'])) {
    include_once('config.php');
    $Email = $_POST['Email'];
    $Password = $_POST['Password'];

    $query = "SELECT * FROM trabalhador WHERE email = '$Email'";
    $result = mysqli_query($conexao, $query);

    if(mysqli_num_rows($result) < 1) {
        unset($_SESSION['Email']);
        unset($_SESSION['Password']);
        $errorMessage = "Email ou senha incorretos";
    } else {
        $row = mysqli_fetch_assoc($result);
        $senhaHash = $row['senha'];
        $numeroID = $row['numeroID'];

        if(password_verify($Password, $senhaHash) && $numeroID == $_POST['numeroID']) {
            $_SESSION['Email'] = $Email;
            $_SESSION['Password'] = $Password;

            header('Location: home.php');
            exit();
        } else {
            unset($_SESSION['Email']);
            unset($_SESSION['Password']);
            $errorMessage = "Email, senha ou número de ID incorretos";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário | Férias</title>
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
        }

        fieldset {
            border: 3px solid rgb(220, 110, 20);
            padding: 20px;
            border-radius: 10px;
            margin-top: 30px;
        }

        legend {
            border: 0.5px solid rgb(14, 138, 196);
            padding: 10px;
            text-align: center;
            background-color: rgb(14, 138, 196);
            border-radius: 10px;
            font-weight: bold;
            font-size: 20px;
        }

        .inputBox {
            position: relative;
            margin-bottom: 20px;
        }

        .inputUser {
            background: none;
            border: none;
            border-bottom: 1px solid white;
            outline: none;
            color: white;
            font-size: 15px;
            width: 100%;
            letter-spacing: 2px;
        }

        .labelInput {
            position: absolute;
            top: 0px;
            left: 0px;
            pointer-events: none;
            transition: .5s;
            color: white;
            font-size: 15px;
            opacity: 0.7;
        }

        .inputUser:focus ~ .labelInput,
        .inputUser:valid ~ .labelInput {
            top: -20px;
            font-size: 12px;
            color: rgb(220, 110, 20);
        }

        .inputSubmit {
            background-image: linear-gradient(to right, rgb(220, 110, 20), rgb(14, 138, 196));
            width: 100%;
            border: none;
            padding: 15px;
            color: white;
            font-size: 15px;
            border-radius: 10px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .inputSubmit:hover {
            background-image: linear-gradient(to right, rgb(189, 92, 12), rgb(11, 110, 156));
        }

        a {
            text-decoration: none;
            color: white;
            font-size: 15px;
            opacity: 0.7;
        }

        a:hover {
            opacity: 1;
        }

        img.logo {
            max-width: 100%;
            height: auto;
            margin-top: 30px;
        }

        .error-message {
            color:  rgb(211, 56, 0);
            margin-top: 10px;
        }

        .show-password {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            background-color: transparent;
            border: none;
            color: white;
            cursor: pointer;
            outline: none;
            font-size: 14px;
        }
    </style>
    <script>
        function togglePasswordVisibility() {
            var passwordInput = document.getElementById("Password");
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
            } else {
                passwordInput.type = "password";
            }
        }
    </script>
</head>
<body>
    <div class="container">
    <a href="login_cadastro.php">Voltar</a>
        <center>
            <img src="tecnocon.png" class="logo">
        </center>
        <form action="tela_de_login.php" method="POST">
            <fieldset>
                <legend>Login</legend>
                <?php if(isset($errorMessage)): ?>
                    <p class="error-message"><?php echo $errorMessage; ?></p>
                <?php endif; ?>
                <br>
                <div class="inputBox">
                    <input type="email" name="Email" id="Email" class="inputUser" required>
                    <label for="Email" class="labelInput">Email</label>
                </div>
                <br>
                <div class="inputBox">
                    <input type="password" name="Password" id="Password" class="inputUser" required>
                    <label for="Password" class="labelInput">Senha</label>
                    <button type="button" class="show-password" onclick="togglePasswordVisibility()">Mostrar senha</button>
                </div>
                <br>
                <div class="inputBox">
                    <input type="number" name="numeroID" id="numeroID" class="inputUser" minlength="8" required>
                    <label for="numeroID" class="labelInput">Numero de identificação</label>
                </div>
                <input class="inputSubmit" type="submit" name="submit" value="Login">
            </fieldset>
        </form>
    </div>
</body>
</html>
