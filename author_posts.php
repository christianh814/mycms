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
			$post_user = $_GET['author'];
		}

                echo "<h1 class='page-header'>All Posts <small>by $post_user</small> </h1>";
		
		$query = "SELECT * FROM posts WHERE post_user = '{$post_user}' AND post_status = 'published'";
		$select_all_posts = mysqli_query($connect, $query);
		while ($post = mysqli_fetch_assoc($select_all_posts)) {
			$post_id = $post['post_id'];
			$post_title = $post['post_title'];
			$post_user = $post['post_user'];
			$post_date = $post['post_date'];
			$post_image = $post['post_image'];
			$post_content = $post['post_content'];

		// Breakout of php here for HTML below
		?>

                <!-- First Blog Post -->
                <h2>
		<a href="post.php?p_id=<?php echo $post_id ?>"><?php echo $post_title ?></a>
                </h2>
                <p class="lead">
                    by: <?php echo $post_user ?>
                </p>
                <p><span class="glyphicon glyphicon-time"></span><?php echo $post_date ?></p>
                <hr>
		<img class="img-responsive" src=<?php echo $post_image?> alt="">
                <hr>
                <p><?php echo $post_content ?></p>
		<hr></hr>
                <!-- No "READ MORE" on post page <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a> -->

		<?php } // this closes the `while` loop ?>



            </div>

<!-- Blog Sidebar Column -->
<?php include "includes/sidebar.php"; ?>

        </div>
        <!-- /.row -->

        <hr>

<!-- Footer -->
<?php include "includes/footer.php"; ?>
