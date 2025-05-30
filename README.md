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

Une fois l'appli lancée, connectez-vous en tant que super-admin au back-office et donnez toutes les permissions au rôle super-admin. Puis créez les rôles éditeur et visiteur avec les droits appropriés (limités à leur tenant).

## Lancement
- `php artisan serve` pour lancer le back
- `npm run dev` pour lancer le front

Ouvrez http://localhost:8000/administration/ et créez votre page d'accueil depuis le back-office.
Puis ouvrez http://localhost:5173 pour voir le résultat.


## Saaas version
La multi-tenancy edition a split du dépôt inital le 24 mars 2025 (dernier commit commun https://github.com/galenskap/choravelle_saas/commit/2197a0c564fc498846bd2698adcaa6a3e0496ae9)