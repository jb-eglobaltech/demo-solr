<?php 
  header('Content-Type: application/json');
  ini_set('display_errors', 'on');
  include_once('header.php');

  $status = array("Green",
                  "Yellow",
                 );
  $statusMsg = array(ucwords($myname)." server is ready for requests",
                     ucwords($myname)." server is busy",
                     );

  $index = rand(0,1);

  $data = array("id" => genrandom(),
                "name" => $self['name'],
                "status" => $status[$index],
                "message" => $statusMsg[$index]
               );

  print_r(json_encode($data, JSON_PRETTY_PRINT));



?>

