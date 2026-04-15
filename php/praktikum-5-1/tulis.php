<?php
$filename = "catatan.txt";

$data = "using file_put_contents()\n";
$data .= "PHP automatic\n";
$data .= "Creation date " . date("Y-m-d H:i:s") . "\n";

$result = file_put_contents($filename, $data);

if ($result !== false) {
  echo "Written to " . $filename;
} else {
  echo "Failed to write to file";
}
