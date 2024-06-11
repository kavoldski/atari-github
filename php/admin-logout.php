<?php
session_start();
session_destroy();
header("Location: /atari-github/atari-github/html/admin_login.html");
exit();
?>
