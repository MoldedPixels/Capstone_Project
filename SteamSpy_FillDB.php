<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
	<head>
		<title>Function Page</title>
		<meta charset="utf-8" />
		<meta name="Author" content="Arieh Gennello, Felix Cori IV, Karl Kiocho" />
		<meta name="description" content="This page is a single function and will not display. This function fills the SteamSpy table with the data returned from the API request."/>
	</head>
</html>
<?php
function fillSteam()
	{
		require_once('capconnect.php');
		$dbh = ConnectDB();
		$url = 'steamspy.com/api.php?request=all';
		// Use cURL to get data from the request in JSON format.
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$json_data = curl_exec($curl);
		curl_close($curl);
		$data = json_decode($json_data, true);
		foreach($data as $item)
			{
				try 
					{
						$query = 'INSERT INTO capstone.steamspy_results(appid, name, developers, publishers, score, positive, negative, userscore, owners, avg_forever, avg_2weeks, med_forever, med_2weeks, price, init_price, discount ) ' .
							'VALUES (:appid, :name, :developers, :publishers, :score, :positive, :negative, :userscore, :owners, :avg_forever, :avg_2weeks, :med_forever, :med_2weeks, :price, :init_price, :discount)';
						$stmt = $dbh->prepare($query);
						// Assign data from the item in the JSON to local variables.
						$appid = $item['appid'];
						$name = $item['name'];
						$devs = $item['developer'];
						$pubs = $item['publisher'];
						$score = $item['score_rank'];
						$pos = $item['positive'];
						$neg = $item['negative'];
						$uscore = $item['userscore'];
						$owns = $item['owners'];
						$avgf = $item['average_forever'];
						$avg2 = $item['average_2weeks'];
						$medf = $item['median_forever'];
						$med2 = $item['median_2weeks'];
						$price = $item['price'];
						$iprice = $item['initialprice'];
						$disc = $item['discount'];
						// Bind the local variables to their matching parameter in the query.
						$stmt->bindParam(':appid', $appid);
						$stmt->bindParam(':name', $name );
						$stmt->bindParam(':developers', $devs);
						$stmt->bindParam(':publishers',$pubs);
						$stmt->bindParam(':score',$score);
						$stmt->bindParam(':positive', $pos);
						$stmt->bindParam(':negative', $neg);
						$stmt->bindParam(':userscore', $uscore );
						$stmt->bindParam(':owners', $owns);
						$stmt->bindParam(':avg_forever',$avgf);
						$stmt->bindParam(':avg_2weeks',$avg2);
						$stmt->bindParam(':med_forever', $medf);
						$stmt->bindParam(':med_2weeks', $med2);
						$stmt->bindParam(':price', $price);
						$stmt->bindParam(':init_price',$iprice);
						$stmt->bindParam(':discount',$disc);
						// Execute the query.
						$stmt->execute();
						$stmt = null;
					}
				catch(PDOException $e)
					{
						die ('PDO error inserting(): ' . $e->getMessage() );
					}	
			}
	}
?>