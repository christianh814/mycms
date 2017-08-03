		    <table class="table table-bordered table-hover">
		      <thead>
		        <tr>
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
						echo "<td>{$post_id}</td>";
						echo "<td>{$post_author}</td>";
						echo "<td>{$post_title}</td>";
						echo "<td>{$post_category_id}</td>";
						echo "<td>{$post_status}</td>";
						echo "<td><img width='100' src='./../{$post_image}' alt='image'></td>";
						echo "<td>{$post_tags}</td>";
						echo "<td>{$post_comment_count}</td>";
						echo "<td>{$post_date}</td>";
						echo "<td><a href='posts.php?source=edit_post&p_id={$post_id}'>Edit</a>&nbsp;|&nbsp;<a href='posts.php?delete={$post_id}'>Delete</a></td>";
						echo "</tr>";
					}
	
			?>
		      </tbody>
		    </table>
			<?php
				if (isset($_GET['delete'])) {
					$the_post_id = $_GET['delete'];

					$query = "DELETE FROM posts WHERE post_id = {$the_post_id} ";

					$delete_query = mysqli_query($connect, $query);

					confirmQuery($delete_query);


				}
			?>