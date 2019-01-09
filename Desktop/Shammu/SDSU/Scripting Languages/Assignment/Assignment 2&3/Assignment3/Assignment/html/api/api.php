<?php
    	
	require_once("Rest.inc.php");
	
	class API extends REST {
	
		public $data = "";
		
		const DB_SERVER = "localhost";
		const DB_USER = "root";
		const DB_PASSWORD = "";
		const DB = "azteka";
		
		private $db = NULL;
		public $dbc =NULL;
	
		public function __construct(){
			parent::__construct();				// Init parent contructor
			$this->dbConnect();					// Initiate Database connection
		}
		
		/*
		 *  Database connection 
		*/
		private function dbConnect(){
			$this->db = mysql_connect(self::DB_SERVER,self::DB_USER,self::DB_PASSWORD);
			if($this->db)
				mysql_select_db(self::DB,$this->db);
			$this->dbc = @mysqli_connect (self::DB_SERVER,self::DB_USER,self::DB_PASSWORD,self::DB);
		}
		
		/*
		 * Public method for access api.
		 * This method dynmically call the method based on the query string
		 *
		 */
		public function processApi(){
			$func = strtolower(trim(str_replace("/","",$_REQUEST['rquest'])));
			if((int)method_exists($this,$func) > 0)
				$this->$func();
			else
				$this->response('',404);				// If the method not exist with in this class, response would be "Page not found".
		}
		
		
		private function get_books(){
			if((!isset($_GET['Top']))&&(!isset($_GET['list']))&&(!isset($_GET['ID']))){
	          echo '
	          <div class="row">
	            <div class="col-lg-12">
	                <h1 class="page-header">
	                    <small>List of All BestSellers</small>
	                </h1>
	            </div>
	        </div> ';
	          $return_arr = array();
	          $sql = "SELECT b.ISBN, b.Name, u.last_name, u.first_name, b.Price FROM users as u, books as b Where b.`Author` = u.user_id AND b.BestSeller = 1 ";
	          $retval = mysqli_query( $this->dbc, $sql );
	          if(! $retval )
	          {
	            die('Could not get data: ' . mysql_error());
	          }
	          while ($row = mysqli_fetch_array($retval, MYSQL_ASSOC )) {
	            $row_array['ISBN'] = $row['ISBN'];
	            $row_array['Name'] = $row['Name'];
	            $row_array['Author'] = $row['first_name'] .' ' . $row['last_name'];
	            $row_array['Price'] = $row['Price'];
	            array_push($return_arr,$row_array);
	          }
	          echo "<pre>";
	          // $json = json_encode($return_arr);
	          echo json_encode($return_arr, JSON_PRETTY_PRINT);
	          echo "</pre>";
	        }

	      if(isset($_GET['list']))
	      {
	        if($_GET['list']=='all')
	        {
	          echo '
	          <div class="row">
	            <div class="col-lg-12">
	                <h1 class="page-header">
	                    <small>List of All Books</small>
	                </h1>
	            </div>
	        </div> ';
	          $return_arr = array();
	          $sql = "SELECT b.ISBN, b.Name, u.last_name, u.first_name, b.Price FROM users as u, books as b Where b.`Author` = u.user_id AND b.Published = 1 ";
	          $retval = mysqli_query( $this->dbc, $sql );
	          if(! $retval )
	          {
	            die('Could not get data: ' . mysql_error());
	          }
	          while ($row = mysqli_fetch_array($retval, MYSQL_ASSOC )) {
	            $row_array['ISBN'] = $row['ISBN'];
	            $row_array['Name'] = $row['Name'];
	            $row_array['Author'] = $row['first_name'] .' ' . $row['last_name'];
	            $row_array['Price'] = $row['Price'];
	            array_push($return_arr,$row_array);
	          }
	          echo "<pre>";
	          // $json = json_encode($return_arr);
	          echo json_encode($return_arr, JSON_PRETTY_PRINT);
	          echo "</pre>";
	          mysqli_close($this->dbc);
	        }
	        
	      }
	      if(isset($_GET['Top']))
	      {
	        $Top = intval($_GET['Top']);
	        // if($_GET['Top']=='10')
	        // {
	          echo '
	          <div class="row">
	            <div class="col-lg-12">
	                <h1 class="page-header">
	                    <small>Top '.$Top.' Books</small>
	                </h1>
	            </div>
	        </div> ';
	          $return_arr = array();

	          $sql = "SELECT b.ISBN, b.Name, u.last_name, u.first_name, b.Price, b.numberSold FROM users as u, books as b Where b.`Author` = u.user_id AND b.Published = 1 ORDER BY b.numberSold desc limit ".$Top;
	          $retval = mysqli_query( $this->dbc, $sql );
	          if(! $retval )
	          {
	            die('Could not get data: ' . mysql_error());
	          }
	          while ($row = mysqli_fetch_array($retval, MYSQL_ASSOC )) {
	            $row_array['ISBN'] = $row['ISBN'];
	            $row_array['Name'] = $row['Name'];
	            $row_array['Author'] = $row['first_name'] .' ' . $row['last_name'];
	            $row_array['Price'] = $row['Price'];
	            $row_array['Number Sold'] = $row['numberSold'];
	            array_push($return_arr,$row_array);
	          }
	          echo "<pre>";
	          // $json = json_encode($return_arr);
	          echo json_encode($return_arr, JSON_PRETTY_PRINT);
	          echo "</pre>";
	          mysqli_close($this->dbc);	        
	      }
	      if(isset($_GET['ID']))
	      {
	        $ID = intval($_GET['ID']);
	        echo '
	          <div class="row">
	            <div class="col-lg-12">
	                <h1 class="page-header">
	                    <small>Details of Book '.$ID.'</small>
	                </h1>
	            </div>
	        </div> ';
	          $return_arr = array();

	          $sql = "SELECT b.ISBN, b.Name, u.last_name, u.first_name, b.Price, b.numberSold FROM users as u, books as b Where b.`Author` = u.user_id AND b.ISBN =".$ID;
	          $retval = mysqli_query( $this->dbc, $sql );
	          if(! $retval )
	          {
	            die('Could not get data: ' . mysql_error());
	          }
	          while ($row = mysqli_fetch_array($retval, MYSQL_ASSOC )) {
	            $row_array['ISBN'] = $row['ISBN'];
	            $row_array['Name'] = $row['Name'];
	            $row_array['Author'] = $row['first_name'] .' ' . $row['last_name'];
	            $row_array['Price'] = $row['Price'];
	            $row_array['Number Sold'] = $row['numberSold'];
	            array_push($return_arr,$row_array);
	          }
	          echo "<pre>";
	          // $json = json_encode($return_arr);
	          echo json_encode($return_arr, JSON_PRETTY_PRINT);
	          echo "</pre>";	
	          mysqli_close($this->dbc);        
	      }
	  }
		/*
		 *	Encode array into JSON
		*/
		private function json($data){
			if(is_array($data)){
				return json_encode($data);
			}
		}
	}
	
	// Initiiate Library
	
	$api = new API;
	$api->processApi();
?>