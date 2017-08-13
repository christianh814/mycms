<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>
<?php
	if (isset($_POST['submit'])) {
		$user_name = $_POST['username'];
		$user_email = $_POST['email'];
		$user_password = $_POST['password'];

		if (!empty($user_name) && !empty($user_email) && !empty($user_password) ) {
			$user_name = mysqli_real_escape_string($connect, $user_name);
			$user_email = mysqli_real_escape_string($connect, $user_email);
			$user_password = mysqli_real_escape_string($connect, $user_password);

			$query = "SELECT rand_salt FROM users ";
			$select_randsalt_query = mysqli_query($connect, $query);

			if (!$select_randsalt_query) {
				die("Error: " . mysqli_error($connect));
			}

			while ($pw = mysqli_fetch_array($select_randsalt_query)) {
				$salt = $pw['rand_salt'];
			}

			$user_password = crypt($user_password, $salt);


			$query = "INSERT INTO users (user_name, user_email, user_password, usre_role) ";
			$query .= "VALUES ('{$user_name}', '{$user_email}','{$user_password}','subscriber') ";

			$register_user = mysqli_query($connect, $query);
			if (!$register_user) {
				die("Error: " . mysqli_error($connect));
			} else {
				$message = "Request Has Been Submited";
			}
			
		} else {
			$message = "Fields cannot be empty";
			
		}

	} else {
		$message = "";
	}
?>

    <!-- Navigation -->
    
    <?php  include "includes/navigation.php"; ?>
    
 
    <!-- Page Content -->
    <div class="container">
    
<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="form-wrap">
                <h1>Register</h1>
                    <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
		     <h6 class="text-center"><?php echo $message; ?></h6>
                        <div class="form-group">
                            <label for="username" class="sr-only">username</label>
                            <input type="text" name="username" id="username" class="form-control" placeholder="Enter Desired Username">
                        </div>
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com">
                        </div>
                         <div class="form-group">
                            <label for="password" class="sr-only">Password</label>
                            <input type="password" name="password" id="key" class="form-control" placeholder="Password">
                        </div>
                
                        <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Register">
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>


        <hr>



<?php include "includes/footer.php";?>
