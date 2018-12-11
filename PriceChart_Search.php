<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
	<head>
		<title>Function Page</title>
		<meta charset="utf-8" />
		<meta name="Author" content="Arieh Gennello, Felix Cori IV, Karl Kiocho" />
		<meta name="description" content="This page is a single function and will not display. The function queries the PriceChart table and returns the results."/>
	</head>
</html>
<?php
	function searchPriceChart()
		{
			require_once('capconnect.php');
			$dbh = ConnectDB();
			
			try 
				{
					$query = "SELECT * FROM capstone.priceguide " .
						"WHERE  `product-name` LIKE (:gname) ORDER BY `product-name`  ASC";
					$stmt = $dbh->prepare($query);
					$stmt->bindValue(':gname','%' . $_SESSION['gname'] . '%');
					$stmt->execute();
					$filedata = $stmt->fetchAll(PDO::FETCH_OBJ);
					$stmt = null;
				}
			catch(PDOException $e)
				{
					die ('Error finding game: ' . $e->getMessage() );
				}
			return $filedata;
		}
?>