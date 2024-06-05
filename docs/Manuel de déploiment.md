# G8C - APP_AUDIA_INFO

# Manuel de déploiement :

## Étape 1 : Cloner le dépôt Git

Pour commencer, vous devez cloner le dépôt Git en utilisant la commande suivante :

```bash
git clone https://github.com/Flotss/APP_AUDIA_INFO
```

## Étape 2 : Navigation dans le dossier du projet

Ensuite, vous devez vous rendre dans le dossier du projet en utilisant la commande suivante :

```bash
cd APP_AUDIA_INFO
```

## Étape 3 : Installer PHP et Composer

Avant de pouvoir installer les dépendances du projet, vous devez installer PHP et Composer.
Vous pouvez les télécharger à partir des liens suivants:

PHP: https://windows.php.net/download/
Composer: https://getcomposer.org/download/

## Étape 4 : Installer les dépendances du projet

Pour installer les dépendances du projet, vous devez exécuter la commande suivante :

```bash
composer install
```

Si vous rencontrez une erreur concernant la version de PHP, vérifiez que vous avez bien installé la version requise par le projet. Vous pouvez vérifier votre version de PHP en utilisant la commande suivante:

```bash
php -v
```

<br>
<br>
<br>
<br>

# Lancer localement le projet :

## Étape 5 : Lancer le serveur PHP

Nous avons utilisé XAMPP pour lancer le serveur PHP localement. Vous pouvez le télécharger à partir du lien suivant :

https://www.apachefriends.org/fr/index.html

Après avoir installé XAMPP, vous devez lancer le serveur Apache.

Si vous avez besoin d'aide supplémentaire, n'hésitez pas à demander.

**Note :** Pensez bien à configurer le dossier racine de votre serveur Apache pour qu'il pointe vers le dossier public du projet.

## Étape 6 : Se rendre sur le site

Pour accéder au site, vous devez ouvrir votre navigateur et taper l'URL suivante :

```bash
http://localhost
```

## Information pratique :

- L'utilisateur administrateur par défaut est :

  - email : admin@gmail.com
  - mot de passe : admin

- La base de données est hébergée sur un serveur distant, vous n'avez pas besoin de la configurer localement. Le serveur est hébergé sur Aiven, une plateforme cloud qui fournit des services de base de données.
