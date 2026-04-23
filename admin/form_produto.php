<?php
require_once "../config/conexao.php";
require_once "../includes/logado.php";

// Busca as categorias no banco para preencher o <select>
$sql_categorias = "SELECT id, nome FROM categorias ORDER BY nome";
$resultado_categorias = mysqli_query($conexao, $sql_categorias);

include '../includes/header.php';
?>

<div class="main-container" style="max-width: 600px;">
    <h2 style="margin-bottom: 20px;">🍔 Cadastrar Novo Produto</h2>

    <?php if (isset($_GET['erro'])): ?>
        <div style="background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 6px; margin-bottom: 20px;">
            <strong>Erro:</strong> <?php echo htmlspecialchars($_GET['erro']); ?>
        </div>
    <?php endif; ?>

    <form action="processa_produto.php" method="POST" enctype="multipart/form-data">

        <div class="form-group">
            <label>Nome do Produto:</label>
            <input type="text" name="nome" class="input-control" required placeholder="Ex: X-Bacon Supremo">
        </div>

        <div class="form-group">
            <label>Categoria:</label>
            <select name="categoria_id" class="input-control" required>
                <option value="">Selecione uma categoria...</option>
                <?php while ($cat = mysqli_fetch_assoc($resultado_categorias)): ?>
                    <option value="<?php echo $cat['id']; ?>">
                        <?php echo htmlspecialchars($cat['nome']); ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="form-group">
            <label>Descrição (Ingredientes):</label>
            <textarea name="descricao" class="input-control" rows="3" required placeholder="Ex: Pão brioche, hambúrguer 200g, queijo e bacon..."></textarea>
        </div>

        <div class="form-group">
            <label>Preço (R$):</label>
            <input type="text" name="preco" class="input-control" required placeholder="Ex: 35,90">
        </div>

        <div class="form-group">
            <label>Imagem do Produto:</label>
            <input type="file" name="imagem" class="input-control" accept="image/jpeg, image/png, image/jpg, image/webp" style="padding: 9px;">
            <small style="color: #666; display: block; margin-top: 5px;">Formatos aceitos: JPG, PNG, WEBP. Deixe em branco para usar a imagem padrão.</small>
        </div>

        <button type="submit" class="btn btn-block">Salvar Produto</button>
        <a href="dashboard.php" class="btn btn-block btn-voltar" style="text-align: center;">Cancelar e Voltar</a>
    </form>
</div>

<?php include '../includes/footer.php'; ?>