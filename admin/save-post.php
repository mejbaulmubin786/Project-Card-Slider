<?php
include "config.php";
//image upload code
if(isset($_FILES['fileToUpload'])){
$errors=array(); //empty array for errors

$file_name=$_FILES['fileToUpload']['name'];
$file_size=$_FILES['fileToUpload']['size'];
$file_tmp=$_FILES['fileToUpload']['tmp_name'];
$file_type=$_FILES['fileToUpload']['type'];
$file_ext=strtolower(end(explode('.',$file_name)));  //dot se bad wali string utayega aur end() jo string ki last value hai wo return krega,,


$extensions=array("jpeg","jpg","png");

//File Restrictions code
 if(in_array($file_ext,$extensions)===false){ //search krega extension
 $errors[]="This extension file is not allowed, Please choose a JPG or PNG file";
 }

//files in bytes so  1kb=1024bytes and 1mb=1024kb so 1024*1024=1048576bytes in 1mb   so 2*1048576==2097152
 if($file_size>2097152){
    $errors[]="File Size Must be 2mb or Lower";
 }

//add time to image for same name problem solve
$new_name=time()."-".basename($file_name);
$target_folder="upload/".$new_name;

//and database and folder different time problm solve
$image_name=$new_name;

 //agr koi erroor ni ata toh file upload ho jayegi
 if(empty($errors)===true){
	 move_uploaded_file($file_tmp,$target_folder);
 }else{
	 print_r($errors);
	 die();
 }
}

session_start();
$title=mysqli_real_escape_string($conn,$_POST['post_title']);
$description=mysqli_real_escape_string($conn,$_POST['postdesc']);
$category=mysqli_real_escape_string($conn,$_POST['category']);
$date=date("d M, Y");
$author= $_SESSION["user_id"];


$sql= "INSERT INTO post (title,description,category,post_date,author,post_img)
VALUES('{$title}','{$description}',{$category},'{$date}',{$author},'{$image_name}');";

//concatinate commmand means category walec table me category counting hoti rahegi jab jab jis category ki post dalegi by default 0 post thi
$sql.="UPDATE category SET post=post+1 WHERE category_id= {$category}";

 if(mysqli_multi_query($conn,$sql)){
 header("Location: {$hostname}/admin/post.php");
 }else{
  echo "<div class='alert alert-danger'>Query Failed</div>";
}

?>
