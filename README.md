## Docker 
La mise en place de Docker du projet a été faite pour le projet Docker de l'année.
Cette configuration Docker est pour une utilisation sous un OS Windows !!!
Pour lancer le build & run le docker :
```
docker-composer up --build
```

```
Pour lancer plus tard après le build s'il n'est pas en cours d'éxécution
docker-composer up -d
```

La dockerization contient une interface phpMyAdmin, MySQL, et un serveur Apache pour faire tourner l'application

Lorsque le build est fait et que les containers tournent, la base 'book_store' sera déjà crée.

Il faut alors construire la structure de la base avec les tables, et les données.

```
docker exec -it book_store_symfony php bin/console doctrine:migrations:migrate
docker exec -it book_store_symfony php bin/console doctrine:fixtures:load
```

Les fichiers migrations sont déjà inclus dans le repository, normalement, la structure ne devrait pas poser de soucis.
Lors de l'import des fixtures, il demandera de purger la base, confirmer par "Oui".

## Variable .env importante à mettre en place dans un fichier local en cas d'utilisation de développement local sans Docker
DATABASE_URL
MAILER_DSN
SECRET_PASSWORD_FIXTURES

### Installation des dépendances : 
```
composer install

npm install
```

### BDD : (En cas de développement local)
La base de données est prête à être crée et remplie
```
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
php bin/console doctrine:fixtures:load
```
### Connexion users:
```
email
password  = username de l'utilisateur
```
