<?php

$msg ="";

if(
  !isset($_POST['name'])||$_POST['name']==""||
  !isset($_POST['text'])||$_POST['text']==""||
  !isset($_POST['image'])||$_POST['image']==""

){
  // exit('入力してください');
  
}

// var_dump($_POST['name']);
// exit();
if (isset($_POST['upload'])){
  
  $image = $_FILES['image']['name'];
  $name = $_POST['name'];
  $text = $_POST['text'];
  $date = $_POST['created_at'];
  $target = "images/".basename($_FILES['image']['name']);
  
$dbn = 'mysql:dbname=gsacf_l0_02;charset=utf8;
port=3306;host=localhost';
$user = 'root';
$pwd = '';

try {
  $pdo = new PDO($dbn, $user, $pwd);
} catch (PDOException $e) {
  echo json_encode(["db error" => "{$e->getMessage()}"]);
  exit();
}
// exit('ok');

$sql = 'INSERT INTO post_table(id, name, text, image,created_at) VALUES (NULL,:name,:text,:image,sysdate())';


if(move_uploaded_file($_FILES['image']['tmp_name'],$target)){
 $msg = "Image uploaded successfully";
} else {
  $msg = "There was a problem ";
}

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':name',$name,PDO::PARAM_STR);
$stmt->bindValue(':text',$text,PDO::PARAM_STR);
$stmt->bindValue(':image',$image,PDO::PARAM_STR);

$status = $stmt->execute();

if($status==false){
$error = $stmt->errorInfo();
exit('sqlError:'.$error[2]);
} else{
header('Location:index.php');
}
exit();
}


?>