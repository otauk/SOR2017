<?php
// utf-8 erzwingen wegen umlauten
// $utf = "SET NAMES 'utf8'";
// $utf_query=$con->query($utf);

try {

	$db = new PDO('mysql:host=localhost;dbname=sor2017;charset=utf8', 'root', 'root', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

}
catch (PDOException $e) {
	echo $e->getMessage();
	}



?>
