<?php
session_start();

if (!isset($_SESSION['Email']) || empty($_SESSION['Password'])) {
    header('Location: home.php');
    exit();
}

$logado = $_SESSION['Password'];

include_once('config.php');

$emailLogado = $_SESSION['Email'];

$sql = "SELECT * FROM trabalhador WHERE email = '$emailLogado'";
$result = $conexao->query($sql);

$feriasArray = array();

while ($user_data = mysqli_fetch_assoc($result)) {
    $inicio_ferias = isset($user_data['inicio_ferias']) ? urlencode($user_data['inicio_ferias']) : '';
    $fim_ferias = isset($user_data['fim_ferias']) ? urlencode($user_data['fim_ferias']) : '';
    $nome_completo = $user_data['nome_completo'];
    $numeroID = $user_data['numeroID'];
    $inicio_horas = $user_data['inicio_horas'];
    $fim_horas = $user_data['fim_horas'];
    $profissao = $user_data['profissao'];
    $setor = $user_data['setor'];
    $motivo = $user_data['motivo'];
    $considerar_falta = $user_data['considerar_falta'];
    $quando_falta = $user_data['quando_falta'];
    $retribuicao = $user_data['retribuicao'];

    $feriasArray[] = array(
        'inicio_ferias' => $inicio_ferias,
        'fim_ferias' => $fim_ferias,
        'nome_completo' => $nome_completo,
        'numeroID' => $numeroID,
        'inicio_horas' => $inicio_horas,
        'fim_horas' => $fim_horas,
        'profissao' => $profissao,
        'setor' => $setor,
        'motivo' => $motivo,
        'considerar_falta' => $considerar_falta,
        'quando_falta' => $quando_falta,
        'retribuicao' => $retribuicao,
    );
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Gerador de PDF</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0px;
      background-image: linear-gradient(to right, rgb(220, 110, 20), rgb(14, 138, 196));
    }

    h1 {
      text-align: center;
      color: #333;
      text-transform: uppercase;
      margin-bottom: 30px;
    }

    button {
      display: block;
      margin: 20px auto;
      padding: 10px 20px;
      background-color: #333;
      color: #fff;
      border: none;
      border-radius: 5px;
      font-size: 16px;
      cursor: pointer;
    }

    button:hover {
      background-color: #555;
    }

    .fieldset_1 {
      height: 345px;
      border: 2px solid orange;
      padding: 10px;
      margin-top: 10px;
      margin-bottom: 0;
      display: block;
    }

    .fieldset_2 {
      height: 380px; 
      border: 2px solid orange;
      padding: 10px;
      margin-top: 10px;
      margin-bottom: 0;
      display: block;
    }
    .fieldset_3 {
      height: 90px; 
      border: 2px solid orange;
      padding: 10px;
      margin-top: 10px;
      margin-bottom: 0;
      display: block;
    }

    .titulo-secao {
      color: orange;
      position: relative;
      text-align: center;
      text-transform: uppercase;
      font-size: 15px;
    }


    #pdf-container {
      width: 100%;
      height: 500px;
    }

    .visualizacao {
      background-color: white;
      width: 210mm;
      height: 297mm;
      margin: auto;
      margin-bottom: 0;
    }

    .data-wrapper {
      display: flex;
      justify-content: flex-end;
      align-items: center;
    }

    .line {
      display: black;
      height: 1px;
      width: 70mm;
      position: relative;
      top: 8px;
      background-color: black;
      margin-left: 10px;
    }
    .assinatura{
      display: flex;
      justify-content: flex-end;
      position: relative;
      top: -20px;
      right: 105px;

    }
    .data-wrapper_rubrica {
      display: flex;
      justify-content: flex;
      align-items: center;
    }
    p{
      font-size: 13px;
    }
    .line_rubrica {
      height: 1px;
      width: 60mm;
      position: relative;
      top: 8px;
      background-color: black;
      margin-left: 10px;
    }
    .rubrica{
      display: flex;
      justify-content: flex;
      position: relative;
      top: -20px;
      right: -225px;
    }
    .rubrica_2{
      display: flex;
      justify-content: flex-end;
      position: relative;
      top: -57px;
      right: 107px;
    }


  .quadrado {
    width: 10px;
    height: 10px;
    border: 1px solid black;
    display: flex;
    position: relative;
    top: -14px;
    right: 15px;
  }
  .logo {
    max-width: 200px;
    margin-bottom: 20px;
    position: relative;
    top: 100px;
    right: -550px;
  }
  .back-button {
    display: inline-block;
    color: white;
    font-size: 15px;
    padding: 10px 20px;
    border-radius: 5px;
    text-decoration: none;
    transition: background-color 0.3s ease;
    }

 .back-button {
    background-color: red;
    position: absolute;
    top: 10px;
    left: 10px;
  }

