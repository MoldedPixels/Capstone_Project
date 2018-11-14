<?php
	function searchTwitch()
	{
	require_once('capconnect.php');
	$dbh = ConnectDB();
try {
    $query = "SELECT * FROM capstone.twitch " .
                   "WHERE  name LIKE(:gname) AND `viewers` > 0 AND `channels` > 0 ORDER BY `name`  ASC";

    $stmt = $dbh->prepare($query);

    $stmt->bindValue(':gname','%' . $_SESSION['gname'] .'%');

    $stmt->execute();
    $filedata = $stmt->fetchAll(PDO::FETCH_OBJ);
    $stmt = null;
	$_SESSION['data'] = $filedata;
}
catch(PDOException $e)
{
    die ('Error finding game: ' . $e->getMessage() );
}
	return $filedata;
	}
?>