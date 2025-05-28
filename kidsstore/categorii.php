<?php
include "navbar.php";
// Conectare la baza de date
$mysqli = new mysqli('localhost', 'root', '', 'kidsstore', 3307);
if ($mysqli->connect_error) {
    die("Conexiunea a eșuat: " . $mysqli->connect_error);
}

// Adaugă categorie nouă
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["new_category"])) {
    $newCategory = trim($_POST["new_category"]);
    if ($newCategory !== "") {
        $stmt = $mysqli->prepare("INSERT INTO categories (name) VALUES (?)");
        $stmt->bind_param("s", $newCategory);
        $stmt->execute();
    }
}

// Șterge categorie (doar dacă nu e folosită în produse)
if (isset($_POST["delete_category"])) {
    $deleteId = $_POST["delete_category"];
    // Verificăm dacă există produse cu acea categorie
    $check = $mysqli->prepare("SELECT COUNT(*) FROM products WHERE category_id = ?");
    $check->bind_param("i", $deleteId);
    $check->execute();
    $check->bind_result($count);
    $check->fetch();
    $check->close();

    if ($count == 0) {
        $stmt = $mysqli->prepare("DELETE FROM categories WHERE id = ?");
        $stmt->bind_param("i", $deleteId);
        $stmt->execute();
    } else {
        echo "<p style='color:red;'>Categoria nu poate fi ștearsă pentru că este folosită în produse.</p>";
    }
}

// Preluare categorii existente
$categories = $mysqli->query("SELECT * FROM categories");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - Categorii</title>
    <style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 8px;
        }
        input[type="text"] {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <h1>Administrare Categorii</h1>

    <h2>Adaugă o categorie nouă</h2>
    <form method="post" action="categorii.php">
        <input type="text" name="new_category" placeholder="Nume categorie" required>
        <input type="submit" value="Adaugă">
    </form>

    <h2>Categorii existente</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Nume</th>
            <th>Acțiune</th>
        </tr>
        <?php while($row = $categories->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row["id"]) ?></td>
            <td><?= htmlspecialchars($row["name"]) ?></td>
            <td>
                <form method="post" style="display:inline;">
                    <input type="hidden" name="delete_category" value="<?= $row["id"] ?>">
                    <input type="submit" value="Șterge" onclick="return confirm('Sigur vrei să ștergi această categorie?')">
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>

</html>
