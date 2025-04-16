<?php
// Si l'utilisateur a cliqué sur le bouton "En savoir plus", on active un cookie
if(isset($_GET['acknowledge'])) {
    setcookie("phishing_awareness", "true", time() + (86400 * 30), "/"); // 30 jours
    header("Location: https://store.steampowered.com/");
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sensibilisation au Phishing - Exercice Éducatif</title>
    <style>
        body {
            background-color: #181a21;
            color: #e9e9e9;
            font-family: "Motiva Sans", Sans-serif;
            margin: 0;
            padding: 20px;
            line-height: 1.6;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #1b2838;
            padding: 30px;
            border-radius: 4px;
            box-shadow: 0 0 20px rgba(0,0,0,0.3);
        }
        h1 {
            color: #fff;
            border-bottom: 1px solid #417a9b;
            padding-bottom: 10px;
            margin-top: 0;
        }
        h2 {
            color: #1999ff;
            margin-top: 25px;
        }
        .warning-box {
            background-color: rgba(217, 65, 38, 0.2);
            border-left: 4px solid #d94126;
            padding: 15px;
            margin: 20px 0;
        }
        .info-box {
            background-color: rgba(26, 159, 255, 0.1);
            border-left: 4px solid #1a9fff;
            padding: 15px;
            margin: 20px 0;
        }
        ul {
            padding-left: 25px;
        }
        li {
            margin-bottom: 8px;
        }
        .button {
            display: inline-block;
            background: linear-gradient(90deg, #06bfff 0, #2d73ff 100%);
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 2px;
            font-weight: bold;
            margin-top: 20px;
            border: none;
            cursor: pointer;
        }
        .button:hover {
            background: linear-gradient(90deg, #06bfff 30%, #2d73ff 100%);
        }
        .footer {
            margin-top: 30px;
            font-size: 14px;
            color: #8f98a0;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Exercice de Sensibilisation au Phishing</h1>
        
        <div class="warning-box">
            <strong>Ceci était un exercice de sensibilisation au phishing</strong>. Vous avez participé à une simulation éducative visant à démontrer comment fonctionnent les attaques de phishing.
        </div>
        
        <h2>Pourquoi cet exercice?</h2>
        <p>Dans le cadre de notre formation en cybersécurité, nous avons créé cette simulation pour:</p>
        <ul>
            <li>Démontrer les techniques utilisées par les cybercriminels</li>
            <li>Sensibiliser aux dangers du phishing</li>
            <li>Vous aider à identifier les signes d'une tentative de phishing</li>
            <li>Renforcer les bonnes pratiques de sécurité</li>
        </ul>
        
        <h2>Comment vous avez été redirigé ici</h2>
        <p>Vous avez scanné un QR code qui vous a mené vers cette réplique du site Steam. Ce type de redirection est une technique courante utilisée dans les attaques de phishing.</p>
        
        <div class="info-box">
            <p><strong>Important:</strong> Les identifiants que vous avez pu saisir sur cette page ne seront utilisés qu'à des fins statistiques anonymes et seront supprimés après analyse. Aucune information ne sera conservée à long terme.</p>
        </div>
        
        <h2>Comment repérer une tentative de phishing</h2>
        <ul>
            <li><strong>Vérifiez toujours l'URL</strong> dans votre navigateur - elle devrait commencer par "https://store.steampowered.com/" pour le vrai site Steam</li>
            <li><strong>Méfiez-vous des QR codes</strong> de source inconnue</li>
            <li><strong>Examinez attentivement les emails</strong> demandant vos informations personnelles</li>
            <li><strong>Activez l'authentification à deux facteurs</strong> sur tous vos comptes importants</li>
            <li><strong>Ne réutilisez jamais vos mots de passe</strong> sur différents sites</li>
        </ul>
        
        <h2>Et maintenant?</h2>
        <p>Si vous avez saisi vos véritables identifiants Steam sur cette page, nous vous recommandons de:</p>
        <ul>
            <li>Changer immédiatement votre mot de passe Steam</li>
            <li>Activer l'authentification à deux facteurs si ce n'est pas déjà fait</li>
            <li>Vérifier régulièrement votre compte pour détecter toute activité suspecte</li>
        </ul>
        
        <a href="?acknowledge=true" class="button">J'ai compris - Me rediriger vers Steam</a>
        
        <div class="footer">
            <p>Cet exercice éducatif a été réalisé dans le cadre d'un projet académique de sensibilisation à la cybersécurité.</p>
        </div>
    </div>
</body>
</html> 