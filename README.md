# docker-php-app

This is a minimal docker app created for the purpose of easily setting up a PHP 8.0/Apache/MariaDB/memcached/Composer docker environment.

## Quick Setup

0. This setup assumes you already have docker (ideally Docker Desktop) installed
1. Setup Docker environment
   - Copy `./.env.example` to `./.env`. Edit newly created `./.env` file and set the value of `PROJECT_KEY=` to something unique (while still remaining alphanumeric).
   - Optionally you may change the port used to access the PHP app by editing `./docker-compose.yml`, change the line `- 8000:80` to your desired port (for example: `- 8001:80`)
2. Copy `./src/config.sensitive_passwords.BLANK.php` to `./src/config.sensitive_passwords.php`.
3. Build and start the docker environment by opening a terminal to the base directory of this project, then running `docker-compose build && docker-compose up`
4. Open the app in your browser by navigating to `http://localhost:8000` (or whatever IP/port the project is assigned to)

## Notes

`./src/` is the base directory for the PHP project.

Changes to `./src/composer.json` are processed every time you boot up the docker project.

`./src/index.php` is a sample PHP file that shows the process of using `require_once(__DIR__ ."/config.php");` that provides database and cache functionality.

`./src/config.php` has several variables to adjust project settings.

`./src/config.sensitive_passwords.php` is where database and cache settings are stored. This docker project sets environment variables so this file should work right away. This file is automatically included in `./src/config.php`.

### Database access

`./src/includes/database.mysql.pdo.php` is where the procedural database functions are. Functions like `db_query()`, `get_rows()`, `get_col()`, and `esc_sql()` are available for easy database access.

### Cache

`./src/includes/cache.memcached.php` is where the procedural cache functions are. Functions like `cache_get('key', $callback, ttl)` and `cache_set('key', $callback, ttl)` are availble. Setting `$callback` as an anonymous function is encouraged, if the key is not found during `cache_get()` the `$callback` function is run and it's returned value is stored in cache and returned.

### Strings

`./src/includes/escape.php` includes several functions like `esc_attr()` (escaping strings in HTML attributes) and `esc_html()` (escaping strings directly into an HTML page).

