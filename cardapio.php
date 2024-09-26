<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$usuario_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'adicionar') {
        $produto_id = $_POST['produto_id'];
        $quantidade = $_POST['quantidade'];

        // Verifica a quantidade em estoque
        $sql = "SELECT quantidade FROM estoque WHERE id = '$produto_id'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $quantidade_estoque = $row['quantidade'];

            // Verifica a quantidade atual no carrinho
            $sql = "SELECT SUM(quantidade) AS quantidade_total FROM carrinho WHERE usuario_id = '$usuario_id' AND produto_id = '$produto_id'";
            $result = $conn->query($sql);
            $quantidade_atual_carrinho = 0;
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $quantidade_atual_carrinho = $row['quantidade_total'];
            }

            // Calcula a quantidade máxima que pode ser adicionada ao carrinho
            $quantidade_disponivel = $quantidade_estoque - $quantidade_atual_carrinho;

            // Verifica se a quantidade solicitada não excede a disponível em estoque
            if ($quantidade <= $quantidade_disponivel) {
                // Adiciona ao carrinho
                if ($quantidade_atual_carrinho > 0) {
                    $sql = "UPDATE carrinho SET quantidade = quantidade + '$quantidade' WHERE usuario_id = '$usuario_id' AND produto_id = '$produto_id'";
                } else {
                    $sql = "INSERT INTO carrinho (usuario_id, produto_id, quantidade) VALUES ('$usuario_id', '$produto_id', '$quantidade')";
                }

                if ($conn->query($sql)) {
                    echo json_encode(['status' => 'success', 'type' => 'success', 'message' => 'Produto adicionado com sucesso.', 'redirect' => 'carrinho.php']);
                } else {
                    echo json_encode(['status' => 'success', 'type' => 'error', 'message' => 'Erro ao adicionar produto ao carrinho.']);
                }
            } else {
                echo json_encode(['status' => 'success', 'type' => 'error', 'message' => 'Quantidade solicitada excede a disponível em estoque.']);
            }
        } else {
            echo json_encode(['status' => 'success', 'type' => 'error', 'message' => 'Produto não encontrado no estoque.']);
        }
        exit();
    }
}

$sql = "SELECT * FROM estoque";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cardápio</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/CSS/cardapio.css">
</head>
<body class="custom-bg">
<a href="tela_cliente_logado.php" class="voltar-button">Voltar</a>
<h1 class="main-title">Cardápio</h1>

<div class="container">
    <?php
    if ($result->num_rows > 0) {
        echo "<table class='produtos-table'>";
        echo "<thead>";
        echo "<tr>";
        echo "<th>Imagem</th>";
        echo "<th>Nome</th>";
        echo "<th>Tipo</th>";
        echo "<th>Preço</th>";
        echo "<th>Estoque</th>";
        echo "<th>Quantidade</th>";
        echo "<th>Ação</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";

        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td><img src='uploads/" . $row['imagem'] . "' alt='" . $row['nome'] . "' class='produto-imagem'></td>";
            echo "<td>" . $row['nome'] . "</td>";
            echo "<td>" . $row['tipo'] . "</td>";
            echo "<td>" . $row['preco'] . "</td>";
            echo "<td>" . $row['quantidade'] . "</td>";
            echo "<td>
                    <input type='number' name='quantidade' class='quantidade' value='1' min='1' max='" . $row['quantidade'] . "'>
                    <input type='hidden' name='produto_id' class='produto_id' value='" . $row['id'] . "'>
                  </td>";
            echo "<td>
                    <button class='adicionar-carrinho'>Adicionar ao Carrinho</button>
                  </td>";
            echo "</tr>";
        }

        echo "</tbody>";
        echo "</table>";
    } else {
        echo "Nenhum produto disponível no momento.";
    }

    $conn->close();
    ?>
</div>

<!-- Modal -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="successModalLabel">AVISO!</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="modal-message">
        <!-- Aqui é onde o texto do modal será inserido dinamicamente -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="modal-ok">OK</button>
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="assets/JS/cardapio.js"></script>

</body>
</html>
