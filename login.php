<?php
session_start();
require_once "config/conexao.php";

$erro = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conexao, $_POST['email']);
    $senha = mysqli_real_escape_string($conexao, $_POST['senha']);

    $sql = "SELECT id, nome FROM usuarios WHERE email = '$email' AND senha = '$senha'";
    $resultado = mysqli_query($conexao, $sql);

    if (mysqli_num_rows($resultado) > 0) {
        $usuario = mysqli_fetch_assoc($resultado);
        $_SESSION['logado'] = true;
        $_SESSION['usuario_nome'] = $usuario['nome'];
        header("Location: admin/dashboard.php");
        exit;
    } else {
        $erro = "E-mail ou senha incorretos!";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Cardápio</title>
    <link rel="stylesheet" href="assets/style.css">
</head>

<body>
    <div class="login-container">
        <h2 style="margin-bottom: 20px; color: #e63946;">🍔 Gerenciar Cardápio</h2>

        <?php if (!empty($erro)) echo "<p style='color: red; margin-bottom: 15px;'>$erro</p>"; ?>

        <form action="" method="POST">
            <div class="form-group">
                <label>E-mail:</label>
                <input type="email" name="email" class="input-control" required placeholder="admin@admin.com">
            </div>
            <div class="form-group">
                <label>Senha:</label>
                <input type="password" name="senha" class="input-control" required placeholder="Digite sua senha">
            </div>
            <button type="submit" class="btn btn-block">Entrar</button>
        </form>
    </div>

</body>

</html>