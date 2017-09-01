<?php  include "includes/db.php"; ?>
<!-- Header -->
<?php include "includes/header.php"; ?>

<!-- Navigation -->
<?php include "includes/navigation.php"; ?>

<?php
	$mycmssite = 'http://172.16.1.253/cms';
	if (!isset($_GET['forgot'])) {
		redirectTo("/cms/");
	}
	if (ifMethod('post')) {
		if (isset($_POST['email'])) {
			$email = $_POST['email'];
			$len = 50;
			$token = bin2hex(openssl_random_pseudo_bytes($len));
			if (emailExists($email)) {
				$stmt = mysqli_prepare($connect, "UPDATE users SET token = '{$token}' WHERE user_email = ?");
				mysqli_stmt_bind_param($stmt, "s", $email);
				mysqli_stmt_execute($stmt);
				mysqli_stmt_close($stmt);
				$query = "SELECT user_firstname,user_lastname FROM users WHERE user_email = '{$email}' ";
				$userinfo = mysqli_query($connect, $query);
				while ($info = mysqli_fetch_assoc($userinfo)) {
					$to_first = $info['user_firstname'];
					$to_last  = $info['user_lastname'];
				}
				// Send email now
				$from = "paintball814@gmail.com";
				$from_fullname = "Christian Hernandez";
				$subject = "Password Reset";
				$to = $email;
				$to_fullname = $to_first . " " .$to_last;
				$body = "<h1>Password Reset</h1>\n<p>Your password reset link:&nbsp;<a href='{$mycmssite}/reset.php?email={$email}&token={$token}'>RESET</a></p>";

				if (sendEmail($from, $from_fullname, $subject, $to, $to_fullname, $body)) {
					echo "<center><h1>Password Reset Instructions Emailed!</h1></center>";
				} else {
					echo "<center><h1>Error Sending Email: Please try again!</h1></center>";
				}
			} else {
				echo "<center><h1>User Not Found</h1></center>";
			}
		}
	}
?>


<!-- Page Content -->
<div class="container">

    <div class="form-gap"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="text-center">


                                <h3><i class="fa fa-lock fa-4x"></i></h3>
                                <h2 class="text-center">Forgot Password?</h2>
                                <p>You can reset your password here.</p>
                                <div class="panel-body">




                                    <form id="register-form" role="form" autocomplete="off" class="form" method="post">

                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                                                <input id="email" name="email" placeholder="email address" class="form-control"  type="email">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input name="recover-submit" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
                                        </div>

                                        <input type="hidden" class="hide" name="token" id="token" value="">
                                    </form>

                                </div><!-- Body-->

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <hr>

    <!-- Footer -->
<?php include "includes/footer.php"; ?>


</div> <!-- /.container -->
