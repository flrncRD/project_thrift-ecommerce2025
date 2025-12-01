<?php
session_start();
include '../config/conn.php';

// Hapus Session
session_unset();
session_destroy();

// Redirect Home
header("Location: " . BASE_URL . "index.php");
exit();
?>