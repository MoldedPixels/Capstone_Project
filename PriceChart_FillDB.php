<?php
function fillPriceChart()
{
	$path = //Enter Your Path to the CSV Here
require_once('capconnect.php');
require_once('PriceChart_Search.php');
	$dbh = ConnectDB();
    
		 
		 try {

        $query = "LOAD DATA LOCAL INFILE ':path'
		INTO TABLE capstone.priceguide 
		FIELDS TERMINATED BY ',' 
		LINES TERMINATED BY '\n'
		IGNORE 1 ROWS ";
        $stmt = $dbh->prepare($query);
		$stmt->bindValue(':path',$path);
        $stmt->execute();
        $stmt = null;

    }
    catch(PDOException $e)
    {
        die ('PDO error inserting(): ' . $e->getMessage() );
    }	
	removeEmpty();
}
function removeEmpty()
{
		$dbh = ConnectDB();
	//$pricechart = searchPriceChart();
	//foreach ( $pricechart as $fname ) 
	//			{
		try {

        $query = "DELETE FROM capstone.priceguide  WHERE `loose-price` NOT LIKE ('%$%.__%') OR `cib-price` NOT LIKE ('%$%.__%') OR `new-price` NOT LIKE ('%$%.__%') OR `retail-loose-sell` NOT LIKE ('%$%.__%') OR `retail-cib-sell`NOT LIKE ('%$%.__%') OR `gamestop-price` NOT LIKE ('%$%.__%') OR `gamestop-trade-price` NOT LIKE ('%$%.__%') ";
        $stmt = $dbh->prepare($query);

        $stmt->execute();
        $stmt = null;

    }
    catch(PDOException $e)
    {
        die ('PDO error inserting(): ' . $e->getMessage() );
    }	
	try {

        $query = "UPDATE capstone.priceguide SET `gamestop-price` = 'N/A' WHERE `gamestop-price` = ''";
        $stmt = $dbh->prepare($query);

        $stmt->execute();
        $stmt = null;

    }
    catch(PDOException $e)
    {
        die ('PDO error inserting(): ' . $e->getMessage() );
    }	
//}
}
?>