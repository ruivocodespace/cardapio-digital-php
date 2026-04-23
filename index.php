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

$item_busca = "";
$filtro_sql = "";

if (isset($_GET['busca']) && !empty(trim($_GET['busca']))) {
    $item_busca = mysqli_real_escape_string($conexao, trim($_GET['busca']));
    // Filtra pelo nome ou descrição do produto
    $filtro_sql = " AND (p.nome LIKE '%$item_busca%' OR p.descricao LIKE '%$item_busca%') ";
}

// Busca apenas os produtos disponíveis, ordenados por Categoria e Nome
$sql = "SELECT p.*, c.nome as categoria_nome 
        FROM produtos p 
        JOIN categorias c ON p.categoria_id = c.id 
        WHERE p.disponivel = 1 $filtro_sql
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        <div class="container-busca">
            <form action="index.php" method="GET" class="form-busca">
                <input type="text" name="busca" class="input-busca" placeholder="Buscar prato, lanche ou bebida..." value="<?php echo htmlspecialchars($item_busca); ?>">
                <button type="submit" class="btn-busca">
                    🔍 </button>
            </form>

            <?php if (!empty($item_busca)): ?>
                <div style="text-align: center; margin-top: 10px;">
                    <span style="color: #666; font-size: 14px;">Mostrando resultados para: <strong><?php echo htmlspecialchars($item_busca); ?></strong></span>
                    <a href="index.php" style="color: #ff4d4d; text-decoration: none; margin-left: 10px; font-weight: bold; font-size: 14px;">✖ Limpar</a>
                </div>
            <?php endif; ?>
        </div>

        <?php if (empty($cardapio_agrupado)): ?>
            <div style="text-align: center; padding: 50px; background: white; border-radius: 8px;">
                <h3 style="color: #888;">Nenhum produto disponível no momento.</h3>
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