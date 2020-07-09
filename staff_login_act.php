<?php
// var_dump($_POST);
// exit();
session_start();

// 外部ファイル読み込み
include("functions.php");

// var_dump($_POST);

// DB接続します
$pdo = connect_to_db();

$name = $_POST["name"];
$password = $_POST["password"];

// var_dump($name);
// var_dump($password);
// exit;

// データ取得SQL作成&実行
$sql = 'SELECT * FROM users_table WHERE name = :name AND password=:password AND is_deleted=0';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':name', $name, PDO::PARAM_STR);
$stmt->bindValue(':password', $password, PDO::PARAM_STR);
$status = $stmt->execute();

// var_dump($status);

// SQL実行時にエラーがある場合
if ($status == false) {
  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
  exit();
}

// うまくいったらデータ（1レコード）を取得
$val = $stmt->fetch(PDO::FETCH_ASSOC);

// var_dump($val);

// ユーザ情報が取得できない場合はメッセージを表示
if (!$val) {
  // echo "<p>ログイン情報に誤りがあります．</p>";
  // echo '<a href="staff_login.php">login</a>';
  header("Location:staff_login_error.php");
  exit();
} else {
  $_SESSION = array();
  $_SESSION["session_id"] = session_id();
  $_SESSION["is_admin"] = $val["is_admin"];
  $_SESSION["user_id"] = $val["user_id"];
  $_SESSION["id"] = $val["id"];
  header("Location:staff_read.php");
  exit();
}
