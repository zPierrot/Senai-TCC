<?php
require_once("admin_check.php");
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gráfico de Produtos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="grafico.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container mt-5">
        <a href="tela_index_adm.php" class="btn btn-primary">Voltar</a>
        <h1 class="text-center">Quantidade de Produtos por Tipo</h1>
        <div id="legend" class="text-center mb-3">
            <span class="legend-item">
                <span class="legend-color" style="background-color: rgba(255, 99, 132, 1);"></span> 
            </span>
            <span class="legend-item">
                <span class="legend-color" style="background-color: rgba(54, 162, 235, 1);"></span>
            </span>
            <span class="legend-item">
                <span class="legend-color" style="background-color: rgba(255, 206, 86, 1);"></span>
        </div>
        <canvas id="productChart" width="400" height="200"></canvas>
    </div>

    <script src="assets/js/grafico.js"></script>
</body>
</html>
