<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $sql = "SELECT products.name, products.price, products.description, products.image_url, categories.name AS category_name
            FROM products
            JOIN categories ON products.category_id = categories.id
            WHERE products.id = $id";
    $result = $conn->query($sql);
} else {
    die("Produsul nu a fost specificat.");
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Detalii produs</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #fdeaff;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 700px;
            margin: auto;
            background: white;
            border-radius: 20px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            overflow: hidden;
            text-align: center;
        }

        .product-image {
            width: 100%;
            height: auto;
            display: block;
        }

        h1 {
            color: #e91e63;
            font-size: 26px;
            margin: 20px 0 10px;
        }

        .price {
            font-size: 20px;
            color: #e91e63;
            margin-bottom: 10px;
        }

        .category {
            background-color: #fce4ec;
            color: #880e4f;
            padding: 6px 14px;
            border-radius: 12px;
            display: inline-block;
            margin-bottom: 15px;
            font-size: 14px;
        }

        .description {
            margin: 0 30px 20px;
            color: #555;
            font-size: 15px;
        }

        a.btn {
            display: inline-block;
            margin: 20px;
            padding: 10px 20px;
            background-color: #90caf9;
            color: white;
            text-decoration: none;
            border-radius: 10px;
            font-weight: bold;
        }

        a.btn:hover {
            background-color: #64b5f6;
        }
    </style>
</head>
<body>

<?php
if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $img = htmlspecialchars($row['image_url']);
?>

<div class="container">
    <img class="product-image" src="<?= $img ?>" alt="Produs">
    <h1><?= htmlspecialchars($row['name']) ?></h1>
    <div class="price"><?= number_format($row['price'], 2) ?> RON</div>
    <div class="category"><?= htmlspecialchars($row['category_name']) ?></div>
    <div class="description"><?= htmlspecialchars($row['description']) ?></div>
    <a href="index.php" class="btn">Înapoi la produse</a>
</div>

<?php
} else {
    echo "<p style='text-align:center; padding:40px;'>Produsul nu a fost găsit.</p>";
}
$conn->close();
?>

</body>
</html>
