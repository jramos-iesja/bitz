<?php
session_start();

/**
 * Neteja una cadena rebuda de l'usuari.
 * - Elimina espais extrems
 * - Opcionalment es pot afegir més lògica
 */
function neteja_input(string $data): string {
    $data = trim($data);
    return $data;
}

/**
 * Comprova si l'usuari està autenticat.
 */
function is_logged_in(): bool {
    return isset($_SESSION['user_id']);
}

/**
 * Redirigeix i atura l'script.
 */
function redirect(string $url): void {
    header("Location: $url");
    exit;
}

/**
 * Escapa text per mostrar-lo en HTML.
 */
function e(string $str): string {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

