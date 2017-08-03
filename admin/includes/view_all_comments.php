		    <table class="table table-bordered table-hover">
		      <thead>
		        <tr>
			  <th>Id</th>
			  <th>Author</th>
			  <th>Comment</th>
			  <th>Email</th>
			  <th>Status</th>
			  <th>In Response To</th>
			  <th>Date</th>
			  <th>Approval</th>
			  <th>Unapproval</th>
			  <th>Actions</th>
			</tr>
		      </thead>
		      <tbody>
			<?php
				$query = "SELECT * FROM comments";
				$select_comments = mysqli_query($connect, $query);
					while ($comment = mysqli_fetch_assoc($select_comments)) {
						$comment_id = $comment['comment_id'];
						$comment_post_id = $comment['comment_post_id'];
						$comment_author = $comment['comment_author'];
						$comment_email = $comment['comment_email'];
						$comment_content = $comment['comment_content'];
						$comment_status = $comment['comment_status'];
						$comment_date = $comment['comment_date'];
						// Put information in the table
						echo "<tr>";
						echo "<td>{$comment_id}</td>";
						echo "<td>{$comment_author}</td>";
						echo "<td>{$comment_content}</td>";
						echo "<td>{$comment_email}</td>";
						// Get the category based on the what we get from the comments table
						/*
						$query = "SELECT * FROM categories WHERE cat_id = {$comment_category_id} ";
						$select_categories_id = mysqli_query($connect, $query);
							while ($cat = mysqli_fetch_assoc($select_categories_id)) {
								$cat_id = $cat['cat_id'];
								$cat_title = $cat['cat_title'];
								echo "<td>{$cat_title}</td>";
							}
						// END dyamic category
						*/
						echo "<td>{$comment_status}</td>";
						// Get post based on what we get from the post table
						$query = "SELECT * FROM posts WHERE post_id = '{$comment_post_id}'";
						$select_post_id_query = mysqli_query($connect, $query);
							while ($post = mysqli_fetch_assoc($select_post_id_query)) {
								$post_id = $post['post_id'];
								$post_title = $post['post_title'];
								echo "<td><a href='../post.php?p_id={$post_id}'>{$post_title}</a></td>";
							}
						//
						echo "<td>{$comment_date}</td>";
						echo "<td><a href='comments.php?delete={$comment_id}'>Approve</a></td>";
						echo "<td><a href='comments.php?delete={$comment_id}'>Unapprove</a></td>";
						echo "<td><a href='comments.php?source=edit_post&p_id={$comment_id}'>Edit</a>&nbsp;|&nbsp;<a href='comments.php?delete={$comment_id}'>Delete</a></td>";
						echo "</tr>";
					}
	
			?>
		      </tbody>
		    </table>
			<?php
				if (isset($_GET['delete'])) {
					$the_comment_id = $_GET['delete'];

					$query = "DELETE FROM comments WHERE comment_id = {$the_comment_id} ";

					$delete_query = mysqli_query($connect, $query);

					confirmQuery($delete_query);


				}
			?>
