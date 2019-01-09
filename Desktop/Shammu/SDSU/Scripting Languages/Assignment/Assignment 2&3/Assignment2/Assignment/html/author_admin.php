<?php # Script 18.5 - index.php
  // This is the main page for the site.
  // Include the configuration file:
  require ('includes/config.inc.php'); 
  require (MYSQL);
  $rec_limit = 2;
  $field='ISBN';
  $sort='ASC';
  include ('includes/header.html');
?>
<div class="container">
  <!-- Page Heading/Breadcrumbs -->
  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">Author Admin
        <small>Azteka</small>
      </h1>
      <ol class="breadcrumb">
        <li>
          <a href="index.php">Home</a>
        </li>
        <li class="active">Author Admin</li>
      </ol>
    </div>
  </div>
  <?php
    if ($_SESSION['user_level'] == 20) {
      $sql = "SELECT count(*) FROM books WHERE Author = {$_SESSION['user_id']} ";
    }
    else if ($_SESSION['user_level'] == 30 || $_SESSION['user_level'] == 40) {
      $sql = "SELECT count(*) FROM books WHERE Published = 0 ";
    }
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
    if($_GET['field']=='ISBN')
    { 
      $field = "ISBN";  
    }
    elseif($_GET['field']=='Name')
    {
      $field = "Name"; 
    }
    elseif($_GET['field']=='first_name')
    { 
      $field="first_name"; 
    }
    elseif($_GET['field']=='Price')
    { 
      $field="Price"; 
    }
    $url='author_admin.php';
    $limit=2;
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
    if ($_SESSION['user_level'] >= 20) {
      echo'
        <div class = "container">
          <h3>Add a book</h3>
          <form name="add_book" 
                id = "add_book_form" 
                action="author_admin.php?p&sorting=ASC&field=ISBN" 
                method="post">
            <fieldset>
              <ol>
                <li>
                  <label for="book_name">Name:</label>
                  <input type="text" name="book_name" />
                </li> 
              </ol>
            </fieldset>
            <div id="message_line"></div>
            <fieldset>
              <div class="buttonHolder">
                <input type="submit" id="submit" class = "book_submit_button" name = "book_submit" />
                <button type="reset" id="clear">Clear</button>
              </div>
            </fieldset>
          </form>
        </div>'
      ;
    }
    if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
      $trimmed = array_map('trim', $_POST);
      if (!empty($_POST['book_submit'])) {
        $p = FALSE;
        $p = mysqli_real_escape_string ($dbc, $trimmed['book_name']);   
        if ($p){ 
          $q = "SELECT Name FROM books WHERE Name='$p'";
          $r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
          if (mysqli_num_rows($r) == 0) { // Available.
            $q = "INSERT INTO books (Name, Author, Publisher) VALUES ('$p', {$_SESSION['user_id']}, NULL )";
            $r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
            if (mysqli_affected_rows($dbc) == 1) { 
              echo '<h3>Book added successfully!</h3>';   
            } 
            else { 
              echo '<p class="error">You could not be registered due to a system error. We apologize for any inconvenience.</p>';
            } 
          } 
          else { // The email address is not available.
            echo '<p class="error">That name has already been registered. </p>';
          }
        } 
        else { // Failed the validation test.
          echo '<p class="error">Please try again.</p>';    
        }
      }
      if (!empty($_POST['save'])) {
        $p = FALSE;
        $id = mysqli_real_escape_string ($dbc, $trimmed['ISBN']);
        $n = mysqli_real_escape_string ($dbc, $trimmed['name']);
        $p = mysqli_real_escape_string ($dbc, $trimmed['price']);
        if ($p && $n) { 
          $q = "UPDATE books SET Name= '$n', Price=$p WHERE ISBN = $id"; 
          echo "$q";
          $r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
          if (mysqli_affected_rows($dbc) == 1) { 
            echo '<h3>Book updated.</h3>';  
          } else { 
            echo '<p class="error">Name and Price was not changed. Make sure your new name is different than the current book name. Contact the system administrator if you think an error occurred.</p>'; 
          }
        }
        else if($n) {
          $q = "UPDATE books SET Name= '$n' WHERE ISBN = $id"; 
          $r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
          if (mysqli_affected_rows($dbc) == 1) { 
            echo '<h3>Book updated.</h3>';
            } else {
              echo '<p class="error">Name was not changed. Make sure your new name is different than the current book name. Contact the system administrator if you think an error occurred.</p>'; 
            }
        } 
        else { // Failed the validation test.
          echo '<p class="error">Please try again.</p>';    
        }
      }
      if (!empty($_POST['delete'])) {
        $p = FALSE;
        $p = mysqli_real_escape_string ($dbc, $trimmed['ISBN']);
        if ($p) 
        {
          $q = "DELETE FROM books WHERE ISBN = {$trimmed['ISBN']}"; 
          $r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
        }
      }
      if (!empty($_POST['publish'])) {
        $p = FALSE;
        $p = mysqli_real_escape_string ($dbc, $trimmed['ISBN']);
        $name = FALSE;
        $name = mysqli_real_escape_string ($dbc, $trimmed['name']);
        $price = FALSE;
        $price = mysqli_real_escape_string ($dbc, $trimmed['price']);
        if ($p) 
        {
          if($name) {
            $q = "UPDATE books SET Name= '$name' WHERE ISBN = $p"; 
            $r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
          }
          if($price) {
            if($price > 0) {
              $q = "UPDATE books SET Published = 1, Publisher = {$_SESSION['user_id']}, Price = $price WHERE ISBN = $p"; 
              $r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
            }
          }
          else {
            echo '<p class="error">Please enter the price.</p>';
          }
          
        }
      }
    } // End of the main Submit conditional.

    $sql = "SELECT b.ISBN, b.Name, u.last_name, u.first_name, b.Price FROM users as u, books as b Where b.`Author` = u.user_id AND Published = 0 ORDER BY $field $sort limit $start, $limit";
    $total_values=mysqli_query($dbc, "SELECT ISBN, Name, Author, Price FROM books WHERE Published = 0");
    $total=mysqli_num_rows($total_values);
    $maxpage=ceil($total/$limit);
    $result = mysqli_query($dbc, $sql) or trigger_error("Query: $sql\n<br />MySQL Error: " . mysqli_error($dbc));
    if($total==0) {
      echo "<h3>No books to display!!</h3>";
    }
    else {
      echo'<table id = "details" border="0">';
      echo"<th><a href=\"{$_SERVER['PHP_SELF']}?p=".$page.'&sorting='.$sort."&field=ISBN\">ISBN</a></th>
      <th><a href=\"{$_SERVER['PHP_SELF']}?p=".$page.'&sorting='.$sort."&field=Name\">Name</a></th>
      <th><a href=\"{$_SERVER['PHP_SELF']}?p=".$page.'&sorting='.$sort."&field=first_name\">Author</a></th>
      <th><a href=\"{$_SERVER['PHP_SELF']}?p=".$page.'&sorting='.$sort."&field=Price\">Price</a></th>
      <th><a href=\"\">Save</a></th>
      <th><a href=\"\">Delete</a></th>";
      if ($_SESSION['user_level'] > 20) {
        echo "<th><a href=\"\">Publish</a></th>";
      }
      while($row = mysqli_fetch_array($result)) {
        echo'<tr> <form name="save" method="post">
              <td>'.$row['ISBN'].'</td>
              <input type="hidden" name="ISBN" value="'.$row['ISBN'].'" />
              <td><input name="name" value='.$row['Name'].'></td>
              <td>'.$row['first_name'].' '.$row['last_name'].'</td>';
        if ($_SESSION['user_level'] == 20) {
          echo '<td>'.$row['Price'].'</td>
                <input type="hidden" name="price" value="'.$row['Price'].'" />';
        }
        else {
          echo '<td><input name="price" value='.$row['Price'].'></td>';
        }
        echo '
        <td><input type="submit" id="save" name="save"  value="Save"/></td>
        </form>
        <form name="delete" method="post">
        <input type="hidden" name="ISBN" value="'.$row['ISBN'].'" />
        <td><input type="submit" id="delete" name="delete"  value="Delete"/></td>
        </form>';
        if ($_SESSION['user_level'] > 20) {
          echo '
          <form name="publish" method="post">
          <input type="hidden" name="ISBN" value="'.$row['ISBN'].'" />
          <input type="hidden" name="name" value="'.$row['Name'].'" />
          <input type="hidden" name="price" value="'.$row['Price'].'" />
          <td><input type="submit" id="publish" name="publish"  value="Publish"/></td>
          </form></tr>
          ';
        }
      }
      echo'</table>';
    }
    function pagination($maxpage,$page,$url,$field,$sort)
    { 
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
          echo'<li style="float:left;padding:5px;"><a href="author_admin.php?p='.$i.'&sorting='.$sort.'&field='.$field.' ">'.$i.'</a></li>';
        }
      }
      echo'</ul>';
    }
    pagination($maxpage,$page,$url,$field,$sort);
  ?>
  </div>