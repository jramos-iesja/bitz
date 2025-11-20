<?php

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/functions.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = neteja_input($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    // Validacions bàsiques
    if ($username === '') {
        $errors[] = 'Cal indicar un nom d\'usuari.';
    }
    if (strlen($password) < 6) {
        $errors[] = 'La contrasenya ha de tenir almenys 6 caràcters.';
    }

    if (empty($errors)) {
        // Comprovem si ja existeix l'usuari
        $stmt = $pdo->prepare('SELECT id FROM users WHERE username = ?');
        $stmt->execute([$username]);
        if ($stmt->fetch()) {
            $errors[] = 'Aquest nom d\'usuari ja existeix.';
        } else {
            // password_hash ja genera hash + salt
            $hash = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $pdo->prepare(
                'INSERT INTO users (username, password_hash) VALUES (?, ?)'
            );
            $stmt->execute([$username, $hash]);

            // Login automàtic després de registrar
            $_SESSION['user_id'] = $pdo->lastInsertId();
            $_SESSION['username'] = $username;

            redirect('bitz.php');
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Registre</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <h1>Registre</h1>
</header>
<main>
    <?php if ($errors): ?>
        <div class="alert">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="post" action="register.php" class="card">
        <label>
            Nom d'usuari:
            <input type="text" name="username" required>
        </label>
        <label>
            Contrasenya:
            <input type="password" name="password" required minlength="6">
        </label>
        <button type="submit" class="btn">Registrar-se</button>
    </form>

    <p><a href="index.php">Tornar a l'inici</a></p>
</main>
</body>
</html>

