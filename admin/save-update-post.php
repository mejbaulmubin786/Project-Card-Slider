<?php
include "config.php";

if(empty($_FILES['new-image']['name'])){ //agr user image upload nhi krega means agr superglobal variable files me   name key empty hai
  $file_name=$_POST['old-image'];
 
}else{ 
  $old_image= $_POST['old-image'];   //agr user image upload krega toh
  unlink("upload/".$old_image);     //delete image from folder

$errors=array(); //empty array for errors

$file_name=$_FILES['new-image']['name'];
$file_size=$_FILES['new-image']['size'];
$file_tmp=$_FILES['new-image']['tmp_name'];
$file_type=$_FILES['new-image']['type'];

$tmp= explode('.', $file_name);
$file_ext = end($tmp); //dot se bad wali string utayega aur end() jo string ki last value hai wo return krega,


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
     $target_folder="upload/".$new_name;
   
 }else{
  print_r($errors);
  echo "file could not be uploaded";
  die();
 }
}

$sql="UPDATE post SET title='{$_POST['post_title']}',description='{$_POST['postdesc']}',category={$_POST['category']},post_img ='{$image_name}' WHERE post_id = {$_POST['post_id']};";
// echo $sql; //testing

//agr user category chage krta hai toh ye if condition chal jayegi jo check kregi old_category not equal to new category toh nhi hai
//old category me 1 minus ho jayega aur new category me 1 add ho jayega
if($_POST['old_category'] != $_POST['category']){
  $sql.="UPDATE category SET post=post-1 WHERE category_id={$_POST['old_category']};";
  $sql.="UPDATE category SET post=post+1 WHERE category_id={$_POST['category']};";
}

$result=mysqli_multi_query($conn,$sql);

if($result){ //if query success
	header("Location: {$hostname}/admin/post.php");
}else{
echo "Query Failed";
}
?>
