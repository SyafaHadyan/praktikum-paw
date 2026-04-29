<?php
session_start();
session_destroy();

header('Location: /php/praktikum-7/login.php?logout=1');
exit;
