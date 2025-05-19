# 🎮 Projet de Simulation de Phishing Éducatif - Steam

## 📝 Description
Ce projet est une simulation éducative de phishing conçue dans le cadre d'une formation en cybersécurité. Il vise à sensibiliser les utilisateurs aux dangers du phishing en reproduisant une interface similaire à celle de Steam, tout en fournissant des informations éducatives sur la sécurité en ligne.

## 🎯 Objectifs
- Démontrer les techniques utilisées par les cybercriminels
- Sensibiliser aux dangers du phishing
- Former à l'identification des signes d'une tentative de phishing
- Renforcer les bonnes pratiques de sécurité

## 🛠️ Technologies Utilisées
- PHP
- HTML/CSS
- NGINX
- VPS Debian 12 (Hostinger) 
- API de géolocalisation (ip-api.com)

## 📋 Fonctionnalités
- Interface reproduisant le design de Steam
- Système de collecte de données pour analyse statistique
- Page éducative détaillée sur la sécurité
- Génération de QR codes
- Suivi des tentatives de connexion
- Géolocalisation des connexions
- Interface d'administration

## 🔒 Sécurité
- Les données collectées sont utilisées uniquement à des fins statistiques
- Aucune donnée n'est conservée à long terme
- Système de journalisation des tentatives de connexion
- Redirection sécurisée vers le site officiel de Steam
- **Suppression automatique des données** : Un script de surveillance (`clear_phishing_loop.sh`) tourne en arrière-plan sur le VPS et supprime automatiquement le contenues du fichier de données toutes les 30secondes pour garantir la confidentialité des informations collectées.



## Exemple de `.gitignore` :
```gitignore
*.log
info_phishing.txt
ip.txt
```

## 🛠️ Fonctionnalités Techniques
- Simulations réalistes d'attaques de phishing
- Capture des données dans un espace administrateur restreint
- Page éducative intégrée
- Hébergement sur un VPS avec Nginx et PHP configurés sous Debian 12
- Système de surveillance automatique des fichiers avec suppression périodique

### 🔄 Système de Surveillance
Le projet intègre un script de surveillance (`clear_phishing_loop.sh`) qui :
- Tourne en arrière-plan sur le serveur Nginx du VPS
- Vérifie l'état des fichiers de données toutes les 30 secondes
- Supprime automatiquement les fichiers de données.
- Garantit la confidentialité des informations collectées
- Journalise les opérations de suppression pour le suivi

## 📦 Installation
1. Clonez le dépôt :
```bash
git clone [https://github.com/TMallor/Steam.git]
```

2. Installez PHP et PHP-FPM :
```bash
sudo apt install php php-fpm
```

3. Configurez votre serveur web (Apache/Nginx) pour pointer vers le répertoire du projet
   OU
   Lancez le serveur PHP directement en local :
```bash
sudo php -S 0.0.0.0:80
```

4. Assurez-vous que PHP est installé et configuré correctement

5. Vérifiez les permissions des fichiers :
```bash
chmod 755 -R /chemin/vers/le/projet
```

## ⚙️ Configuration
- Modifiez les paramètres de connexion dans les fichiers PHP selon vos besoins
- Configurez les redirections dans le fichier de configuration
- Ajustez les paramètres de journalisation selon vos besoins
- Le fuseau horaire est configuré sur 'Europe/Paris' dans le fichier `config.php`

### Configuration du Fuseau Horaire
Le projet utilise le fuseau horaire 'Europe/Paris' pour assurer la cohérence des horodatages. Cette configuration est définie dans le fichier `config.php` qui est inclus dans tous les fichiers PHP du projet.

### Configuration Nginx
Pour configurer le serveur web Nginx, créez un fichier de configuration dans `/etc/nginx/sites-available/steam` avec le contenu suivant :

```nginx
server {
    listen 80;
    server_name localhost;

    root /var/www/html;
    index index.php index.html index.htm;

    location / {
        try_files $uri $uri/ =404;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/run/php/php8.2-fpm.sock;
    }

    location ~ /\.ht {
        deny all;
    }
}
```

Après avoir créé le fichier, activez la configuration avec :
```bash
sudo ln -s /etc/nginx/sites-available/steam /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl restart nginx
```

Pour modifier le fuseau horaire :
1. Ouvrez le fichier `login.php`
2. Modifiez la ligne : `date_default_timezone_set('Europe/Paris');`
3. Remplacez 'Europe/Paris' par le fuseau horaire souhaité

### 🔐 Sécurisation du Serveur
Pour une utilisation en production, il est fortement recommandé de sécuriser votre serveur :

1. **Authentification SSH par clé** :
   - Désactivez l'authentification par mot de passe
   - Configurez l'authentification par clé SSH uniquement
   ```bash
   # Dans /etc/ssh/sshd_config
      PasswordAuthentication no
      ChallengeResponseAuthentication no
      UsePAM no
      PubkeyAuthentication yes
     ```



2. **Désactivation de l'accès root** :
   - Créez un utilisateur non-root avec les privilèges sudo
   - Désactivez la connexion SSH en tant que root
   ```bash
   # Dans /etc/ssh/sshd_config
   PermitRootLogin no
   ```


## 📊 Utilisation
1. Accédez à l'interface principale via votre navigateur / Scannez le QR code généré
2. Suivez le processus de simulation
3. Consultez la page éducative pour plus d'informations

## 👥 Contribution
Les contributions sont les bienvenues ! N'hésitez pas à :
- Signaler des bugs
- Proposer des améliorations
- Soumettre des pull requests


## ⚠️ Avertissement
Ce projet est conçu uniquement à des fins éducatives. L'utilisation de ces outils pour des activités malveillantes est strictement interdite.

Le projet a été **déployé sur un VPS Hostinger** sous **Debian 12**, à l'adresse suivante seulement jusqu'au 06/06/2025 :  
🔗 [http://69.62.80.127/](http://69.62.80.127/)

## 📞 Contact
Pour toute question ou suggestion, n'hésitez pas à nous contacter.
tom.mallor@ynov.com
vincent.badusch@ynov.com
elio.nguingnang@ynov.com

---
*Ce projet a été développé dans le cadre d'une formation en cybersécurité.*

