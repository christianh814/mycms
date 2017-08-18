<?php
	if (isset($_GET['p_id'])) {
		$the_post_id =  $_GET['p_id'];
	}
	$query = "SELECT * FROM posts WHERE post_id = '{$the_post_id}'";
	$select_posts_by_id = mysqli_query($connect, $query);
	while ($post = mysqli_fetch_assoc($select_posts_by_id)) {
		$post_id = $post['post_id'];
		$post_author = $post['post_author'];
		$post_user = $post['post_user'];
		$post_title = $post['post_title'];
		$post_category_id = $post['post_category_id'];
		$post_status = $post['post_status'];
		$post_image = $post['post_image'];
		$post_tags = $post['post_tags'];
		$post_comment_count = $post['post_comment_count'];
		$post_date = $post['post_date'];
		$post_content = $post['post_content'];
	}
	
	if (isset($_POST['update_post'])) {

		$post_user = $_POST['post_user'];
		$post_title = $_POST['post_title'];
		$post_category_id = $_POST['post_category'];
		$post_status = $_POST['post_status'];
		$post_image_temp = $_FILES['post_image']['tmp_name'];
		$post_content = $_POST['post_content'];
		$post_tags = $_POST['post_tags'];
		$post_image = $_FILES['post_image']['name'];
		


		if (empty($post_image)) {
			$query = "SELECT * FROM posts WHERE post_id = '{$the_post_id}'";
			$select_image = mysqli_query($connect, $query);
			while ($image = mysqli_fetch_array($select_image)) {
				$post_image = $image['post_image'];
			}
		} else {
			move_uploaded_file($post_image_temp, "../images/{$post_image}");
		}

		$query =  "UPDATE posts SET ";
		$query .= "post_title        = '{$post_title}', ";
		$query .= "post_category_id  = '{$post_category_id}', ";
		$query .= "post_date         =  now(), ";
		$query .= "post_user         = '{$post_user}', ";
		$query .= "post_status       = '{$post_status}', ";
		$query .= "post_tags         = '{$post_tags}', ";
		$query .= "post_content      = '{$post_content}', ";
		$query .= "post_image        = 'images/{$post_image}' ";
		$query .= "WHERE post_id     = {$the_post_id} ";

		$update_post = mysqli_query($connect, $query);


		confirmQuery($update_post);

		echo "<p>Post Updated: " . "<a href='../post.php?p_id={$the_post_id}'>View Posts</a> | <a href='posts.php'>Edit Posts</a></p>";

	}

?>
<form action="" method="post" enctype="multipart/form-data">
	<div class="form-group">
		<label for="title">Post Title</label>
		<input value="<?php echo $post_title; ?>" type="text" class="form-control" name="post_title">
	</div>

	<div class="form-group">
		<label for="categories">Categories</label>
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
                <?php echo "<option value='{$post_user}'>{$post_user}</option>"; ?>
                <?php
                        $users_query = "SELECT * FROM users ";
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
			<option value='<?php echo $post_status ; ?>'><?php echo $post_status ; ?></option>
			<?php
				if ($post_status == 'published') {
					echo "<option value='draft'>Draft</option>";
				} else {
					echo "<option value='published'>Published</option>";
				}
			?>
		</select>
	</div>

	<div class="form-group">
		<img width="100" src="./../<?php echo $post_image; ?>" alt="no image"></img>
	</div>

	<div class="form-group">
		<input type="file" name="post_image">
	</div>

	<div class="form-group">
		<label for="post_tags">Post Tags</label>
		<input value="<?php echo $post_tags; ?>" type="text" class="form-control" name="post_tags">
	</div>

	<div class="form-group">
		<label for="post_content">Post Content</label>
		<textarea class="form-control" name="post_content" id="" cols="30" rows="10"><?php echo $post_content; ?></textarea>
	</div>

	<div class="form-group">
		<input class="btn btn-primary" type="submit" name="update_post" value="Update Post">
	</div>


</form>
