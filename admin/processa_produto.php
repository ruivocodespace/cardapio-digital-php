<<<<<<< Updated upstream
=======
<?php
// Inciar sessão
session_start();

// Verificações
require_once "../config/conexao.php";
require_once "../includes/logado.php";

// Verificar se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Recebendo os dados do formulário
    $nome         = mysqli_real_escape_string($conexao, $_POST["nome"]);
    $descricao    = mysqli_real_escape_string($conexao, $_POST["descricao"]);
    $categoria_id = intval($_POST["categoria_id"]);

    // Formatação do preço
    $preco_formatado = str_replace(',', '.', $_POST["preco"]);
    $preco           = mysqli_real_escape_string($conexao, $preco_formatado);

    // Imagem padrão padronizada quando nao tiver img
    $nome_img = "sem-foto.jpg";
    $erro = "";

    // LÓGICA DE UPLOAD DA IMAGEM
    $pasta_destino = "../uploads/produtos/";

    // Verifica se foi enviada uma nova imagem
    if (isset($_FILES['imagem']) && $_FILES['imagem']['size'] > 0) {

        // Pega extensão
        $extensao = strtolower(pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION));
        $extensoes_permitidas = ['jpg', 'jpeg', 'png', 'webp'];

        if (!in_array($extensao, $extensoes_permitidas)) {
            $erro = "Formato de imagem inválido.";
        } else {
            // Gera nome único para a imagem
            $novo_nome_imagem = uniqid() . "." . $extensao;

            // Move imagem para pasta uploads
            if (move_uploaded_file($_FILES['imagem']['tmp_name'], $pasta_destino . $novo_nome_imagem)) {
                $nome_img = $novo_nome_imagem; // Atualiza a variável com o novo nome
            } else {
                $erro = "Erro ao salvar a imagem na pasta.";
            }
        }
    }

    // Se não houve erro no upload:
    if (empty($erro)) {

        // Verificar se já existe um produto com o mesmo nome
        $sql_busca = "SELECT id FROM produtos WHERE nome = '$nome'";
        $resultado_busca = mysqli_query($conexao, $sql_busca);

        if (mysqli_num_rows($resultado_busca) > 0) {
            $erro = "Já existe um produto cadastrado com este nome.";
        } else {
            // INSERT
            $sql_salvar = "INSERT INTO produtos (categoria_id, nome, descricao, preco, imagem)
            VALUES ('$categoria_id', '$nome', '$descricao', '$preco', '$nome_img')";

            // Executa o salvamento
            if (mysqli_query($conexao, $sql_salvar)) {
                header("Location: dashboard.php?sucesso=Produto adicionado com sucesso");
                exit;
            } else {
                $erro = "Erro ao salvar no banco: " . mysqli_error($conexao);
            }
        }
    }

    // Redirecionamento de erro
    if (!empty($erro)) {
        header("Location: form_produto.php?erro=" . urlencode($erro));
        exit;
    }
} else {
    // Bloqueia acesso direto pela URL
    header("Location: dashboard.php");
    exit;
}
>>>>>>> Stashed changes
