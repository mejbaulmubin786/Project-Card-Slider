<?php
// echo "<pre>";
// print_r($_SERVER);
// echo "</pre>";
// echo "$_SERVER[PHP_SELF]";

//Dynamic Website Title coding Start
$pagename=basename($_SERVER['PHP_SELF']);
//echo $pagename;

include "config.php";
switch ($pagename) {
    case 'single.php':
    if(isset($_GET['id'])){
      $sql="SELECT * FROM post WHERE post_id={$_GET['id']}";
      $result=mysqli_query($conn,$sql) or die("Query Failed : single");
      $row=mysqli_fetch_assoc($result);
      $page_title=$row['title']. " News";
    }else{
      $page_title="No Post Found";
    }
    break;

    case 'category.php':
    if(isset($_GET['cid'])){
    $sql="SELECT * FROM category WHERE category_id ={$_GET['cid']}";
    $result=mysqli_query($conn,$sql) or die("Query Failed :");
    $row=mysqli_fetch_assoc($result);
    $page_title=$row['category_name']. " News";
    }else{
    $page_title="No Post Found";
    }
    break;

    case 'author.php':
    if(isset($_GET['aid'])){
    $sql="SELECT * FROM user WHERE user_id ={$_GET['aid']}";
    $result=mysqli_query($conn,$sql) or die("Query Failed :");
    $row=mysqli_fetch_assoc($result);
    $page_title="News by ".$row['first_name'] . $row['last_name'];
    }else{
    $page_title="No Post Found";
    }
    break;

    case 'search.php':
    if(isset($_GET['search'])){
    $page_title=$_GET['search'];
    }else{
    $page_title="No Search Result Found";
    }
    break;

    default:
    $page_title="Mejbaul Mubin's Blogs";
    break;
    }

 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?php echo $page_title; ?></title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <!-- Font Awesome Icon -->
    <link rel="stylesheet" href="css/font-awesome.css">
    <!-- Custom stlylesheet -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<!-- HEADER -->
<div id="header">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <!-- LOGO -->
            <div class=" col-md-offset-4 col-md-4">
              <?php
                include "config.php";
                $sql1 = "SELECT * FROM settings";
                $result1 = mysqli_query($conn, $sql1) or die("Query Failed: Because You Have Not Created any Posts Yet :) Please Create Atleast One post to view This ");
                if(mysqli_num_rows($result1) > 0){
                  while($row1 = mysqli_fetch_assoc($result1)) {
     //agr logo image me koi image nhi toh simply websitename show kr dega
                    if($row1['logo']==" "){
          echo '<a href="index.php"><h1>'.$row1["websitename"].'</h1></a>';
                    }else{
       echo '<a href="index.php" id="logo"><img src="admin/images/'.$row1['logo'].'"></a>';
                    }
            }
          }?>
            </div>
        <!-- /LOGO -->
        </div>
    </div>
</div>
<!-- /HEADER -->
<!-- Menu Bar -->
<div id="menu-bar">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
              <?php include "config.php";
              if(isset($_GET['cid'])){
                $cat_id=$_GET['cid'];
             }

             //print Dynamic menus catagory pages
              //wo category show ho jinke andar koi post hai
              $sql2="SELECT * FROM category WHERE post > 0";
              $result2=mysqli_query($conn,$sql2) or die("Query failed :Category");
              if(mysqli_num_rows($result2) > 0 ){
                 $active="";
               ?>
                <ul class='menu'>
                  <li><a class='' href='<?php echo $hostname; ?>'>HOME</a></li>
                    <?php
                    while($row2 = mysqli_fetch_assoc($result2)) {
                    if(isset($_GET['cid'])){
                      if($row2['category_id']==$cat_id){
                        $active="active";
                      }else{
                       $active="";
                      }
                   }
  echo "<li><a class='{$active}' href='category.php?cid={$row2['category_id']}'>{$row2['category_name']}</a></li>";
              } ?>
                </ul>
              <?php } ?>
            </div>
        </div>
    </div>
</div>
<!-- /Menu Bar -->
