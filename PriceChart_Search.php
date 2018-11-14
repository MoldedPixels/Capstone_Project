<?php
	function searchPriceChart()
	{
	require_once('capconnect.php');
	$dbh = ConnectDB();
try {
    $query = "SELECT * FROM capstone.priceguide " .
                   "WHERE  `product-name` LIKE (:gname) ORDER BY `product-name`  ASC";

    $stmt = $dbh->prepare($query);

    $stmt->bindValue(':gname','%' . $_SESSION['gname'] . '%');

    $stmt->execute();
    $filedata = $stmt->fetchAll(PDO::FETCH_OBJ);
    $stmt = null;
	$_SESSION['pdata'] = $filedata;
}
catch(PDOException $e)
{
    die ('Error finding game: ' . $e->getMessage() );
}
return $filedata;
	}
?>