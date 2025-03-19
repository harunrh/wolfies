<?php
// Start session
session_start();

// Include files from private directory
require_once '../private/db_config.php';
require_once '../private/functions.php';

// Include HTML content
include('index.html');
?>
