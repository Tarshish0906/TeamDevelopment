<?php

// var_dump($_POST);
// exit();

// 関数ファイル読み込み
include('functions.php');


// データ受け取り
$felica_id = $_POST["felica_id"];
$name = $_POST["name"];
$password = $_POST["password"];
$status = $_POST["status"];
$is_admin = $_POST["is_admin"];
$is_deleted = $_POST["is_deleted"];

// var_dump($felica_id);
// var_dump($name);
// var_dump($password);

// exit();

// DB接続関数
$pdo = connect_to_db();

// ユーザ存在有無確認
$sql = 'SELECT COUNT(*) FROM users_table WHERE felica_id = :felica_id ';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':felica_id', $felica_id, PDO::PARAM_STR);
$status = $stmt->execute();

// var_dump($status);
// exit;

if ($status == false) {
  // SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
  exit();
}

if ($stmt->fetchColumn() > 0) {
  // user_idが1件以上該当した場合はエラーを表示して元のページに戻る
  // $count = $stmt->fetchColumn();
  echo "<p>すでに登録されているユーザです．</p>";
  echo '<a href="staff_login.php">login</a>';
  exit();
}

// ユーザ登録SQL作成
// `created_at`と`updated_at`には実行時の`sysdate()`関数を用いて実行時の日時を入力する
$sql = 'INSERT users_table(id, felica_id, name, password, status, is_admin, is_deleted, created_at, updated_at) 
      VALUES(NULL, :felica_id, :name, :password, 0, 0, 0, sysdate(), sysdate())';

// SQL準備&実行
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':felica_id', $felica_id, PDO::PARAM_STR);
$stmt->bindValue(':name', $name, PDO::PARAM_STR);
$stmt->bindValue(':password', $password, PDO::PARAM_STR);
$status = $stmt->execute();

// var_dump($status);
// exit;

// データ登録処理後
if ($status == false) {
  // SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
  exit();
} else {
  // 正常にSQLが実行された場合は入力ページファイルに移動し，入力ページの処理を実行する
  header("Location:staff_login.php");
  exit();
}
