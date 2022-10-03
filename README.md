# docker-php-app

This is a rudimentary docker app created for the purpose of quickly getting a PHP 8.0/Apache/MariaDB/memcached stack up and running.

## Quick Setup

1. Setup Docker environment
   - Copy `./.env.example` to `./.env`. Edit newly created `./.env` file and set the value of `PROJECT_KEY=` to something unique (while still remaining alphanumeric).
   - Optionally you may change the port used to access the PHP app by editing `./docker-compose.yml`, find the line `- 8000:80` and updating it to any port you like (for example: `- 8001:80`)
2. Copy `./src/config.sensitive_passwords.BLANK.php` to `./src/config.sensitive_passwords.php`.
3. Build and start the docker environment by opening a terminal to the base directory of this project, then running `docker-compose build && docker-compose up`
4. Open the app in your browser by navigating to `http://localhost:8000` (or whatever IP/port the project is assigned to)

## Notes

`./src/` is the base directory for the PHP project. `./src/index.php` is a rudimentary initial script, everything after the third line can be removed.

`./src/config.php` has several variables to adjust project settings.

`./src/config.sensitive_passwords.php` is where database and cache settings are stored. This docker project sets environment variables so this file should work right away.

### Database functionality

`./src/includes/database.mysql.pdo.php` is automatically included with any inclusion of `./src/config.php`. Functions like `db_query()`, `get_rows()`, `get_col()`, and `esc_sql()` are available.

### Cache functionality

`./src/includes/cache.memcached.php` is automatically included with any inclusion of `./src/config.php`. Functions like `cache_get('key', $callback, ttl)` and `cache_set('key', $callback, ttl)` are availble. Setting `$callback` as an anonymous function is encouraged, if the key is not found during `cache_get()` the `$callback` function is run and it's returned value is stored in cache and returned.

### String Escapes

`./src/includes/escape.php` includes several useful functions like `esc_attr()` (for escaping strings in HTML attributes), `esc_html()` for escaping strings for direct display in HTML.

