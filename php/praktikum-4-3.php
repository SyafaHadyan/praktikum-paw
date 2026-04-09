<?php

class Mahasiswa
{
  public $nim;
  public $nama;
  public $prodi;

  public function __construct($nim, $nama, $prodi)
  {
    $this->nim = $nim;
    $this->nama = $nama;
    $this->prodi = $prodi;
  }

  public function kuliah()
  {
    echo $this->nama . " sedang mengikuti perkuliahan." . "\n";
  }

  public function ujian()
  {
    echo $this->nama . " sedang mengikuti ujian." . "\n";
  }

  public function praktikum()
  {
    echo $this->nama . " sedang mengikuti praktikum." . "\n";
  }
}

$mahasiswa1 = new Mahasiswa("245150207111047", "Syafa Hadyan Rasendriya", "Teknik Informatika");
$mahasiswa2 = new Mahasiswa("123456789098765", "Rasendriya Hadyan Syafa", "Teknik Informatika");

echo "Mahasiswa 1:" . "\n";
echo "NIM: " . $mahasiswa1->nim . "\n";
echo "Nama: " . $mahasiswa1->nama . "\n";
echo "Prodi: " . $mahasiswa1->prodi . "\n";
$mahasiswa1->kuliah();
$mahasiswa1->ujian();
$mahasiswa1->praktikum();

echo "\n";

echo "Mahasiswa 2:" . "\n";
echo "NIM: " . $mahasiswa2->nim . "\n";
echo "Nama: " . $mahasiswa2->nama . "\n";
echo "Prodi: " . $mahasiswa2->prodi . "\n";
$mahasiswa2->kuliah();
$mahasiswa2->ujian();
$mahasiswa2->praktikum();
