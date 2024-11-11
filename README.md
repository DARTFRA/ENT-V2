# Mon ENT (Espace Numérique de Travail)

Bienvenue dans le dépôt GitHub de mon **Espace Numérique de Travail (ENT)** ! Ce projet, développé en PHP avec Symfony, propose une plateforme centralisée pour les établissements éducatifs.

## 🚀 Fonctionnalités

- **Gestion des utilisateurs** : Enregistrement, connexion et gestion de profils (étudiants, enseignants, administrateurs).
- **Planning et agenda** : Consultation des emplois du temps et événements scolaires.
- **Messagerie interne** : Communication entre utilisateurs avec notifications en temps réel.
- **Ressources pédagogiques** : Accès aux cours, exercices et documents partagés par les enseignants.
- **Suivi des performances** : Consultation des notes et des retours d'évaluation.

## 🛠️ Installation

1. **Clonez le dépôt :**
   ```bash
   git clone https://github.com/DARTFRA/ENT-V2.git
   cd ENT-V2
   ```

2. **Installez les dépendances via Composer :**
   ```bash
   composer install
   ```

3. **Configurez les variables d'environnement :**
   Créez un fichier `.env.local` en vous basant sur `.env` et renseignez les informations nécessaires (par exemple, les informations de la base de données).

4. **Créez la base de données et appliquez les migrations :**
   ```bash
   php bin/console doctrine:database:create
   php bin/console doctrine:migrations:migrate
   ```

5. **Lancez le serveur Symfony :**
   ```bash
   symfony server:start
   ```

6. **Accédez à l'ENT** dans votre navigateur :
   ```
   http://localhost:8000
   ```

## 💻 Technologies utilisées

```plaintext
- Backend : PHP, Symfony
- Base de données : MySQL (ou autre base compatible avec Doctrine)
- Authentification : Gestion de sessions et sécurité Symfony
- Frontend : Twig, HTML/CSS, JavaScript
```

## 🤝 Contribution

Les contributions sont les bienvenues ! Pour signaler des bugs ou proposer des améliorations, créez une *issue* ou soumettez une *pull request*.
