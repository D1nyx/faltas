<?php
session_start();

if (!isset($_SESSION['Email']) || !isset($_SESSION['Password'])) {
    unset($_SESSION['Email']);
    unset($_SESSION['Password']);
    header('Location: tela_de_login.php');
    exit();
}

$logado = $_SESSION['Email'];

if (isset($_POST['submit'])) {
    include_once('config.php');

    $nome = mysqli_real_escape_string($conexao, $_POST['nome']);
    $email = mysqli_real_escape_string($conexao, $_POST['Email']);
    $numeroID = mysqli_real_escape_string($conexao, $_POST['numeroID']);
    $data_inicio = mysqli_real_escape_string($conexao, $_POST['data_inicio']);
    $data_fim = mysqli_real_escape_string($conexao, $_POST['data_fim']);
    $profissao = mysqli_real_escape_string($conexao, $_POST['profissao']);
    $setor = mysqli_real_escape_string($conexao, $_POST['setor']);
    $retribuicao = mysqli_real_escape_string($conexao, $_POST['retribuicao']);
    $considerar_falta = isset($_POST['considerar_falta_hidden']) ? mysqli_real_escape_string($conexao, $_POST['considerar_falta_hidden']) : '';
    $quando_falta = mysqli_real_escape_string($conexao, $_POST['quando_falta']);
    $inicio_horas = mysqli_real_escape_string($conexao, $_POST['inicio_horas']);
    $fim_horas = mysqli_real_escape_string($conexao, $_POST['fim_horas']);
    $motivo = mysqli_real_escape_string($conexao, $_POST['motivo']);

    $sql = "SELECT * FROM trabalhador WHERE email = '$email' AND numeroID = '$numeroID'";
    $result = mysqli_query($conexao, $sql);

    if (mysqli_num_rows($result) > 0) {
        $query = "UPDATE trabalhador SET nome_completo = '$nome', inicio_ferias = '$data_inicio', fim_ferias = '$data_fim', profissao = '$profissao', setor = '$setor', retribuicao = '$retribuicao', considerar_falta = '$considerar_falta', quando_falta = '$quando_falta', inicio_horas = '$inicio_horas', fim_horas = '$fim_horas', motivo = '$motivo' WHERE email = '$email' AND numeroID = '$numeroID'";
        $updateResult = mysqli_query($conexao, $query);

        if ($updateResult) {
            header('Location: sucesso_registro.php');
            exit();
        } else {
            $message = "Ocorreu um erro ao atualizar as férias.";
            $messageClass = "error";
        }
    } else {
        $message = "O email ou o número de identificação não existe na base de dados. Não é possível adicionar os dados.";
        $messageClass = "error";
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
            position: relative; 
        }

        .back-button {
            display: inline-block;
            color: white;
            font-size: 15px;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
            background-image: linear-gradient(to right, rgb(220, 110, 20), rgb(14, 138, 196));
            position: relative;
            top: -20px; 
            right: 20px; 
            
        }

        .back-button:hover {
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

        fieldset {
            border: 3px solid rgb(220, 110, 20);
            padding: 20px;
            margin-top: 30px;
            border-radius: 10px;
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

        #data_inicio,
        #data_fim {
            border: none;
            padding: 8px;
            color: bla;
            border-radius: 10px;
            outline: none;
            font-size: 15px;
        }

        #submit {
            background-image: linear-gradient(to right, rgb(220, 110, 20), rgb(14, 138, 196));
            width: 100%;
            border: none;
            padding: 15px;
            color: white;
            font-size: 15px;
            cursor: pointer;
            border-radius: 10px;
            transition: background-color 0.3s ease;
        }

        #submit:hover {
            background-image: linear-gradient(to right, rgb(189, 92, 12), rgb(11, 110, 156));
        }

        .message {
            margin-top: 10px;
            padding: 10px;
            border-radius: 5px;
            color: white;
            font-weight: bold;
            text-align: center;
        }
        .success {
            background-color: #4CAF50;
        }

        .error {
            background-color: #f44336;
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


        .logo {
            max-width: 400px;
            width: 100%;
            margin-bottom: 30px;
        }

        .caixinha-container {
            margin-bottom: 10px;
        }

        .caixinha-container label {
            font-size: 16px;
            color: white;
        }

        #considerar_falta{
            margin-top: 10px;
            width: 300px;
            padding: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
    <a href="home.php">Voltar</a>
        <div class="box">
            <a href="sair.php" class="logout-button">Sair</a>
            <center>
                <img src="tecnocon.png" class="logo">
            </center>
            <form action="ferias_marcacao.php" method="POST">
                <fieldset>
                    <legend>Marcacão de Férias</legend>
                    <?php if(isset($message)): ?>
                        <div class="message <?php echo $messageClass; ?>"><?php echo $message; ?></div>
                    <?php endif; ?>
                    <br><br>
                    <div class="inputBox">
                        <input type="text" name="nome" id="nome" class="inputUser" required>
                        <label for="nome" class="labelInput" >Nome Completo:</label>
                    </div>
                    <br>
                    <div class="inputBox">
                        <input type="number" name="numeroID" id="numeroID" class="inputUser" minlength="8" required>
                        <label for="numeroID" class="labelInput">Número de Identificação:</label>
                    </div>
                    <br>
                    <div class="inputBox">
                        <input type="email" name="Email" id="Email" class="inputUser" required>
                        <label for="Email" class="labelInput">Email:</label>
                    </div>
                    <br>
                    <div class="inputBox">
                        <input type="text" name="profissao" id="profissao" class="inputUser" required>
                        <label for="profissao" class="labelInput">Profissão:</label>
                    </div>
                    <br>
                    <div class="inputBox">
                        <input type="text" name="setor" id="setor" class="inputUser" required>
                        <label for="setor" class="labelInput">Setor:</label>
                    </div>
                    <br>
                    <div>
                        <b>Comunica que { 
                        <input type="radio" id="deseja_faltar" name="quando_falta" value="Deseja Faltar" required>
                        <label for="deseja_faltar">Deseja Faltar</label>
                        
                        <input type="radio" id="faltou" name="quando_falta" value="Faltou" required>
                        <label for="faltou">Faltou</label>
                        } &nbsp; serviço no seguinte período:</b>
                    </div>
                    <br>
                    <label for="data_inicio">Data de Início:</label>
                    <input type="date" name="data_inicio" id="data_inicio" required>
                    <br><br><br>
                    <label for="data_fim">Data do Fim:</label>
                    <input type="date" name="data_fim" id="data_fim" required>
                    <br><br><br>
                    <label for="inicio_horas">Início das Horas:</label>
                    <input type="time" name="inicio_horas" id="inicio_horas" required>
                    <br><br><br>
                    <label for="fim_horas">Fim das Horas:</label>
                    <input type="time" name="fim_horas" id="fim_horas" required>
                    <br><br><br>
                    <div class="inputBox">
                        <input type="text" name="motivo" id="motivo" class="inputUser" maxlength="240"required>
                        <label for="motivo" class="labelInput" >Por motivo de (MAX 240 carateres):</label>
                    </div>
                    <br>
                    <div>
                        <b>Caso estas faltas determinem perda de retribuição, pertende que esta perda de retribuição seja subtituída por desconto nas férias { 
                        <input type="radio" id="Sim" name="retribuicao" value="Sim" required>
                        <label for="deseja_faltar">Sim</label>
                        
                        <input type="radio" id="Nao" name="retribuicao" value="Não" required>
                        <label for="Nao">Não</label> } </b>
                    </div>
                    <br>
                    <div class="caixinha-container">
                        <label for="linha-container">Pretende que as faltas sejam consideradas</label>
                        <input type="checkbox" id="linha-container">
                    </div>
                    <div>
                        <label for="considerar_falta" id="label-considerar-falta"></label>
                        <input type="text" name="considerar_falta" id="considerar_falta" placeholder="..."  maxlength="100" style="display: none;">
                        <input type="hidden" name="considerar_falta_hidden" id="considerar_falta_hidden">
                    </div>
                    <script>
                        const button = document.getElementById('linha-container');
                        const linhaContainer = document.getElementById('considerar_falta');
                        const labelConsiderarFalta = document.getElementById('label-considerar-falta');
                        const considerarFaltaHidden = document.getElementById('considerar_falta_hidden');

                        button.addEventListener('click', function() {
                            if (linhaContainer.style.display === 'none') {
                                linhaContainer.style.display = 'block';
                                labelConsiderarFalta.style.display = 'block';
                                considerarFaltaHidden.value = '';
                            } else {
                                linhaContainer.style.display = 'none';
                                labelConsiderarFalta.style.display = 'none';
                                considerarFaltaHidden.value = 'N/A';
                            }
                        });

                        linhaContainer.addEventListener('input', function() {
                            considerarFaltaHidden.value = this.value;
                        });
                    </script>


                    <br>
                    <input type="submit" name="submit" id="submit" value="Enviar">
                </fieldset>
            </form>
        </div>
    </div>
</body>
</html>

