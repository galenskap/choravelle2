## Prérequis

Environnement PHP avec php-sqlite3 d'installé (pour la version dev)

## Première installation

Clonez ce dépôt, entrez dans le dossier et : 
- copiez .env.example en .env (renseignez les différentes informations)
- `composer install`
- `php artisan key:generate`
- `php artisan migrate`
- `npm install && npm run build`
- `php artisan make:filament-user`
- `php artisan storage:link`
- `npm run dev`

Ouvrez http://localhost:8000

