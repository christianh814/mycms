<?php include "db.php"; 

if (isset($_POST['login'])) {
	$username = $_POST['username'];
	$password = $_POST['password'];

	$username = mysqli_real_escape_string($connect, $username);
	$password = mysqli_real_escape_string($connect, $password);

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
		header("Location: ../admin/index.php");
	}
}

?>
