<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
  <title>Results!</title>
  <meta charset="utf-8" />
  <meta name="Author" content="Arieh Gennello" />
  <style>
    a { text-decoration: none; }
    a:hover { text-decoration: underline; }
    table.fancy    { border-width: 1px 3px 3px 1px;
                     border-collapse: collapse;
                     border: solid blue; }
    table.fancy td { border: 1px dotted black;
                     padding: 2px 5px;
                     margin: 5px 20px;
                     text-align: right; }
  </style>
</head>
<body>
<h1>Welcome! Please wait while we fill the databases!</h1>
</br>
<?php
	require_once('capconnect.php');
	require_once('SteamSpy_FillDB.php');
	require_once('PriceChart_FillDB.php');
	require_once('Twitch_FillDB.php');
	$dbh = ConnectDB();
		echo '<div> Filling Steam...'; 
		//fillSteam();
		echo 'Complete!';
		echo '</div>';
		echo '</br>';
		echo '<div> Filling PriceChart...';
		fillPriceChart();
		echo 'Complete!';
		echo '</div>';
		echo '</br>';
//header("Location: Search.php");
//	exit;
?>
</body>
<footer style="border-top: 2px solid red; margin-top: 1ex;">
    Arieh Gennello

<span style="float: right;">
<a href="http://validator.w3.org/check/referer">HTML5</a> /
<a href="http://jigsaw.w3.org/css-validator/check/referer?profile=css3">
    CSS3 </a>
</span>
</footer>
</html>