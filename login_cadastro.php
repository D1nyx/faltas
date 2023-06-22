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
    </style>
</head>
<body>
    <div class="container">
        <img src="tecnocon.png" class="logo" alt="Logo">
        <h1>Login / Cadastro</h1>
            <a href="tela_de_login.php">Login</a>
            <a href="tela_de_cadastro.php">Cadastro</a>
    </div>
</body>
</html>
