<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro realizado com sucesso</title>
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
    <div class="container">
        <img src="tecnocon.png" class="logo" alt="Logo">
        <h1>Férias marcadas com sucesso!</h1>
        <p>Obrigado por marcar as suas férias. Seu registro foi realizado com sucesso.</p>
        <p><a href="home.php">Voltar</a></p>
    </div>
</body>
</html>