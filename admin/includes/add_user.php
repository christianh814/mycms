<?php
	if (isset($_POST['create_user'])){
		$user_firstname = $_POST['user_firstname'];
		$user_lastname = $_POST['user_lastname'];
		$usre_role = $_POST['usre_role'];
		$user_name = $_POST['user_name'];

		$user_image = $_FILES['image']['name'];
		$user_image_temp = $_FILES['image']['tmp_name'];

		$user_email = $_POST['user_email'];
		$user_password = $_POST['user_password'];

		move_uploaded_file($user_image_temp, "../images/{$user_image}");

		$password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 12) );
		$user_password = $password;

		$query = "INSERT INTO users (user_id, user_name, user_password, user_firstname, user_lastname, user_email, user_image, usre_role)";
		$query .= "VALUES (NULL, '{$user_name}', '{$user_password }', '$user_firstname', '$user_lastname', '$user_email', 'images/{$user_image}', '$usre_role')";

		$create_post_query = mysqli_query($connect, $query);

		confirmQuery($create_post_query);

		echo "User Created " . "<a href='users.php'>View Users </a>";


	}
?>
<form action="" method="post" enctype="multipart/form-data">
	<div class="form-group">
		<label for="user_firstname">Firstname</label>
		<input type="text" class="form-control" name="user_firstname">
	</div>

	<div class="form-group">
		<label for="user_lastname">Lastname</label>
		<input type="text" class="form-control" name="user_lastname">
	</div>


	<div class="form-group">
		<select name="usre_role" id="">
			<option value="subscriber">&mdash; SELECT OPTION &mdash;</option>
			<option value="admin">Admin</option>
			<option value="subscriber">Subscriber</option>
		</select>
	</div>

	<div class="form-group">
		<label for="user_name">Username</label>
		<input type="text" class="form-control" name="user_name">
	</div>

	<div class="form-group">
		<label for="user_email">Email</label>
		<input type="text" class="form-control" name="user_email">
	</div>

	<div class="form-group">
		<label for="post_tags">Password</label>
		<input type="password" class="form-control" name="user_password">
	</div>

	<div class="form-group">
		<label for="post_image">User Image</label>
		<input type="file" name="image">
	</div>

	<div class="form-group">
		<input class="btn btn-primary" type="submit" name="create_user" value="Create User">
	</div>


</form>
