            <!-- Blog Sidebar Widgets Column -->
            <div class="col-md-4">

                <!-- Blog Search Well -->
                <div class="well">
                    <h4>Blog Search</h4>
		    <form action="search.php" method="post">
                    <div class="input-group">
                        <input name="search" type="text" class="form-control">
                        <span class="input-group-btn">
                            <button name="submit" class="btn btn-default" type="submit">
                                <span class="glyphicon glyphicon-search"></span>
                        </button>
                        </span>
                    </div>
		    </form>
                    <!-- /.input-group -->
                </div>

                <!-- Login Form -->
                <div class="well">
		    <?php if(isset($_SESSION['usre_role'])):?>
		    	<h4>Loggged in as <?php echo $_SESSION['user_name']?> </h4>
			<a href="includes/logout.php" class="btn btn-primary">Logout</a>
		    <?php else: ?>

                    	<h4>Login</h4>
		    	<form action="includes/login.php" method="post">
                    	<div class="form-group">
                        	<input name="username" type="text" class="form-control" placeholder="Enter Username">
                    	</div>
                    	<div class="input-group">
                        	<input name="password" type="password" class="form-control" placeholder="Enter Password">
					<span class="input-group-btn">
			 			<button class="btn btn-primary" name="login" type="submit">Login</button>
					</span>
                    	</div>
		    	</form>

		    <?php endif;?>

                </div>
                <!-- End Login -->

                <!-- Blog Categories Well -->
                <div class="well">
                <?php
                        $query = "SELECT * FROM categories";
                        $select_sidebar_categories = mysqli_query($connect, $query);

                ?>

                    <h4>Blog Categories</h4>
                    <div class="row">
                        <div class="col-lg-12">
                            <ul class="list-unstyled">
				<?php 
					while ($cat_sidebar = mysqli_fetch_assoc($select_sidebar_categories)) {
                                		$cat_sidebar_title = $cat_sidebar['cat_title'];
                                		$cat_sidebar_id = $cat_sidebar['cat_id'];
                                		echo "<li><a href='category.php?category={$cat_sidebar_id}'>" . $cat_sidebar_title . "</a></li>";
                        		}
				?>
                            </ul>
                        </div>


                    </div>
                    <!-- /.row -->
                </div>

                <!-- Side Widget Well -->
		<?php include "widget.php"; ?>

            </div>

