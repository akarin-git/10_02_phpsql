<?php

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


$sql = 'SELECT * FROM post_table';

$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

if ($status == false) {
  $error = $stmt->errorInfo();
  exit('sqlError:' . $error[2]);
} else {
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

  $output = "";
  foreach ($result as $record) {
    // var_dump($record);
    // exit();
    $output .= "<li>";
    $output .= "<p>{$record["name"]}<p>";
    $output .= "<div>";
    $output .= "<img src='images/" . $record["image"] . "'}>";
    $output .= "</div>";
    $output .= "<p>{$record["text"]}<p>";
    $output .= "<p>{$record["created_at"]}</p>";
    $output .= "</li>";
  }
}

?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>

  <div class="input_form">
    <form action="create.php" method="post" enctype="multipart/form-data">
      <input type="hidden" name="size" value="1000000">

      <div class="input">
        <ul>

          <li>
            title: <input type="text" name="name">
          </li>
          <li>
            text: <textarea type="text" rows="5" cols="35" name="text" placeholder="説明を書いてください"></textarea>
          </li>
          <li>

            <input type="file" name="image">
          </li>
          <li>
            <input type="submit" name="upload" value="送信">
          </li>
        </ul>
      </div>
    </form>
  </div>


  <section class="container">

    <div class="output_box">
      <div class="output">
        <?= $output ?>
      </div>
    </div>

  </section>


</body>

</html>