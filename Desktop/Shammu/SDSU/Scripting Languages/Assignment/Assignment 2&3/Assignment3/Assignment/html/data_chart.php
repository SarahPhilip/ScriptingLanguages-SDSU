<?PHP
	require ('includes/config.inc.php'); 
	require (MYSQL);
    $return_arr = array();
    $sql = "SELECT * FROM books Where BestSeller = 1 ";
    $retval = mysqli_query( $dbc, $sql );
    if(! $retval )
    {
        die('Could not get data: ' . mysql_error());
    }
    while ($row = mysqli_fetch_array($retval, MYSQL_ASSOC )) {
    	echo $row['Name'] . "/" . $row['numberSold']. "/" ;
        // $row_array['Name'] = $row['Name'];
        // $row_array['numberSold'] = $row['numberSold'];
        // array_push($return_arr,$row_array);
    }
    mysqli_close($dbc);
    // print(json_encode($return_arr, JSON_NUMERIC_CHECK));
?>
