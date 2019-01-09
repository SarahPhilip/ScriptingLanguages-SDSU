<?php # Script 18.8 - login.php
// This is the login page for the site.
require ('includes/config.inc.php'); 
$page_title = 'Login';
include ('includes/header.html');
// $_SESSION['expire'] = time()+1*60;
function getRealIpAddr()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
      $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
      $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
      $ip=$_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}
?>

<!-- Page Content -->
    <div class="container">

        <!-- Page Heading/Breadcrumbs -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Login
                    
                </h1>
                <ol class="breadcrumb">
                    <li><a href="index.php?p=&sorting=ASC&field=Name">Home</a>
                    </li>
                    <li class="active">Login</li>
                </ol>
            </div>
        </div>
        <!-- /.row -->

        <!-- Intro Content -->
        <form name="login"  
            id="login"            
            action="login.php"
            method="post">
            <fieldset>
                <ol>
                    
                    <li>
                        <label for="email">E-mail:</label>
                        <input id="username" name="email" type="text" placeholder="example@example.com">
                    </li>
                    <li>
                        <label for="pass">Password:</label>
                        <input id="password" name="pass" type="password" placeholder="******">
                    </li> 
                </ol>
            </fieldset>
            
            <div id="message_line"></div>
            
            <fieldset>
                <div class="buttonHolder">
                    <button type="submit" id="submit">Login</button>
                    <button type="reset" id="clear">Clear</button>
                </div>
            </fieldset>
            
        </form>
        <div id="status"></div>
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	require (MYSQL);
	
	// Validate the email address:
	if (!empty($_POST['email'])) {
		$e = mysqli_real_escape_string ($dbc, $_POST['email']);
	} else {
		$e = FALSE;
		echo '<p class="error">You forgot to enter your email address!</p>';
	}
	
	// Validate the password:
	if (!empty($_POST['pass'])) {
		$p = mysqli_real_escape_string ($dbc, $_POST['pass']);
	} else {
		$p = FALSE;
		echo '<p class="error">You forgot to enter your password!</p>';
	}
	
	if ($e && $p) { // If everything's OK.

		// Query the database:
		$q = "SELECT user_id, first_name, user_level FROM users WHERE (email='$e' AND pass=SHA1('$p')) AND active IS NULL";		
		$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
		
		if (@mysqli_num_rows($r) == 1) { // A match was made.

			// Set the cookies:
			setcookie ('last_login_time', time());
			setcookie ('last_IP_used', getRealIpAddr());
			// Register the values:
			$_SESSION = mysqli_fetch_array ($r, MYSQLI_ASSOC); 
			$_SESSION['start'] = time();
			$_SESSION['expire'] = $_SESSION['start'] + (3 * 60);
			mysqli_free_result($r);
			mysqli_close($dbc);
							
			// Redirect the user:
			$url = BASE_URL . 'index.php?p=&sorting=ASC&field=Name'; // Define the URL.
			ob_end_clean(); // Delete the buffer.
			header("Location: $url");
			exit(); // Quit the script.
				
		} else { // No match was made.
			echo '<p class="error">Either the email address and password entered do not match those on file or you have not yet activated your account.</p>';
		}
		
	} else { // If everything wasn't OK.
		echo '<p class="error">Please try again.</p>';
	}
	
	mysqli_close($dbc);

} // End of SUBMIT conditional.
?>

    </div>
    <!-- /.container -->

<?php include ('includes/footer.html'); ?>