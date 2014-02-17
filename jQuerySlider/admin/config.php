<?php

	$DB_HOST="localhost";
	$DB_USER="root";
	$DB_PASSWORD="PetarMySql@";
	$DATABASE="jquery";
	
	$connect_baza=mysql_connect($DB_HOST,$DB_USER,$DB_PASSWORD);
	if(!$connect_baza)
	{
		die("can't connect to the server");
	}
	
	$select_db=mysql_select_db($DATABASE);
	if(!$select_db)
	{
		die("can't connect to the database");
	}

	//check mysql injection
	function check_input($value){
		$value=htmlspecialchars($value);
		if (get_magic_quotes_gpc()){
  			$value = stripslashes($value);
  		}
		// Quote if not a number
		if (!is_numeric($value)){
  			$value = mysql_real_escape_string($value);
  		}
		return $value;
	}

	//is login function
	function is_login()
	{
		session_start();
		if(!isset($_SESSION['SESSION_ADMIN_ID']) || (trim($_SESSION['SESSION_ADMIN_ID']) == '') ) {
			header("location: index.php?login=0");
			exit();
		}
	}

	function head()
	{
		return <<<HEAD
		<!DOCTYPE html>
		<html>
		<head>
			<title>jQuery Slider ADMINISTRATION</title>
			<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
  			<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
  			<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
  		</head>
HEAD;
	}
	
?>
