# Docker Stack

This repo contains a simple Docker setup you can drop into many PHP-based projects. Find out more about the idea behind this [in my blog post](https://kovah.me/en/5gw1x8-a-drop-in-docker-stack-for-php-app/).


## Basics

The stack consists of four files from those two are configuration files and one is the .env file you can find in many projects.

Directory structure
```
/
├─ docker
│  ├─ php.ini
│  └─ nginx.conf
├─ // Your other app files
├─ .env
└─ docker-compose.yml
```

My default setup consists of PHP, a MySQL-compatible database server, nginx and Redis. All services are defined in the `docker-compose.yml` file.

Part of the docker-compose
```
# --- PHP 7.2
php:
  container_name: "project-php"
  image: bitnami/php-fpm:7.2
  volumes:
    - .:/app
    - ./docker/php.ini:/opt/bitnami/php/etc/conf.d/php.ini:ro

# --- nginx 1.14
nginx:
  container_name: "project-nginx"
  image: bitnami/nginx:1.14
  ports:
    - "127.0.0.1:80:8085"
  depends_on:
    - php
  volumes:
    - .:/app
    - ./docker/nginx.conf:/opt/bitnami/nginx/conf/vhosts/site.conf:ro
```

This is the definition of the PHP and nginx containers. As you can see it runs with PHP 7.2. The only things it does is to make the project available in the `/app` directory (the base directory for all Bitnami containers) and apply your custom php.ini.

You can find details about the definition of each service in the main README file.


## Setup Configuration

In most cases you only have to change the .env file because it contains variable details about the stack and passwords. The main stack works for all plain PHP projects but you can easily make it work with Laravel or any CMS by changing the `nginx.conf` file because each system may has different requirements on the web server configuration.


## Installation and usage

* Copy the main files (everything except /public and README.md) to your project
* Make a copy of the `.env.example` file and name it `.env`, or copy the needed values to your existing .env file. Laravel users do not have to copy anything.
* Make sure the current configuration matches your project setup. CMS like Wordpress or Drupal need additinal configuration.
* Run `docker-compose up -d`

Docker will then download all images and start them up. By default Port 80 on your host machine is bound to nginx so you should be able to access your app by opening `http://localhost` in your browser.


---

Docker Stack is a project by [Kovah](https://kovah.de) | [Contributors](https://github.com/Kovah/Docker-Stack/graphs/contributors)
