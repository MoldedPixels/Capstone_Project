<?php

// Creates PDO to get and edit data in the database.
// Note for Line 16: LOCAL_INFILE is enabled to allow for the CSV file to be read from a different directory location rather than the MySQL directory.
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
    return $dbh;
	
}

?>
