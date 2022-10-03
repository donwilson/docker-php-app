<?php
	if(!defined('INCLUDE_DIR') || !INCLUDE_DIR) {
		throw new Exception("Cannot run this directly");
	}
	
	// cache
	require_once(INCLUDE_DIR ."cache.memcached.php");
	
	// database
	require_once(INCLUDE_DIR ."database.mysql.pdo.php");
	
	// escape strings
	require_once(INCLUDE_DIR ."escape.php");
	
	