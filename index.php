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
		$query = "SELECT * FROM posts WHERE post_status = 'published' ";
		$select_all_posts = mysqli_query($connect, $query);
		while ($post = mysqli_fetch_assoc($select_all_posts)) {
			$post_id = $post['post_id'];
			$post_title = $post['post_title'];
			$post_author = $post['post_author'];
			$post_date = $post['post_date'];
			$post_image = $post['post_image'];
			$post_content = substr($post['post_content'], 0, 150);
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
                    by <a href="index.php"><?php echo $post_author ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span><?php echo $post_date ?></p>
                <hr>
		<a href="post.php?p_id=<?php echo $post_id ?>"><img class="img-responsive" src=<?php echo $post_image?> alt=""></a>
                <hr>
                <p><?php echo $post_content ?></p>
                <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

		<?php } // this closes the `while` loop ?>

            </div>

<!-- Blog Sidebar Column -->
<?php include "includes/sidebar.php"; ?>

        </div>
        <!-- /.row -->

        <hr>

<!-- Footer -->
<?php include "includes/footer.php"; ?>
<!--
Bootsrap Buttons

<button type="button" class="btn">Basic</button>
<button type="button" class="btn btn-default">Default</button>
<button type="button" class="btn btn-primary">Primary</button>
<button type="button" class="btn btn-success">Success</button>
<button type="button" class="btn btn-info">Info</button>
<button type="button" class="btn btn-warning">Warning</button>
<button type="button" class="btn btn-danger">Danger</button>
<button type="button" class="btn btn-link">Link</button>

In A link

<a href="#" class="btn btn-info" role="button">Link Button</a>
-->
