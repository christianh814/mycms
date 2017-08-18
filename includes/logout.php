<?php
session_start();
$_SESSION['user_name'] = null;
$_SESSION['user_firstname'] = null;
$_SESSION['user_lastname'] = null;
$_SESSION['usre_role'] = null;
$_SESSION['user_id'] = null;
//
header("Location: ../index.php");
?>
