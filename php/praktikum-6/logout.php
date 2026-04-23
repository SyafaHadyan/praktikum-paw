<?php
session_start();
session_destroy();

setcookie('last_user', '', time() - 3600, '/');

header("Location: login.php?logout=1");
exit;
