<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nama = $_POST["name"];
  $nim = $_POST["nim"];
  $email = $_POST["email"];

  if (empty($nama) || empty($nim) || empty($email)) {
    echo "Please fill all fields.";
  } else {
    $sanitizedName = htmlspecialchars($name);
    $sanitizedNim = htmlspecialchars($nim);
    $sanitizedEmail = htmlspecialchars($email);

    $data = "Name: " . $sanitizedName . ", NIM: " . $sanitizedNim . ", Email: " . $sanitizedEmail . "\n";

    $filename = "data_mahasiswa.txt";

    $file = fopen($filename, "a");

    if ($file) {
      fwrite($file, $data);
      fclose($file);

      echo "Data saved.<br>";
      echo "Name: " . $sanitizedName . "<br>";
      echo "NIM: " . $sanitizedNim . "<br>";
      echo "Email: " . $sanitizedEmail;
    } else {
      echo "Failed to save data.";
    }
  }
}
