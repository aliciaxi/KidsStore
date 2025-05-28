<?php
session_start();
include 'db.php';


$cart_items = $_SESSION['cos'] ?? [];

if (empty($cart_items)) {
    header("Location: cos.php");
    exit;
}

$guest_form_submitted = false;
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_guest_order'])) {
    $nume = trim($_POST['nume'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $adresa = trim($_POST['adresa'] ?? '');

    if ($nume === '' || $email === '' || $adresa === '') {
        $errors[] = "Toate campurile sunt obligatorii.";
    }

    if (empty($errors)) {
        // Salvare comanda (doar afisare pt. test acum)
        $guest_form_submitted = true;
        $_SESSION['cos'] = []; // golim cosul dupa trimitere
    }
}
?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Finalizeaza comanda</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 0;
            margin: 0;
        }
        form {
            max-width: 500px;
            margin: auto;
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 10px;
            background-color: #f9f9f9;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        input, textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .errors {
            color: red;
            margin-bottom: 15px;
        }
        .success {
            color: green;
            text-align: center;
        }
        .guest-note {
            text-align: center;
            margin-bottom: 20px;
        }
        .confirmation-box {
            text-align: center;
            background: linear-gradient(to right, #fce4ec, #e3f2fd);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(0,0,0,0.05);
            max-width: 600px;
            margin: 50px auto;
            font-family: 'Arial', sans-serif;
        }
        .confirmation-box .icon {
            font-size: 50px;
            color: #ec407a;
            margin-bottom: 15px;
        }
        .confirmation-box h2 {
            color: #3949ab;
            margin-bottom: 10px;
        }
        .confirmation-box p {
            font-size: 18px;
            color: #555;
            margin-bottom: 30px;
        }
        .confirmation-box .back-home {
            display: inline-block;
            background-color: #ba68c8;
            color: white;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }
        .confirmation-box .back-home:hover {
            background-color: #ab47bc;
        }
    </style>
</head>
<body>

<?php if ($guest_form_submitted): ?>
    <div class="confirmation-box">
        <div class="icon">&#10084;</div>
        <h2>Comanda a fost trimisa cu succes!</h2>
        <p>Iti multumim pentru comanda ta <?php echo isset($_SESSION['user']) ? 'ca si client.' : 'ca invitat.'; ?></p>
        <a class="back-home" href="index.php">⟵ Inapoi la homepage</a>
    </div>

<?php else: ?>

    <h2 style="text-align:center;">Finalizeaza comanda</h2>

    <?php if (isset($_SESSION['user'])): ?>
        <p class="guest-note">Esti logat ca si client. Comanda ta va fi asociata contului tau.</p>
    <?php else: ?>
        <p class="guest-note">Comanzi ca invitat. Daca doresti, poti <a href="login_client.php">sa iti faci cont</a> pentru a urmari comenzile mai usor.</p>
    <?php endif; ?>

    <?php if (!empty($errors)): ?>
        <div class="errors">
            <?php foreach ($errors as $error): ?>
                <p><?= htmlspecialchars($error) ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="post">
        <label for="nume">Nume complet</label>
        <input type="text" name="nume" id="nume" required>

        <label for="email">Email</label>
        <input type="email" name="email" id="email" required>

        <label for="adresa">Adresa de livrare</label>
        <textarea name="adresa" id="adresa" rows="3" required></textarea>

        <button type="submit" name="submit_guest_order">Trimite comanda</button>
    </form>

<?php endif; ?>

</body>
</html>
