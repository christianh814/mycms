<?php  include "includes/db.php"; ?>
<!-- Header -->
<?php include "includes/header.php"; ?>

<!-- Navigation -->
<?php include "includes/navigation.php"; ?>

<?php
	if (!isset($_GET['email']) || !isset($_GET['token'])) {
		redirectTo('/cms');
	}
	$verified = false;
	$token = $_GET['token'];
	$user_email = $_GET['email'];

	if ($stmt = mysqli_prepare($connect, 'SELECT user_name, user_email, token FROM users WHERE token=?')) {
		mysqli_stmt_bind_param($stmt, "s", $token);
		mysqli_stmt_execute($stmt);
		mysqli_stmt_bind_result($stmt, $user_name, $user_email, $token);
		mysqli_stmt_fetch($stmt);
		mysqli_stmt_close($stmt);
		if ($_GET['token'] !== $token || $_GET['email'] !== $user_email) {
			redirectTo('/cms');
		}
		if (isset($_POST['password']) && isset($_POST['confirmPassword'])) {
			$first_password = $_POST['password'];
			$second_password = $_POST['confirmPassword'];
			if ($first_password == $second_password) {
				$password = $first_password;
				$hashedPassword = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));
				if ($stmt = mysqli_prepare($connect, "UPDATE users SET token='', user_password='{$hashedPassword}' WHERE user_email = ?")) {
					mysqli_stmt_bind_param($stmt, "s", $user_email);
					mysqli_stmt_execute($stmt);
					if (mysqli_stmt_affected_rows($stmt) >= 1) {
						redirectTo('/cms/login.php');
					}
					mysqli_stmt_close($stmt);
					$verified = true;
				} else {
					echo "<center><h1>Error updating password</h1></center>";
				}
			} else {
				echo "<center><h1>Passwords MUST match!</h1></center>";
			}
		}
	}

?>

<!-- Page Content -->
<div class="container">
<?php if (!$verified): ?> 
    <div class="form-gap"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="text-center">

                                <h3><i class="fa fa-lock fa-4x"></i></h3>
                                <h2 class="text-center">Reset Password</h2>
                                <p>You can reset your password here.</p>
                                <div class="panel-body">

                                    <form id="register-form" role="form" autocomplete="off" class="form" method="post">

                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-user color-blue"></i></span>
                                                <input id="password" name="password" placeholder="Enter Password" class="form-control"  type="password">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-ok color-blue"></i></span>
                                                <input id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" class="form-control"  type="password">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input name="recover-submit" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
                                        </div>

                                        <input type="hidden" class="hide" name="token" id="token" value="">
                                    </form>

                                </div><!-- Body-->

                                <!-- <h2>Please check your email</h2> -->

                        </div>
                    </div>
                </div>
            </div>
        </div>
	<?php else:?>

	<?php redirectTo('/cms/login.php');?>

	<?php endif;?>
    </div>


    <hr>

       <!-- Footer -->
    <?php include "includes/footer.php"; ?>


</div> <!-- /.container -->

