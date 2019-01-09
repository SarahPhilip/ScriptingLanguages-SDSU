<!--       <?php # Script 18.5 - index.php
      // This is the main page for the site.

      // Include the configuration file:
      // require ('../includes/config.inc.php'); 
      // require (MYSQL);
      // include './Pagination.php';
      // $rec_limit = 4;
      // $field='ISBN';
      // $sort='ASC';

      // // Set the page title and include the HTML header:
      // $page_title = 'api';
        
      // include ('../includes/header.html');
      
      ?>
      <div class="container">

        <!-- Page Heading/Breadcrumbs -->
        
        
        <?php   

      //   if (empty($_GET)) {
      //     echo '
      //     <div class="row">
      //       <div class="col-lg-12">
      //           <h1 class="page-header">
      //               <small>List of All BestSellers</small>
      //           </h1>
      //       </div>
      //   </div> ';
      //     $return_arr = array();
      //     $sql = "SELECT b.ISBN, b.Name, u.last_name, u.first_name, b.Price FROM users as u, books as b Where b.`Author` = u.user_id AND b.BestSeller = 1 ";
      //     $retval = mysqli_query( $dbc, $sql );
      //     if(! $retval )
      //     {
      //       die('Could not get data: ' . mysql_error());
      //     }
      //     while ($row = mysqli_fetch_array($retval, MYSQL_ASSOC )) {
      //       $row_array['ISBN'] = $row['ISBN'];
      //       $row_array['Name'] = $row['Name'];
      //       $row_array['Author'] = $row['first_name'] .' ' . $row['last_name'];
      //       $row_array['Price'] = $row['Price'];
      //       array_push($return_arr,$row_array);
      //     }
      //     echo "<pre>";
      //     // $json = json_encode($return_arr);
      //     echo json_encode($return_arr, JSON_PRETTY_PRINT);
      //     echo "</pre>";
      //   }

      // if(isset($_GET['list']))
      // {
      //   if($_GET['list']=='all')
      //   {
      //     echo '
      //     <div class="row">
      //       <div class="col-lg-12">
      //           <h1 class="page-header">
      //               <small>List of All Books</small>
      //           </h1>
      //       </div>
      //   </div> ';
      //     $return_arr = array();
      //     $sql = "SELECT b.ISBN, b.Name, u.last_name, u.first_name, b.Price FROM users as u, books as b Where b.`Author` = u.user_id AND b.Published = 1 ";
      //     $retval = mysqli_query( $dbc, $sql );
      //     if(! $retval )
      //     {
      //       die('Could not get data: ' . mysql_error());
      //     }
      //     while ($row = mysqli_fetch_array($retval, MYSQL_ASSOC )) {
      //       $row_array['ISBN'] = $row['ISBN'];
      //       $row_array['Name'] = $row['Name'];
      //       $row_array['Author'] = $row['first_name'] .' ' . $row['last_name'];
      //       $row_array['Price'] = $row['Price'];
      //       array_push($return_arr,$row_array);
      //     }
      //     echo "<pre>";
      //     // $json = json_encode($return_arr);
      //     echo json_encode($return_arr, JSON_PRETTY_PRINT);
      //     echo "</pre>";
      //   }
        
      // }
      // if(isset($_GET['Top']))
      // {
      //   $Top = intval($_GET['Top']);
      //   // if($_GET['Top']=='10')
      //   // {
      //     echo '
      //     <div class="row">
      //       <div class="col-lg-12">
      //           <h1 class="page-header">
      //               <small>Top 10 Books</small>
      //           </h1>
      //       </div>
      //   </div> ';
      //     $return_arr = array();

      //     $sql = "SELECT b.ISBN, b.Name, u.last_name, u.first_name, b.Price, b.numberSold FROM users as u, books as b Where b.`Author` = u.user_id AND b.Published = 1 ORDER BY b.numberSold desc limit ".$Top;
      //     $retval = mysqli_query( $dbc, $sql );
      //     if(! $retval )
      //     {
      //       die('Could not get data: ' . mysql_error());
      //     }
      //     while ($row = mysqli_fetch_array($retval, MYSQL_ASSOC )) {
      //       $row_array['ISBN'] = $row['ISBN'];
      //       $row_array['Name'] = $row['Name'];
      //       $row_array['Author'] = $row['first_name'] .' ' . $row['last_name'];
      //       $row_array['Price'] = $row['Price'];
      //       $row_array['Number Sold'] = $row['numberSold'];
      //       array_push($return_arr,$row_array);
      //     }
      //     echo "<pre>";
      //     // $json = json_encode($return_arr);
      //     echo json_encode($return_arr, JSON_PRETTY_PRINT);
      //     echo "</pre>";
        // }
        
      // }
      
      ?>
      
    <!-- </div> --> 