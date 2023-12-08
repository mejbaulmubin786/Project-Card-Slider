<?php include "header.php";?>

  <div id="admin-content">
      <div class="container">
          <div class="row">
              <div class="col-md-10">
                  <h1 class="admin-heading">All Posts</h1>
              </div>
              <div class="col-md-2">
                  <a class="add-new" href="add-post.php">add post</a>
              </div>
              <div class="col-md-12">
              <?php
              include "config.php";
              $limit=3;
              if(isset($_GET["page"])){  //first time page refresh error solve
                $page=$_GET["page"];
              }else{
                  $page=1;
              }
              $offset=($page-1) * $limit;  //here is offset logic

              //This is secure query for seleled coloumns
              if($_SESSION["user_role"]==1){  //means normal user hai toh redirect
                $sql="SELECT post.post_id,post.title,category.category_name,post.post_date,user.username,post.category FROM post
                LEFT JOIN category ON post.category=category.category_id
                LEFT JOIN user ON post.author=user.user_id
                ORDER BY post_id DESC LIMIT {$offset}, {$limit}";   //view latest post information

               }elseif($_SESSION["user_role"]==0){    //normal user admin ki post na dekh ske
                $sql="SELECT post.post_id,post.title,category.category_name,post.post_date,user.username,post.category FROM post
                LEFT JOIN category ON post.category=category.category_id
                LEFT JOIN user ON post.author=user.user_id
                WHERE post.author={$_SESSION['user_id']}
                ORDER BY post_id DESC LIMIT {$offset}, {$limit}";
               }

              $result=mysqli_query($conn,$sql) or die("Query failed ");
              if(mysqli_num_rows($result) > 0 ){

               ?>
                  <table class="content-table">
                      <thead>
                          <th>S.No.</th>
                          <th>Title</th>
                          <th>Category</th>
                          <th>Date</th>
                          <th>Author</th>
                          <th>Edit</th>
                          <th>Delete</th>
                      </thead>
                      <tbody>
                      <?php
                      $serial_number=$offset+1;
                      while($row = mysqli_fetch_assoc($result)) {
                          ?>
                          <tr>
                              <!-- <td class='id'><?php //echo $row["post_id"];?></td> don't show post id instead of this we will use serial number according to offset -->
                              <!-- <td class='id'><?php //echo $offset;?></td> -->


                              <td class='id'><?php echo $serial_number; ?></td>
                              <td><?php echo $row["title"];?></td>
                              <td><?php echo $row["category_name"];?></td>
                              <td><?php echo $row["post_date"];?></td>
                              <td><?php echo $row["username"];?></td>
                              <td class='edit'><a href='update-post.php?id=<?php echo $row["post_id"];?>'><i class='fa fa-edit'></i></a></td>
                <td class='delete'><a href='delete-post.php?id=<?php echo $row["post_id"];?>&catid=<?php echo $row["category"];?>'><i class='fa fa-trash-o'></i></a></td>
                          </tr>
                          <?php
                          $serial_number++; //for increments
                        } ?>
                      </tbody>
                  </table>

                  <?php }
                //show pagenation codes
                if($_SESSION["user_role"]==1){
                  $sql1="SELECT * FROM post";       //jo user hai usko apni hi post dikhegi
                }elseif($_SESSION["user_role"]==0){
                  $sql1="SELECT * FROM post WHERE post.author={$_SESSION['user_id']}";
                }

                $result1=mysqli_query($conn,$sql1) or die("Query Failed");
                if(mysqli_num_rows($result1) >0 ){
                  $total_records=mysqli_num_rows($result1);
                  //$limit=3;
                  $total_pages= ceil ($total_records / $limit);  //return upper value
                  echo "<ul class='pagination admin-pagination'>";
                  if($page>1){ //1>2
                      echo'<li><a href="post.php?page='.($page - 1). '">Prev</a></li>';
                  }

                  for ($i=1; $i<=$total_pages; $i++) { //means 3 time print buttons
                    //active class code
                    if($i==$page){
                      $active="active";
                    }else{
                      $active="";
                    }
                      echo '<li class="'.$active.'"><a href="post.php?page=' .$i .'">'.$i.'</a></li>';
                  } //for close
                   if($total_pages>$page){ //3>2
                        echo'<li><a href="post.php?page='.($page + 1).'">Next</a></li>';
                   }
                    echo "</ul>";
                }
                ?>
              </div>
          </div>
      </div>
  </div>
<?php include "footer.php"; ?>
