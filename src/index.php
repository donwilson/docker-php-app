<?php
	require_once(__DIR__ ."/config.php");
	
	print "<p>date: ". date("r") ."</p>\n";
	print "<p>date (cached): ". cache_get('index.php:date', function() { return date("r"); }, (60 * 2)) ."</p>\n";
	print "<p>can cache? ". (can_cache()?"YES":"NO") ."</p>\n";
	
	print "<hr>\n";
	
	phpinfo();