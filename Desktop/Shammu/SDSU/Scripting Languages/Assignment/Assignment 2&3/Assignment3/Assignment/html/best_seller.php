<?php # Script 18.5 - index.php
// This is the main page for the site.

// Include the configuration file:
require ('includes/config.inc.php'); 
require (MYSQL);
// include './Pagination.php';
$rec_limit = 2;
$field='ISBN';
$sort='ASC';

// Set the page title and include the HTML header:
$page_title = 'Home';

include ('includes/header.html');
if (!isset($_SESSION['first_name'])) {
  if (!isset($_COOKIE['best_seller_page_count'])) {
          setcookie ('best_seller_page_count', 1);
        }
        else {
          $count = $_COOKIE['best_seller_page_count'] + 1;
          setcookie('best_seller_page_count', $count);
        }
      }
?>
<div class="container">

        <!-- Page Heading/Breadcrumbs -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Best Seller
                    <small>Azteka</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="index.php">Home</a>
                    </li>
                    <li class="active">Best Seller</li>
                </ol>
            </div>
        </div>
        <!-- /.row -->

        <!-- Intro Content -->
<?php
/* Get total number of records */
$sql = "SELECT count(*) FROM books WHERE BestSeller = 1 ";
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

//-------------------------------------------------------------
//pagination
 $url='index.php';
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

$sql = "SELECT b.ISBN, b.Name, u.last_name, u.first_name, b.Price FROM users as u, books as b Where b.`Author` = u.user_id AND BestSeller = 1 ORDER BY $field $sort limit $start, $limit";
// echo "$sql";
$total_values=mysqli_query($dbc, "SELECT ISBN, Name, Author, Price FROM books WHERE BestSeller = 1");
$total=mysqli_num_rows($total_values);
$maxpage=ceil($total/$limit);
$result = mysqli_query($dbc, $sql) or trigger_error("Query: $sql\n<br />MySQL Error: " . mysqli_error($dbc));
echo'<table id = "details" border="0">';
echo"<th><a href=\"{$_SERVER['PHP_SELF']}?p=".$page.'&sorting='.$sort."&field=ISBN\">ISBN</a></th>
     <th><a href=\"{$_SERVER['PHP_SELF']}?p=".$page.'&sorting='.$sort."&field=Name\">Name</a></th>
     <th><a href=\"{$_SERVER['PHP_SELF']}?p=".$page.'&sorting='.$sort."&field=first_name\">Author</a></th>
     <th><a href=\"{$_SERVER['PHP_SELF']}?p=".$page.'&sorting='.$sort.'&field=Price\">Price</a></th>';
while($row = mysqli_fetch_array($result)) {
echo'<tr><td>'.$row['ISBN'].'</td><td>'.$row['Name'].'</td><td>'.$row['first_name'].' '.$row['last_name'].'</td><td>'.$row['Price'].'</td></tr>';
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
echo'<li style="float:left;padding:5px;"><a href="best_seller.php?p='.$i.'&sorting='.$sort.'&field='.$field.' ">'.$i.'</a></li>';
}
   }
  echo'</ul>';
}
pagination($maxpage,$page,$url,$field,$sort);
?>
<div id="chart" style="height: 400px; margin: 0 auto"></div>  
<script src="http://code.highcharts.com/highcharts.js"></script>
<script src="http://code.highcharts.com/modules/exporting.js"></script> 
<script type="text/javascript" src="js/high_chart.js"></script>
</div>