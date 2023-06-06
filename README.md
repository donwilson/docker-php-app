# docker-php-app

This is a project created to quickly create a minimalist Docker + Apache + PHP 8.2 + MariaDB + memcached + Composer development environment.

# Quick Setup

0. Have docker installed and running
1. Setup the environment
   - Run `cp ./.env.example ./.env` to copy the environment file
   - If using multiple copies of this project, open `./.env` and change the value of `PROJECT_NAME=` to something unique
   - Run `cp ./src/config.sensitive_passwords.BLANK.php ./src/config.sensitive_passwords.php`
3. Build and start the docker project by running `docker compose up`. To send the docker environment to the background, run `docker compose up -d` instead
4. Open the app in your browser by navigating to `http://localhost/`
5. To shutdown the project while it's in the background, navigate to the base directory and run `docker compose down`

# Notes

`./src/` is the base directory for the PHP project.

Changes to `./src/composer.json` are processed every time you boot up the docker project.

`./src/index.php` is a sample PHP file that shows usage of `require_once(__DIR__ ."/config.php");` that provides procedural database and cache functionality.

`./src/config.php` has several variables to adjust project settings.

`./src/config.sensitive_passwords.php` is where database and cache settings are stored. This docker project sets environment variables so this file should work right away. This file is automatically included in `./src/config.php`.

## Database access

`./src/includes/database.mysql.pdo.php` is where the procedural database functions are. Functions like `db_query()`, `get_rows()`, `get_col()`, and `esc_sql()` are available for easy database access.

## Cache

`./src/includes/cache.memcached.php` is where the procedural cache functions are. Functions like `cache_get('key', $callback, ttl)` and `cache_set('key', $callback, ttl)` are availble. Setting `$callback` as an anonymous function is encouraged, if the key is not found during `cache_get()` the `$callback` function is run and it's returned value is stored in cache and returned.

## Strings

`./src/includes/escape.php` includes functions like `esc_attr()` (for escaping strings into HTML attributes) and `esc_html()` (for escaping strings directly into HTML).

