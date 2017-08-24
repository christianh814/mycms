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
                if (isset($_POST['submit'])) {
                $search =  $_POST['search'];
                $query = "SELECT * FROM posts WHERE post_tags LIKE '%$search%'";
                $search_query = mysqli_query($connect, $query);

                if (!$search_query) {
                        die("QUERY FAILED:" . mysqli_error($connect));
                }

                $count = mysqli_num_rows($search_query);
                if ($count == 0){
                        echo "<h1>No Results Found</h1>";
                } else {
		$select_all_posts = mysqli_query($connect, $query);
		while ($post = mysqli_fetch_assoc($search_query)) {
			$post_title = $post['post_title'];
			$post_user = $post['post_user'];
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
                    by <a href="index.php"><?php echo $post_user ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span><?php echo $post_date ?></p>
                <hr>
		<img class="img-responsive" src=<?php echo $post_image?> alt="">
                <hr>
                <p><?php echo $post_content ?></p>
                <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

		<?php } // this closes the `while` loop
                }
                }
                ?>

            </div>

<!-- Blog Sidebar Column -->
<?php include "includes/sidebar.php"; ?>

        </div>
        <!-- /.row -->

        <hr>

<!-- Footer -->
<?php include "includes/footer.php"; ?>
