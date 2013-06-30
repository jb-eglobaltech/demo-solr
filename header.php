<?php

$file = file_get_contents('app.json');
$json = json_decode($file,true);
$connects = $json['services'];
$myname = $json['name'];
$app = $json['app'];

/* Set self instance */
list($file) = glob('../env/'.$myname.'*.json'); 
$json = file_get_contents($file);
$self = json_decode($json,true);

/* Set services array */
$services = array();

foreach($connects as $connect) {
	list($file) = glob('../env/'.$connect.'*.json'); 
	$json = file_get_contents($file);
	$services[$connect] = json_decode($json,true);
}


function genrandom() {
  $characters = 'abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ123456789';
  $string = '';
  for ($i = 0; $i < 20; $i++) {
      $string .= $characters[rand(0, strlen($characters) - 1)];
  }
  return $string;
}

?>
