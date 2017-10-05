<?php
//1.GETでidを取得
$id = $_GET["id"];

//2.DB接続など
try {
  $pdo = new PDO('mysql:dbname=gs_db16;charset=utf8;host=localhost','root','');
} catch (PDOException $e) {
  exit('データベースに接続できませんでした。'.$e->getMessage());
}

//3．データ受取り
$stmt = $pdo->prepare("SELECT * FROM gs_user_table WHERE id=:id");
$stmt->bindValue(':id', $id);
$status = $stmt->execute();

//4．データ表示
$view="";
if($status==false){
  //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);
}else{
  //Selectデータの数だけ自動でループしてくれる
  $row = $stmt->fetch(); //$row["name"]
}

//5．ラジオボタンの選択
$kanri_flg = 0;
$life_flg = 0;
$checked0 = 0;
$checked1 = 0;
$checked2 = 0;
$checked3 = 0;

switch($row["kanri_flg"]){
case 0:
    $checked0 = "checked";
    break;
case 1:
    $checked1 = "checked";
}

switch($row["life_flg"]){
case 0:
    $checked2 = "checked";
    break;
case 1:
    $checked3 = "checked";
}

?>


<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>POSTデータ更新</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <style>div{padding: 10px;font-size:16px;}</style>
</head>
<body>

<!-- Head[Start] -->
<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
    <div class="navbar-header"><a class="navbar-brand" href="select.php">データ一覧</a></div>
  </nav>
</header>
<!-- Head[End] -->

<!-- Main[Start] -->
<form method="post" action="update.php">
  <div class="jumbotron">
 <fieldset>
    <legend>ユーザー登録</legend>
     <label>名前：<input type="text" name="name" value="<?=$row["name"]?>"></label><br>
     <label>ログインID：<input type="text" name="lid" value="<?=$row["lid"]?>"></label><br>
     <label>ログインPW：<input type="password" name="lpw" value="<?=$row["lpw"]?>"></label><br>
     <label>
         <input type="radio" name="kanri_flg" value="0" <?=$checked0?>>管理者
         <input type="radio" name="kanri_flg" value="1" <?=$checked1?>>スーパー管理者
     </label><br>
     <label>
         <input type="radio" name="life_flg" value="0" <?=$checked2?>>使用する
         <input type="radio" name="life_flg" value="1" <?=$checked3?>>使用しない
     </label><br>
     <input type="hidden" name="id" value="<?=$row["id"]?>">
     <input type="submit" value="更新">
    </fieldset>
  </div>
</form>
<!-- Main[End] -->


</body>
</html>






