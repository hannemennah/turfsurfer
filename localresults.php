<?php
require 'config.php';


// Get parameters from URL
$center_lat = $_GET["lat"];
$center_lng = $_GET["lng"];
$radius = $_GET["radius"];

// Start XML file, create parent node
$dom = new DOMDocument("1.0");
$node = $dom->createElement("markers");
$parnode = $dom->appendChild($node);


//Connect to database
$dbh = new PDO("mysql:host=$db_host;dbname=$db_name", $db_username, $db_password);
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
try {
// Prepare statement
$stmt = $dbh->prepare("SELECT  name, address, lat, lng, ( 3959 * acos( cos( radians(?) ) * cos( radians( lat ) ) * cos( radians( lng ) - radians(?) ) + sin( radians(?) ) * sin( radians( lat ) ) ) ) AS distance FROM markers HAVING distance < ? ORDER BY distance LIMIT 0 , 20");
// Assign parameters
$stmt->bindParam(1,$center_lat);
$stmt->bindParam(2,$center_lng);
$stmt->bindParam(3,$center_lat);
$stmt->bindParam(4,$radius);
//Execute query
$stmt->setFetchMode(PDO::FETCH_ASSOC);
$stmt->execute();
header("Content-type: text/xml");

// Iterate through the rows, adding XML nodes for each
while($row = $stmt->fetch()) {
    $node = $dom->createElement("marker");
    $newnode = $parnode->appendChild($node);
    $newnode->setAttribute("name", $row['name']);
    $newnode->setAttribute("address", $row['address']);
    $newnode->setAttribute("lat", $row['lat']);
    $newnode->setAttribute("lng", $row['lng']);
    $newnode->setAttribute("distance", $row['distance']);
    }
echo $dom->saveXML();
 }
 catch(PDOException $e) {
echo "I'm sorry I'm afraid you can't do that.". $e->getMessage() ;// Remove or modify after testing 
file_put_contents('PDOErrors.txt',date('[Y-m-d H:i:s]').", phpsqlsearch_genxml.php, ". $e->getMessage()."\r\n", FILE_APPEND);  
 }
//Close the connection
$dbh = null; 



?>
