<?php include "includes/admin_header.php"?>
    <div id="wrapper">

        <!-- Navigation -->

<?php include "includes/admin_navigation.php"?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                    <h1 class="page-header">
                      Welcome to Admin
                      <small>Comments</small>


                    </h1>

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
				$query = "SELECT * FROM comments WHERE comment_post_id = " . mysqli_real_escape_string($connect, $_GET['id'] . " ");
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
						echo "<td><a href='post_comments.php?approved={$comment_id}&id=" . $_GET['id'] . "' class='btn btn-success' role='button'>Approve</a></td>";
						echo "<td><a href='post_comments.php?unapproved={$comment_id}&id=" . $_GET['id'] . "' class='btn btn-warning' role='button'>Unapprove</a></td>";
						echo "<td><a href='post_comments.php?delete={$comment_id}&id=" . $_GET['id'] . "' class='btn btn-danger' role='button'>Delete</a></td>";
						echo "</tr>";
					}
	
			?>
		      </tbody>
		    </table>
			<?php
				// If we get a "delete" GET 
				if (isset($_GET['delete'])) {
					$the_comment_id = $_GET['delete'];

					$query = "DELETE FROM comments WHERE comment_id = {$the_comment_id} ";

					$delete_query = mysqli_query($connect, $query);

					confirmQuery($delete_query);
					header("Location: post_comments.php?id=" . $_GET['id'] . "");


				}
				// If we get a "unapprove" GET 
				if (isset($_GET['unapproved'])) {
					$the_comment_id = $_GET['unapproved'];

					$query = "UPDATE comments SET comment_status = 'unapproved' WHERE comment_id = {$the_comment_id} ";

					$unapproved_query = mysqli_query($connect, $query);

					confirmQuery($unapproved_query);
					header("Location: post_comments.php?id=" . $_GET['id'] . "");


				}
				// If we get a "approved" GET 
				if (isset($_GET['approved'])) {
					$the_comment_id = $_GET['approved'];

					$query = "UPDATE comments SET comment_status = 'approved' WHERE comment_id = {$the_comment_id} ";

					$approved_query = mysqli_query($connect, $query);

					confirmQuery($approved_query);
					header("Location: post_comments.php?id=" . $_GET['id'] . "");


				}
			?>
                    </div>                 
                </div>                     
                <!-- /.row -->             

            </div>                         
            <!-- /.container-fluid -->     

        </div>                             
        <!-- /#page-wrapper -->            

<?php include "includes/admin_footer.php" ?>  
