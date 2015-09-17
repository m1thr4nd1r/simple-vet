<?php
function connect($host, $dbname, $user, $pass)
{
	try {
	    $dbh = new PDO('mysql:host='.$host.';dbname='.$dbname, $user, $pass);	    
	} catch (PDOException $e) {
		$dbh = null;
	    print "Error!: " . $e->getMessage() . "<br/>";
	    die();
	}
	return $dbh;
}
?>