<?php

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

function usersOnline() {
	global $connect;

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
	return $counted_user = mysqli_num_rows($users_online);


}

//
//
//
?>
