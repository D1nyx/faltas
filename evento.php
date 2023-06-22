<?php
include_once('config.php');
if ($conexao->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conexao->connect_error);
}

$sql = "SELECT inicio_ferias, fim_ferias, nome_completo FROM trabalhador";
$result = $conexao->query($sql);

$events = [];

function generateRandomColor() {
    $color = '#';
    for ($i = 0; $i < 3; $i++) {
        $component = dechex(rand(180, 255));
        $color .= str_pad($component, 2, '0', STR_PAD_LEFT);
    }
    return $color;
}

$workerColors = [];

if (file_exists('worker_colors.json')) {
    $workerColors = json_decode(file_get_contents('worker_colors.json'), true);
}

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $initials = getInitials($row['nome_completo']);

        if (isset($workerColors[$initials])) {
            $randomColor = $workerColors[$initials];
        } else {
            $randomColor = generateRandomColor();
            $workerColors[$initials] = $randomColor;
        }

        $start = $row['inicio_ferias'];
        $end = date('Y-m-d', strtotime(' 1 day', strtotime($row['fim_ferias'])));

        $event = [
            'start' => $start,
            'end' => $end,
            'title' => $initials,
            'color' => $randomColor,
            'textColor' => '#000000'
        ];
        $events[] = $event;
    }
}

file_put_contents('worker_colors.json', json_encode($workerColors));

header('Content-Type: application/json');
echo json_encode($events);

$conexao->close();

function getInitials($fullName) {
    $names = explode(" ", $fullName);
    $initials = "";
    foreach ($names as $name) {
        $initials .= strtoupper(substr($name, 0, 1));
    }
    return $initials;
}
?>
