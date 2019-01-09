      <?php # Script 18.5 - index.php
      // This is the main page for the site.

      // Include the configuration file:
      require ('includes/config.inc.php'); 
      require (MYSQL);
      // include './Pagination.php';
      $rec_limit = 4;
      $field='ISBN';
      $sort='ASC';

      // Set the page title and include the HTML header:
      $page_title = 'Home';
        
      include ('includes/header.html');
      if (!isset($_SESSION['first_name'])) {
        if (!isset($_COOKIE['main_page_count'])) {
          setcookie ('main_page_count', 1);
        }
        else {
          $count = $_COOKIE['main_page_count'] + 1;
          setcookie('main_page_count', $count);
        }
    }
      ?>
      <div class="container">

        <!-- Page Heading/Breadcrumbs -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Home
                    <small>Azteka</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="index.php">Home</a>
                    </li>
                    <!-- <li class="active">About</li> -->
                </ol>
            </div>
        </div>
        <!-- /.row -->

        <!-- Intro Content -->
        <?php
      // Welcome the user (by name if they are logged in):
      // echo '<h1>Welcome';
      // if (isset($_SESSION['first_name'])) {
      // echo ", {$_SESSION['first_name']}";
      // }
      // echo '!</h1>';
      // echo "{$_SERVER['PHP_SELF']}";
      /* Get total number of records */
      $sql = "SELECT count(*) FROM books WHERE Published = 1 ";
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
      if(isset($_GET['field'])) {
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
      }
      if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
        $trimmed = array_map('trim', $_POST);
        
        if (!empty($_POST['Order_number'])) {
          $p = FALSE;
          $id = mysqli_real_escape_string ($dbc, $trimmed['ISBN']);
          $n = mysqli_real_escape_string ($dbc, $trimmed['order']);
          
          $q = "UPDATE books SET numberSold = numberSold + '$n' WHERE ISBN = $id"; 
          $r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
          if (mysqli_affected_rows($dbc) == 1) { // If it ran OK.
            echo '<h3>Book ordered.</h3>';
          } 
        }   
      }
      ?>
      <div id="centreImage">
        
            <img src="images/publish2.jpg" alt="slideshow1" align = "middle" />                 
    
      </div>
      <?php
      //-------------------------------------------------------------
      //pagination
       $url='index.php';
       $limit=2;
       if(isset($_GET['p']))
        $page=$_GET['p'];
      else
        $page = '';
       if($page=='')
       {
        $page=1;
        $start=0;
       }
       else
       {
        $start=$limit*($page-1);
       }

      $sql = "SELECT b.ISBN, b.Name, u.last_name, u.first_name, b.Price FROM users as u, books as b Where b.`Author` = u.user_id AND b.Published = 1 ORDER BY $field $sort limit $start, $limit";
      // echo "$sql";
      $total_values=mysqli_query($dbc, "SELECT ISBN, Name, Author, Price FROM books WHERE Published = 1");
      $total=mysqli_num_rows($total_values);
      $maxpage=ceil($total/$limit);
      $result = mysqli_query($dbc, $sql) or trigger_error("Query: $sql\n<br />MySQL Error: " . mysqli_error($dbc));
      
      echo'<table id = "details" border="0">';
      echo"<th><a href=\"{$_SERVER['PHP_SELF']}?p=".$page."&sorting=".$sort."&field=ISBN\">ISBN</a></th>
           <th><a href=\"{$_SERVER['PHP_SELF']}?p=".$page."&sorting=".$sort."&field=Name\">Name</a></th>
           <th><a href=\"{$_SERVER['PHP_SELF']}?p=".$page."&sorting=".$sort."&field=first_name\">Author</a></th>
           <th><a href=\"{$_SERVER['PHP_SELF']}?p=".$page."&sorting=".$sort."&field=Price\">Price</a></th>";
           if (isset($_SESSION['first_name'])) {
            echo'<th><a href="index.php?p='.$page.'&sorting='.$sort.'&field=Quantity">Quantity</a></th>';
            echo'<th><a href="">Order</a></th>';
           }
      while($row = mysqli_fetch_array($result)) {
      echo'<tr><td>'.$row['ISBN'].'</td><td>'.$row['Name'].'</td><td>'.$row['first_name'].' '.$row['last_name'].'</td><td>'.$row['Price'].'</td>';
      if (isset($_SESSION['first_name'])) {
            // echo'<td><input type="text" size="7" ></td>';
            // echo'<td><button class="orderbtn">Order </button></td>';
            echo '
            <form name="Order_number" method="post">
            <td><input type="text" name = "order" size="7" ></td>
            <input type="hidden" name="ISBN" value="'.$row['ISBN'].'" />
            <td><input type="submit" id="Order_number" name="Order_number"  value="Order"/></td>
            </form>';
           }
      echo "</tr>";
      }
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
      echo'<li style="float:left;padding:5px;"><a href="index.php?p='.$i.'&sorting='.$sort.'&field='.$field.' ">'.$i.'</a></li>';
      }
         }
        echo'</ul>';
      }
      pagination($maxpage,$page,$url,$field,$sort);
      ?>
    </div>