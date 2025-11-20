<?php

//error_reporting(E_ALL);
//ini_set('display_errors', 1);

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/functions.php';

if (!is_logged_in()) {
    redirect('login.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bitz_id = isset($_POST['bitz_id']) ? (int) $_POST['bitz_id'] : 0;
    $vote_str = $_POST['vote'] ?? '';

    if ($bitz_id > 0 && in_array($vote_str, ['up', 'down'], true)) {
        $value = $vote_str === 'up' ? 1 : -1;

        // Primera comprovació: el bitz existeix?
        $stmt = $pdo->prepare('SELECT id FROM bitz WHERE id = ?');
        $stmt->execute([$bitz_id]);
        if ($stmt->fetch()) {
            // Guardem o actualitzem el vot
            $stmt = $pdo->prepare("
                INSERT INTO votes (user_id, bitz_id, value)
                VALUES (:user_id, :bitz_id, :value)
                ON DUPLICATE KEY UPDATE value = :value_up
            ");
            //var_dump($stmt->debugDumpParams());

            $stmt->execute([
                ':user_id' => $_SESSION['user_id'],
                ':bitz_id' => $bitz_id,
                ':value' => $value,
                ':value_up' => $value
            ]);
        }
    }

    // Si la petició ve via fetch() (AJAX) retornem JSON
    if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {

        // Recalculem el rànquing d'aquest bitz
        $stmt = $pdo->prepare("
            SELECT COALESCE(SUM(value), 0) AS ranking
            FROM votes
            WHERE bitz_id = ?
        ");
        $stmt->execute([$bitz_id]);
        $ranking = (int) $stmt->fetchColumn();

        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'ranking' => $ranking]);
        exit;
    }

    // Si no és AJAX, tornem a la llista
    redirect('bitz.php');
}

redirect('bitz.php');

