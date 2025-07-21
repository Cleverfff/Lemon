<?php
/**
 * File: logout.php
 * Author: Pan Zitao
 * Date: 2025-07-21
 * Description: Handles the server-side logic for user logout.
 */

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