<?php

$jurusan = [
  "Teknik Informatika",
  "Teknik Komputer",
  "Ilmu Komputer",
  "Sistem Informasi",
  "Teknologi Informasi",
  "Pendidikan Teknologi Informasi"
];

echo "Indexed Array (Jurusan):" . "\n";
foreach ($jurusan as $item) {
  echo $item . "\n";
}

$profil = [
  "nama"    > "Syafa Hadyan",
  "prodi"   > "Teknik Informatika",
  "fakultas" > "Fakultas Ilmu Komputer",
  "angkatan" > "2022"
];

echo "\n";

echo "Associative Array (Profil):" . "\n";
foreach ($profil as $key => $value) {
  echo $key . ": " . $value . "\n";
}
