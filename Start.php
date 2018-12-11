<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
  <title>Filling Databases!</title>
  <meta charset="utf-8" />
  <meta name="Author" content="Arieh Gennello, Felix Cori IV, Karl Kiocho" />
  <meta name="description" content="This page is a single function and will not display. The function calls the functions to fill the SteamSpy and PriceChart tables with the API call and CSV file respectively. It should only be run if those tables are empty!"/>
</html>
  <?php
	require_once('capconnect.php');
	require_once('SteamSpy_FillDB.php');
	require_once('PriceChart_FillDB.php');
	$dbh = ConnectDB();
	fillSteam();
	fillPriceChart();
	header("Location: Search.html");
	exit;
?>
