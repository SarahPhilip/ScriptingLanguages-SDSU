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
      $page_title = 'Images';
        
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
                <h1 class="page-header">Images
                    <small>Azteka</small>
                </h1>
                <ol class="breadcrumb">
                  <li><a href="index.php">Home</a></li>
                  <li><a href="publisher_admin.php?p&sorting=ASC&field=Name">Publisher Admin</a></li>
                  <li class="active">Images</li>
                </ol>
            </div>
        </div>
        <!-- /.row -->  
        <?php

        if(file_exists('tmpmedia/'.$_POST["ISBN"].'.jpeg')) {
          echo '
          <h3>Show Images</h3>
          <form name="images_form" method="post" action = "show_images.py">
          <input type="hidden" name="isbn" value="'.$_POST["ISBN"].'" />
          <input type="hidden" name = "bookName" value="'.$_POST["bookName"].'" />
          <input type="submit" id="show_image" name="show_image"  value="Show Images"/>
        </form>
        <br /> ';
        }

        ?> 
        
        <form action="submitted_images.py" method="post" enctype="multipart/form-data">
            <h3>Upload Image </h3> <br />
            <input type="file" name="myfile" /> 
            <?php
        echo '
            <input type="hidden" name="isbn" value="'.$_POST["ISBN"].'" /> <br />
            <input type="text" name = "bookName" value="'.$_POST["bookName"].'" />
            <br />';
            ?>
            <br />
            
             <input type="submit" name="submit" value="Submit" />
        </form>

    </div>
     <?php
    //     include ('includes/footer.html');
    ?>