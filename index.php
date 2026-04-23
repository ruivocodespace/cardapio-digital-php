<?php
// 1. Inicia a sessão para verificar se o admin está logado
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "config/conexao.php"; // Ajuste o caminho conforme sua pasta

// 2. Define o link e o texto baseado no login
if (isset($_SESSION["usuario_nome"])) {
    $url_admin = "admin/dashboard.php"; // Caminho se estiver logado
    $texto_btn = "⚙️ Ir para o Dashboard";
} else {
    $url_admin = "login.php";           // Caminho se NÃO estiver logado
    $texto_btn = "🔒 Área Admin";
}

require_once "config/conexao.php";

// Busca apenas os produtos disponíveis, ordenados por Categoria e Nome
$sql = "SELECT p.*, c.nome as categoria_nome 
        FROM produtos p 
        JOIN categorias c ON p.categoria_id = c.id 
        WHERE p.disponivel = 1 
        ORDER BY c.nome, p.nome";
$resultado = mysqli_query($conexao, $sql);

$cardapio_agrupado = [];
while ($item = mysqli_fetch_assoc($resultado)) {
    $categoria = $item['categoria_nome'];
    $cardapio_agrupado[$categoria][] = $item;
}


?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Dashboard - Cardápio</title>
    <link rel="stylesheet" href="assets/style.css">
</head>

<body>

    <div class="main-container" style="max-width: 1000px; background: transparent; box-shadow: none;">
        <div style="display: flex; justify-content: flex-end; margin-bottom: 10px;">
            <a href="<?php echo $url_admin; ?>" style="color: #555; text-decoration: none; font-size: 14px; border: 1px solid #ccc; padding: 6px 12px; border-radius: 6px; background-color: white; transition: 0.3s; font-weight: bold;">
                <?php echo $texto_btn; ?>
            </a>
        </div>
        <div style="text-align: center; margin-bottom: 30px;">
            <h1 style="color: #333; font-size: 36px;">🍔 Nosso Cardápio</h1>
            <p style="color: #666;">Confira nossas delícias e faça seu pedido no balcão!</p>
        </div>

        <?php if (empty($cardapio_agrupado)): ?>
            <div style="text-align: center; padding: 50px; background: white; border-radius: 8px;">
                <h3 style="color: #888;">Nenhum produto disponível no momento. Volte mais tarde!</h3>
            </div>
        <?php else: ?>

            <?php foreach ($cardapio_agrupado as $categoria => $produtos): ?>

                <h2 class="categoria-titulo"><?php echo htmlspecialchars($categoria); ?></h2>

                <div class="grid-cardapio">
                    <?php foreach ($produtos as $produto): ?>
                        <div class="card-produto">

                            <div class="card-imagem">
                                <?php if (!empty($produto['imagem']) && $produto['imagem'] !== 'sem-foto.jpg'): ?>
                                    <img src="uploads/produtos/<?php echo $produto['imagem']; ?>" alt="<?php echo htmlspecialchars($produto['nome']); ?>">
                                <?php else: ?>
                                    <span>Sem foto</span>
                                <?php endif; ?>
                            </div>

                            <div class="card-corpo">
                                <h3 class="card-titulo"><?php echo htmlspecialchars($produto['nome']); ?></h3>
                                <p class="card-descricao"><?php echo htmlspecialchars($produto['descricao']); ?></p>

                                <div class="card-preco">
                                    R$ <?php echo number_format($produto['preco'], 2, ',', '.'); ?>
                                </div>
                            </div>

                        </div>
                    <?php endforeach; ?>
                </div> <?php endforeach; ?>

        <?php endif; ?>
    </div>

    <?php include 'includes/footer.php'; ?>

</body>

</html>