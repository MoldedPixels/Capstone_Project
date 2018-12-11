<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
	<head>
		<title>Function Page</title>
		<meta charset="utf-8" />
		<meta name="Author" content="Arieh Gennello, Felix Cori IV, Karl Kiocho" />
		<meta name="description" content="This page is a single function and will not display. This function fills the Twitch table with the data returned from the API request."/>
	</head>
</html>
<?php
// WARNING: As of January 1, 2019 Twitch is depreciating this API!
function fillTwitch($game)
	{
		require_once('capconnect.php');
		$dbh = ConnectDB();
		$clientid = 'wk5d3iadtpck0p8ucazpnzaza03b11';
		$sgame = urlencode($game);
		$sgame = str_replace("%3A",":", $sgame);
		$url = 'https://api.twitch.tv/kraken/streams/summary?game=' . $sgame;
		// Use cURL to get data from the request in JSON format.
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array("Client-ID: " . $clientid, "Accept: application/vnd.twitchtv.v4+json"));
		$json_data = curl_exec($curl);
		curl_close($curl);
		$data = json_decode($json_data, true);
		//Check the JSON for error codes.
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
