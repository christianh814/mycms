<?php include "db.php"; 
session_start();

if (isset($_POST['login'])) {
	$username = $_POST['username'];
	$posted_password =$_POST['password'];

	$username = mysqli_real_escape_string($connect, $username);
	$posted_password = mysqli_real_escape_string($connect, $posted_password);

	//
        $query = "SELECT rand_salt FROM users ";
        $select_randsalt_query = mysqli_query($connect, $query);

        if (!$select_randsalt_query) {
        	die("Error: " . mysqli_error($connect));
        }

        while ($pw = mysqli_fetch_array($select_randsalt_query)) {
		$salt = $pw['rand_salt'];
        }

        $password = crypt($posted_password, $salt);
	//


	$query = "SELECT * FROM users WHERE user_name = '{$username}' AND user_password = '{$password}' ";
	$select_user = mysqli_query($connect, $query);

	if (!$select_user) {
		die("ERROR: " . mysqli_error($connect));
	}

	while ($user = mysqli_fetch_array($select_user)) {
		$user_id = $user['user_id'];
		$user_password = $user['user_password'];
		$user_firstname = $user['user_firstname'];
		$user_lastname = $user['user_lastname'];
		$user_role = $user['usre_role'];
		$user_name = $user['user_name'];
	}
	if (!isset($user_id)) {
		header("Location: ../index.php");
	} else {
		$_SESSION['user_name'] = $user_name;
		$_SESSION['user_firstname'] = $user_firstname;
		$_SESSION['user_lastname'] = $user_lastname;
		$_SESSION['usre_role'] = $user_role;
		header("Location: ../admin/index.php");
	}
}

?>
