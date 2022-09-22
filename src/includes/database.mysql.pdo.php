<?php
	function db_connect() {
		if(!isset($GLOBALS['db_instance'])) {
			try {
				$GLOBALS['db_instance'] = new PDO("mysql:dbname=". DB_NAME .";host=". DB_HOST .";charset=". DB_CHARSET, DB_USER, DB_PASSWORD);
				$GLOBALS['db_instance']->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$GLOBALS['db_instance']->exec("SET NAMES ". DB_CHARSET);
				$GLOBALS['db_instance']->exec("SET CHARACTER SET ". DB_CHARSET);
			} catch(PDOException $e) {
				die("Could not connect to the database server (cause: ". $e->getMessage() .")");
			}
		}
	}
	
	function db_change_database($database_name=false) {
		db_connect();
		
		throw new Exception("db_change_database(PDO) does not allow dynamically changing database name");
	}
	
	function esc_sql($string) {
		db_connect();
		
		if(is_array($string)) {
			return array_map('esc_sql', $string);
		}
		
		//return addslashes($string);
		return $GLOBALS['db_instance']->quote($string);
	}
	
	function db_query($query) {
		db_connect();
		
		try {
			if(false === ($result = $GLOBALS['db_instance']->exec($query))) {
				throw new Exception("Query failed to run");
			}
			
			if(preg_match("#^\s*INSERT#si", $query)) {
				return $GLOBALS['db_instance']->lastInsertId();
			}
			
			return $result;
		} catch(PDOException $e) {
			if(defined('PRINT_SQL_ERRORS') && PRINT_SQL_ERRORS) {
				$GLOBALS['sql_last_errorInfo'] = $GLOBALS['db_instance']->errorInfo();
				
				if(php_sapi_name() === 'cli') {
					print print_r($GLOBALS['sql_last_errorInfo'], true) ."\n";
				} else {
					print "<pre>". print_r($GLOBALS['sql_last_errorInfo'], true) ."</pre>\n";
				}
				
				if(defined('DIE_ON_SQL_ERROR') && DIE_ON_SQL_ERROR) {
					die;
				}
			}
			
			return false;
		}
	}
	
	function db_last_error() {
		if(isset($GLOBALS['sql_last_errorInfo'])) {
			return $GLOBALS['sql_last_errorInfo'];
		}
		
		return null;
	}
	
	function get_rows($query, $column_key=false) {
		db_connect();
		
		try {
			$result = $GLOBALS['db_instance']->query($query);
		} catch(Exception $e) {
			return false;
		}
		
		$rows = [];
		
		if($result->rowCount()) {
			while($row = $result->fetch(PDO::FETCH_ASSOC)) {
				if((false !== $column_key) && isset($row[ $column_key ])) {
					$rows[ $row[ $column_key ] ] = $row;
				} else {
					$rows[] = $row;
				}
			}
		}
		
		return $rows;
	}	function get_results($query, $column_key=false) { return get_rows($query, $column_key); }
	
	function get_col($query, $column_key=0) {
		db_connect();
		
		try {
			$result = $GLOBALS['db_instance']->query($query);
		} catch(Exception $e) {
			return false;
		}
		
		$rows = [];
		
		if($result->rowCount()) {
			while($row = $result->fetch(PDO::FETCH_ASSOC)) {
				if(isset($row[ $column_key ])) {
					$rows[] = $row[ $column_key ];
				} else {
					$rows[] = array_shift($row);
				}
			}
		}
		
		return $rows;
	}
	
	function get_col_assoc($query, $assoc_key, $column_key=0) {
		db_connect();
		
		try {
			$result = $GLOBALS['db_instance']->query($query);
		} catch(Exception $e) {
			return false;
		}
		
		$rows = [];
		
		if($result->rowCount()) {
			$assoc_col = null;
			$value_col = null;
			
			while($row = $result->fetch(PDO::FETCH_ASSOC)) {
				// determine key column
				if(is_null($assoc_col)) {
					if(isset($row[ $assoc_key ]) && ($assoc_key !== $column_key)) {
						$assoc_col = $assoc_key;
					} else {
						//$assoc_possibilities = array_keys($row);
						//$assoc_col = array_shift($assoc_possibilities);
						$assoc_col = false;
					}
				}
				
				// determine value column
				if(is_null($value_col)) {
					if(isset($row[ $column_key ])) {
						$value_col = $column_key;
					} else {
						$assoc_possibilities = array_keys($row);
						$value_col = array_pop($assoc_possibilities);
					}
				}
				
				// assign rows
				if(false !== $assoc_col) {
					$rows[ $row[ $assoc_col ] ] = $row[ $value_col ];
				} else {
					$rows[] = $row[ $value_col ];
				}
			}
		}
		
		return $rows;
	}
	
	function get_row($query) {
		db_connect();
		
		try {
			$result = $GLOBALS['db_instance']->query($query);
		} catch(Exception $e) {
			return false;
		}
		
		if(!$result->rowCount()) {
			return false;
		}
		
		return $result->fetch(PDO::FETCH_ASSOC);
	}
	
	function get_var($query, $column=false) {
		if(false === ($row = get_row($query))) {
			return false;
		}
		
		if(false !== $column) {
			if(isset($row[ $column ])) {
				return $row[ $column ];
			}
			
			return false;
		}
		
		return array_shift($row);
	}