<?php 

  header('Content-Type: application/json');
  ini_set('display_errors', 'on');
  include_once('header.php');

  // Website url to open
  $service_name = $_GET['service'];

  $url = 'http://'.$services[$service_name]['automatic']['ec2']['public_ipv4'].'/demo-'.$service_name.'/status.php';

  $json = file_get_contents($url);

  $data = json_decode($json, TRUE);

  print_r(json_encode($data, JSON_PRETTY_PRINT));

?>

