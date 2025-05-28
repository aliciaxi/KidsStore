<?php
include 'db.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


$search = isset($_GET['q']) ? trim($_GET['q']) : '';
$products = [];

if (!empty($search)) {
    $stmt = $conn->prepare("SELECT * FROM products WHERE name LIKE CONCAT('%', ?, '%') OR description LIKE CONCAT('%', ?, '%')");
    $stmt->bind_param("ss", $search, $search);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Rezultate cautare</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 0;
            margin: 0;
            background-color: #fffafc;
        }
        h1 {
            color: #e91e63;
        }
        .product {
            border: 1px solid #eee;
            padding: 15px;
            margin-bottom: 15px;
            display: flex;
            gap: 15px;
            align-items: center;
        }
        .product img {
            width: 100px;
            height: auto;
            border-radius: 8px;
            border: 1px solid #ccc;
        }
        .product-info {
            flex: 1;
        }
        .product-info h3 {
            margin: 0;
        }
    </style>
</head>
<body>

<h1>Rezultate pentru: <?= htmlspecialchars($search) ?></h1>

<?php if (count($products) > 0): ?>
    <?php foreach ($products as $prod): ?>
        <div class="product">
            <?php
                $img = !empty($prod['image_url']) ? htmlspecialchars($prod['image_url']) : 'images/placeholder.png';
            ?>
            <img src="<?= $img ?>" alt="<?= htmlspecialchars($prod['name']) ?>">
            <div class="product-info">
                <h3><?= htmlspecialchars($prod['name']) ?></h3>
                <p><?= htmlspecialchars($prod['description']) ?></p>
                <strong><?= htmlspecialchars($prod['price']) ?> lei</strong>
            </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>Nu s-au gasit produse care sa corespunda cautarii.</p>
<?php endif; ?>

</body>
</html>
