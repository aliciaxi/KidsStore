<?php
session_start();
include 'db.php';

// Initializeaza wishlist daca nu exista
if (!isset($_SESSION['wishlist'])) {
    $_SESSION['wishlist'] = [];
}

// Sterge din wishlist
if (isset($_GET['remove'])) {
    $remove_id = intval($_GET['remove']);
    $_SESSION['wishlist'] = array_filter($_SESSION['wishlist'], function ($id) use ($remove_id) {
        return $id != $remove_id;
    });
    if (empty($_SESSION['wishlist'])) {
        unset($_SESSION['wishlist']);
    }
}

// Adauga in cos
if (isset($_GET['adauga_in_cos'])) {
    $id = intval($_GET['adauga_in_cos']);
    if (isset($_SESSION['cos'][$id])) {
        $_SESSION['cos'][$id]++;
    } else {
        $_SESSION['cos'][$id] = 1;
    }
    // Sterge din wishlist dupa adaugare in cos
    $_SESSION['wishlist'] = array_filter($_SESSION['wishlist'], function ($wid) use ($id) {
        return $wid != $id;
    });
    if (empty($_SESSION['wishlist'])) {
        unset($_SESSION['wishlist']);
    }
}

// Obține produsele din wishlist
$wishlist_items = isset($_SESSION['wishlist']) ? $_SESSION['wishlist'] : [];

if (count($wishlist_items) > 0) {
    $ids = implode(",", array_map('intval', $wishlist_items));
    $sql = "SELECT * FROM products WHERE id IN ($ids)";
    $result = $conn->query($sql);
} else {
    $result = false;
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Favorite</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #fff;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #f9f9f9;
            border-radius: 12px;
            overflow: hidden;
        }

        th, td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        img {
            width: 80px;
            height: auto;
            border-radius: 10px;
        }

        .btn {
            padding: 8px 15px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            transition: 0.3s;
        }

        .btn-remove {
            background-color: transparent;
            color: red;
        }

        .btn-adauga {
            background-color: #e91e63;
            color: white;
        }

        .btn-adauga:hover {
            background-color: #c2185b;
        }

        .btn-remove:hover {
            text-decoration: underline;
        }

        p.empty {
            text-align: center;
            font-size: 1.2rem;
            color: #888;
        }
    </style>
</head>
<body>

<h1 style="text-align:left; margin: 30px 50px;">Produse Favorite</h1>

<?php if ($result && $result->num_rows > 0): ?>
    <table>
        <thead>
            <tr>
                <th>Imagine</th>
                <th>Produs</th>
                <th>Pret</th>
                <th>Actiuni</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><img src="<?= htmlspecialchars($row['image_url']) ?>" alt="<?= htmlspecialchars($row['name']) ?>"></td>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= number_format($row['price'], 2) ?> RON</td>
                    <td>
                        <a href="?adauga_in_cos=<?= $row['id'] ?>" class="btn btn-adauga">Adauga in cos</a>
                        <a href="?remove=<?= $row['id'] ?>" class="btn btn-remove">Sterge</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
<?php else: ?>
    <p class="empty">Nu ai produse in lista de favorite.</p>
<?php endif; ?>

</body>
</html>
