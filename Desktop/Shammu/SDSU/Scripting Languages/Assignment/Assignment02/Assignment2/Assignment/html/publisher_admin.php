<?php # Script 18.5 - index.php
  // This is the main page for the site.
  // Include the configuration file:
  require ('includes/config.inc.php'); 
  require (MYSQL);
  $rec_limit = 2;
  $field='ISBN';
  $sort='ASC';
  $page_title = 'Home';
  include ('includes/header.html');
?>
<div class="container">
  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header">Publisher Admin
          <small>Azteka</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="index.php">Home</a>
        </li>
        <li class="active">Publisher Admin</li>
      </ol>
    </div>
  </div>
<?php
  if ($_SESSION['user_level'] == 30) {
    $sql = "SELECT count(*) FROM books WHERE Publisher = {$_SESSION['user_id']} AND Published = 0  ";
  }
  else
    $sql = "SELECT count(*) FROM books WHERE Published = 0  ";
  
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
  if ($_SESSION['user_level'] == 20) {
    echo'
    <div class = "container">
      <h3>Add a book</h3>
      <form name="add_book"  
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
            <input type="submit" id="submit" name = "book_submit" />
            <button type="reset" id="clear">Clear</button>
          </div>
        </fieldset>
      </form>
    </div>';
  }
  if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
    $trimmed = array_map('trim', $_POST);
    if (!empty($_POST['book_submit'])) {
      $p = FALSE;
      $p = mysqli_real_escape_string ($dbc, $trimmed['book_name']);   
      if ($p) { 
        $q = "SELECT Name FROM books WHERE Name='$p'";
        $r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
        if (mysqli_num_rows($r) == 0) { 
          $q = "INSERT INTO books (Name, Author) VALUES ('$p', {$_SESSION['user_id']} )";
          $r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
          if (mysqli_affected_rows($dbc) == 1) { // If it ran OK.
            echo '<h3>Book added successfully!</h3>';   
          } 
          else { // If it did not run OK.
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
      $b = mysqli_real_escape_string ($dbc, $trimmed['best_seller_dropdown']);
      $q = "UPDATE books SET Name= '$n', Price=$p, BestSeller = $b WHERE ISBN = $id"; 
      $r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
      if (mysqli_affected_rows($dbc) == 1) { // If it ran OK.
        echo '<h3>Book updated.</h3>';
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
      if ($p) 
      {
        $q = "UPDATE books SET Published = 1, Publisher = {$_SESSION['user_id']} WHERE ISBN = $p"; 
        $r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
      }
    }
  } // End of the main Submit conditional.

  if ($_SESSION['user_level'] == 30) {
    $sql = "SELECT b.ISBN, b.Name, u.last_name, u.first_name, b.Price, b.BestSeller \n"
      . "FROM books as b\n"
      . "INNER JOIN users as u\n"
      . "On b.`Author` = u.user_id\n"
      . "Where Publisher = {$_SESSION['user_id']} AND Published = 1 \n"
      . "ORDER BY $field $sort \n"
      . "LIMIT $start, $limit";
    $total_values=mysqli_query($dbc, "SELECT ISBN, Name, Author, Price, BestSeller FROM books WHERE Publisher = {$_SESSION['user_id']} AND Published = 1 ");
  }
  else {
    $sql = "SELECT b.ISBN, b.Name, u.last_name, u.first_name, b.Price, b.BestSeller, u.user_level FROM users as u, books as b Where b.`Author` = u.user_id AND Published = 1 ORDER BY $field $sort limit $start, $limit";
    $total_values=mysqli_query($dbc, "SELECT ISBN, Name, Author, Price, BestSeller FROM books WHERE Published = 1 ");
  }
  $total=mysqli_num_rows($total_values);
  $maxpage=ceil($total/$limit);
  $result = mysqli_query($dbc, $sql) or trigger_error("Query: $sql\n<br />MySQL Error: " . mysqli_error($dbc));
  echo'<table id = "details" border="0">';
  echo"<th><a href=\"{$_SERVER['PHP_SELF']}?p=".$page.'&sorting='.$sort."&field=ISBN\">ISBN</a></th>
  <th><a href=\"{$_SERVER['PHP_SELF']}?p=".$page.'&sorting='.$sort."&field=Name\">Name</a></th>
  <th><a href=\"{$_SERVER['PHP_SELF']}?p=".$page.'&sorting='.$sort."&field=first_name\">Author</a></th>
  <th><a href=\"{$_SERVER['PHP_SELF']}?p=".$page.'&sorting='.$sort."&field=Price\">Price</a></th>
  <th><a href=\"{$_SERVER['PHP_SELF']}?p=".$page.'&sorting='.$sort."&field=BestSeller\">Best Seller</a></th>
  <th><a href=\"\">Save</a></th>
  <th><a href=\"\">Delete</a></th>
  ";
  while($row = mysqli_fetch_array($result)) {
    echo'<tr> <form name="save" method="post">
    <td>'.$row['ISBN'].'</td>
    <input type="hidden" name="ISBN" value="'.$row['ISBN'].'" />
    <td><input name="name" value='.$row['Name'].'></td>
    <td>'.$row['first_name'].' '.$row['last_name'].'</td>
    <td><input name="price" value='.$row['Price'].'></td>
    <td>
      <select name="best_seller_dropdown">';
      $bestSeller = $row['BestSeller']; 
      $selection = array( // Create Index Of AuthIDs and AuthNames
        0 => "NO",
        1 => "YES");
      foreach($selection as $key => $value) // Loop Through $selection, Where $key is AuthID and $value is AuthName
      {
          echo '<option value="' . $key . '"'; // Start Menu Item
          if ($bestSeller == $key) // Check If AuthID from $selection equals $authid from database
              echo ' selected="selected"'; // Select The Menu Item If They Match
          echo '>' . $value . '</option>'; // End Menu Item
      }
    echo '   
    </select>
  </td>
    <td><input type="submit" id="save" name="save"  value="Save"/></td>
    </form>
    <form name="delete" method="post">
    <input type="hidden" name="ISBN" value="'.$row['ISBN'].'" />
    <td><input type="submit" id="delete" name="delete"  value="Delete"/></td>
    </form>
    </tr>';
  }
  echo'</table>';
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
        echo'<li style="float:left;padding:5px;"><a href="publisher_admin.php?p='.$i.'&sorting='.$sort.'&field='.$field.' ">'.$i.'</a></li>';
      }
    }
    echo'</ul>';
  }
  pagination($maxpage,$page,$url,$field,$sort);
?>
</div>