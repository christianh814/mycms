 	<?php
		if (isset($_POST['checkBoxArray'])) {
			foreach ($_POST['checkBoxArray'] as $checkBoxValue) {
				$bulk_options = $_POST['bulk_options'];
				switch ($bulk_options) {
					case 'published':
						$query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = '{$checkBoxValue}' ";
						$update_to_published = mysqli_query($connect, $query);
						confirmQuery($update_to_published);
					break;
					case 'draft':
						$query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = '{$checkBoxValue}' ";
						$update_to_draft = mysqli_query($connect, $query);
						confirmQuery($update_to_draft);
					break;
					case 'delete':
						$query = "DELETE FROM posts WHERE post_id = '{$checkBoxValue}' ";
						$delete_post = mysqli_query($connect, $query);
						confirmQuery($delete_post);
					break;
				}
			}
		}
	?>
	<form action="" method="post">
		    <table class="table table-bordered table-hover">

		    <div id="bulkOptionsContainer" class="col-xs-4">
		    	<select class="form-control" name="bulk_options" id="">
				<option value="">Select Options</option>
				<option value="published">Publish</option>
				<option value="draft">Draft</option>
				<option value="delete">Delete</option>
			</select>
		    </div>
		    <div>
		    	<input type="submit" name="submit" class="btn btn-success" value="Apply">
			<a class="btn btn-primary" href="posts.php?source=add_post">Add New</a>
		    </div>

		      <br>
		      <thead>
		        <tr>
			  <th><input type="checkbox" id="selectAllBoxes"></th>
			  <th>Id</th>
			  <th>Author</th>
			  <th>Title</th>
			  <th>Category</th>
			  <th>Status</th>
			  <th>Image</th>
			  <th>Tags</th>
			  <th>Comments</th>
			  <th>Date</th>
			  <th>Action</th>
			</tr>
		      </thead>
		      <tbody>
			<?php
				$query = "SELECT * FROM posts";
				$select_posts = mysqli_query($connect, $query);
					while ($post = mysqli_fetch_assoc($select_posts)) {
						$post_id = $post['post_id'];
						$post_author = $post['post_author'];
						$post_title = $post['post_title'];
						$post_category_id = $post['post_category_id'];
						$post_status = $post['post_status'];
						$post_image = $post['post_image'];
						$post_tags = $post['post_tags'];
						$post_comment_count = $post['post_comment_count'];
						$post_date = $post['post_date'];
						// Put information in the table
						echo "<tr>";
						?>
						<td><input class="checkBoxes" type="checkbox" name="checkBoxArray[]" value='<?php echo $post_id ;?>'></td>
						<?php
						echo "<td>{$post_id}</td>";
						echo "<td>{$post_author}</td>";
						echo "<td><a href='../post.php?p_id={$post_id}'>{$post_title}</a></td>";
						// Get the category based on the what we get from the posts table
						$query = "SELECT * FROM categories WHERE cat_id = {$post_category_id} ";
						$select_categories_id = mysqli_query($connect, $query);
							while ($cat = mysqli_fetch_assoc($select_categories_id)) {
								$cat_id = $cat['cat_id'];
								$cat_title = $cat['cat_title'];
								echo "<td>{$cat_title}</td>";
							}
						// END dyamic category
						echo "<td>{$post_status}</td>";
						echo "<td><img width='100' src='./../{$post_image}' alt='image'></td>";
						echo "<td>{$post_tags}</td>";
						echo "<td>{$post_comment_count}</td>";
						echo "<td>{$post_date}</td>";
						echo "<td><a href='posts.php?source=edit_post&p_id={$post_id}' class='btn btn-warning' role='button'>Edit</a>&nbsp;&nbsp;<a onClick=\"javascript: return confirm('Are you sure?');\" href='posts.php?delete={$post_id}' class='btn btn-danger' role='button'>Delete</a></td>";
						echo "</tr>";
					}
	
			?>
		      </tbody>
		    </table>
	</form>
			<?php
				if (isset($_GET['delete'])) {
					$the_post_id = $_GET['delete'];

					$query = "DELETE FROM posts WHERE post_id = {$the_post_id} ";

					$delete_query = mysqli_query($connect, $query);

					confirmQuery($delete_query);
					header("Location: posts.php");


				}
			?>