.back-button:hover {
  background-color: red;
}
a {
  color: white;
  text-decoration: none;
        }
  </style>
</head>
<body>
  <br>
  <a href="home.php" class="back-button">Voltar</a>
  <img src="tecnocon.png" style="display: block; margin: 0 auto;">
  <h1>Gerador de PDF</h1>
  <button onclick="visualizarPDF()">Visualizar PDF</button>
  <button onclick="gerarPDF()">Download PDF</button>

  <div id="pdf-container"></div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>


  <script>
    function visualizarPDF() {
      const dadosFormulario = {
        nome: "<?php echo $feriasArray[0]['nome_completo']; ?>",
        numeroID: "<?php echo $feriasArray[0]['numeroID']; ?>",
        data_inicio: "<?php echo $feriasArray[0]['inicio_ferias']; ?>",
        data_fim: "<?php echo $feriasArray[0]['fim_ferias']; ?>",
        profissao: "<?php echo $feriasArray[0]['profissao']; ?>",
        setor: "<?php echo $feriasArray[0]['setor']; ?>",
        considerar_falta: "<?php echo $feriasArray[0]['considerar_falta']; ?>",
        quando_falta: "<?php echo $feriasArray[0]['quando_falta']; ?>",
        inicio_horas: "<?php echo $feriasArray[0]['inicio_horas']; ?>",
        fim_horas: "<?php echo $feriasArray[0]['fim_horas']; ?>",
        motivo: "<?php echo $feriasArray[0]['motivo']; ?>",
        retribuicao: "<?php echo $feriasArray[0]['retribuicao']; ?>",
      };
      const conteudoHTML = `
      <div class="visualizacao">
      <img src="tecnocon.png" class="logo" alt="Logo">
    <h3 class="titulo-secao">A Preencher Pelo Trabalhador</h3>
    <fieldset class="fieldset_1">
      <h4>1 - Comunicação de falta</h4>
      <p>
        <strong>Nome:</strong>
        <u>${dadosFormulario.nome}</u>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <strong>Número ID:</strong>
        <u>${dadosFormulario.numeroID}</u>
      </p>     
      <p>
        <strong>Profissão:</strong>
        <u>${dadosFormulario.profissao}</u>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <strong>Setor:</strong>
        <u>${dadosFormulario.setor}</u>
      </p>      
      <p>
        <strong>Comunica que:</strong>
        <u>${dadosFormulario.quando_falta}</u>
        <strong>ao serviço no seguinte período:</strong>
      </p>
        
      <p>
        <strong>De/Em:</strong>
        <u>${dadosFormulario.data_inicio}</u>
        <strong>a</strong>
        <u>${dadosFormulario.data_fim}</u>
        <strong>das</strong>
        <u>${dadosFormulario.inicio_horas}</u>
        <strong>às</strong>
        <u>${dadosFormulario.fim_horas}</u>
        <strong>horas</strong>
      </p>
        
      <p>
        <strong>Por motivo de:</strong>
        <span style="word-break: break-word;">${dadosFormulario.motivo}</span>
      </p>

        
      <p>
        <strong>Pretende que estas faltas sejam consideradas:</strong>
        <span style="word-break: break-word;">${dadosFormulario.considerar_falta}</span>
      </p>

      <p>
        <strong>Caso estas faltas determinem perda de retribuição, pretende que esta perda de retribuição seja substituída por desconto nas férias:</strong>
        <u>${dadosFormulario.retribuicao}</u>
      </p>  
        
      <p class="data-wrapper">
        <span class="data">___/___/____</span>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <span class="line"></span>
        <h6 class="assinatura">Assinatura</h6>
      </p>
    </fieldset>
    <h2 class="titulo-secao">A Preencher Pela Entidade Patronal</h2>
    <fieldset class="fieldset_2">
    <div style="float: center; margin-right: 20px;">
      <h5>2 - Informação dos serviços</h5>
      <hr style="position: relative; top: -10px;">
      <hr style="position: relative; top: 0px;">
      <p class="data-wrapper_rubrica">
        <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;___/___/____</span>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <b class="line_rubrica"></b>
        &nbsp;&nbsp;
        <strong> &nbsp; | &nbsp;</strong>
        <span>___/___/____</span>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <b class="line_rubrica"></b>
        <h6 class="rubrica">Rúbrica</h6>
        <h6 class="rubrica_2">Rúbrica</h6>
        <hr style="position: relative; top: -75px;">
      </p>
      </div>
      <h5 style="position: relative; top: -75px;">3 - Decisão - A falta considera-se</h5>

        <div style="float: left; margin-right: 50px;">
        <p style="position: relative; top: -85px; left: 30px;">
          <strong>Doença C/Baixa <span class="quadrado"></span></strong>
        </p>
        <p style="position: relative; top: -110px; left: 30px;">
          <strong>Doença S/Baixa <span class="quadrado"></span></strong>
        </p>
        <p style="position: relative; top: -135px; left: 30px;">
          <strong>Acidente de trabalho<span class="quadrado"></span></strong>
        </p>
        <p style="position: relative; top: -160px; left: 30px;">
          <strong>Licença<span class="quadrado"></span></strong>
        </p>
        <p style="position: relative; top: -185px; left: 30px;">
          <strong>Casamento <span class="quadrado"></span></strong>
        </p>
        <p style="position: relative; top: -210px; left: 30px;">
          <strong>Parto <span class="quadrado"></span></strong>
        </p>
        <p style="position: relative; top: -235px; left: 30px;">
          <strong>Aleitação <span class="quadrado"></span></strong>
        </p>
        <p style="position: relative; top: -260px; left: 30px;">
          <strong>Nascimento <span class="quadrado"></span></strong>
        </p>
      </div>
      <div style="float: left; margin-left: 130px;">
        <p style="position: relative; top: -85px; left: 30px;">
          <strong>Luto <span class="quadrado"></span></strong>
        </p>
        <p style="position: relative; top: -110px; left: 30px;">
          <strong>Férias <span class="quadrado"></span></strong>
        </p>
        <p style="position: relative; top: -135px; left: 30px;">
          <strong>Assistência a familiar <span class="quadrado"></span></strong>
        </p>
        <p style="position: relative; top: -160px; left: 30px;">
          <strong>Sinistro fora do trabalho <span class="quadrado"></span></strong>
        </p>
        <p style="position: relative; top: -185px; left: 30px;">
          <strong>Frequência de aulas <span class="quadrado"></span></strong>
        </p>
        <p style="position: relative; top: -210px; left: 30px;">
          <strong>Exames <span class="quadrado"></span></strong>
        </p>
        <p style="position: relative; top: -235px; left: 30px;">
          <strong>Doação de sangue <span class="quadrado"></span></strong>
        </p>
        <p style="position: relative; top: -260px; left: 30px;">
          <strong>Obrigações legais<span class="quadrado"></span></strong>
        </p>
      </div>
      <div style="float: left; margin-left: 130px;">
        <p style="position: relative; top: -85px; left: 30px;">
          <strong>Atividade sindical <span class="quadrado"></span></strong>
        </p>
        <p style="position: relative; top: -110px; left: 30px;">
          <strong>Greve <span class="quadrado"></span></strong>
        </p>
        <p style="position: relative; top: -135px; left: 30px;">
          <strong>Injustificadas <span class="quadrado"></span></strong>
        </p>
        <p style="position: relative; top: -160px; left: 30px;">
          <strong>_______________ <span class="quadrado"></span></strong>
        </p>
        <p style="position: relative; top: -160px; left: 30px;">
          <strong>Renumerada<span class="quadrado"></span></strong>
        </p>
        <p style="position: relative; top: -185px; left: 30px;">
          <strong>Não renumerada <span class="quadrado"></span></strong>
        </p>
        </p>
      </div>
      <p>
        <span style="position: relative; top: -178.5px; right: 110px;">___/___/____</span>
        <span style="display: block; height: 1px; width: 70mm; position: relative; top: -180px; right: -470px; background-color: black;"></span>
        <h6 style="position: relative; top: -200px; right: -95px;">Assinatura e carimbo</h6>
      </p>

    </fieldset>

    <fieldset class="fieldset_3">
      <h5>4 - Recebi original da presente comunicação de falta e respetiva decisão </h5>
      <p>
        <span style="position: relative; top: 10px; right: -110px;">_____/_____/_______</span>
        <span style="display: block; height: 1px; width: 70mm; position: relative; top: 10px; right: -430px; background-color: black;"></span>
        <h6 style="position: relative; top: -60px; right: -505px;">O TRABALHADOR</h6>
      </p>
    </fieldset>
  </div>`;

      const element = document.createElement('div');
      element.innerHTML = conteudoHTML;

      const pdfContainer = document.getElementById('pdf-container');
      pdfContainer.innerHTML = '';
      pdfContainer.appendChild(element);

      PDFObject.embed('trabalhador.pdf', '#pdf-container');
    }

    function gerarPDF() {
      const dadosFormulario = {
        nome: "<?php echo $feriasArray[0]['nome_completo']; ?>",
        numeroID: "<?php echo $feriasArray[0]['numeroID']; ?>",
        data_inicio: "<?php echo $feriasArray[0]['inicio_ferias']; ?>",
        data_fim: "<?php echo $feriasArray[0]['fim_ferias']; ?>",
        profissao: "<?php echo $feriasArray[0]['profissao']; ?>",
        setor: "<?php echo $feriasArray[0]['setor']; ?>",
        considerar_falta: "<?php echo $feriasArray[0]['considerar_falta']; ?>",
        quando_falta: "<?php echo $feriasArray[0]['quando_falta']; ?>",
        inicio_horas: "<?php echo $feriasArray[0]['inicio_horas']; ?>",
        fim_horas: "<?php echo $feriasArray[0]['fim_horas']; ?>",
        motivo: "<?php echo $feriasArray[0]['motivo']; ?>",
        retribuicao: "<?php echo $feriasArray[0]['retribuicao']; ?>",
      };

      const conteudoHTML = `
      <div class="visualizacao">
      <img src="tecnocon.png" class="logo" alt="Logo">
    <h3 class="titulo-secao">A Preencher Pelo Trabalhador</h3>
    <fieldset class="fieldset_1" style="word-break: break-word;">
      <h4>1 - Comunicação de falta</h4>
      <p>
        <strong>Nome:</strong>
        <u>${dadosFormulario.nome}</u>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <strong>Número ID:</strong>
        <u>${dadosFormulario.numeroID}</u>
      </p>     
      <p>
        <strong>Profissão:</strong>
        <u>${dadosFormulario.profissao}</u>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <strong>Setor:</strong>
        <u>${dadosFormulario.setor}</u>
      </p>      
      <p>
        <strong>Comunica que:</strong>
        <u>${dadosFormulario.quando_falta}</u>
        <strong>ao serviço no seguinte período:</strong>
      </p>
        
      <p>
        <strong>De/Em:</strong>
        <u>${dadosFormulario.data_inicio}</u>
        <strong>a</strong>
        <u>${dadosFormulario.data_fim}</u>
        <strong>das</strong>
        <u>${dadosFormulario.inicio_horas}</u>
        <strong>às</strong>
        <u>${dadosFormulario.fim_horas}</u>
        <strong>horas</strong>
      </p>
        
      <p>
        <strong>Por motivo de:</strong>
        <span>${dadosFormulario.motivo}</span>
      </p>

      <p>
        <strong>Pretende que estas faltas sejam consideradas:</strong>
        <span>${dadosFormulario.considerar_falta}</span>
      </p>

      <p>
        <strong>Caso estas faltas determinem perda de retribuição, pretende que esta perda de retribuição seja substituída por desconto nas férias:</strong>
        <u>${dadosFormulario.retribuicao}</u>
      </p>  
        
      <p class="data-wrapper">
        <span class="data">___/___/____</span>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <span class="line"></span>
        <h6 class="assinatura">Assinatura</h6>
      </p>
    </fieldset>
    <h2 class="titulo-secao">A Preencher Pela Entidade Patronal</h2>
    <fieldset class="fieldset_2">
    <div style="float: center; margin-right: 20px;">
      <h5>2 - Informação dos serviços</h5>
      <hr style="position: relative; top: -10px;">
      <hr style="position: relative; top: 0px;">
      <p class="data-wrapper_rubrica">
        <span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;___/___/____</span>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <b class="line_rubrica"></b>
        &nbsp;&nbsp;
        <strong> &nbsp; | &nbsp;</strong>
        <span>___/___/____</span>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <b class="line_rubrica"></b>
        <h6 class="rubrica">Rúbrica</h6>
        <h6 class="rubrica_2">Rúbrica</h6>
        <hr style="position: relative; top: -75px;">
      </p>
      </div>
      <h5 style="position: relative; top: -75px;">3 - Decisão - A falta considera-se</h5>

        <div style="float: left; margin-right: 50px;">
        <p style="position: relative; top: -85px; left: 30px;">
          <strong>Doença C/Baixa <span class="quadrado"></span></strong>
        </p>
        <p style="position: relative; top: -110px; left: 30px;">
          <strong>Doença S/Baixa <span class="quadrado"></span></strong>
        </p>
        <p style="position: relative; top: -135px; left: 30px;">
          <strong>Acidente de trabalho<span class="quadrado"></span></strong>
        </p>
        <p style="position: relative; top: -160px; left: 30px;">
          <strong>Licença<span class="quadrado"></span></strong>
        </p>
        <p style="position: relative; top: -185px; left: 30px;">
          <strong>Casamento <span class="quadrado"></span></strong>
        </p>
        <p style="position: relative; top: -210px; left: 30px;">
          <strong>Parto <span class="quadrado"></span></strong>
        </p>
        <p style="position: relative; top: -235px; left: 30px;">
          <strong>Aleitação <span class="quadrado"></span></strong>
        </p>
        <p style="position: relative; top: -260px; left: 30px;">
          <strong>Nascimento <span class="quadrado"></span></strong>
        </p>
      </div>
      <div style="float: left; margin-left: 130px;">
        <p style="position: relative; top: -85px; left: 30px;">
          <strong>Luto <span class="quadrado"></span></strong>
        </p>
        <p style="position: relative; top: -110px; left: 30px;">
          <strong>Férias <span class="quadrado"></span></strong>
        </p>
        <p style="position: relative; top: -135px; left: 30px;">
          <strong>Assistência a familiar <span class="quadrado"></span></strong>
        </p>
        <p style="position: relative; top: -160px; left: 30px;">
          <strong>Sinistro fora do trabalho <span class="quadrado"></span></strong>
        </p>
        <p style="position: relative; top: -185px; left: 30px;">
          <strong>Frequência de aulas <span class="quadrado"></span></strong>
        </p>
        <p style="position: relative; top: -210px; left: 30px;">
          <strong>Exames <span class="quadrado"></span></strong>
        </p>
        <p style="position: relative; top: -235px; left: 30px;">
          <strong>Doação de sangue <span class="quadrado"></span></strong>
        </p>
        <p style="position: relative; top: -260px; left: 30px;">
          <strong>Obrigações legais<span class="quadrado"></span></strong>
        </p>
      </div>
      <div style="float: left; margin-left: 130px;">
        <p style="position: relative; top: -85px; left: 30px;">
          <strong>Atividade sindical <span class="quadrado"></span></strong>
        </p>
        <p style="position: relative; top: -110px; left: 30px;">
          <strong>Greve <span class="quadrado"></span></strong>
        </p>
        <p style="position: relative; top: -135px; left: 30px;">
          <strong>Injustificadas <span class="quadrado"></span></strong>
        </p>
        <p style="position: relative; top: -160px; left: 30px;">
          <strong>_______________ <span class="quadrado"></span></strong>
        </p>
        <p style="position: relative; top: -160px; left: 30px;">
          <strong>Renumerada<span class="quadrado"></span></strong>
        </p>
        <p style="position: relative; top: -185px; left: 30px;">
          <strong>Não renumerada <span class="quadrado"></span></strong>
        </p>
        </p>
      </div>
      <p>
        <span style="position: relative; top: -178.5px; right: 110px;">___/___/____</span>
        <span style="display: block; height: 1px; width: 70mm; position: relative; top: -180px; right: -470px; background-color: black;"></span>
        <h6 style="position: relative; top: -200px; right: -95px;">Assinatura e carimbo</h6>
      </p>

    </fieldset>

    <fieldset class="fieldset_3">
      <h5>4 - Recebi original da presente comunicação de falta e respetiva decisão </h5>
      <p>
        <span style="position: relative; top: 10px; right: -110px;">_____/_____/_______</span>
        <span style="display: block; height: 1px; width: 70mm; position: relative; top: 10px; right: -430px; background-color: black;"></span>
        <h6 style="position: relative; top: -60px; right: -505px;">O TRABALHADOR</h6>
      </p>
    </fieldset>
  </div>`;
  const element = document.createElement('div');
element.innerHTML = conteudoHTML;
const opt = {
  margin: 0,
  filename: 'trabalhador.pdf',
  image: { type: 'pdf', quality: 0.98 },
  html2canvas: { scale: 1 },
  jsPDF: { unit: 'in', format: 'a4', orientation: 'portrait' },
};
function updateContent(newHTML) {
  element.innerHTML = newHTML;
}
function updatePdf() {
  if (element.innerHTML) {
    html2pdf().from(element).set(opt).save();
  }
}
html2pdf().from(element).set(opt).save();
updateContent(div);
updatePdf();
    }
  </script>
</body>
</html>
