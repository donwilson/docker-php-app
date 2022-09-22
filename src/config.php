<?php
	// dev mode
	define('DEV_MODE', true);
	
	// errors
	//define('PRINT_PHP_ERRORS', DEV_MODE);
	define('PRINT_SQL_ERRORS', DEV_MODE);
	define('DIE_ON_SQL_ERROR', DEV_MODE);
	
	// timezone
	define('DATE_TIMEZONE', "US/Central");
	define('DATE_TIMEZONE_SHORT', "CST");
	
	// set timezone
	ini_set('date.timezone', DATE_TIMEZONE);
	date_default_timezone_set(DATE_TIMEZONE);
	
	// directory paths
	define('ABS_DIR', __DIR__ ."/");
	define('VENDOR_DIR', ABS_DIR ."vendor/");
	define('INCLUDE_DIR', ABS_DIR ."includes/");
	
	// sensitive information (file specifically ignored by git repo)
	// MUST be called before including kitchen_sink.php
	require_once(ABS_DIR ."config.sensitive_passwords.php");
	
	// dates
	define('DATE_FORMAT_CONTENT', "D, M j, Y");   // Mon, Feb 01, 2016 -- php.net/date
	
	// quick matches
	define('REGEX_MATCH_IMAGE', "#\.(jpe?g|gif|png)$#si");
	define('REGEX_MATCH_VIDEO', "#\.(mp4|flv|avi|wmv|mpe?g|mov|webm|mkv)$#si");
	
	if(!file_exists(VENDOR_DIR ."autoload.php")) {
		die("Composer needs installing");
	}
	
	require_once(VENDOR_DIR ."autoload.php");
	
	// errors
	if(defined('DEV_MODE') && DEV_MODE) {
		@include_once(INCLUDE_DIR ."errors.php");
	}
	
	// start session
	//session_start();
	
	// include code
	@include_once(INCLUDE_DIR ."kitchen_sink.php");