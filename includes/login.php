<?php
session_start();
include "db.php"; 
include "../admin/functions.php"; 

if (isset($_POST['login'])) {
	loginUser($_POST['username'], $_POST['password']);
}

?>
