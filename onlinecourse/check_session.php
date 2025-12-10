<?php
session_start();
echo "=== SESSION CHECK ===\n";
echo "Session ID: " . session_id() . "\n";
echo "Session Status: " . session_status() . "\n\n";

echo "Session Data:\n";
var_dump($_SESSION);

echo "\n\nCookies:\n";
var_dump($_COOKIE);
?>
