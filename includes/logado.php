<<<<<<< Updated upstream
=======
<?php
session_start();
// Verificar se o usuario está logado
if (!isset($_SESSION["usuario_nome"])) {
    header("Location: ../login.php");
    exit;
}
>>>>>>> Stashed changes
