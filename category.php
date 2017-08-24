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
		//
		if (isset($_GET['category'])) {
			$post_category_id = $_GET['category'];
		
		//
		if (isAdmin($_SESSION['user_name'])) {
			// $query = "SELECT * FROM posts WHERE post_category_id = '{$post_category_id}' ";
			$stm1 = mysqli_prepare($connect, "SELECT post_id, post_title, post_user, post_date, post_image, post_content FROM posts WHERE post_category_id = ? ");
		} else {
			//$query = "SELECT * FROM posts WHERE post_category_id = '{$post_category_id}' AND post_status = 'published'";
			$published = 'published';
			$stm2 = mysqli_prepare($connect, "SELECT post_id, post_title, post_user, post_date, post_image, post_content FROM posts WHERE post_category_id = ? AND post_status = ? ");
		}
		//
		if (isset($stm1)) {
			mysqli_stmt_bind_param($stm1, "i", $post_category_id);
			mysqli_stmt_execute($stm1);
			mysqli_stmt_bind_result($stm1, $post_id, $post_title, $post_user, $post_date, $post_image, $post_content);
			$stmt = $stm1;
		} else {
			mysqli_stmt_bind_param($stm2, "is", $post_category_id, $published);
			mysqli_stmt_execute($stm2);
			mysqli_stmt_bind_result($stm2, $post_id, $post_title, $post_user, $post_date, $post_image, $post_content);
			$stmt = $stm2;
		}
		//$select_all_posts = mysqli_query($connect, $query);
		if (mysqli_stmt_num_rows($stmt) == 0) {
			echo "<h1 class='text-center'>No Post Available</h1>";
		}
		while (mysqli_stmt_fetch($stmt)) {
			//$post_id = $post['post_id'];
			//$post_title = $post['post_title'];
			//$post_user = $post['post_user'];
			//$post_date = $post['post_date'];
			//$post_image = $post['post_image'];
			//$post_content = substr($post['post_content'], 0, 150);
		// Breakout of php here for HTML below
		?>

                <h1 class="page-header">
                    Page Heading
                    <small>Secondary Text</small>
                </h1>

                <!-- First Blog Post -->
                <h2>
		<a href="post.php?p_id=<?php echo $post_id ?>"><?php echo $post_title ?></a>
                </h2>
                <p class="lead">
                    by <a href="index.php"><?php echo $post_user ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span><?php echo $post_date ?></p>
                <hr>
		<img class="img-responsive" src=<?php echo $post_image?> alt="">
                <hr>
                <p><?php echo $post_content ?></p>
                <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

		<?php 
		} // this closes the `while` loop
			mysqli_stmt_close($stmt);
		} else {
			header("Location: index.php");
		}// closes `if` statement
		?>

            </div>

<!-- Blog Sidebar Column -->
<?php include "includes/sidebar.php"; ?>

        </div>
        <!-- /.row -->

        <hr>

<!-- Footer -->
<?php include "includes/footer.php"; ?>
