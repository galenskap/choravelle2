# Guide d'utilisation des Seeders

Ce document explique comment configurer et utiliser les seeders pour initialiser votre base de données avec les rôles, permissions et données de test.

## 🚀 Procédure recommandée

### 1. Préparation de la base de données

```bash
# Procédure complète pour une installation fraîche
php artisan migrate:fresh
php artisan shield:generate --all
php artisan shield:super-admin
php artisan db:seed --class=ShieldSeeder
```

### 4. Ajout de données de test (optionnel)

```bash
# Lance le seeder des données de test
php artisan db:seed --class=TestDataSeeder
```

Le `TestDataSeeder` crée :

#### 🏢 **Organisations**
- **Dames de choeur** (damesdechoeur.fr)
- **Music M Choeur** (musicmchoeur.com)

#### 👤 **Utilisateurs admin**
- `jean.deborah+ddc@gmail.com` (mdp: `auieauie`) - Admin Dames de Choeur
- `jean.deborah+mmc@gmail.com` (mdp: `auieauie`) - Admin Music M Choeur

#### 🎼 **Pupitres**
- **Dames de Choeur** : Alti, Sopranes 1, Sopranes 2
- **Music M Choeur** : Alti, Sopranes, Ténors, Basses

#### 👥 **Utilisateurs fictifs**
- 20 utilisateurs par organisation (40 au total)
- Répartis aléatoirement sur les pupitres
- Emails : `ddc.user1@example.com` à `ddc.user20@example.com` et `mmc.user1@example.com` à `mmc.user20@example.com`
- Mot de passe : `password`

#### 📁 **Contenu**
- 1 dossier "Saison 2025-2026" par organisation
- 10 chansons par organisation avec 2 fichiers chacune
- 2 événements futurs et 5 passés par organisation
- 1 page d'accueil par organisation