<?php
session_start();

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to admin login page
header("Location: /atari-github/atari-github/html/admin_login.html");
exit; 
?>
