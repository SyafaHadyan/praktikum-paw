<?php
$filename = "catatan.txt";

$file = fopen($filename, "a");

if ($file) {
  $tambahan = "Test add using fwrite()\n";
  $tambahan .= "Test add date " . date("Y-m-d H:i:s") . "\n";

  fwrite($file, $tambahan);
  fclose($file);

  echo "Data berhasil ditambahkan ke " . $filename;
} else {
  echo "Gagal membuka file.";
}
