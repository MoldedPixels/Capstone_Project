<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
  <title>Results!</title>
  <meta charset="utf-8" />
  <meta name="Author" content="Arieh Gennello, Felix Cori IV, Karl Kiocho" />
  <meta name="description" content="This page calls each search function and outputs the result data into CSS tables."/>
  <style>
    a { text-decoration: none; }
    a:hover { text-decoration: underline; }
	body{background-color: #eeeeee;}
	div.main {width: 75%; height:auto; margin: auto; background-color: #eeeeee;line-height: normal; clear: both;}
	div.break {clear:both;}
	div.middle {text-align : center; clear:both;}
	div.tab {width: 300px; height:auto; margin:auto; padding:5px 5px; display:inline-block; background-color: #eeeeee; vertical-align: top;line-height: normal;}
    table.fancy    { border-width: 1px, 1px, 1px, 1px;
                     border: groove black; }
	table.fancy td { border: 1px dotted black;
                     padding: 2px 5px;
                     margin: 5px 20px;
                     text-align: center;
					 align-content: center;
					 }
	table.fancy th {background-color: #4CAF50;}
	table.fancy tr {background-color: #eeeeee;}
	table.fancy tr:hover {background-color: #dddddd;}
	hr{ clear:both; }
		
  </style>
</head>
<body>
<?php
		session_start();
		echo "<center><h1>Let's see the results for: <i>". $_SESSION['gname'] . "</i></h1></center>";
	?>
	<center><div id="Menu" style = "";>
	<span style = "color: #000000; font-family: 'Palatino Linotype'; font-size: 15px;">
	<a href = "Search.html">Home</a>
    |   
	<a href = "help.php">Help</a>
	</span>
	</div></center>
	</br>
	<hr>
	</br>
<?php
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
			echo '<center><h3>No Steam Data Found!</h3></center>';
			echo '</br>';
		}
	else
		{
			echo '<div>';
				echo '<table class = "fancy"
					summary="The table of Steam Data."
					border="1"
					cellpadding="3"
					cellspacing="5">';
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
							/*
								The Twitch Data is filled here to reduce the number of API requests and to ensure that each request gets data at the time of the search. 
								Filling the Twitch Table at the start with the other databases added 2.5 hours to the loading time for each search. 
								This method is more efficient and allows for more accurate information.
							*/
							fillTwitch($fname -> name);
					
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
	echo '<hr>';
		

	echo '<div class = middle>'; // This div acts as a parent div for the divs for each table in order to keep them centered on the page.
	$twitch = searchTwitch();
	if (count($twitch) == 0 )
		{
			echo '<div class = "tab">';
			echo '<center><h3>No Twitch Data Found!</h3></center>';
			echo '</br>';
			echo'</div>';
		}
	else
		{
			echo '<center><h2> Twitch Data</h2> </center>';
			$name = '';
			$length = count($twitch);
			$i = 0;
			echo '</br>';
			foreach ($twitch as $fname)
				{
					if($name == '')
						{
							echo '<div class = "tab">'; // This div acts as a parent div for a single table to allow them to have multiple tables in a line and to align them.
								$name = $fname -> name;
								echo '<table class = "fancy"
										summary="The table of Twitch Data."
										border="1"
										cellpadding="3"
										cellspacing="5">';
								echo'<caption><i>' . $name . ' </i></caption>';
								echo '<thead>';
									echo '<tr>';
										echo '<th>Viewers</th>';
										echo '<th>Channels</th>';
										echo '<th>Timestamp</th>';
									echo '</tr>';
								echo '</thead>';
								echo ('<tbody>');
									echo ('<tr>');
										echo('<td>' . $fname-> viewers .' </td>');	
										echo('<td>' . $fname -> channels . ' </td>');
										echo('<td>' . date("H:i:s m/d/Y",strtotime($fname-> tstamp)). ' </td>');					
									echo'</tr>';
									$i++;
						}
					else
						{
							if($name == $fname -> name)
								{
									echo ('<tbody>');
										echo ('<tr>');
											echo('<td>' . $fname-> viewers .' </td>');	
											echo('<td>' . $fname -> channels . ' </td>');											
											echo('<td>' . date("H:i:s m/d/Y",strtotime($fname-> tstamp)). ' </td>');					
										echo'</tr>';
										$i++;
								}
							else
								{
									if ($i < $length)
										{
											$name = $fname -> name;
											echo'</tbody>';
											echo'</table>';
											echo'</div>';
											echo '<div class = "tab">';
												echo '<table class = "fancy td"
													summary="The table of Twitch Data."
													border="1"
													cellpadding="3"
													cellspacing="5">';
												echo'<caption><i>' . $name .' </i></caption>';
												echo '<thead>';
													echo '<tr>';
														echo '<th>Viewers</th>';
														echo '<th>Channels</th>';											
														echo '<th>Timestamp</th>';
													echo '</tr>';
												echo '</thead>';
												echo ('<tbody>');
													echo ('<tr>');
														echo('<td>' . $fname-> viewers .' </td>');
														echo('<td>' . $fname -> channels . ' </td>');
														echo('<td>' . date("H:i:s m/d/Y",strtotime($fname-> tstamp)). ' </td>');					
													echo'</tr>';
													$i++;
										}
								}
						}
				}
				//This if statement does not work within the for-each loop, which is why it is outside of the loop.
				if($i == $length)
					{
						echo'</tbody>';
						echo'</table>';
						echo'</div>';
					}
		}
	echo '</div>';		
	echo '<div class = break>';
	echo '</div>';
	echo '</br>';
	echo '<hr>';
	echo '<div class = "main">';	
		if (count($pricechart) == 0 )
			{
				echo '<center><h3>No PriceChart Data Found!</h3></center>';
				echo '</br>';
			}
		else
			{
				echo '<table class = "fancy"
						summary="The table of PriceChart Data."
						border="1"
						cellpadding="3"
						cellspacing="5">';
				echo '<center><h2> PriceChart Data</h2> </center>';
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
		echo '</br>';
		echo '</br>';
		echo '</br>';
?>
</body>
<footer  style="border-top: 2px solid red; margin-top: 1ex; margin-right: 100px; clear: left; position: relative; left: 50; right: 50; bottom:10;">
    <center>Arieh Gennello | Felix Cori IV | Karl Kiocho</center>
</footer>
</html>
