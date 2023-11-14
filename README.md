## Variable .env importante à mettre en place dans un fichier local
DATABASE_URL
MAILER_DSN
SECRET_PASSWORD_FIXTURES

### Installation des dépendances : 
```
composer install

npm install
```

### BDD :
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
