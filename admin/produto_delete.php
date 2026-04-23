<?php
session_start();
require_once "../config/conexao.php";
require_once "../includes/logado.php";

if (isset($_GET["id"])) {

    $id = intval($_GET["id"]);

    // Buscar o nome da capa antes de apagar o produto
    $sql_busca = "SELECT imagem FROM produtos WHERE id = $id";
    $resultado = mysqli_query($conexao, $sql_busca);

    // Verifica se achou o produto
    if ($produto = mysqli_fetch_assoc($resultado)) {

        $nome_img = $produto['imagem'];
        $caminho_imagem = "uploads/produtos/" . $nome_img;

        // Apagar o arquivo de imagem da pasta
        // Só apaga se o arquivo existir e NÃO for a imagem padrão
        if ($nome_img !== 'sem-foto.jpeg' && file_exists($caminho_imagem)) {
            unlink($caminho_imagem); // O unlink serve para deletar o arquivo físico (files)
        }

        // 3. Deletar do banco de dados
        $sql_delete = "DELETE FROM produtos WHERE id = $id";

        if (mysqli_query($conexao, $sql_delete)) {
            // Sucesso! Volta para o dashboard
            header("Location: dashboard.php?sucesso=produto_deletado");
            exit;
        } else {
            // Caso falhe o banco de dados
            header("Location: dashboard.php?erro=Erro ao deletar do banco");
            exit;
        }
    } else {
        // Se o ID não existir no banco
        header("Location: dashboard.php?erro=Produto não encontrado");
        exit;
    }
} else {
    // Redirecionamento caso acessar sem passar o ID na URL
    header("Location: dashboard.php");
    exit;
}
