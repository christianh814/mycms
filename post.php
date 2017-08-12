<!-- Header -->
<?php include "includes/header.php"; ?>

<!-- Navigation -->
<?php include "includes/navigation.php"; ?>

<!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

		<?php

		if (isset($_GET['p_id'])){
			$post_id = $_GET['p_id'];
		}
		
		$query = "SELECT * FROM posts WHERE post_id = '{$post_id}' AND post_status = 'published'";
		$select_all_posts = mysqli_query($connect, $query);
		while ($post = mysqli_fetch_assoc($select_all_posts)) {
			$post_title = $post['post_title'];
			$post_author = $post['post_author'];
			$post_date = $post['post_date'];
			$post_image = $post['post_image'];
			$post_content = $post['post_content'];

		// Breakout of php here for HTML below
		?>

                <h1 class="page-header">
                    Page Heading
                    <small>Secondary Text</small>
                </h1>

                <!-- First Blog Post -->
                <h2>
		<a href="#"><?php echo $post_title ?></a>
                </h2>
                <p class="lead">
                    by <a href="index.php"><?php echo $post_author ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span><?php echo $post_date ?></p>
                <hr>
		<img class="img-responsive" src=<?php echo $post_image?> alt="">
                <hr>
                <p><?php echo $post_content ?></p>
		<hr></hr>
                <!-- No "READ MORE" on post page <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a> -->

		<?php } // this closes the `while` loop ?>

		<?php
			if (isset($_POST['create_comment'])) {
					$post_id = $_GET['p_id'];
					$comment_author = $_POST['comment_author'];
					$comment_email = $_POST['comment_email'];
					$comment_content = $_POST['comment_content'];
	
					$query = "INSERT INTO comments ";
					$query .= "(comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date) ";
					$query .= "VALUES ";
					$query .= "('{$post_id}', '{$comment_author}', '{$comment_email}', '{$comment_content}', 'unapproved', now() ) ";
	
					$create_comment = mysqli_query($connect, $query);
	
					if (!$create_comment) {
						die("QUERY FAILED: " . mysqli_error($connect));
					}
	
					$query = "UPDATE posts SET post_comment_count = post_comment_count +1 ";
					$query .= "WHERE post_id = {$post_id}";
	
					$update_comment_count = mysqli_query($connect, $query);
				}
	
		?>

		<!-- Comment Form -->
		<div class="well">
			<h4>Leave A Comment</h4>
			<form action="" method="post" role="form">
				<div class="form-group">
					<label for="Author">Author</label>
					<input type="text" class="form-control" name="comment_author" placeholder="Name">
				</div>

				<div class="form-group">
					<label for="Email">Email</label>
					<input type="email" class="form-control" name="comment_email" placeholder="E-Mail">
				</div>

				<div class="form-group">
					<label for="Comment">Comment</label>
					<textarea name="comment_content" class="form-control" rows="3" placeholder="What do you think?"></textarea>
				</div>
				<button type="submit" name="create_comment" class="btn btn-primary">Submit</button>
			</form>
		</div>

               <!-- Posted Comments -->

		<?php
			$query = "SELECT * FROM comments WHERE comment_post_id = {$post_id} ";
			$query .= "AND comment_status = 'approved' ";
			$query .= "ORDER BY comment_id DESC";

			$select_comment_query = mysqli_query($connect, $query);

			if (!$select_comment_query) {
				die("QUERY FAILED: " . mysqli_error($connect));
			}

			while ($comment = mysqli_fetch_array($select_comment_query)) {
				$comment_date = $comment['comment_date'];
				$comment_content = $comment['comment_content'];
				$comment_author = $comment['comment_author'];
			?>
                <!-- Comment -->
                <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="http://placehold.it/64x64" alt="">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading"><?php echo $comment_author ?>
                            <small><?php $comment_date ?></small>
                        </h4>
			<?php echo $comment_content ?>
                    </div>
                </div>

                <!-- End Comment -->
			<?php } ?>

                        <!-- Nested Comment -->
			<!--
                        <div class="media">
                            <a class="pull-left" href="#">
                                <img class="media-object" src="http://placehold.it/64x64" alt="">
                            </a>
                            <div class="media-body">
                                <h4 class="media-heading">Nested Start Bootstrap
                                    <small>August 25, 2014 at 9:30 PM</small>
                                </h4>
                                Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis. Fusce condimentum nunc ac nisi vulputate fringilla. Donec lacinia congue felis in faucibus.
                            </div>
                        </div>
		    -->
                        <!-- End Nested Comment -->


            </div>

<!-- Blog Sidebar Column -->
<?php include "includes/sidebar.php"; ?>

        </div>
        <!-- /.row -->

        <hr>

<!-- Footer -->
<?php include "includes/footer.php"; ?>
