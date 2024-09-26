<?php
// Conexão com o banco de dados
$servername = "localhost";
$username = "dimy";
$password = "dimymano";
$dbname = "dimy";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Consulta ao banco de dados
$sql = "SELECT tipo, SUM(quantidade) as total FROM estoque GROUP BY tipo";
$result = $conn->query($sql);

$data = [
    'estoque' => [
        'comida' => 0,
        'bebida' => 0,
        'doce' => 0
    ]
];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data['estoque'][$row['tipo']] = $row['total'];
    }
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($data);
?>
