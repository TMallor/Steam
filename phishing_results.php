<?php
// Page pour visualiser les données de phishing recueillies
// IMPORTANT: Cette page doit être protégée par un mot de passe en production

// Paramètres de connexion
$username = "admin";
$password = "securitydemo2023";

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

// Action de purge des données
if ($loggedIn && isset($_POST['purge'])) {
    if (file_exists('info_phishing.txt')) {
        file_put_contents('info_phishing.txt', '');
        $success = "Les données ont été purgées avec succès.";
    }
}

// Fonction pour afficher les données de phishing
function displayPhishingData() {
    $file = 'info_phishing.txt';
    
    if (!file_exists($file)) {
        echo "<p>Le fichier de données de phishing n'existe pas encore.</p>";
        return;
    }
    
    if (filesize($file) == 0) {
        echo "<p>Aucune donnée de phishing n'a été collectée pour le moment.</p>";
        return;
    }
    
    $content = file_get_contents($file);
    
    echo "<h3>Données de phishing collectées</h3>";
    echo "<div class='data-container'>";
    echo "<pre>" . htmlspecialchars($content) . "</pre>";
    echo "</div>";
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultats de Phishing - Projet de Sensibilisation</title>
    <style>
        body {
            background-color: #181a21;
            color: #e9e9e9;
            font-family: "Motiva Sans", Sans-serif;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
            background-color: #1b2838;
            padding: 30px;
            border-radius: 4px;
            box-shadow: 0 0 20px rgba(0,0,0,0.3);
        }
        h1, h2, h3 {
            color: #fff;
        }
        h1 {
            border-bottom: 1px solid #417a9b;
            padding-bottom: 10px;
            margin-top: 0;
        }
        .data-container {
            background-color: #32353c;
            padding: 15px;
            border-radius: 4px;
            overflow-x: auto;
            margin: 20px 0;
        }
        pre {
            color: #e9e9e9;
            white-space: pre-wrap;
            word-wrap: break-word;
            font-family: monospace;
            margin: 0;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #afafaf;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 8px;
            background-color: #32353c;
            border: 1px solid #000;
            color: white;
            border-radius: 3px;
        }
        .button {
            background: linear-gradient(to right, #06bfff, #2d73ff);
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 3px;
            cursor: pointer;
            margin-right: 10px;
        }
        .button:hover {
            background: linear-gradient(to right, #2d73ff, #06bfff);
        }
        .button.danger {
            background: linear-gradient(to right, #d94126, #c15755);
        }
        .button.danger:hover {
            background: linear-gradient(to right, #ee563b, #d94126);
        }
        .error {
            color: #ff5050;
            margin-bottom: 15px;
        }
        .success {
            color: #59bf40;
            margin-bottom: 15px;
            background-color: rgba(90, 163, 43, 0.2);
            padding: 10px;
            border-left: 4px solid #5ba32b;
        }
        .warning {
            color: #ffcc00;
            background-color: rgba(255, 204, 0, 0.2);
            padding: 10px;
            border-left: 4px solid #ffcc00;
            margin: 20px 0;
        }
        .actions {
            margin-top: 20px;
            display: flex;
            gap: 10px;
        }
        .refresh {
            margin-top: 20px;
            text-align: right;
        }
        .refresh a {
            color: #1999ff;
            text-decoration: none;
        }
        .refresh a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Résultats de Phishing</h1>
        
        <?php if (!$loggedIn): ?>
            <?php if (isset($error)): ?>
                <div class="error"><?php echo $error; ?></div>
            <?php endif; ?>
            
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
            <?php if (isset($success)): ?>
                <div class="success"><?php echo $success; ?></div>
            <?php endif; ?>
            
            <div class="warning">
                <strong>Attention:</strong> Ces données sont confidentielles et doivent être utilisées uniquement à des fins éducatives.
            </div>
            
            <?php displayPhishingData(); ?>
            
            <div class="refresh">
                <a href="?<?php echo time(); ?>">Rafraîchir les données</a>
            </div>
            
            <div class="actions">
                <form method="post" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer toutes les données de phishing? Cette action est irréversible.');">
                    <button type="submit" name="purge" class="button danger">Purger les données</button>
                </form>
                
                <a href="admin.php" class="button">Retour au tableau de bord</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html> 