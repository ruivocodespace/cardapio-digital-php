<?php
if (!isset($_SESSION)) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciador de Cardápio</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>

<body>

    <?php
    // O menu só aparece se o usuário estiver logado
    if (isset($_SESSION['logado']) && $_SESSION['logado'] === true):
    ?>
        <header class="navbar">
            <div class="nav-container">
                <h1 class="logo">🍔 Sistema Cardápio</h1>
                <nav class="nav-links">
                    <a href="dashboard.php" class="nav-link">Dashboard</a>
                    <a href="../index.php" class="nav-link">Cardápio</a>
                    <a href="../logout.php" class="nav-link btn-sair-nav">Sair</a>
                </nav>
            </div>
        </header>
    <?php endif; ?>