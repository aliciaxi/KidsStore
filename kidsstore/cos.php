<?php
session_start();
include 'db.php';


// Stergere produs din cos
if (isset($_GET['remove'])) {
    $remove_id = intval($_GET['remove']);
    unset($_SESSION['cos'][$remove_id]);
}
// Sterge produsele cu cantitate zero din cos
$_SESSION['cos'] = array_filter($_SESSION['cos'], function($qty) {
    return is_numeric($qty) && $qty > 0;
});


// Adaugare cantitate
if (isset($_GET['plus'])) {
    $id = intval($_GET['plus']);
    if (isset($_SESSION['cos'][$id])) {
        $_SESSION['cos'][$id]++;
    }
}

// Scadere cantitate
if (isset($_GET['minus'])) {
    $id = intval($_GET['minus']);
    if (isset($_SESSION['cos'][$id])) {
        if ($_SESSION['cos'][$id] > 1) {
            $_SESSION['cos'][$id]--;
        } else {
            unset($_SESSION['cos'][$id]);
        }
    }
}

// Verificare produse in cos
$cart_items = $_SESSION['cos'] ?? [];

if (count($cart_items) > 0) {
    $ids = implode(',', array_keys($cart_items));
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
    <title>Cos de cumparaturi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
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

        .qty-buttons a {
            padding: 4px 10px;
            background-color: #e91e63;
            color: white;
            border-radius: 4px;
            text-decoration: none;
            margin: 0 5px;
        }

        .total {
            text-align: right;
            font-size: 1.2em;
            margin-top: 20px;
        }

        .remove-btn {
            color: red;
            text-decoration: none;
        }

        .btn-finalizeaza {
            display: inline-block;
            background: linear-gradient(to right, #f8bbd0, #b2ebf2); /* roz pastel + albastru pastel */
            color: #000;
            font-weight: bold;
            text-decoration: none;
            padding: 12px 25px;
            border-radius: 30px;
            font-size: 16px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            margin-top: 30px;
        }

        .btn-finalizeaza:hover {
            background: linear-gradient(to right, #f48fb1, #4dd0e1); /* nuante mai intense la hover */
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(0,0,0,0.15);
        }

        .empty {
            text-align: center;
            font-size: 1.2rem;
            color: #888;
        }
    </style>
</head>
<body>
    <h1>Cosul tau</h1>

    <?php if ($result && $result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Imagine</th>
                    <th>Produs</th>
                    <th>Pret</th>
                    <th>Cantitate</th>
                    <th>Total</th>
                    <th>Sterge</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total_general = 0;
                while ($row = $result->fetch_assoc()):
                    $id = $row['id'];
                    if (!isset($cart_items[$id])) continue;

                    $cantitate = $cart_items[$id];
                    $total_pe_produs = $row['price'] * $cantitate;
                    $total_general += $total_pe_produs;
                ?>
                    <tr>
                        <td><img src="<?= htmlspecialchars($row['image_url']) ?>" alt="<?= htmlspecialchars($row['name']) ?>"></td>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td><?= number_format($row['price'], 2) ?> RON</td>
                        <td class="qty-buttons">
                            <a href="?minus=<?= $id ?>">-</a>
                            <?= $cantitate ?>
                            <a href="?plus=<?= $id ?>">+</a>
                        </td>
                        <td><?= number_format($total_pe_produs, 2) ?> RON</td>
                        <td><a class="remove-btn" href="?remove=<?= $id ?>">Sterge</a></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>

        <p class="total"><strong>Total de plata:</strong> <?= number_format($total_general, 2) ?> RON</p>

        <p><a href="finalizeaza_comanda.php" class="btn-finalizeaza">Finalizeaza comanda</a></p>

    <?php else: ?>
        <p class="empty">Cosul este gol.</p>
    <?php endif; ?>
</body>
</html>
