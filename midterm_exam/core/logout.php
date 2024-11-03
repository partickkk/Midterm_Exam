<?php
session_start();
unset($_SESSION['bakeryID']);
unset($_SESSION['username']);
header("Location: ../login.php");
?>