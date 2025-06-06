## Prérequis

Environnement PHP avec php-sqlite3 d'installé (pour la version dev)

## Première installation

Clonez ce dépôt, entrez dans le dossier et : 
- copiez .env.example en .env (renseignez les différentes informations)
- `npm install && npm run build`
- `composer install`
- `php artisan key:generate`
- `php artisan migrate`
- `php artisan storage:link`

### Création du compte super admin

- `php artisan make:filament-user`
- `php artisan shield:setup --fresh`
- `php artisan shield:install administration`
- `php artisan shield:super-admin`
- `php artisan db:seed --class=ShieldSeeder` pour créer les rôles
- `php artisan db:seed --class=BlockTemplateSeeder` pour créer les block templates

- voir [SEEDING.md](SEEDING.md) pour le détail du seeding de test.

## Lancement
- `php artisan serve` pour lancer le back
- `npm run dev` pour lancer le front

Ouvrez http://localhost:8000/administration/ et créez votre page d'accueil depuis le back-office.
Puis ouvrez http://localhost:5173 pour voir le résultat.