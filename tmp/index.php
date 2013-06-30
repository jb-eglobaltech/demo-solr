<?php 

$url = "";
if ($handle = opendir('.')) {
    $blacklist = array('.', '..', 'env', 'index.php');
    while (false !== ($file = readdir($handle))) {
        if (!in_array($file, $blacklist)) {
            $url = $file;
		break;
        }
    }
    closedir($handle);
}

header("Location: ".$url);
?>
