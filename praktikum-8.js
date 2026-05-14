function tampilkanSapaanWaktu() {
  const now = new Date();
  const totalMenit = now.getHours() * 60 + now.getMinutes();
  const heading = document.getElementById("sapaan");

  if (totalMenit >= 1 && totalMenit <= 659) {
    heading.textContent = "SELAMAT PAGI";
  } else if (totalMenit >= 660 && totalMenit <= 839) {
    heading.textContent = "SELAMAT SIANG";
  } else if (totalMenit >= 840 && totalMenit <= 1079) {
    heading.textContent = "SELAMAT SORE";
  } else {
    heading.textContent = "SELAMAT PETANG";
  }
}

tampilkanSapaanWaktu();
