<?php
session_start();
require_once "../config/conexao.php";
require_once "../includes/logado.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Recebe o ID do campo oculto para saber quem atualizar
    $id = intval($_POST["id"]);

    // Recebe os dados textuais
    $nome         = mysqli_real_escape_string($conexao, $_POST["nome"]);
    $descricao    = mysqli_real_escape_string($conexao, $_POST["descricao"]);
    $categoria_id = intval($_POST["categoria_id"]);

    // Tratamento do preço (Vírgula para Ponto)
    $preco_formatado = str_replace(',', '.', $_POST["preco"]);
    $preco           = mysqli_real_escape_string($conexao, $preco_formatado);

    // Recebe a imagem antiga caso nenhuma nova seja enviada
    $nome_img = $_POST["imagem_antiga"];
    $erro = "";

    // LÓGICA DE UPLOAD DA NOVA IMAGEM (Se existir)
    if (isset($_FILES['imagem']) && $_FILES['imagem']['size'] > 0) {
        $pasta_destino = "../uploads/produtos/";
        $extensao = strtolower(pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION));
        $extensoes_permitidas = ['jpg', 'jpeg', 'png', 'webp'];

        if (!in_array($extensao, $extensoes_permitidas)) {
            $erro = "Formato de imagem inválido. Use JPG, PNG ou WEBP.";
        } else {
            $novo_nome_imagem = uniqid() . "." . $extensao;

            if (move_uploaded_file($_FILES['imagem']['tmp_name'], $pasta_destino . $novo_nome_imagem)) {

                // Apagar a imagem antiga fisicamente da pasta para economizar espaço
                $caminho_img_antiga = $pasta_destino . $nome_img;
                if ($nome_img !== 'sem-foto.jpg' && file_exists($caminho_img_antiga)) {
                    unlink($caminho_img_antiga);
                }

                // Substitui a variável da imagem pelo nome da imagem nova
                $nome_img = $novo_nome_imagem;
            } else {
                $erro = "Erro ao salvar a nova imagem.";
            }
        }
    }

    // Se não houver erro na imagem, atualiza no banco
    if (empty($erro)) {
        // UPDATE em vez de INSERT
        $sql_atualizar = "UPDATE produtos SET 
                            categoria_id = '$categoria_id', 
                            nome = '$nome', 
                            descricao = '$descricao', 
                            preco = '$preco', 
                            imagem = '$nome_img' 
                          WHERE id = $id";

        if (mysqli_query($conexao, $sql_atualizar)) {
            header("Location: dashboard.php?sucesso=Produto atualizado com sucesso!");
            exit;
        } else {
            $erro = "Erro ao atualizar no banco: " . mysqli_error($conexao);
        }
    }

    // Se deu erro, volta para a tela de edição
    if (!empty($erro)) {
        header("Location: produto_edit.php?id=$id&erro=" . urlencode($erro));
        exit;
    }
} else {
    header("Location: dashboard.php");
    exit;
}
