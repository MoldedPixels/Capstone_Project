<?php
function fillSteam()
{
	require_once('capconnect.php');
	$dbh = ConnectDB();
    $url = 'steamspy.com/api.php?request=all';


    // Use cURL to get data in JSON format
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $json_data = curl_exec($curl);
    curl_close($curl);

    $data = json_decode($json_data, true);
	//print_r($data);
		foreach($data as $item){
			//print_r($item);
			try 
			{
				$query = 'INSERT INTO capstone.steamspy_results(appid, name, developers, publishers, score, positive, negative, userscore, owners, avg_forever, avg_2weeks, med_forever, med_2weeks, price, init_price, discount ) ' .
					'VALUES (:appid, :name, :developers, :publishers, :score, :positive, :negative, :userscore, :owners, :avg_forever, :avg_2weeks, :med_forever, :med_2weeks, :price, :init_price, :discount)';
				$stmt = $dbh->prepare($query);
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
				//$ccu = $item['ccu'];
				$price = $item['price'];
				$iprice = $item['initialprice'];
				$disc = $item['discount'];
				//$tags = $item['tags'];
				//$langs = $item['languages'];
				//$genre = $item['genre'];
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
				//$stmt->bindParam(':ccu', $ccu );
				$stmt->bindParam(':price', $price);
				$stmt->bindParam(':init_price',$iprice);
				$stmt->bindParam(':discount',$disc);
				//$stmt->bindParam(':tags', $tags);
				//$stmt->bindParam(':languages', $langs);
				//$stmt->bindParam(':genre', $genre);
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