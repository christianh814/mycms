<?php

function escapeText($string) {
	global $connect;
	return mysqli_real_escape_string($connect, trim($string));
}

//
function confirmQuery($result) {
	global $connect;
	if (!$result) {
		die("QUERY FAILED: " . mysqli_error($connect));
	}
}
//

function insertCategories() {
	global $connect;
	if(isset($_POST['submit'])) {
	$cat_title = $_POST['cat_title'];
		if ($cat_title == "" || empty($cat_title)) {
			echo "This field should not be empty!";
		} else {
			$query = "INSERT INTO categories (cat_title)";
			$query .= "VALUE ('{$cat_title}')";
			$create_category_query = mysqli_query($connect, $query);
			if (!$create_category_query) {
				die('Category Creation FAILED: ' . mysqli_error($connect));
			}
		}
	}
}
//

function findCategories() {
	global $connect;
	$query = "SELECT * FROM categories";
	$select_categories = mysqli_query($connect, $query);
	while ($cat = mysqli_fetch_assoc($select_categories)) {
		$cat_id = $cat['cat_id'];
		$cat_title = $cat['cat_title'];
		echo "<tr>";
		echo "<td>" . $cat_id . "</td>";
		echo "<td>" . $cat_title . "</td>";
		echo "<td>";
		echo "<a href='categories.php?delete=" . $cat_id . "' class='btn btn-danger' role='button'>Delete</a>";
		echo "&nbsp;&nbsp;";
		echo "<a href='categories.php?edit=" . $cat_id . "' class='btn btn-warning' role='button'>Edit</a>";
		echo "</td>";
		echo "</tr>";
	}
}
//

function deleteCategories() {
	global $connect;
	if (isset($_GET['delete'])) {
		$the_cat_id = $_GET['delete'];
		$query = "DELETE FROM categories WHERE cat_id = {$the_cat_id} ";
		$delete_query = mysqli_query($connect, $query);
		header("Location: categories.php");
}

}
//

function editCategories() {
	global $connect;
	if (isset($_GET['edit'])) {
		$cat_id = $_GET['edit'];
		include "includes/update_categories.php";
	}

}
//

function recordCount($table) {
	global $connect;
	$query = "SELECT * FROM " . $table;
	$select_all = mysqli_query($connect, $query);
	return mysqli_num_rows($select_all); 

}
//

function checkStatus($table, $column, $status) {
	global $connect;
	$query = "SELECT * FROM  $table WHERE $column = '$status' ";
	$result = mysqli_query($connect, $query);
	return mysqli_num_rows($result); 
}
//

function checkUserRole($table, $column, $role) {
	global $connect;
	$query = "SELECT * FROM  $table WHERE $column = '$role' ";
	$result = mysqli_query($connect, $query);
	return mysqli_num_rows($result); 
}
//

function isAdmin($username) {
	global $connect;
	$query = "SELECT usre_role FROM users WHERE user_name = '{$username}' ";
	$result = mysqli_query($connect, $query);
	$row = mysqli_fetch_array($result);
	if ($row['usre_role'] == 'admin') {
		return true;
	} else {
		return false;
	}
}
//

function usernameExists($username) {
	global $connect;
	$query = "SELECT user_name FROM users WHERE user_name = '{$username}' ";
	$result = mysqli_query($connect, $query);
	if (mysqli_num_rows($result) > 0 ) {
		return true;
	} else {
		return false;
	}
}
//

function emailExists($email) {
	global $connect;
	$query = "SELECT user_email FROM users WHERE user_email = '{$email}' ";
	$result = mysqli_query($connect, $query);
	if (mysqli_num_rows($result) > 0 ) {
		return true;
	} else {
		return false;
	}
}
//

function loginUser($username, $password) {
	global $connect;
        $username = trim(mysqli_real_escape_string($connect, $username));
        $posted_password = trim(mysqli_real_escape_string($connect, $password));

        $query = "SELECT * FROM users WHERE user_name = '{$username}' ";
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
        if (!password_verify($posted_password, $user_password)) {
		redirectTo('/cms');
        } else {
                $_SESSION['user_name'] = $user_name;
                $_SESSION['user_firstname'] = $user_firstname;
                $_SESSION['user_lastname'] = $user_lastname;
                $_SESSION['usre_role'] = $user_role;
		redirectTo('/cms/admin');
        }  
}
//

function redirectTo($location) {
	return header("Location: " . $location);
}
//

function registerUser($username, $email, $password){
	global $connect;
	$password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));
	$user_password = $password;
	$query = "INSERT INTO users (user_name, user_email, user_password, usre_role) ";
	$query .= "VALUES ('{$username}', '{$email}','{$user_password}','subscriber') ";
	$register_user = mysqli_query($connect, $query);

}
//

function usersOnline() {
	if (isset($_GET['onlineusers'])) {
		global $connect;
		 if (!$connect) {
		 	session_start();
			include("../includes/db.php");

			$session = session_id();
			$time = time();
			$time_out_in_seconds = 60;
			$timeout = $time -$time_out_in_seconds;
	
			$query = "SELECT * FROM users_online WHERE session = '{$session}' ";
			$send_query = mysqli_query($connect, $query);
			$count = mysqli_num_rows($send_query);
	
			if ($count == NULL) {
				mysqli_query($connect, "INSERT INTO users_online(session, time) VALUES('{$session}', '{$time}') ");
			} else {
				mysqli_query($connect, "UPDATE users_online SET time = '{$time}' WHERE session = '{$session}' ");
			}
			$users_online = mysqli_query($connect, "SELECT * FROM users_online WHERE time > '{$timeout}' ");
			echo $counted_user = mysqli_num_rows($users_online);
		}

	}


}
//
usersOnline();
//

//
//
//
?>
