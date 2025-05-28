<?php session_start(); ?>
<?php include 'navbar.php'; ?>
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Jucarii pentru baieti - KidsStore</title>
    <style>
    body {
        font-family: 'Poppins', sans-serif;
        background-color: #e1f5fe;
        margin: 0;
    }

    .titlu {
        text-align: center;
        color: #0288d1;
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
        border: 1px solid #b3e5fc;
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
        color: #0288d1;
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
        background: #4fc3f7;
        color: white;
        padding: 6px 12px;
        border-radius: 8px;
        cursor: pointer;
    }

    .butoane button:hover {
        background: #0288d1;
    }
</style>

</head>
<body>

<h1 class="titlu">Jucarii pentru baieti</h1>

<div class="container">
    <?php
    $produse_baieti = [
        ["carucior-baieti.jpg", "Carucior pliabil", 399],
        ["catelus-interactiv.jpg", "Catelus interactiv", 79],
        ["chitara-baieti.jpg", "Chitara", 129],
        ["cort-baieti.jpg", "Cort pentru baietei", 249],
        ["leagan-baieti.jpg", "Leagan automat", 199],
        ["lego-star-wars.jpg", "Lego Star Wars", 149],
        ["masina-cu-spatar.jpg", "Masina decapotata de jucarie", 89],
        ["masina-sport.jpg", "Masina sport", 99],
        ["pian-baieti.jpg", "Pian de jucarie", 99],
        ["plus-baieti.jpg", "Stitch", 59],
        ["puzzle-numere.jpg", "Puzzle cu numere", 39],
        ["transformers.jpg", "Jucarie Transformers - Optimus Prime", 179]
    ];

    foreach ($produse_baieti as $produs) {
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
                    <input type="hidden" name="redirect" value="cos.php">
                    <button type="submit">Adauga in cos</button>
                </form>

                <form method="post" action="adauga_in_wishlist.php">
                    <input type="hidden" name="produs" value="' . $produs[1] . '">
                    <input type="hidden" name="imagine" value="images/' . $produs[0] . '">
                    <input type="hidden" name="pret" value="' . $produs[2] . '">
                    <input type="hidden" name="redirect" value="wishlist.php">
                    <button type="submit" name="adauga_wishlist">❤</button>
                </form>
            </div>
        </div>';
    }
    ?>
</div>
</body>
</html>
