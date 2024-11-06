# Application de Gestion des Files d'Attente

Ce projet a été réalisé dans le cadre de mon stage de première année en Génie Logiciel à l'ENSIAS. Développée chez REDAL, cette application web vise à optimiser la gestion des files d'attente, permettant aux clients de prendre des tickets et de suivre leur position dans la file en temps réel.

## 📋 Table des matières
- [Présentation du Projet](#📌-présentation-du-projet)
- [Fonctionnalités](#✨-fonctionnalités)
- [Technologies Utilisées](#🛠-technologies-utilisées)
- [Installation](#🚀-installation)
- [Utilisation](#💻-utilisation)
- [Aperçu de l'Application](#🎨-aperçu-de-lapplication)
- [Auteur](#👤-auteur)
- [Remerciements](#🙏-remerciements)

## 📌 Présentation du Projet
L'application de gestion des files d'attente permet une organisation fluide des flux de clients et améliore l'expérience utilisateur grâce à un système de tickets et de suivi en temps réel. Elle est destinée aux agences de service pour réduire les temps d'attente et fournir des statistiques aux administrateurs.

## ✨ Fonctionnalités
- Prise de ticket en ligne pour rejoindre une file d'attente
- Suivi de la position en temps réel
- Gestion des files d'attente par les agents
- Statistiques pour les administrateurs
- Interface utilisateur réactive et moderne

## 🛠 Technologies Utilisées
- **Backend** : Laravel
- **Frontend** : Vue.js
- **Base de données** : MySQL
- **Environnement de développement** : Visual Studio Code
- **Contrôle de version** : Git

## 🚀 Installation

1. Clonez ce dépôt :
    ```bash
    git clone https://github.com/Ismail-Ah/project.git
    ```
2. Installez les dépendances pour le backend et le frontend :
    ```bash
    composer install
    npm install
    ```
3. Configurez les fichiers d'environnement :
    - Backend : `.env` (configurez la connexion à la base de données MySQL et autres variables nécessaires)

4. Démarrez le backend :
    ```bash
    php artisan serve
    ```
5. Démarrez le frontend :
    ```bash
    npm run serve
    ```

## 💻 Utilisation
Lancez l'application dans votre navigateur en accédant à l'URL indiquée par le serveur de développement frontend. 

### Exemples d'utilisation :
- **Prendre un ticket** : Les clients peuvent prendre un ticket en ligne et consulter leur position dans la file.  
  ![Ticket](images/Ticket.png)

- **Suivre l'état de la file d'attente** : Les clients peuvent accéder en temps réel aux informations sur l'état des files d'attente associées aux services.
  ![File d'Attente](images/FileAttente.png)

- **Gérer la file d'attente** : Les agents peuvent consulter et valider les tickets.  
  ![Dashboard](images/dashboard.png)

- **Accès aux paramètres** : Les administrateurs peuvent gérer les agences les services et les utilisateurs.  
  ![Ajouter Service](images/ajouter_service.png)

- **Accéder aux statistiques** : Les administrateurs ont accès aux statistiques de gestion pour optimiser les services.  
  ![Statistiques](images/stat2.png)

## 🎨 Aperçu de l'Application
[Voir la vidéo de démonstration](https://drive.google.com/file/d/1JLJxI_xRk1PrD-AyqPo-aTuB893bssUW/view?usp=drive_link)

## 👤 Auteur
- **Nom** : Ismail Ahakay
- **Filière** : Génie Logiciel, ENSIAS

## 🙏 Remerciements
Un grand merci à mon encadrant **Ahmed El Hamdi** pour son soutien et ses conseils tout au long de ce projet.

---

> Ce projet a été développé dans le cadre de mon stage chez **REDAL**, où j'ai eu l'opportunité de travailler sur la digitalisation des processus d'attente pour améliorer la satisfaction client et optimiser les opérations.

