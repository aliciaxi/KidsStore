<?php
session_start();
include 'db.php';

// Categorii
$categorii = $conn->query("SELECT * FROM categories");

// Filtru categorie
$filtru = isset($_GET['categorie']) ? intval($_GET['categorie']) : 0;

$sql = "SELECT products.id, products.name, products.price, products.image_url, categories.name AS category_name
        FROM products
        JOIN categories ON products.category_id = categories.id";
if ($filtru) {
    $sql .= " WHERE category_id = $filtru";
}
$sql .= " ORDER BY products.id DESC LIMIT 20";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>LittleOnes - Acasa</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #fdf6ff;
            margin: 0;
            padding: 0;
        }

        .main-content {
            display: flex;
            max-width: 1200px;
            margin: 20px auto;
            gap: 20px;
        }

        aside {
            width: 220px;
            background: #fff;
            border-radius: 16px;
            padding: 15px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }

        aside h3 {
            margin-bottom: 15px;
            color: #e91e63;
        }

        aside a {
            display: block;
            margin-bottom: 10px;
            color: #333;
            text-decoration: none;
            font-weight: 500;
        }

        aside a:hover {
            color: #e91e63;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 20px;
            flex: 1;
        }

        .product {
            background: white;
            border-radius: 16px;
            padding: 15px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            transition: transform 0.2s;
            position: relative;
        }

        .product:hover {
            transform: scale(1.03);
        }

        .product img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 12px;
        }

        .product h3 {
            font-size: 1.1rem;
            margin: 10px 0 5px;
            color: #333;
        }

        .product p {
            margin: 5px 0;
        }

        .price {
            color: #e91e63;
            font-weight: bold;
        }

        .category {
            background-color: #fce4ec;
            color: #880e4f;
            padding: 4px 10px;
            border-radius: 12px;
            display: inline-block;
            font-size: 0.8rem;
        }

        .btn, .fav-btn, .details-btn {
            display: inline-block;
            margin-top: 8px;
            padding: 6px 12px;
            background-color: #a2d4f7;
            color: #fff;
            border: none;
            border-radius: 10px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s;
            cursor: pointer;
        }

        .btn:hover, .details-btn:hover {
            background-color: #7bc1ef;
        }

        .details-btn {
            background-color: #ce93d8;
        }

        .details-btn:hover {
            background-color: #ba68c8;
        }

        .btn-group {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 10px;
        }

        .fav-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background: transparent;
            font-size: 20px;
            color: #e91e63;
            border: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h1 style="text-align:center; color:#e91e63; margin-top:20px;">Cele mai populare produse</h1>

    <div class="main-content">
        <!-- Categorii -->
        <aside>
            <h3>Categorii</h3>
            <a href="index.php">Toate</a>
            <?php while ($cat = $categorii->fetch_assoc()): ?>
                <a href="index.php?categorie=<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></a>
            <?php endwhile; ?>
        </aside>

        <!-- Produse -->
        <div class="product-grid">
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="product">
                        <form method="post" action="adauga_in_cos.php">
                            <input type="hidden" name="product_id" value="<?= $row['id'] ?>">

                            <button type="submit" class="fav-btn" formaction="adauga_in_wishlist.php" title="Adauga la favorite">❤️</button>

                            <a href="produs.php?id=<?= $row['id'] ?>">
                                <img src="<?= htmlspecialchars($row["image_url"]) ?>" alt="Imagine produs">
                            </a>

                            <h3>
                                <a href="produs.php?id=<?= $row['id'] ?>" style="text-decoration:none; color:inherit;">
                                    <?= htmlspecialchars($row['name']) ?>
                                </a>
                            </h3>

                            <p class="price"><?= number_format($row['price'], 2) ?> RON</p>
                            <p class="category"><?= htmlspecialchars($row['category_name']) ?></p>

                            <div class="btn-group">
                                <a href="produs.php?id=<?= $row['id'] ?>" class="details-btn">Detalii produs</a>
                                <button type="submit" class="btn">Adauga in cos</button>
                            </div>
                        </form>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>Nu sunt produse disponibile.</p>
            <?php endif; ?>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>
