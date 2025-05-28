<?php
include "navbar.php";
// Conectare la baza de date
$mysqli = new mysqli('localhost', 'root', '', 'kidsstore', 3307);
if ($mysqli->connect_error) {
    die("Conexiunea a eșuat: " . $mysqli->connect_error);
}

// Ștergere produs
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];
    $stmt = $mysqli->prepare("DELETE FROM products WHERE id = ?");
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
}

// Adăugare produs nou
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["name"]) && isset($_POST["category"])) {
    $name = $_POST["name"];
    $description = $_POST["description"];
    $price = $_POST["price"];
    $category = $_POST["category"];
    $image_url = "";

    // Verificăm dacă s-a încărcat o imagine
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
        $uploadDir = "images/";
        $imageName = basename($_FILES["image"]["name"]);
        $targetFile = $uploadDir . $imageName;

        // Mutăm imaginea în folderul images/
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            $image_url = $targetFile; // Salvăm path-ul complet
        } else {
            echo "Eroare la încărcarea imaginii.";
        }
    }

    // Salvăm produsul în baza de date
    $stmt = $mysqli->prepare("INSERT INTO products (name, description, price, image_url, category_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdss", $name, $description, $price, $image_url, $category);
    $stmt->execute();
}

// Preluare produse existente
$result = $mysqli->query("SELECT * FROM products");

// Preluare categorii pentru dropdown
$category_result = $mysqli->query("SELECT id, name FROM categories");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - Produse</title>
    <style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 0px;
            margin: 0;
        }
        img {
            width: 80px;
        }
        input, textarea, select {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <h1>Adaugă un produs nou</h1>
    <form method="post" action="adauga.php" enctype="multipart/form-data">
        <input type="text" name="name" placeholder="Nume produs" required><br>
        <textarea name="description" placeholder="Descriere"></textarea><br>
        <input type="number" step="0.01" name="price" placeholder="Preț" required><br>
        <input type="file" name="image" accept="image/*" required><br>

        <label for="category">Categorie:</label><br>
        <select name="category" required>
            <option value="">-- Alege o categorie --</option>
            <?php while($cat = $category_result->fetch_assoc()): ?>
                <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
            <?php endwhile; ?>
        </select><br>

        <input type="submit" value="Adaugă produs">
    </form>

    <h2>Produse existente</h2>
    <table>
        <tr>
            <th>Nume</th>
            <th>Descriere</th>
            <th>Preț</th>
            <th>Imagine</th>
            <th>Categorie ID</th>
            <th>Acțiune</th>
        </tr>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row["name"]) ?></td>
            <td><?= htmlspecialchars($row["description"]) ?></td>
            <td><?= htmlspecialchars($row["price"]) ?> lei</td>
            <td>
                <?php if (!empty($row["image_url"])): ?>
                    <img src="<?= htmlspecialchars($row["image_url"]) ?>" alt="Imagine produs">
                <?php else: ?>
                    (fără imagine)
                <?php endif; ?>
            </td>
            <td><?= htmlspecialchars($row["category_id"]) ?></td>
            <td>
                <form method="post" style="display:inline;">
                    <input type="hidden" name="delete_id" value="<?= $row["id"] ?>">
                    <input type="submit" value="Șterge" onclick="return confirm('Sigur vrei să ștergi acest produs?')">
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
