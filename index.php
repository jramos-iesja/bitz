<?php
require_once __DIR__ . '/functions.php';
?>
<!DOCTYPE html>
<html lang="ca">
    <head>
        <meta charset="UTF-8">
        <title>BitZ - Aprendre a Bocinets!l</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <header>
            <img src="bitz_banner.png" alt="BitZ - Aprendre a Bocinets">
            <h1>Benvinguts a l'aplicació de BitZ per aprendre a Bocinets</h1>
        </header>

        <main>
            <?php if (is_logged_in()): ?>
                <p>Hola, <?php echo e($_SESSION['username']); ?>!</p>
                <a class="btn" href="bitz.php">Anar a la llista de BitZ</a>
                <a class="btn btn-secondary" href="logout.php">Tancar sessió</a>
            <?php else: ?>
                <p>Inicia sessió o registra't per participar.</p>
                <a class="btn" href="register.php">Registrar-se</a>
                <a class="btn btn-secondary" href="login.php">Iniciar sessió</a>
            <?php endif; ?>
        </main>
    </body>
</html>

