<?php session_start(); ?>
<?php include 'navbar.php'; ?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Jucarii pentru fetite - KidsStore</title>
   <style>
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #fce4ec;
        margin: 0;
    }

    .titlu {
        text-align: center;
        color: #e91e63;
        font-size: 32px;
        margin-top: 20px;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 30px 20px;
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        gap: 25px;
        justify-content: center;
    }

    .produs {
        background: white;
        border-radius: 12px;
        padding: 15px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        text-align: center;
        border: 1px solid #f8bbd0;
        transition: transform 0.2s;
    }

    .produs:hover {
        transform: scale(1.03);
    }

    .produs img {
        width: 100%;
        height: 160px;
        object-fit: contain;
    }

    .produs h4 {
        color: #e91e63;
        font-size: 18px;
        margin: 10px 0;
    }

    .pret {
        color: #333;
        font-weight: bold;
    }

    .butoane {
        margin-top: 10px;
    }

    .butoane form {
        display: inline-block;
        margin-right: 5px;
    }

    .butoane button {
        border: none;
        background: #f48fb1;
        color: white;
        padding: 6px 12px;
        border-radius: 8px;
        cursor: pointer;
    }

    .butoane button:hover {
        background: #e91e63;
    }
</style>

</head>
<body>

<h1 class="titlu">Jucarii pentru fetite</h1>

<div class="container">
    <?php
    $produse_fete = [
        ["bebe.jpg", "Bebelus de jucarie", "49"],
        ["bucatarie.jpg", "Set de bucatarie", "399"],
        ["carucior-fete.jpg", "Carucior pliabil", "450"],
        ["carucior-papusi.JPG", "Carucior de papusi", "119"],
        ["chitara-fete.jpg", "Chitara", "209"],
        ["cort-fete.jpg", "Cort de interior", "349"],
        ["leagan-fete.jpg", "Leagan automat", "509"],
        ["pian-fete.jpg", "Pian electronic", "139"],
        ["plus-fete.jpg", "Stitch roz", "99"],
        ["puzzle-numere.jpg", "Puzzle cu numere", "39"],
        ["castel.jpg", "Castel fermecator", "249"],
         ["set-role.jpg", "Set role reglabil - Pozitionare multipla a rotilor - Fluturi 600x600 ", "249"]
    ];

    foreach ($produse_fete as $index => $produs) {
        echo '
        <div class="produs">
            <img src="images/' . $produs[0] . '" alt="' . $produs[1] . '">
            <h4>' . $produs[1] . '</h4>
            <div class="pret">' . $produs[2] . ' RON</div>
            <div class="butoane">
   <form action="adauga_in_cos.php" method="post">
    <input type="hidden" name="produs" value="' . $produs[1] . '">
    <input type="hidden" name="imagine" value="images/' . $produs[0] . '">
    <input type="hidden" name="pret" value="' . $produs[2] . '">
    <button type="submit">Adauga in cos</button>
</form>



                <form method="post" action="adauga_in_wishlist.php">
    <input type="hidden" name="produs" value="' . $produs[1] . '">
    <input type="hidden" name="imagine" value="images/' . $produs[0] . '">
    <input type="hidden" name="pret" value="' . $produs[2] . '">
    <input type="hidden" name="redirect" value="wishlist.php"> <!-- ACESTA E CHEIA -->
    <button type="submit" name="adauga_wishlist">❤</button>
</form>

            </div>
        </div>';
    }
    ?>
</div>
</body>
</html>
