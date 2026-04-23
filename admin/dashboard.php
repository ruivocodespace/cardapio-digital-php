<?php
require_once "../includes/logado.php";
require_once "../config/conexao.php";

// Busca os produtos e cruza com a tabela de categorias para pegar o nome da categoria
$sql = "SELECT p.id, p.nome, p.descricao, p.preco, p.disponivel, c.nome as categoria_nome 
        FROM produtos p 
        JOIN categorias c ON p.categoria_id = c.id 
        ORDER BY c.nome, p.nome";
$resultado = mysqli_query($conexao, $sql);

include_once('../includes/header.php');
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Cardápio</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>

<body>

    <div class="main-container">

        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h2 style="margin: 0;">📋 Gerenciar Cardápio</h2>
            <a href="form_produto.php" class="btn" style="background-color: #28a745; color: white; padding: 10px 15px; border-radius: 5px; text-decoration: none; font-weight: bold;">➕ Novo Produto</a>
        </div>
        <div class="table-responsive">
            <table class="tabela-cardapio">
                <thead>
                    <tr>
                        <th>Categoria</th>
                        <th>Produto</th>
                        <th>Preço</th>
                        <th>Status</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($resultado) > 0): ?>
                        <?php while ($item = mysqli_fetch_assoc($resultado)): ?>
                            <tr>
                                <td><span style="background: #eee; padding: 4px 8px; border-radius: 4px; font-size: 12px;"><?php echo htmlspecialchars($item['categoria_nome']); ?></span></td>
                                <td><strong><?php echo htmlspecialchars($item['nome']); ?></strong></td>
                                <td class="preco">R$ <?php echo number_format($item['preco'], 2, ',', '.'); ?></td>
                                <td><?php echo $item['disponivel'] ? '✅ Ativo' : '❌ Esgotado'; ?></td>
                                <td>
                                    <a href="produto_edit.php?id=<?php echo $item['id']; ?>" class="btn-acao btn-editar">Editar</a>
                                    <a href="produto_delete.php?id=<?php echo $item['id']; ?>"
                                        class="btn-acao btn-excluir"
                                        onclick="return confirm('Tem certeza que deseja excluir este produto?')">Excluir</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 30px; color: #666;">
                                Nenhum produto cadastrado no momento.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php include '../includes/footer.php'; ?>

</body>

</html>