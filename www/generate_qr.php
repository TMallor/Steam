<?php
// Page pour générer des QR codes pour le projet de sensibilisation
// Cette page est protégée par mot de passe pour éviter une utilisation non autorisée

// Paramètres de connexion
$username = "admin";
$password = "securitydemo2023"; // À changer pour un mot de passe plus fort en production

// Vérifier si l'utilisateur est connecté
session_start();
$loggedIn = false;

if (isset($_POST['login'])) {
    if ($_POST['username'] == $username && $_POST['password'] == $password) {
        $_SESSION['admin'] = true;
        $loggedIn = true;
    } else {
        $error = "Identifiants incorrects";
    }
} elseif (isset($_SESSION['admin']) && $_SESSION['admin'] === true) {
    $loggedIn = true;
}

// Paramètres par défaut pour les QR codes
$defaultUrl = (!empty($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'];
$qrCodeGenerated = false;

// Générer un QR code si demandé
if ($loggedIn && isset($_POST['generate'])) {
    $url = !empty($_POST['custom_url']) ? $_POST['custom_url'] : $defaultUrl;
    $size = isset($_POST['size']) ? intval($_POST['size']) : 300;
    $qrCodeUrl = "https://api.qrserver.com/v1/create-qr-code/?size={$size}x{$size}&data=" . urlencode($url);
    $qrCodeGenerated = true;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Générateur de QR Codes - Projet de Sensibilisation</title>
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
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #afafaf;
        }
        input[type="text"], 
        input[type="password"],
        input[type="number"] {
            width: 100%;
            padding: 10px;
            border-radius: 2px;
            background-color: #32353c;
            border: 1px solid #32353c;
            color: #fff;
            font-size: 15px;
        }
        input[type="text"]:hover, 
        input[type="password"]:hover,
        input[type="number"]:hover {
            background-color: #393c44;
        }
        .button {
            display: inline-block;
            background: linear-gradient(90deg, #06bfff 0, #2d73ff 100%);
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 2px;
            font-weight: bold;
            border: none;
            cursor: pointer;
        }
        .button:hover {
            background: linear-gradient(90deg, #06bfff 30%, #2d73ff 100%);
        }
        .qr-container {
            text-align: center;
            margin-top: 30px;
            padding: 20px;
            background-color: white;
            border-radius: 4px;
        }
        .warning {
            background-color: rgba(217, 65, 38, 0.2);
            border-left: 4px solid #d94126;
            padding: 15px;
            margin: 20px 0;
        }
        .info {
            background-color: rgba(26, 159, 255, 0.1);
            border-left: 4px solid #1a9fff;
            padding: 15px;
            margin: 20px 0;
        }
        .error {
            color: #c15755;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Générateur de QR Codes - Projet de Sensibilisation</h1>
        
        <?php if (!$loggedIn): ?>
            <?php if (isset($error)): ?>
                <div class="error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <div class="info">
                <p>Cette page est réservée aux administrateurs du projet. Veuillez vous connecter pour générer des QR codes.</p>
            </div>
            
            <form method="post">
                <div class="form-group">
                    <label for="username">Nom d'utilisateur:</label>
                    <input type="text" id="username" name="username" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Mot de passe:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                
                <button type="submit" name="login" class="button">Se connecter</button>
            </form>
        <?php else: ?>
            <div class="warning">
                <p><strong>Attention:</strong> Cet outil est destiné uniquement à des fins éducatives dans le cadre du projet académique de sensibilisation à la sécurité.</p>
            </div>
            
            <form method="post">
                <div class="form-group">
                    <label for="custom_url">URL à encoder (laissez vide pour utiliser l'URL actuelle):</label>
                    <input type="text" id="custom_url" name="custom_url" placeholder="<?php echo $defaultUrl; ?>">
                </div>
                
                <div class="form-group">
                    <label for="size">Taille du QR code (en pixels):</label>
                    <input type="number" id="size" name="size" value="300" min="100" max="1000">
                </div>
                
                <button type="submit" name="generate" class="button">Générer le QR code</button>
            </form>
            
            <?php if ($qrCodeGenerated): ?>
                <div class="qr-container">
                    <img src="<?php echo $qrCodeUrl; ?>" alt="QR Code">
                    <p>URL encodée: <?php echo htmlspecialchars($url); ?></p>
                </div>
                
                <div class="info">
                    <p>Pour utiliser ce QR code:</p>
                    <ol>
                        <li>Faites un clic droit sur l'image et sélectionnez "Enregistrer l'image sous..."</li>
                        <li>Imprimez le QR code et utilisez-le dans le cadre de l'exercice de sensibilisation</li>
                        <li>Assurez-vous d'informer les participants de la nature éducative de l'exercice après leur participation</li>
                    </ol>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</body>
</html> 