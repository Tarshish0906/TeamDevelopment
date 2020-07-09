<?php

// 送信データのチェック
// var_dump($_POST);
// exit();

// 関数ファイルの読み込み
session_start();
include("functions.php");
check_session_id();

// 送信データ受け取り
$id = $_POST["id"];
$felica_id = $_POST["felica_id"];
$name = $_POST["name"];
$password = $_POST["password"];
$status = $_POST["status"];
$is_admin = $_POST["is_admin"];
$is_deleted = $_POST["is_deleted"];

// DB接続
$pdo = connect_to_db();
// var_dump($id);
// exit();

// UPDATE文を作成&実行
$sql = "UPDATE users_table SET felica_id=:felica_id, name=:name, password=:password, status=:status, is_admin=:is_admin, is_deleted=:is_deleted, updated_at=sysdate() WHERE id=:id";

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$stmt->bindValue(':felica_id', $felica_id, PDO::PARAM_STR);
$stmt->bindValue(':name', $name, PDO::PARAM_STR);
$stmt->bindValue(':password', $password, PDO::PARAM_STR);
$stmt->bindValue(':status', $status, PDO::PARAM_INT);
$stmt->bindValue(':is_admin', $is_admin, PDO::PARAM_INT);
$stmt->bindValue(':is_deleted', $is_deleted, PDO::PARAM_INT);
$status = $stmt->execute();

// データ登録処理後
if ($status == false) {
  // SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
  exit();
} else {
  // 正常にSQLが実行された場合は一覧ページファイルに移動し，一覧ページの処理を実行する
  header("Location:staff_read.php");
  exit();
}
