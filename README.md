# Docker Stack

![PHP 7.4](https://img.shields.io/badge/PHP-7.4-8892BF.svg)
![MariaDB](https://img.shields.io/badge/Database_Server-MariaDB_10.5-c0765a.svg)
![nginx](https://img.shields.io/badge/Webserver-nginx_1.19-009447.svg)
![Redis](https://img.shields.io/badge/Cache_Engine-Redis_6-D92A2A.svg)
![Laravel ready!](https://img.shields.io/badge/Laravel-Ready_✔-e74430.svg)

This repo contains a simple Docker setup you can drop into many PHP-based projects. Find out more about the idea behind this [in my blog post](https://blog.kovah.de/en/5gw1x8-a-drop-in-docker-stack-for-php-app/).


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

My default setup consists of PHP, MariaDB as a MySQL-compatible database server, nginx and Redis. All services are defined in the `docker-compose.yml` file.

Part of the docker-compose
```
# --- PHP 7.4
php:
  container_name: "project-php"
  image: bitnami/php-fpm:7.4
  volumes:
    - .:/app:delegated
    - ./docker/php.ini:/opt/bitnami/php/etc/conf.d/php.ini:ro

# --- nginx 1.19
nginx:
  container_name: "project-nginx"
  image: bitnami/nginx:1.19
  ports:
    - "127.0.0.1:80:8085"
  depends_on:
    - php
  volumes:
    - .:/app:delegated
    - ./docker/nginx.conf:/opt/bitnami/nginx/conf/server_blocks/site.conf:ro
```

This is the definition of the PHP and nginx containers. As you can see it runs with PHP 7.3. The only things it does is to make the project available in the `/app` directory (the base directory for all Bitnami containers) and apply your custom php.ini.

### Current Service Versions

| Service  | Version  |
| -------- | -------- |
| PHP      | 7.4      |
| MariaDB  | 10.5     |
| nginx    | 1.19     |
| Redis    | 6.0      |


## Setup & Configuration

In most cases you only have to change the .env file because it contains variable details about the stack and passwords. The main stack works for all plain PHP projects, but you can easily make it work with Laravel or any CMS by changing the `nginx.conf` file because each system may has different requirements on the web server configuration.


## Installation and usage

* Copy the main files (everything except /public and README.md) to your project
* Make a copy of the `.env.example` file and name it `.env`, or copy the needed values to your existing .env file. Laravel users do not have to copy anything.
* Make sure the current configuration matches your project setup. CMS like Wordpress or Drupal need additinal configuration.
* Replace `project` with your own project name in the `docker-compose.yml` file.
* Run `docker-compose up -d`.

Docker will then download all images and start them up. By default, port 80 on your host machine is bound to nginx, so you should be able to access your app by opening `http://localhost` in your browser.


---

Docker Stack is a project by [Kovah](https://kovah.de) | [Contributors](https://github.com/Kovah/Docker-Stack/graphs/contributors)
