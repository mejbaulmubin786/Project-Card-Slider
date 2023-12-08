<?php include 'header.php'; ?>
    <div id="main-content">
      <div class="container">
        <div class="row">
            <div class="col-md-8">
                <!-- post-container -->
                <div class="post-container">
                  <?php
                  include "config.php";
                  if(isset($_GET['search'])){
                  $search_term= mysqli_real_escape_string($conn,$_GET['search']);
                  }
                   ?>
                  <h2 class="page-heading">Search : <?php echo $search_term ?></h2>

                  <?php
                    if(isset($_GET['search'])){
                    $search_term=$_GET['search'];
                    }

                    $limit=3;
                    if(isset($_GET["page"])){
                    $page=$_GET["page"];
                  
                      }else{
                          $page=1;
                      }
                      $offset=($page-1) * $limit;

                //SQL Main QUery jo search ke according data show kregi
                //according to title and description
                $sql="SELECT post.post_id,post.title,category.category_name,post.post_date,post.description,post.post_img,user.username,post.category FROM post
                LEFT JOIN category ON post.category=category.category_id
                LEFT JOIN user ON post.author=user.user_id
                WHERE post.title LIKE '%{$search_term}%' OR post.description LIKE '%{$search_term}%' OR user.username LIKE '%{$search_term}%' OR category.category_name LIKE '%{$search_term}%'
                ORDER BY post_id DESC LIMIT {$offset}, {$limit}";

                $result=mysqli_query($conn,$sql) or die("Query failed :Fetch Search Items");
                if(mysqli_num_rows($result) > 0 ){
                  while($row = mysqli_fetch_assoc($result)) {
                  ?>
                      <div class="post-content">
                          <div class="row">
                              <div class="col-md-4">
                                  <a class="post-img" href="single.php?id=<?php echo $row['post_id'];?>"><img src="admin/upload/<?php echo $row['post_img'];?>" alt="blank"/></a>
                              </div>
                              <div class="col-md-8">
                                  <div class="inner-content clearfix">
                                      <h3><a href="single.php?id=<?php echo $row['post_id'];?>"><?php echo $row["title"];?></a></h3>
                                      <div class="post-information">
                                          <span>
                                              <i class="fa fa-tags" aria-hidden="true"></i>
    <a href='category.php?cid=<?php echo $row["category"]; ?>'><?php echo $row["category_name"];?></a>
                                          </span>
                                          <span>
                                              <i class="fa fa-user" aria-hidden="true"></i>
                                              <a href='author.php?aid=<?php echo $row['author']; ?>'><?php echo $row["username"];?></a>
                                          </span>
                                          <span>
                                              <i class="fa fa-calendar" aria-hidden="true"></i>
                                              <?php echo $row["post_date"];?>
                                          </span>
                                      </div>
                                      <p class="description">
                                      <?php echo substr($row["description"],0,140)."....";?>
                                      </p>
                                      <a class='read-more pull-right' href="single.php?id=<?php echo $row['post_id'];?>">Read More</a>
                                  </div>
                              </div>
                          </div>
                      </div>
                      <?php
                      }
                  }else{
                      echo "<h2> No Posts Record Found</h2>";
                  }?>

                  <?php
                  //show pagenation codes
                  $sql1="SELECT * FROM post WHERE post.title LIKE '%{$search_term}%' ";
                  $result1=mysqli_query($conn,$sql1) or die("Query Failed");


                    if(mysqli_num_rows($result1) > 0 ){
                      $total_records=mysqli_num_rows($result1);

                      //$limit=3;
                      $total_pages= ceil ($total_records / $limit);  //return upper value
                      echo "<ul class='pagination admin-pagination'>";
                      if($page>1){ //1>2
                          echo'<li><a href="search.php?search='.$search_term.'&page='.($page - 1). '">Prev</a></li>';
                      }

                      for ($i=1; $i<=$total_pages; $i++) { //means 3 time print buttons
                        //active class code
                        if($i==$page){
                          $active="active";
                        }else{
                          $active="";
                        }
                          echo '<li class="'.$active.'"><a href="search.php?search='.$search_term.'&page=' .$i .'">'.$i.'</a></li>';
                      } //for close
                       if($total_pages>$page){
                            echo'<li><a href="search.php?search='.$search_term.'&page='.($page + 1).'">Next</a></li>';
                       }
                        echo "</ul>";
                    }
                    ?>
                </div><!-- /post-container -->
            </div>
            <?php include 'sidebar.php'; ?>
        </div>
      </div>
    </div>
<?php include 'footer.php'; ?>
