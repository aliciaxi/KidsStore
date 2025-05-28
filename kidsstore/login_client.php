<?php
session_start();
include 'db.php';

$eroare = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email !== '' && $password !== '') {
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND role = 'client' LIMIT 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $rezultat = $stmt->get_result();

        if ($rezultat->num_rows === 1) {
            $user = $rezultat->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION['client_logged_in'] = true;
                $_SESSION['client_id'] = $user['id'];
                $_SESSION['client_username'] = $user['username'];

                header("Location: finalizeaza_comanda.php");
                exit;
            } else {
                $eroare = "Parola incorecta.";
            }
        } else {
            $eroare = "Utilizatorul nu a fost gasit sau nu este client.";
        }
    } else {
        $eroare = "Te rugam sa completezi toate campurile.";
    }
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Login Client</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 0px;
            margin: 0;
        }
        form {
            max-width: 400px;
            margin: auto;
            padding: 20px;
            border-radius: 10px;
            background: #f9f9f9;
            box-shadow: 0 0 10px #ccc;
        }
        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
        }
        .error {
            color: red;
            margin-bottom: 15px;
            text-align: center;
        }
    </style>
</head>
<body>

<h2 style="text-align:center;">Autentificare Client</h2>

<?php if ($eroare): ?>
    <div class="error"><?= htmlspecialchars($eroare) ?></div>
<?php endif; ?>

<form method="post">
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Parola" required>
    <button type="submit">Login</button>
</form>

</body>
</html>
