<?php
	// database
	define('DB_HOST', getenv("DB_HOST"));
	define('DB_USER', getenv("DB_USER"));
	define('DB_PASSWORD', getenv("DB_PASSWORD"));
	define('DB_NAME', getenv("DB_NAME"));
	define('DB_CHARSET', "utf8mb4");
	
	// memcached
	define('CACHE_CAN_CACHE', ((defined('DEV_MODE') && DEV_MODE)?!isset($_REQUEST['_force']):true));//define('CACHE_CAN_CACHE', true);
	define('CACHE_MEMCACHE_IP', (getenv("CACHE_HOST")?getenv("CACHE_HOST"):"localhost"));
	define('CACHE_MEMCACHE_PORT', (getenv("CACHE_PORT")?getenv("CACHE_PORT"):"11211"));
	define('CACHE_HASH_PREFIX', ((getenv("PROJECT_NAME")?getenv("PROJECT_NAME"):md5(__DIR__))) ."|");
	define('CACHE_DEFAULT_TTL', (60 * 30));   // default cache expiry in seconds