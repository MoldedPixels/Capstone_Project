<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
	<head>
		<title>Function Page</title>
		<meta charset="utf-8" />
		<meta name="Author" content="Arieh Gennello, Felix Cori IV, Karl Kiocho" />
		<meta name="description" content="This page checks the number of results to ensure that there is at least one result. If not, it redirects to the Failed Search page."/>
	</head>
</html>
<?php
	session_start();
	require_once('capconnect.php');
	require_once('Steam_Search.php');
	require_once('Twitch_Search.php');
	require_once('PriceChart_Search.php');
	$dbh = ConnectDB();
	$_SESSION['gname'] = $_POST['gname'];
	$f1 = searchSteam(); 
	$f2 = searchPriceChart();
	// If the there are no results, redirect users to the Failed Search Page.
	if ( (count($f1) == 0) && (count($f2) == 0) )
		{
			header("Location: SearchFail.html");
			exit; // Ensure we only redirect the user once.
		}
	else
		{
			header("Location: Result.php");
			exit;
		}
?>