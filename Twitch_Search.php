<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
	<head>
		<title>Function Page</title>
		<meta charset="utf-8" />
		<meta name="Author" content="Arieh Gennello, Felix Cori IV, Karl Kiocho" />
		<meta name="description" content="This page is a single function and will not display. The function queries the Twitch table and returns the results."/>
	</head>
</html>
<?php
	function searchTwitch()
		{
			require_once('capconnect.php');
			$dbh = ConnectDB();
			try
				{
					$query = "SELECT * FROM capstone.twitch " .
						"WHERE  name LIKE(:gname) AND `viewers` > 0 AND `channels` > 0 ORDER BY `name`  ASC, `tstamp` Desc";
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