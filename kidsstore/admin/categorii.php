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
    <title>Admin - Categorii</title>
    <style>
        body { font-family: 'Poppins', sans-serif; padding: 20px; background-color: #fff5fa; }
        table { width: 50%; border-collapse: collapse; background: white; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
        th { background-color: #e91e63; color: white; }
        input, button { padding: 8px; margin: 5px 0; border-radius: 6px; border: 1px solid #ccc; }
        .btn-logout { float: right; background: #ccc; padding: 6px 12px; border-radius: 6px; text-decoration: none; }
    </style>
</head>
<body>

<h2>Administrare Categorii</h2>
<a href="../logout.php" class="btn-logout">Logout</a>

<form method="post" action="adauga_categorie.php">
    <input type="text" name="name" placeholder="Nume categorie" required>
    <button type="submit">Adaugă</button>
</form>

<table>
    <tr>
        <th>ID</th><th>Nume</th><th>Acțiune</th>
    </tr>
    <?php
    $result = $conn->query("SELECT * FROM categories");
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["id"] . "</td>";
        echo "<td>" . htmlspecialchars($row["name"]) . "</td>";
        echo "<td><form method='post' action='sterge_categorie.php'><input type='hidden' name='id' value='{$row["id"]}'><button type='submit'>Șterge</button></form></td>";
        echo "</tr>";
    }
    $conn->close();
    ?>
</table>

<a href="index.php">← Înapoi la produse</a>

</body>
</html>
