<?php
function fillTwitch($game)
{
	require_once('capconnect.php');
	$dbh = ConnectDB();
	$clientid = 'wk5d3iadtpck0p8ucazpnzaza03b11';
	$sgame = urlencode($game);
	$sgame = str_replace("%3A",":", $sgame);
    $url = 'https://api.twitch.tv/kraken/streams/summary?game=' . $sgame;

    // Use cURL to get data in JSON format
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_HTTPHEADER, array("Client-ID: " . $clientid, "Accept: application/vnd.twitchtv.v4+json"));
    $json_data = curl_exec($curl);
    curl_close($curl);

    $data = json_decode($json_data, true);
	//$id = 0;
	//$name = $item['name'];
	//$steamid = $item['appid'];
	if(isset($data['error'],$data['status']))
		{
			echo "Error Found";
		}
	else
	{
				try
					{
						$query = 'INSERT INTO capstone.twitch(name, channels, viewers) ' .
						'VALUES (:name, :channels, :viewers)';
						$stmt = $dbh->prepare($query);
						$channels = $data["channels"];
						$viewers = $data["viewers"];
							
						$stmt->bindParam(':name', $game);
						$stmt->bindParam(':channels', $channels );
						$stmt->bindParam(':viewers', $viewers );
						$stmt->execute();
						$stmt = null;
					}
			
				catch(PDOException $e)
					{
						die('PDO error inserting(): ' . $e->getMessage());
					}
			}
}		 
?>
