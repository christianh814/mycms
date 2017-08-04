<?php
	if (isset($_POST['create_post'])){
		$post_title = $_POST['title'];
		$post_author = $_POST['author'];
		$post_category_id = $_POST['post_category'];
		$post_status = $_POST['post_status'];

		$post_image = $_FILES['image']['name'];
		$post_image_temp = $_FILES['image']['tmp_name'];

		$post_tags = $_POST['post_tags'];
		$post_content = $_POST['post_content'];
		$post_date = date('d-m-y');
		$post_comment_count = 0;

		move_uploaded_file($post_image_temp, "../images/{$post_image}");

		$query = "INSERT INTO posts(post_category_id, post_title, post_author, post_date, post_image, post_content, post_tags, post_comment_count, post_status)";
		$query .= "VALUES ('{$post_category_id}', '{$post_title}', '{$post_author}', now(), 'images/{$post_image}', '{$post_content}', '{$post_tags}', '{$post_comment_count}', '{$post_status}')";

		$create_post_query = mysqli_query($connect, $query);

		confirmQuery($create_post_query);


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
		<?php
			$query = "SELECT * FROM users";
			$select_user_role = mysqli_query($connect, $query);
			confirmQuery($select_user_role);
			while ($role = mysqli_fetch_assoc($select_user_role)) {
				$user_id = $role['user_id'];
				$user_role = $role['usre_role'];
				echo "<option value='{$user_id}'>{$user_role}</option>";
			}
		?>
		</select>
	</div>

	<div class="form-group">
		<label for="user_name">Username</label>
		<input type="text" class="form-control" name="user_name">
	</div>

	<div class="form-group">
		<label for="post_tags">Password</label>
		<input type="text" class="form-control" name="user_password">
	</div>

<!--
	<div class="form-group">
		<label for="post_category">Post Category Id</label>
		<input type="text" class="form-control" name="post_category_id">
	</div>
-->

<!--
	<div class="form-group">
		<label for="post_image">Post Image</label>
		<input type="file" name="image">
	</div>
-->

	<div class="form-group">
		<input class="btn btn-primary" type="submit" name="create_user" value="Create User">
	</div>


</form>
