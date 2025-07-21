<?php
// filepath: c:\Users\97701\Desktop\Lemon\lemon\logout.php

// Start the session
session_start();

// Unset all of the session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to login page
header("location: login.html");
exit;
?>