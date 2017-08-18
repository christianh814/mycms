<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>
<?php
	if (isset($_POST['submit'])) {
		$from = $_POST['email'];
		$subject = $_POST['subject'];
		$body = $_POST['body'];

		if (!empty($from) && !empty($subject) && !empty($body) ) {
			$from = mysqli_real_escape_string($connect, $from);
			$subject = mysqli_real_escape_string($connect, $subject);
			$body = mysqli_real_escape_string($connect, $body);

			// send email here with $message
			require("admin/includes/sendgrid/sendgrid-php.php");                                        

			$from = new SendGrid\Email("Sender Fullname", $from);                 
			$to = new SendGrid\Email("Recv Fullname", "randomuser@mailinator.com");                  
			$content = new SendGrid\Content("text/plain", $body);                                                                                     

			$mail = new SendGrid\Mail($from, $subject, $to, $content);                            
			
			$apiKey = getenv('SENDGRID_API_KEY');      
			$sg = new \SendGrid($apiKey);              
			
			$response = $sg->client->mail()->send()->post($mail);                                 
			if ($response->statusCode() == 202) {      
				$message = "Email Sent";
			} else {                                   
				$message = "ERROR: Cannot Send Email";
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
                <h1>Contact</h1>
                    <form role="form" action="contact.php" method="post" id="login-form" autocomplete="off">
		     <h6 class="text-center"><?php echo $message; ?></h6>

                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Enter Your Email">
                        </div>

                        <div class="form-group">
                            <label for="subject" class="sr-only">Subject</label>
                            <input type="text" name="subject" id="subject" class="form-control" placeholder="Subject">
                        </div>

                         <div class="form-group">
				<textarea class="form-control" name="body" id="body" cols="30" rows="10"></textarea>
                        </div>
                
                        <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Submit">
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>


        <hr>



<?php include "includes/footer.php";?>
