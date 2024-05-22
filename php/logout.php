<?php
session_start();
session_destroy();
header("Location: /atari-github/atari-github/html/sign-in.html");
exit();
?>
