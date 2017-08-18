<?php
	if (isset($_POST['create_post'])){
		$post_title = escapeText($_POST['title']);
		$post_user = escapeText($_POST['post_user']);
		$post_category_id = escapeText($_POST['post_category']);
		$post_status = escapeText($_POST['post_status']);

		$post_image = $_FILES['image']['name'];
		$post_image_temp = $_FILES['image']['tmp_name'];

		$post_tags = escapeText($_POST['post_tags']);
		$post_content = escapeText($_POST['post_content']);
		$post_date = date('d-m-y');
		$post_comment_count = 0;

		move_uploaded_file($post_image_temp, "../images/{$post_image}");

		$query = "INSERT INTO posts(post_category_id, post_title, post_user, post_date, post_image, post_content, post_tags, post_comment_count, post_status)";
		$query .= "VALUES ('{$post_category_id}', '{$post_title}', '{$post_user}', now(), 'images/{$post_image}', '{$post_content}', '{$post_tags}', '{$post_comment_count}', '{$post_status}')";


		$create_post_query = mysqli_query($connect, $query);

		confirmQuery($create_post_query);

		$the_post_id = mysqli_insert_id($connect);
		echo "<p>Post Created: " . "<a href='../post.php?p_id={$the_post_id}'>View Post</a> | <a href='posts.php'>Edit Posts</a></p>";


	}
?>
<form action="" method="post" enctype="multipart/form-data">
	<div class="form-group">
		<label for="title">Post Title</label>
		<input type="text" class="form-control" name="title">
	</div>

	<div class="form-group">
		<label for="category">Category</label>
		<select name="post_category" id="">
		<?php
			$query = "SELECT * FROM categories";
			$select_categories = mysqli_query($connect, $query);
			confirmQuery($select_categories);
			while ($cat = mysqli_fetch_assoc($select_categories)) {
				$cat_id = $cat['cat_id'];
				$cat_title = $cat['cat_title'];
				echo "<option value='{$cat_id}'>{$cat_title}</option>";
			}
		?>
		</select>
	</div>

	<div class="form-group">
		<label for="users">Users</label>
		<select name="post_user" id="">
		<?php
			$users_query = "SELECT * FROM users";
			$select_users = mysqli_query($connect, $users_query);
			confirmQuery($select_users);
			while ($user = mysqli_fetch_assoc($select_users)) {
				$user_id = $user['user_id'];
				$user_name = $user['user_name'];
				echo "<option value='{$user_name}'>{$user_name}</option>";
			}
		?>
		</select>
	</div>


	<div class="form-group">
		<select name="post_status" id="">
			<option value="draft">&mdash; Post Status &mdash;</option>
			<option value="published">Publish</option>
			<option value="draft">Draft</option>
		</select>
	</div>

	<div class="form-group">
		<label for="post_image">Post Image</label>
		<input type="file" name="image">
	</div>

	<div class="form-group">
		<label for="post_tags">Post Tags</label>
		<input type="text" class="form-control" name="post_tags">
	</div>

	<div class="form-group">
		<label for="post_content">Post Content</label>
		<textarea class="form-control" name="post_content" id="" cols="30" rows="10"></textarea>
	</div>

	<div class="form-group">
		<input class="btn btn-primary" type="submit" name="create_post" value="Publish Post">
	</div>


</form>
