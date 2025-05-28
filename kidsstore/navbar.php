<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Curata cosul de produse cu cantitate zero sau invalide
$_SESSION['cos'] = array_filter($_SESSION['cos'] ?? [], function($qty) {
    return is_numeric($qty) && $qty > 0;
});
$_SESSION['wishlist'] = array_filter($_SESSION['wishlist'] ?? [], function ($val) {
    return is_numeric($val) && $val > 0;
});

// Asigurare sesiuni initialize
$_SESSION['cos'] = $_SESSION['cos'] ?? [];
$_SESSION['wishlist'] = $_SESSION['wishlist'] ?? [];

$cart_count = array_sum($_SESSION['cos']);
$wishlist_count = count($_SESSION['wishlist']);
?>

<style>
    nav {
        background: linear-gradient(to right, #fce4ec, #e1f5fe);
        padding: 15px 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: sticky;
        top: 0;
        z-index: 999;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    }

    nav .logo {
        font-size: 1.5rem;
        color: #e91e63;
        font-weight: bold;
        text-decoration: none;
    }

    nav .menu {
        display: flex;
        gap: 20px;
        align-items: center;
        flex-wrap: wrap;
    }

    nav .menu a {
        text-decoration: none;
        color: #333;
        font-weight: 500;
        padding: 6px 12px;
        border-radius: 8px;
        transition: background 0.2s;
        position: relative;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    nav .menu a:hover {
        background-color: #f8bbd0;
        color: #fff;
    }

    .badge {
        background-color: #e91e63;
        color: white;
        font-size: 10px;
        border-radius: 50%;
        padding: 2px 6px;
        position: absolute;
        top: -6px;
        right: -6px;
    }

    .icon {
        width: 18px;
        height: 18px;
        fill: #e91e63;
    }

    nav .search-box input[type="text"] {
        padding: 6px 10px;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-family: 'Poppins', sans-serif;
    }

    .nav-spacer {
        height: 20px;
    }
</style>

<nav>
    <a class="logo" href="index.php">LittleOnes</a>
    <div class="menu">
        <a href="index.php">Home</a>
        <a href="jocuri-fete.php">Fetite</a>
        <a href="jocuri-baieti.php">Baietei</a>

        <a href="wishlist.php">
            <svg class="icon" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 6 4 4 6.5 4c1.74 0 3.41 1.01 4.13 2.44C11.09 5.01 12.76 4 14.5 4 17 4 19 6 19 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
            Favorite
            <?php if ($wishlist_count > 0): ?>
                <span class="badge"><?= $wishlist_count ?></span>
            <?php endif; ?>
        </a>

        <a href="cos.php">
            <svg class="icon" viewBox="0 0 24 24"><path d="M7 18c-1.1 0-1.99.9-1.99 2S5.9 22 7 22s2-.9 2-2-.9-2-2-2zm10 0c-1.1 0-1.99.9-1.99 2S15.9 22 17 22s2-.9 2-2-.9-2-2-2zM7.16 14h9.68l1.72-7H6l1.16 7zM5 6h14l-1.1 5H6.1L5 6z"/></svg>
            Cos
            <?php if ($cart_count > 0): ?>
                <span class="badge"><?= $cart_count ?></span>
            <?php endif; ?>
        </a>

        <a href="contact.php">Contact</a>

        <?php if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
            <a href="adauga.php">Adauga produs</a>
            <a href="categorii.php">Categorii</a>
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <a href="login.php">Login</a>
        <?php endif; ?>

        <form class="search-box" action="search.php" method="get" style="display: inline-block;">
            <input type="text" name="q" placeholder="Cauta produse...">
        </form>
    </div>
</nav>

<div class="nav-spacer"></div>
