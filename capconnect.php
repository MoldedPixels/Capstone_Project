<?php

// ConnectDB() - takes no arguments, returns database handle
// USAGE: $dbh = ConnectDB();
function ConnectDB() {

    /*** mysql server info ***/
    $hostname = 'localhost';
    $username = 'root';
    $password = '';
    $dbname   = 'capstone';

    try {
        $dbh = new PDO("mysql:host=localhost;dbname=capstone",
                       $username, $password, array(PDO::MYSQL_ATTR_LOCAL_INFILE => true,));
		$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        die ('PDO error in "ConnectDB()": ' . $e->getMessage() );
    }
	//echo "connection established";
    return $dbh;
	
}

?>
