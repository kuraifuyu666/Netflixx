# Netflixx - Gestion des Films

Netflixx est une application simple qui permet d'enregistrer des films avec leurs informations telles que le titre, le réalisateur, l'année de sortie, le genre, etc. Cette application permet de gérer une collection personnelle de films via une interface web.

## Fonctionnalités
- Ajouter des films avec leurs informations (titre, réalisateur, année, etc.)
- Rechercher des films dans la collection
- Mettre à jour ou supprimer des films
- Interface utilisateur simple et intuitive

## Prérequis
Avant de commencer, assurez-vous d'avoir installé les éléments suivants :
- Docker
- Docker Compose

## Installation

### 1. docker-compose.yaml

```yaml
    services:
    php-fpm:
        build: ./php
        volumes:
            - ./app:/var/www/html

    apache:
        build: ./apache
        ports:
            - 8080:80
        depends_on:
            - php-fpm
        volumes:
            - ./app:/var/www/html
                        
    mysql:
        image: mysql
        restart: always
        environment:
            MYSQL_ROOT_PASSWORD: 'root'
            MYSQL_DATABASE: 'NOM_DE_VOTRE_BASE'
            MYSQL_USER: 'VOTRE_NOM_UTILISATEUR'
            MYSQL_PASSWORD: 'VOTRE_MDP_UTILISATEUR'
        volumes:
            - ./mysql:/var/lib/mysql
        ports:
            - 3308:3306

    phpmyadmin:
        image: phpmyadmin/phpmyadmin
        container_name: phpmyadmin
        environment:
            PMA_HOST: mysql
            MYSQL_ROOT_PASSWORD: 'root'
            MYSQL_USER: 'VOTRE_NOM_UTILISATEUR'  
            MYSQL_PASSWORD: 'VOTRE_MDP_UTILISATEUR'
        ports:
            - "8081:80"
        depends_on:
            - mysql
```

### 1. Cloner le dépôt dans app
```bash
    git clone https://github.com/kuraifuyu666/tp-Netflixx.git
```
