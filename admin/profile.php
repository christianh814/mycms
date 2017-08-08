<?php include "includes/admin_header.php"?>
<?php
	if (isset($_SESSION['user_name'])) {
		$user_name = $_SESSION['user_name'];
		$query = "SELECT * FROM users WHERE user_name = '{$user_name}' ";

		$select_user_profile = mysqli_query($connect, $query);

		while ($user = mysqli_fetch_array($select_user_profile)) {
			$user_name = $user['user_name'];
			$user_password = $user['user_password'];
			$user_firstname = $user['user_firstname'];
			$user_lastname = $user['user_lastname'];
			$user_email = $user['user_email'];
			$user_image = $user['user_image'];
			$user_role = $user['usre_role'];
			$rand_salt = $user['rand_salt'];
		}
	}
	//
	if (isset($_POST['update_profile'])){
		$user_firstname = $_POST['user_firstname'];
		$user_lastname = $_POST['user_lastname'];
		$user_role = $_POST['usre_role'];
		$user_name = $_POST['user_name'];
		$user_image = $_FILES['image']['name'];

		$user_image_temp = $_FILES['image']['tmp_name'];

		$user_email = $_POST['user_email'];
		$user_password = $_POST['user_password'];


                if (empty($user_image)) {
                        $query = "SELECT * FROM users WHERE user_name = '{$user_name}'";
                        $select_image = mysqli_query($connect, $query);
                        while ($image = mysqli_fetch_array($select_image)) {
                                $user_image = $image['user_image'];
                        }
                } else {
			move_uploaded_file($user_image_temp, "../images/{$user_image}");
		}

                $query =  "UPDATE users SET ";
                $query .= "user_firstname        = '{$user_firstname}', ";
                $query .= "user_lastname  = '{$user_lastname}', ";
                $query .= "usre_role       = '{$user_role}', ";
                $query .= "user_name       = '{$user_name}', ";
                $query .= "user_email      = '{$user_email}', ";
                $query .= "user_password      = '{$user_password}', ";
                $query .= "user_image        = 'images/{$user_image}' ";
                $query .= "WHERE user_name     = '{$user_name}' ";

                $update_user = mysqli_query($connect, $query);

                confirmQuery($update_user);
	}

?>
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
		      <small>Author Name</small>
		    </h1>
		        <!-- FORM -->
			<form action="" method="post" enctype="multipart/form-data">
				<div class="form-group">
					<label for="user_firstname">Firstname</label>
					<input type="text" value="<?php echo $user_firstname ?>" class="form-control" name="user_firstname">
				</div>
			
				<div class="form-group">
					<label for="user_lastname">Lastname</label>
					<input type="text" value="<?php echo $user_lastname ?>" class="form-control" name="user_lastname">
				</div>
			
				<div class="form-group">
					<select name="usre_role" id="">
						<option value="subscriber"><?php echo $user_role ?></option>
						<?php
							if ($user_role == 'admin') {
								echo "<option value='subscriber'>Subscriber</option>";
							} else {
								echo "<option value='admin'>Admin</option>";
							}
						?>
					</select>
				</div>
			
				<div class="form-group">
					<label for="user_name">Username</label>
					<input type="text" value="<?php echo $user_name ?>" class="form-control" name="user_name">
				</div>
			
				<div class="form-group">
					<label for="user_email">Email</label>
					<input type="text" value="<?php echo $user_email ?>"class="form-control" name="user_email">
				</div>

				<div class="form-group">
					<label for="post_tags">Password</label>
					<input type="password" value="<?php echo $user_password ?>" class="form-control" name="user_password">
				</div>
			
				<div class="form-group">
 					<img width="100" src="./../<?php echo $user_image; ?>" alt="no image"></img>
				</div>

				<div class="form-group">
					<label for="post_image">User Image</label>
					<input value="<?php echo $user_image ?>" type="file" name="image">
				</div>
			
				<div class="form-group">
					<input class="btn btn-primary" type="submit" name="update_profile" value="Update Profile">
				</div>
			
			
			</form>
			<!-- /.Form -->

                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

<?php include "includes/admin_footer.php" ?>
