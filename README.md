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

### 1. Création dossiers apache, php et phpmyadmin

Créez un dossier nommé apache et ajoutez-y les fichiers suivants :

**Fichier default.conf**

Ce fichier configure le serveur Apache pour gérer les requêtes et transmettre celles en PHP à PHP-FPM.

```conf
<VirtualHost *:80>
    DocumentRoot /var/www/html/

    <FilesMatch \.php$>
        # Active le support PHP-FPM pour apache
        SetHandler proxy:fcgi://php-fpm:9000
    </FilesMatch>

    <Directory /var/www/html/>
        DirectoryIndex index.php
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```
**Fichier Dockerfile pour Apache**

Dans le dossier apache, créez un fichier Dockerfile pour configurer l'image Apache.

```dockerfile
FROM httpd:2.4

COPY ./default.conf /usr/local/apache2/conf/extra/apache.vhost.conf

# Activer les modules proxy et proxy_fcgi
RUN sed -i \
    -e '/#LoadModule proxy_module/s/^#//g' \
    -e '/#LoadModule proxy_fcgi_module/s/^#//g' \
    /usr/local/apache2/conf/httpd.conf

RUN echo "Include /usr/local/apache2/conf/extra/apache.vhost.conf" >> /usr/local/apache2/conf/httpd.conf
```


**Fichier Dockerfile pour PHP**

Créez un dossier nommé php et ajoutez-y le fichier suivant :

Ce Dockerfile configure l'image PHP avec PHP-FPM et active les extensions nécessaires, telles que PDO et PDO MySQL.

```dockerfile
FROM php:8.4-fpm

RUN apt-get update && \
    docker-php-ext-install pdo pdo_mysql

WORKDIR /var/www/html
```

**Fichier Dockerfile pour PHPMYADMIN**

Créez un dossier nommé phpmyadmin et ajoutez-y le fichier suivant :

```dockerfile
# Dockerfile pour phpmyadmin
FROM phpmyadmin/phpmyadmin:latest

# Optionnel : si tu souhaites ajouter des configurations personnalisées ou des plugins
COPY custom-config.inc.php /etc/phpmyadmin/config.inc.php

# Expose le port 80
EXPOSE 80
```

### 2. docker-compose.yaml

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

### 3. Lancer les conteneurs Docker

```bash
docker-compose up --build
```
L'application sera alors accessible via http://localhost.

### 4. Cloner le dépôt dans le dossier app
```bash
    git clone https://github.com/kuraifuyu666/tp-Netflixx.git
```
### 5. Créer le fichier config.php dans le dossier app

ce fichier permettra la communication avec votre BDD.

```config
<?php
$servername = 'mysql';  // Hôte de ton serveur MySQL
$dbname = '';     // Nom de ta base de données
$username = '';    // Nom d'utilisateur de la base de données
$password = '';    // Mot de passe de la base de données

// Ajouter 'charset=utf8mb4' pour assurer un bon encodage
$dsn = "mysql:host=$servername;dbname=$dbname;charset=utf8mb4";

try {
    $connection = new PDO($dsn, $username, $password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //echo 'Connexion réussie';
} catch (PDOException $e) {
    echo 'Erreur : ' . $e->getMessage();
}
?>
```
## Utilisation

Une fois les conteneurs lancés, accédez à l'URL mentionnée ci-dessus pour interagir avec l'application et commencer à ajouter des films à votre collection.

## Auteur

kuraifuyu666 - Développeur principal