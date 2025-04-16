# Projet Académique : Sensibilisation à la Sécurité par Simulation de Phishing

## Description
Ce projet éducatif a été conçu pour sensibiliser aux risques liés aux attaques de phishing en reproduisant les mécanismes couramment utilisés par les cybercriminels. L'objectif est purement pédagogique et vise à renforcer la vigilance des utilisateurs face à ces menaces.

## Objectifs pédagogiques
- Comprendre comment fonctionnent les attaques de phishing
- Identifier les signes d'une tentative de phishing
- Apprendre les bonnes pratiques de sécurité en ligne
- Développer des compétences en cybersécurité défensive

## Structure du projet
- Une réplique de la page de connexion Steam pour démontrer le phishing
- Un système de collecte des identifiants à des fins de statistiques
- Une page éducative expliquant la simulation après la participation
- Un tableau de bord administratif pour analyser les résultats

## Déploiement

### Prérequis
- Docker et Docker Compose
- Un serveur web accessible (pour les démonstrations en classe)

### Installation
1. Clonez ce dépôt sur votre serveur
   ```
   git clone [URL du dépôt]
   cd [nom du dossier]
   ```

2. Lancez les conteneurs Docker
   ```
   docker-compose up -d
   ```

3. Accédez au site à l'adresse suivante : http://localhost

### Pages importantes
- `/` - Page d'accueil (réplique de la page de connexion Steam)
- `/admin.php` - Interface d'administration (identifiants par défaut : admin/securitydemo2023)
- `/generate_qr.php` - Générateur de QR codes pour les démonstrations
- `/education.php` - Page éducative expliquant l'exercice

## Considérations éthiques
- Ce projet est exclusivement destiné à une utilisation dans un cadre académique contrôlé
- Les participants doivent être informés de la nature de l'exercice après leur participation
- Les données collectées doivent être traitées de manière confidentielle et supprimées après analyse
- Ne jamais utiliser ce projet à des fins malveillantes ou en dehors d'un contexte éducatif

## Sécurité
Ce projet étant destiné à des fins éducatives, plusieurs mesures ont été prises :
- Accès protégé par mot de passe aux interfaces d'administration
- Possibilité de purger toutes les données collectées
- Déploiement isolé dans des conteneurs Docker

## Modification des identifiants
Pour des raisons de sécurité, il est recommandé de modifier les identifiants par défaut :
1. Ouvrez les fichiers `admin.php` et `generate_qr.php`
2. Modifiez les valeurs des variables `$username` et `$password`

## Auteurs
Ce projet a été développé dans le cadre d'une formation en cybersécurité à [Nom de l'école]. 