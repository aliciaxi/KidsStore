<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $productId = intval($_POST['product_id']);

    // Initializam cosul daca nu exista
    if (!isset($_SESSION['cos'])) {
        $_SESSION['cos'] = [];
    }

    // Daca produsul deja exista in cos, incrementam cantitatea
    if (isset($_SESSION['cos'][$productId])) {
        $_SESSION['cos'][$productId]++;
    } else {
        $_SESSION['cos'][$productId] = 1;
    }
}

header("Location: index.php");
exit;
