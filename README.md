<<<<<<< HEAD
<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
=======
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

>>>>>>> 3e4dea3121a988e109a7f954991f0a13ef5556cc
