<?php # Script 18.5 - index.php
  // This is the main page for the site.
  // Include the configuration file:
  require ('includes/config.inc.php'); 
  require (MYSQL);
  // include './Pagination.php';
  $rec_limit = 3;
  $field='user_id';
  $sort='ASC';
  $user_level=10;
  // Set the page title and include the HTML header:
  $page_title = 'Home';
  include ('includes/header.html');
  ?>
  <!-- Page Content -->
    <div class="container">

        <!-- Page Heading/Breadcrumbs -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">About
                    <small>Azteka</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="index.php">Home</a>
                    </li>
                    <li class="active">About</li>
                </ol>
            </div>
        </div>
        <!-- /.row -->

        <!-- Intro Content -->
        <?php
  // Welcome the user (by name if they are logged in):
  // echo '<h1>Welcome';
  // if (isset($_SESSION['first_name'])) {
  //   echo ", {$_SESSION['first_name']}";
  // }
  // echo '!</h1>';
  /* Get total number of records */
  
    $sql = "SELECT count(*) FROM users ";
  
  $retval = mysqli_query( $dbc, $sql );
  if(! $retval )
  {
    die('Could not get data: ' . mysql_error());
  }
  $row = mysqli_fetch_array($retval, MYSQL_NUM );
  $rec_count = $row[0];

  if( isset($_GET{'page'} ) )
  {
    $page = $_GET{'page'} + 1;
    $offset = $rec_limit * $page ;
  }
  else
  {
    $page = 0;
    $offset = 0;
  }
  $left_rec = $rec_count - ($page * $rec_limit);

  if(isset($_GET['sorting']))
  {
    if($_GET['sorting']=='ASC')
    {
      $sort='DESC';
    }
    else { $sort='ASC'; }
  }
  if($_GET['field']=='user_id')
  { 
    $field = "user_id";  
  }
  elseif($_GET['field']=='first_name')
  {
    $field = "last_name"; 
  }
  elseif($_GET['field']=='email')
  { 
    $field="email"; 
  }
  elseif($_GET['field']=='user_level')
  { 
    $field="user_level"; 
  }
  elseif($_GET['field']=='registration_date')
  { 
    $field="registration_date"; 
  }

  //-------------------------------------------------------------
  //pagination
  $url='admin_admin.php';
  $limit=3;
  $page=$_GET['p'];
  if($page=='')
  {
    $page=1;
    $start=0;
  }
  else
  {
    $start=$limit*($page-1);
  }
  
  if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
   $trimmed = array_map('trim', $_POST);
   
    if (!empty($_POST['save'])) {
      $p = FALSE;
      $id = mysqli_real_escape_string ($dbc, $trimmed['user_id']);
      $fn = mysqli_real_escape_string ($dbc, $trimmed['first_name']);
      $ln = mysqli_real_escape_string ($dbc, $trimmed['last_name']);
      $email = mysqli_real_escape_string ($dbc, $trimmed['email']);
      $level = mysqli_real_escape_string ($dbc, $trimmed['best_seller_dropdown']);
      // If everything's OK.
        // Make the query:
        $q = "UPDATE users SET first_name= '$fn', last_name = '$ln', email = '$email', user_level = $level WHERE user_id = $id"; 
        // echo "$q";
        $r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
        if (mysqli_affected_rows($dbc) == 1) { // If it ran OK.
          // Send an email, if desired.
          echo '<h3>User detail(s) updated.</h3>';
          
        }
        else 
        { // If it did not run OK.
          echo '<p class="error">Name and Price was not changed. Make sure your new name is different than the current book name. Contact the system administrator if you think an error occurred.</p>'; 
        }
      }
    else { // Failed the validation test.
      echo '<p class="error">Please try again.</p>';    
    }
  
  // if (!empty($_POST['delete'])) {
  //   $p = FALSE;
  //   $p = mysqli_real_escape_string ($dbc, $trimmed['ISBN']);
  //   if ($p) 
  //   {
  //     $q = "DELETE FROM users WHERE ISBN = {$trimmed['ISBN']}"; 
  //     $r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
  //   }
  // }
  } // End of the main Submit conditional.

  
  $sql = "SELECT * FROM users WHERE user_level < 40 ORDER BY $field $sort limit $start, $limit ";
  $total_values=mysqli_query($dbc, "SELECT * FROM users WHERE user_level < 40 ");

  
  $total=mysqli_num_rows($total_values);
  $maxpage=ceil($total/$limit);
  $result = mysqli_query($dbc, $sql) or trigger_error("Query: $sql\n<br />MySQL Error: " . mysqli_error($dbc));
  // echo "$result";
  echo'<table id = "details" border="0">';
  echo"<th><a href=\"{$_SERVER['PHP_SELF']}?p=".$page.'&sorting='.$sort."&field=user_id\">ID</a></th>
  <th><a href=\"{$_SERVER['PHP_SELF']}?p=".$page.'&sorting='.$sort."&field=first_name\">First Name</a></th>
  <th><a href=\"{$_SERVER['PHP_SELF']}?p=".$page.'&sorting='.$sort."&field=last_name\">Last Name</a></th>
  <th><a href=\"{$_SERVER['PHP_SELF']}?p=".$page.'&sorting='.$sort."&field=email\">E-mail</a></th>
  <th><a href=\"{$_SERVER['PHP_SELF']}?p=".$page.'&sorting='.$sort."&field=user_level\">Level</a></th>
  <th><a href=\"\">Save</a></th>";
  
  while($row = mysqli_fetch_array($result)) {
    // $userLevel = $row['user_level'];
    // if($userLevel<40){
    echo'<tr> <form name="save" method="post">
    <td>'.$row['user_id'].'</td>
    <input type="hidden" name="user_id" value="'.$row['user_id'].'" />
    <td><input name="first_name" value='.$row['first_name'].'></td>
    <td><input name="last_name" value='.$row['last_name'].'></td>
    <td><input name="email" value='.$row['email'].'></td>
    <td>
      <select name="best_seller_dropdown">';
      $userLevel = $row['user_level']; // Get $authid from database
      $selection = array( // Create Index Of AuthIDs and AuthNames
        10 => "Member",
        20 => "Author",
        30 => "Publisher" );
      foreach($selection as $key => $value) // Loop Through $selection, Where $key is AuthID and $value is AuthName
      {
          echo '<option value="' . $key . '"'; // Start Menu Item
          if ($userLevel == $key) // Check If AuthID from $selection equals $authid from database
              echo ' selected="selected"'; // Select The Menu Item If They Match
          echo '>' . $value . '</option>'; // End Menu Item
      }
    echo '   
    </select>
  </td>
    <td><input type="submit" id="save" name="save"  value="Save"/></td>
    </form>
    </tr>';
  }
// }
  echo'</table>';
  function pagination($maxpage,$page,$url,$field,$sort)
  { 
  //After you sorting your table by clicking particular column, the following trick is used to display
  //values with similar sorted values.
    if($sort=='ASC')
    {
      $sort='DESC';
    }
    else
    {
      $sort='ASC';
    }
    echo'<ul style="list-style-type:none;">';
    for($i=1; $i<=$maxpage; $i++)
    {
      if($i==$page)
      {
        echo'<li style="float:left;padding:5px;">'.$i.'</li>';
      }
      else
      {
        echo'<li style="float:left;padding:5px;"><a href="admin_admin.php?p='.$i.'&sorting='.$sort.'&field='.$field.' ">'.$i.'</a></li>';
      }
    }
    echo'</ul>';
  }
  pagination($maxpage,$page,$url,$field,$sort);
?>
</div>