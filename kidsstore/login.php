<?php
session_start();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['username'] ?? '';
    $pass = $_POST['password'] ?? '';

    // Exemplu static (înlocuiește cu verificare în baza de date dacă e cazul)
    if ($user === 'admin' && $pass === 'parola123') {
        $_SESSION['logged_in'] = true;
        header('Location: adauga.php');
        exit;
    } else {
        $error = 'Utilizator sau parola incorecta.';
    }
}
?>

<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Login - LittleOnes</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to right, #fce4ec, #e1f5fe);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-box {
            background-color: #fff;
            padding: 40px 30px;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            width: 350px;
            text-align: center;
        }

        .login-box h2 {
            color: #e91e63;
            margin-bottom: 20px;
        }

        .login-box input[type="text"],
        .login-box input[type="password"] {
            width: 100%;
            padding: 12px 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 10px;
        }

        .login-box input[type="submit"] {
            background-color: #e91e63;
            color: #fff;
            padding: 12px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            width: 100%;
            font-weight: 600;
        }

        .login-box input[type="submit"]:hover {
            background-color: #d81b60;
        }

        .error {
            color: red;
            margin-top: 10px;
        }

        .show-pass {
            font-size: 14px;
            display: flex;
            align-items: center;
            margin-top: 5px;
        }

        .show-pass input {
            margin-right: 6px;
        }
    </style>
</head>
<body>
    <form class="login-box" method="POST" action="">
        <h2>Autentificare Admin</h2>
        <input type="text" name="username" placeholder="Utilizator" required>
        <input type="password" id="password" name="password" placeholder="Parola" required>
        <div class="show-pass">
            <input type="checkbox" onclick="togglePassword()"> Arata parola
        </div>
        <input type="submit" value="Login">
        <?php if (!empty($error)): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
    </form>

    <script>
        function togglePassword() {
            var passInput = document.getElementById("password");
            passInput.type = passInput.type === "password" ? "text" : "password";
        }
    </script>
</body>
</html>
