<?php
require_once "../config/conexao.php";
require_once "../includes/logado.php";

// Verifica se o ID foi passado na URL
if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit;
}
$id = intval($_GET['id']);

// Busca os dados do produto atual para preencher o formulário
$sql_produto = "SELECT * FROM produtos WHERE id = $id";
$resultado_produto = mysqli_query($conexao, $sql_produto);
$produto = mysqli_fetch_assoc($resultado_produto);

if (!$produto) {
    header("Location: dashboard.php");
    exit;
}

// Busca as categorias para montar o select
$sql_categorias = "SELECT id, nome FROM categorias ORDER BY nome";
$resultado_categorias = mysqli_query($conexao, $sql_categorias);

include '../includes/header.php';
?>

<div class="main-container" style="max-width: 600px;">
    <h2 style="margin-bottom: 20px;">✏️ Editar Produto</h2>

    <?php if (isset($_GET['erro'])): ?>
        <div style="background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 6px; margin-bottom: 20px;">
            <strong>Erro:</strong> <?php echo htmlspecialchars($_GET['erro']); ?>
        </div>
    <?php endif; ?>

    <form action="atualiza_produto.php" method="POST" enctype="multipart/form-data">

        <input type="hidden" name="id" value="<?php echo $produto['id']; ?>">
        <input type="hidden" name="imagem_antiga" value="<?php echo $produto['imagem']; ?>">

        <div class="form-group">
            <label>Nome do Produto:</label>
            <input type="text" name="nome" class="input-control" value="<?php echo htmlspecialchars($produto['nome']); ?>" required>
        </div>

        <div class="form-group">
            <label>Categoria:</label>
            <select name="categoria_id" class="input-control" required>
                <?php while ($cat = mysqli_fetch_assoc($resultado_categorias)): ?>
                    <option value="<?php echo $cat['id']; ?>" <?php if ($cat['id'] == $produto['categoria_id']) echo 'selected'; ?>>
                        <?php echo htmlspecialchars($cat['nome']); ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="form-group">
            <label>Descrição:</label>
            <textarea name="descricao" class="input-control" rows="3" required><?php echo htmlspecialchars($produto['descricao']); ?></textarea>
        </div>

        <div class="form-group">
            <label>Preço (R$):</label>
            <input type="text" name="preco" class="input-control" value="<?php echo number_format($produto['preco'], 2, ',', ''); ?>" required>
        </div>

        <div class="form-group">
            <label>Imagem do Produto:</label>

            <?php if ($produto['imagem'] != 'sem-foto.jpg'): ?>
                <div style="margin-bottom: 15px; border: 1px solid #ddd; padding: 10px; border-radius: 8px; display: inline-block; background: #fff;">
                    <span style="display: block; font-size: 12px; color: #666; margin-bottom: 5px;">Imagem atual:</span>
                    <img src="../uploads/produtos/<?php echo $produto['imagem']; ?>" alt="Imagem atual" style="max-width: 120px; border-radius: 4px;">
                </div>
            <?php endif; ?>

            <input type="file" name="imagem" class="input-control" accept="image/jpeg, image/png, image/jpg, image/webp" style="padding: 9px;">
            <small style="color: #666; display: block; margin-top: 5px;">Selecione um arquivo <strong>apenas</strong> se quiser trocar a foto atual.</small>
        </div>

        <button type="submit" class="btn btn-block">Salvar Alterações</button>
        <a href="dashboard.php" class="btn btn-block btn-voltar" style="text-align: center;">Cancelar e Voltar</a>
    </form>
</div>

<?php include '../includes/footer.php'; ?>