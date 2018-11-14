<?php
function searchSteam()
{	
	require_once('capconnect.php');
	$dbh = ConnectDB();
	try 
		{
			$query = "SELECT * FROM capstone.steamspy_results " .
                   "WHERE  name LIKE (:gname) ORDER BY `name`  ASC";

			$stmt = $dbh->prepare($query);

			$stmt->bindValue(':gname', '%' . $_SESSION['gname'] . '%');

			$stmt->execute();
			$filedata = $stmt->fetchAll(PDO::FETCH_OBJ);
			$stmt = null;
			$_SESSION['sdata'] = $filedata;
		}
	catch(PDOException $e)
		{
			die ('Error finding game: ' . $e->getMessage() );
		}
		return $filedata;
}
?>