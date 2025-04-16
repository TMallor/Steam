<?php
// Redirection après un court délai vers la page éducative
header("refresh:5;url=education.php");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion en cours...</title>
    <style>
        body {
            background-color: #181a21;
            color: #e9e9e9;
            font-family: "Motiva Sans", Sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            padding: 20px;
            text-align: center;
        }
        .container {
            max-width: 600px;
        }
        .loader {
            border: 5px solid #32353c;
            border-radius: 50%;
            border-top: 5px solid #1999ff;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
            margin: 20px auto;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        h1 {
            color: #fff;
            font-size: 24px;
            font-weight: 300;
        }
        p {
            color: #afafaf;
            font-size: 16px;
            line-height: 1.5;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Connexion en cours...</h1>
        <div class="loader"></div>
        <p>Merci de patienter pendant que nous vérifions vos identifiants.</p>
        <p>Vous allez être redirigé automatiquement dans quelques secondes.</p>
    </div>
</body>
</html> 