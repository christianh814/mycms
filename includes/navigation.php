<?php include "includes/db.php" ?>
    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">MyCMS</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
		<?php
			$query = "SELECT * FROM categories LIMIT 3";
			$select_all_categories = mysqli_query($connect, $query);

			while ($cat = mysqli_fetch_assoc($select_all_categories)) {
				$cat_title = $cat['cat_title'];
				$cat_id = $cat['cat_id'];

				$category_class = '';
				$registration_class = '';

				$page_name = basename($_SERVER['PHP_SELF']);
				$registration_page = 'registration.php';
				$contact_page = 'contact.php';

				if (isset($_GET['category']) && $_GET['category'] == $cat_id) {
					$category_class = 'active';
				} elseif ($page_name == $registration_page) {
					$registration_class = 'active';
				} elseif ($page_name == $contact_page) {
					$contact_page = 'active';
				}

				echo "<li class='{$category_class}'><a href='category.php?category={$cat_id}'>" . $cat_title . "</a></li>";
			}
		?>
		  <li class="<?php echo $registration_class ?>"><a href="registration.php">Registration</a></li>
		  <li class="<?php echo $contact_page ?>"><a href="contact.php">Contact Page</a></li>
		<?php
			if (isset($_SESSION['usre_role'])) {
				if (isset($_GET['p_id'])) {
					$the_post_id = $_GET['p_id'] ;
		  			echo "<li><a href='admin/posts.php?source=edit_post&p_id={$the_post_id}'>Edit Post</a></li>";
				}
			}
		?>
		  <li><a href="admin">Admin</a></li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
