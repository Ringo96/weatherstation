<?php

$row = 1;

$file = '/home/pi/temps.csv';

$handle = fopen($file, "r") or die("Cant open file because: $php_errormsg");
if ($handle !== FALSE) {
  while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
    $num = count($data);
    $row++;
    for ($c=0; $c < $num; $c++) {
        echo str_replace(",",".",$data[$c]) . "/";
    }
	echo "\n";
  }
  fclose($handle);
}else
{
	echo "Could not open file!";
}

?>