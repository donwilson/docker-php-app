<?php
	// database
	define('DB_HOST', (getenv("DB_HOST")?getenv("DB_HOST"):""));
	define('DB_USER', (getenv("DB_USER")?getenv("DB_USER"):""));
	define('DB_PASSWORD', (getenv("DB_PASSWORD")?getenv("DB_PASSWORD"):""));
	define('DB_NAME', (getenv("DB_NAME")?getenv("DB_NAME"):""));
	define('DB_CHARSET', "utf8mb4");
	