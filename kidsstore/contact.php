
<!DOCTYPE html>
<html lang="ro">
<head>
    <meta charset="UTF-8">
    <title>Contact KidsStore</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #fdf6ff;
            margin: 0;
            padding: 0;
        }

        .contact-container {
    max-width: 600px;
    margin: 80px auto 40px; /* adaugam spatiu de sus */
    background: white;
    padding: 2rem;
    border-radius: 16px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}

        h2 {
            text-align: center;
            color: #e91e63;
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
            color: #333;
        }

        input, textarea {
            width: 100%;
            padding: 10px;
            margin-top: 6px;
            border: 1px solid #ccc;
            border-radius: 10px;
        }

        button {
            background-color: #a2d4f7;
            color: white;
            border: none;
            padding: 10px 16px;
            border-radius: 12px;
            margin-top: 15px;
            cursor: pointer;
            font-weight: bold;
        }

        button:hover {
            background-color: #7bc1ef;
        }
    </style>
</head>
<body>

<?php include "navbar.php"; ?>

    <div class="contact-container">
        <h2>Contactează-ne</h2>
        <form action="#" method="post">
            <label for="name">Nume</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>

            <label for="message">Mesaj</label>
            <textarea id="message" name="message" rows="5" required></textarea>

            <button type="submit">Trimite mesajul</button>
        </form>
    </div>
</body>
</html>
