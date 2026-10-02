## KonturCMS

## Installation in Docker
You must have a [Docker](https://www.docker.com/) and [GIT](https://git-scm.com/) version control system.
1. Clone or download this repository on local workstation.
```bash
git clone https://github.com/KONTUR-Novosibirsk/konturCMS_laravel.git kontur
cd kontur
```
2. Start the container
```bash
docker-compose up -d
```
3. Open the app container console.
```bash
docker exec -it app bash
```
install composer dependencies
```bash
composer install
```
4. Open the nodejs container console.
```bash
docker exec -it nodejs bash
```
Build assets and install dependencies
```bash
npm install && npm run build
```
5. Copy .env.example to .env, write database data

   DB_CONNECTION=mysql

   DB_HOST=db

   DB_PORT=3306

   DB_DATABASE=laravel

   DB_USERNAME=root

   DB_PASSWORD=root

Web app url: http://localhost:8876

Admin dashboard: http://localhost:8876/admin

Phpmyadmin: http://localhost:8081

Publish Module Resources 
```bash
php artisan vendor:publish --tag=module-resources
```


