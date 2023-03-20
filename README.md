<img src="https://chatpot2.mattheo-prl.fr/assets/images/large-logo.png" width="400"/>

# ChatPoT
Réalisation d’une application de messagerie instantanée durant les cours de R4A10 Complement WEB en IUT Informatique 2eme année.

# Fonctionnalités
Cette messagerie instantanée propose les fonctionnalités suivantes
* Connexion / Déconnexion
* Création de compte
* Envoi de message
* Envoi de gif
* Gestion de different canal de discussion
* Liste des personnes connectées
* Generation d'un avatar à partir d'un API selon le nom de l'utilisateur


# Installation
## Prérequis
* Docker
* Docker-compose
## Lancement pour un environnement de développement
```bash 
cd docker
docker-compose up -d
```
Dans cet environnement de développement, les ports sont ouverts et le service web est accessible sur le **port 85**.

Le volume du serveur web est monté directement par rapport à la machine hôte pour permettre de voir les changements en temps réel sans rebuild.

Les erreurs sont affichées reportées sur la page.

## Lancement pour un environnement de production
Dans le dossier docker, il doit y avoir un fichier .env qui contient les variables d'environnement suivantes
* DB_HOST : l'adresse de la base de donnée

Dans ce docker-compose, les ports ne sont pas ouverts de base laissant l'utilisateur libre ou pas d'utiliser un reverse proxy.
```bash
cd docker
docker-compose -f docker-compose.yml -f docker-compose.prod.yml up -d
```

Dans cet environnement de production, les erreurs ne sont pas affichées sur la page mais dans les logs du service web.

_Nb: Vous pouvez rajouter un fichier docker-compose pour lancer des services supplémentaires comme un reverse proxy ou bien ouvrir les ports du service chatpot_web._