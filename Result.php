<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
  <title>Results!</title>
  <meta charset="utf-8" />
  <meta name="Author" content="Arieh Gennello" />
  <style>
    a { text-decoration: none; }
    a:hover { text-decoration: underline; }
	body{background-color: #f2f2f2;}
	div.main {width: 75%; margin: auto;float:none;clear:left;background-color: #f2f2f2;}
	div.tab {height:200px; width: 20%; margin:auto;display:inline-block;float:left;background-color: #f2f2f2;}
    table.fancy td { border: 1px dotted black;
                     padding: 2px 5px;
                     margin: 5px 20px;
                     text-align: center;
					 align-content: center;
					 }
		th {background-color: #4CAF50;}
		tr {background-color: #ffffff;}
		
  </style>
</head>
<body>
<h1>Let's see what we found!</h1>
<div id="Menu" style = "background-color: $f6f6f6";>
<span style = "color: #000000; font-family: 'Palatino Linotype'; font-size: 15px;border: 2px solid red;">
<a href = "Search.html">Home
</a>
    |   
<a href = "help.php">Help
</a>
    |   
<a href = "list.php">List of Games
</a>
</span>
</div>
</br>
<?php
	session_start();
	require_once('capconnect.php');
	require_once('Steam_Search.php');
	require_once('Twitch_Search.php');
	require_once('PriceChart_Search.php');
	require_once('Twitch_FillDB.php');
	$dbh = ConnectDB();
	$steam = searchSteam();
	$cname = "console-name";
	$pname = "product-name";
	$lprice = "loose-price";
	$cprice = "cib-price";
	$nprice = "new-price";
	$rlbuy = "retail-loose-buy";
	$rlsell = "retail-loose-sell";
	$rcbuy = "retail-cib-buy";
	$rcsell = "retail-cib-sell";
	$gprice = "gamestop-price";
	$gtprice = "gamestop-trade-price";
	$pricechart = searchPriceChart();
	if (count($steam) == 0 )
		{
			echo 'No Steam Data Found!';
			echo '</br>';
		}
	else
		{
			$odd = 1;
			echo '<div>';
			echo '<table class = "fancy td"
				summary="A table of student expenses, listing costs for rent,
                food, and textbooks for the first three months of a
                year."
				border="1"
				cellpadding="3"
				cellspacing="5">
				';
								echo'<caption> <h2>Steam Data<h2></caption>';

				echo '<thead>';
					echo '<tr>';
					echo '<th>Name</th>';
					echo '<th>Developers</th>';
					echo '<th>Publishers</th>';
					echo '<th>Score</th>';
					echo '<th>Positive Reviews</th>';
					echo '<th>Negative Reviews</th>';
					echo '<th>User Score</th>';
					echo '<th>Owners</th>';
					echo '<th>Average Playtime (All-Time)</th>';
					echo '<th>Average Playtime (2-Weeks)</th>';
					echo '<th>Median Playtime (All-Time)</th>';
					echo '<th>Median Playtime (2-Weeks)</th>';
					echo '<th>Current Price</th>';
					echo '<th>Price at Launch</th>';
					echo '<th>Current Discount</th>';
					echo '</tr>';
				echo '</thead>';
				echo '<tbody>';
			foreach ( $steam as $fname ) 
				{
					//fillTwitch($fname -> name);


					echo'<tr>';
						echo('<td>' . $fname -> name . ' </td>');
						echo('<td>' . $fname -> developers . ' </td>');
						echo('<td>' .$fname-> publishers .' </td>');
						echo('<td>' .$fname-> score . ' </td>');
						echo('<td>' .$fname-> positive . ' </td>');
						echo('<td>' .$fname-> negative . ' </td>');
						echo('<td>' .$fname-> userscore . ' </td>');
						echo('<td>' .$fname-> owners . ' </td>');
						echo'<td> '. $fname-> avg_forever . ' hrs </td>';
						echo'<td> '. $fname-> avg_2weeks . ' hrs </td>';
						echo'<td> '. $fname-> med_forever . ' hrs</td>';
						echo'<td> '. $fname-> med_2weeks . ' hrs </td>';
						echo'<td> $'. $fname-> price / 100 . ' </td>';
						echo'<td> $'. $fname-> init_price / 100 . ' </td>';
						echo'<td> '. $fname-> discount . '% </td>';
						
					echo'</tr>';
				}
			echo'</tbody>';
			echo'</table>';
			
			echo '</br>';
		}
		echo'</div>';
		echo '<center><h2> Twitch Data</h2> </center>';
		echo '</br>';
				$twitch = searchTwitch();
		if (count($twitch) == 0 )
		{
			echo '<div class = "tab">';
			echo 'No Twitch Data Found!';
			echo '</br>';
			echo'</div>';
		}
		//else if (count($steam) > 1)
		//{
		//	echo '</br>';
		//	echo 'Twitch Data: ';
		//	echo 'Too many results, please refine your search!';
		//	echo '</br>';
		//}
	else
		{
			$name = '';
			
				foreach ($twitch as $fname)
				{
					if($name == '')
					{
						echo '<div class = "tab">';
						$name = $fname -> name;
						echo '<table class = "fancy td"
						summary="A table of student expenses, listing costs for rent,
						food, and textbooks for the first three months of a
						year."
						border="1"
						cellpadding="3"
						cellspacing="5">';
						echo'<caption>' . $name . ' Data </caption>';
						echo '<thead>';
						echo '<tr>';
						echo '<th></th>';
						echo '<th>Viewers</th>';
						echo '<th>Channels</th>';
						echo '</tr>';
						echo '</thead>';
						echo ('<tbody>');
							echo ('<tr>');
							echo('<td>' . date("H:i:s m/d/Y",strtotime($fname-> tstamp)). ' </td>');					
							echo('<td>' . $fname -> channels . ' </td>');
							echo('<td>' . $fname-> viewers .' </td>');
							echo'</tr>';
					}
					else
					{
						
						if($name == $fname -> name)
						{
							echo ('<tbody>');
							echo ('<tr>');
							echo('<td>' . date("H:i:s m/d/Y",strtotime($fname-> tstamp)). ' </td>');					
							echo('<td>' . $fname -> channels . ' </td>');
							echo('<td>' . $fname-> viewers .' </td>');
							echo'</tr>';
						}
						else
						{
							$name = '';
							echo'</tbody>';
							echo'</table>';
							echo'</div>';
						}
					}
					}

			
		}
	echo '<div class = "main">';	
	if (count($pricechart) == 0 )
		{
			echo 'No PriceChart Data Found!';
			echo '</br>';
		}
	else
		{
			echo '<table class = "fancy td"
				summary="A table of student expenses, listing costs for rent,
                food, and textbooks for the first three months of a
                year."
				border="1"
				cellpadding="3"
				cellspacing="5">';
				echo '<caption><h2>PriceChart Data</h2></caption>';

				echo '<thead>';
					echo '<tr>';
					echo '<th> Name</th>';
					echo '<th>Console</th>';
					echo '<th>Online Average Loose Price</th>';
					echo '<th>Online Average Complete In Box Price</th>';
					echo '<th>New Price</th>';
					echo '<th>Retail Loose Sell</th>';
					echo '<th>Retail Complete In Box Sell</th>';
					echo '<th>Gamestop Price</th>';
					echo '<th>Gamestop Trade Price</th>';
					echo '</tr>';
				echo '</thead>';
			foreach ( $pricechart as $fname ) 
				{
				echo '<tbody>';
					echo'<tr>';
						echo('<td>' . $fname -> $pname . ' </td>');
						echo('<td>' . $fname -> $cname . ' </td>');
						echo('<td>' .$fname-> $lprice .' </td>');
						echo('<td>' .$fname-> $cprice . ' </td>');
						echo('<td>' .$fname-> $nprice . ' </td>');
						echo('<td>' .$fname-> $rlsell . ' </td>');
						echo('<td>' .$fname-> $rcsell . ' </td>');
						echo('<td>' .$fname-> $gprice . ' </td>');
						echo('<td>' .$fname-> $gtprice . ' </td>');
						
					echo'</tr>';
				}
			echo'</tbody>';
			echo'</table>';
		}
		echo'</div>';
?>
</body>
<footer  style="border-top: 2px solid red; margin-top: 1ex;">
    Arieh Gennello

<span style="float: right;">
<a href="http://validator.w3.org/check/referer">HTML5</a> /
<a href="http://jigsaw.w3.org/css-validator/check/referer?profile=css3">
    CSS3 </a>
</span>
</footer>
</html>
