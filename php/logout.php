<?php
session_start();
session_unset();    // Remove todas as variáveis de sessão
session_destroy();  // Destroi a sessão

// Redireciona para a página de login após o logout
header("Location: /espaco_lazer/templates/login.php");
exit();
?>
