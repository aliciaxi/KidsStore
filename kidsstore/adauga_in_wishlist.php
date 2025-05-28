<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $productId = intval($_POST['product_id']);

    if (!isset($_SESSION['wishlist'])) {
        $_SESSION['wishlist'] = [];
    }

    if (!in_array($productId, $_SESSION['wishlist'])) {
        $_SESSION['wishlist'][] = $productId;
    }

    header("Location: wishlist.php");
    exit;
} else {
    header("Location: index.php");
    exit;
}
