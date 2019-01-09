<?php 
require ('includes/config.inc.php');
$page_title = 'Register';
include ('includes/header.html');
?>	
<!-- Page Content -->
<div class="container">
	<div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Register</h1>
            <ol class="breadcrumb">
            	<li><a href="index.php?p=&sorting=ASC&field=Name">Home</a></li>
            	<li class="active">Register</li>
            </ol>
        </div>
    </div>
    <!-- Intro Content -->
    <form name="login"  
          id="login"            
          action="register.php"
          method="post">
        <fieldset>
            <ol>
                <li>
                    <label for="first_name">First Name:</label>
                    <input type="text" id="fname" name="first_name" class="name" size="20" maxlength="20" value="<?php if (isset($trimmed['first_name'])) echo $trimmed['first_name']; ?>" placeholder="Firstname" />
                </li>
                <li>
                    <label for="last_name">Last Name:</label>
                    <input type="text" name="last_name" class="name" size="20" maxlength="40" value="<?php if (isset($trimmed['last_name'])) echo $trimmed['last_name']; ?>" placeholder="Lastname" />
                </li>
                <li>
                    <label for="email">E-mail:</label>
					<input type="text" id="email" name="email" size="30" maxlength="60" value="<?php if (isset($trimmed['email'])) echo $trimmed['email']; ?>" placeholder="example@example.com" />                    
				</li>
                <li>
                    <label for="password1">Password:</label>
                    <input type="password" name="password1" size="20" maxlength="20" value="<?php if (isset($trimmed['password1'])) echo $trimmed['password1']; ?>" placeholder="******" />
                </li> 
                <li>
                    <label for="password2">Re-type Password:</label>
                    <input type="password" name="password2" size="20" maxlength="20" value="<?php if (isset($trimmed['password2'])) echo $trimmed['password2']; ?>" placeholder="******" />
                </li> 
            </ol>
        </fieldset>
        <div id="message_line"></div>
        <fieldset>
            <div class="buttonHolder">
                <button type="submit" id="submit">Register</button>
                <button type="reset" id="clear">Clear</button>
            </div>
        </fieldset>
    </form>
    <div id="status"></div>
</div>
    <!-- /.container -->
 <?php 
	if ($_SERVER['REQUEST_METHOD'] == 'POST') { // Handle the form.
	// Need the database connection:
	require (MYSQL);
	// Trim all the incoming data:
	$trimmed = array_map('trim', $_POST);
	// Assume invalid values:
	$fn = $ln = $e = $p = FALSE;
	// Check for a first name:
	if (preg_match ('/^[A-Z \'.-]{2,20}$/i', $trimmed['first_name'])) {
		$fn = mysqli_real_escape_string ($dbc, $trimmed['first_name']);
	} else {
		echo '<p class="error">Please enter your first name!</p>';
	}
	// Check for a last name:
	if (preg_match ('/^[A-Z \'.-]{2,40}$/i', $trimmed['last_name'])) {
		$ln = mysqli_real_escape_string ($dbc, $trimmed['last_name']);
	} else {
		echo '<p class="error">Please enter your last name!</p>';
	}
	// Check for an email address:
	if (filter_var($trimmed['email'], FILTER_VALIDATE_EMAIL)) {
		$e = mysqli_real_escape_string ($dbc, $trimmed['email']);
	} else {
		echo '<p class="error">Please enter a valid email address!</p>';
	}
	// Check for a password and match against the confirmed password:
	if (preg_match ('/^\w{4,20}$/', $trimmed['password1']) ) {
		if ($trimmed['password1'] == $trimmed['password2']) {
			$p = mysqli_real_escape_string ($dbc, $trimmed['password1']);
		} else {
			echo '<p class="error">Your password did not match the confirmed password!</p>';
		}
	} else {
		echo '<p class="error">Please enter a valid password!</p>';
	}
	if ($fn && $ln && $e && $p) { // If everything's OK...
		// Make sure the email address is available:
		$q = "SELECT user_id FROM users WHERE email='$e'";
		$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
		if (mysqli_num_rows($r) == 0) { // Available.
			// Create the activation code:
			$a = NULL;
			// Add the user to the database:
			$q = "INSERT INTO users (email, pass, first_name, last_name, registration_date) VALUES ('$e', SHA1('$p'), '$fn', '$ln', NOW() )";
			$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
			if (mysqli_affected_rows($dbc) == 1) { 
				echo '<h3>Thank you for registering! You may now log in.</h3>';
				include ('includes/footer.html'); // Include the HTML footer.
				exit(); // Stop the page.
				
			} else { // If it did not run OK.
				echo '<p class="error">You could not be registered due to a system error. We apologize for any inconvenience.</p>';
			}
			
		} else { // The email address is not available.
			echo '<p class="error">That email address has already been registered.</p>';
		}
		
	} else { // If one of the data tests failed.
		echo '<p class="error">Please try again.</p>';
	}
	mysqli_close($dbc);
} ?>
<!-- <script type="text/javascript" src="js/register.js"></script> -->
<?php
// End of the main Submit conditional.
include ('includes/footer.html'); 
?>