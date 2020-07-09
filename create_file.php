<?php
session_start();
include("functions.php");
check_session_id();

$pdo = connect_to_db();

if (
  !isset($_POST['todo']) || $_POST['todo'] == '' ||
  !isset($_POST['deadline']) || $_POST['deadline'] == ''
) {
  // 項目が入力されていない場合はここでエラーを出力し，以降の処理を中止する
  echo json_encode(["error_msg" => "no input"]);
  exit();
}

// 受け取ったデータを変数に入れる
$todo = $_POST['todo'];
$deadline = $_POST['deadline'];


// ここからファイルアップロード&DB登録の処理を追加しよう！！！
// ファイルが追加されていない or エラー発生の場合を分ける．
// 送信されたファイルは$_FILES['...'];で受け取る！
// コード
if (isset($_FILES['upfile']) && $_FILES['upfile']['error'] == 0) {
  // 送信が正常に行われたときの処理

  // var_dump('OK');
  } else {
  // 送られていない，エラーが発生，などの場合
  exit('Error:画像が送信されていません');
  }
  // アップロードしたファイル名を取得．
// 一時保管しているtmpフォルダの場所の取得．
// アップロード先のパスの設定（サンプルではuploadフォルダ←作成！）
// コード
$uploadedFileName = $_FILES['upfile']['name'];//ファイル名の取得
$tempPathName = $_FILES['upfile']['tmp_name']; //tmpフォルダの場所
$fileDirectoryPath = 'upload/'; //アップロード先フォルダ
// （↑自分で決める）
// ファイルの拡張子の種類を取得．
// ファイルごとにユニークな名前を作成．（最後に拡張子を追加）
// ファイルの保存場所をファイル名に追加．
// コード
$extension = pathinfo($uploadedFileName, PATHINFO_EXTENSION);
$uniqueName = date('YmdHis').md5(session_id()) . "." . $extension;
$fileNameToSave = $fileDirectoryPath.$uniqueName;
// 最終的に「upload/hogehoge.png」のような形になる

if (is_uploaded_file($tempPathName)) {
  if (move_uploaded_file($tempPathName, $fileNameToSave)) {
  chmod($fileNameToSave, 0644);

  // INSERT文にimageカラムを追加！
// $sql ='INSERT INTO
// todo_table(id, todo, deadline, image, created_at, updated_at)
// VALUES(NULL, :todo, :deadline, :image, sysdate(), sysdate())';

// $stmt = $pdo ->prepare($sql);
// $stmt->bindValue(':todo', $todo, PDO::PARAM_STR);
// $stmt->bindValue(':deadline', $deadline, PDO::PARAM_STR);
// $stmt->bindValue(':image', $fileNameToSave, PDO::PARAM_STR);
// $status = $stmt -> execute();
// ...実行，エラー処理，etc...

// 一覧画面で画像を表示


  
  } else {
  exit('Error:アップロードできませんでした'); // 画像の保存に失敗
  }
  } else {
  exit('Error:画像がありません'); // tmpフォルダにデータがない
  }
  // 他のデータと一緒にDBへ登録！
// INSERT文にimageカラムを追加！
$sql ='INSERT INTO
todo_table(id, todo, deadline, image, created_at, updated_at)
VALUES(NULL, :todo, :deadline, :image, sysdate(), sysdate())';
// ...
$stmt = $pdo ->prepare($sql);
$stmt->bindValue(':todo', $todo, PDO::PARAM_STR);
$stmt->bindValue(':deadline', $deadline, PDO::PARAM_STR);
$stmt->bindValue(':image', $fileNameToSave, PDO::PARAM_STR);
$status = $stmt -> execute();

var_dump($status);

if($status == false){

  echo 'errorです。';

}else{

  header('location:todo_read.php');
}



// ...実行，エラー処理，etc...



// 一覧画面で画像を表示
