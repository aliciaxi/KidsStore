<?php
include "navbar.php";

session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: ../login.php");
    exit;
}

include '../db.php';
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Admin - Produse</title>
    <style>
        body { font-family: 'Poppins', sans-serif; padding: 20px; background-color: #f9f3ff; }
        table { width: 100%; border-collapse: collapse; background: white; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        th { background-color: #e91e63; color: white; }
        input, select, button { padding: 8px; margin: 5px 0; border-radius: 6px; border: 1px solid #ccc; }
        .btn-logout { float: right; background: #ccc; padding: 6px 12px; border-radius: 6px; text-decoration: none; }
    </style>
</head>
<body>

<h2>Administrare Produse</h2>
<a href="../logout.php" class="btn-logout">Logout</a>

<!-- formular de adaugare produs -->
<form method="post" action="adauga_produs.php" enctype="multipart/form-data">
    <input type="text" name="name" placeholder="Nume produs" required><br>
    <textarea name="description" placeholder="Descriere"></textarea><br>
    <input type="number" step="0.01" name="price" placeholder="Preț" required><br>
    <input type="file" name="image" required><br>
    <select name="category_id" required>
        <option value="">-- Alege o categorie --</option>
        <?php
        $cat = $conn->query("SELECT * FROM categories");
        while ($row = $cat->fetch_assoc()) {
            echo "<option value='{$row["id"]}'>" . htmlspecialchars($row["name"]) . "</option>";
        }
        ?>
    </select><br>
    <button type="submit">Adaugă produs</button>
</form>

<!-- tabel produse -->
<h3>Produse existente</h3>
<table>
    <tr>
        <th>Nume</th><th>Descriere</th><th>Preț</th><th>Imagine</th><th>Categorie ID</th><th>Acțiune</th>
    </tr>
    <?php
    $result = $conn->query("SELECT * FROM products");
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row["name"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["description"]) . "</td>";
        echo "<td>" . number_format($row["price"], 2) . " lei</td>";
        echo "<td><img src='" . htmlspecialchars($row["image_url"]) . "' width='60'></td>";
        echo "<td>" . $row["category_id"] . "</td>";
        echo "<td><form method='post' action='sterge_produs.php'><input type='hidden' name='id' value='{$row["id"]}'><button type='submit'>Șterge</button></form></td>";
        echo "</tr>";
    }
    $conn->close();
    ?>
</table>
<a href="categorii.php">→ Administrare categorii</a>

</body>
</html>
