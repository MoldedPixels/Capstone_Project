<?php
	session_start();
	require_once('capconnect.php');
	require_once('Steam_Search.php');

	$dbh = ConnectDB();
	$_SESSION['gname'] = $_POST['gname'];
	
	$filedata = searchSteam(); 
	
// If the name didn't match, let them try again.
	if ( count($filedata) == 0 )
		{
			header("Location: SearchFail.html");
			exit; // Ensure we only send one location line.
		}
	else
		{
			header("Location: Result.php");
			exit;
		}
?>