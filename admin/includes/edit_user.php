<?php
	if (isset($_GET['e_id'])) {
		$the_user_id = $_GET['e_id'];

		$query = "SELECT * FROM users where user_id = '$the_user_id' ";
		$select_users = mysqli_query($connect, $query);
		while ($users = mysqli_fetch_assoc($select_users)) {
			$user_id = $users['user_id'];
			$user_name = $users['user_name'];
			$user_password = $users['user_password'];
			$user_firstname = $users['user_firstname'];
			$user_lastname = $users['user_lastname'];
			$user_email = $users['user_email'];
			$user_image = $users['user_image'];
			$user_role = $users['usre_role'];
			$rand_salt = $users['rand_salt'];
			}
	}
	if (isset($_POST['edit_user'])){
		$user_firstname = $_POST['user_firstname'];
		$user_lastname = $_POST['user_lastname'];
		$user_role = $_POST['usre_role'];
		$user_name = $_POST['user_name'];
		$user_image = $_FILES['image']['name'];

		$user_image_temp = $_FILES['image']['tmp_name'];

		$user_email = $_POST['user_email'];
		$user_password = $_POST['user_password'];


                if (empty($user_image)) {
                        $query = "SELECT * FROM users WHERE user_id = '{$the_user_id}'";
                        $select_image = mysqli_query($connect, $query);
                        while ($image = mysqli_fetch_array($select_image)) {
                                $user_image = $image['user_image'];
                        }
                } else {
			move_uploaded_file($user_image_temp, "../images/{$user_image}");
		}
		$query = "SELECT rand_salt FROM users ";
		$select_randsalt_query = mysqli_query($connect, $query);

		if (!$select_randsalt_query) {
			die("Error: " . mysqli_error($connect));
		}

		while ($pw = mysqli_fetch_array($select_randsalt_query)) {
			$salt = $pw['rand_salt'];
		}
		$enc_password = crypt($user_password, $salt);

                $query =  "UPDATE users SET ";
                $query .= "user_firstname        = '{$user_firstname}', ";
                $query .= "user_lastname  = '{$user_lastname}', ";
                $query .= "usre_role       = '{$user_role}', ";
                $query .= "user_name       = '{$user_name}', ";
                $query .= "user_email      = '{$user_email}', ";
                $query .= "user_password      = '{$enc_password}', ";
                $query .= "user_image        = 'images/{$user_image}' ";
                $query .= "WHERE user_id     = {$the_user_id} ";

                $update_user = mysqli_query($connect, $query);

                confirmQuery($update_user);



	}
?>
<form action="" method="post" enctype="multipart/form-data">
	<div class="form-group">
		<label for="user_firstname">Firstname</label>
		<input type="text" value="<?php echo $user_firstname ?>" class="form-control" name="user_firstname">
	</div>

	<div class="form-group">
		<label for="user_lastname">Lastname</label>
		<input type="text" value="<?php echo $user_lastname ?>" class="form-control" name="user_lastname">
	</div>

	<div class="form-group">
		<select name="usre_role" id="">
			<option value="subscriber"><?php echo $user_role ?></option>
			<?php
				if ($user_role == 'admin') {
					echo "<option value='subscriber'>Subscriber</option>";
				} else {
					echo "<option value='admin'>Admin</option>";
				}
			?>
		</select>
	</div>

	<div class="form-group">
		<label for="user_name">Username</label>
		<input type="text" value="<?php echo $user_name ?>" class="form-control" name="user_name">
	</div>

	<div class="form-group">
		<label for="user_email">Email</label>
		<input type="text" value="<?php echo $user_email ?>"class="form-control" name="user_email">
	</div>

	<div class="form-group">
		<label for="post_tags">Password</label>
		<input type="password" value="<?php echo $user_password ?>" class="form-control" name="user_password">
	</div>

	<div class="form-group">
 		<img width="100" src="./../<?php echo $user_image; ?>" alt="no image"></img>
	</div>

	<div class="form-group">
		<label for="post_image">User Image</label>
		<input value="<?php echo $user_image ?>" type="file" name="image">
	</div>

	<div class="form-group">
		<input class="btn btn-primary" type="submit" name="edit_user" value="Update User">
	</div>


</form>
