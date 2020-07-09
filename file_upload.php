<?php

// ファイルが追加されていない or エラー発生の場合を分ける．
// 送信されたファイルは$_FILES['...'];で受け取る！
// コード
if (isset($_FILES['upfile']) && $_FILES['upfile']['error'] == 0) {
  // 送信が正常に行われたときの処理
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
//（↑自分で決める）

// ファイルの拡張子の種類を取得．
// ファイルごとにユニークな名前を作成．（最後に拡張子を追加）
// ファイルの保存場所をファイル名に追加．
// コード
$extension = pathinfo($uploadedFileName, PATHINFO_EXTENSION);
$uniqueName = date('YmdHis').md5(session_id()) . "." . $extension;
$fileNameToSave = $fileDirectoryPath.$uniqueName;
// 最終的に「upload/hogehoge.png」のような形になる

// var_dump($fileNameToSave);
// exit;

$img='';
if (is_uploaded_file($tempPathName)) {
if (move_uploaded_file($tempPathName, $fileNameToSave)) {
chmod($fileNameToSave, 0644); // 権限の変更
$img = '<img src="'. $fileNameToSave . '" >'; // imgタグを設定
} else {
exit('Error:アップロードできませんでした'); // 画像の保存に失敗
}
} else {
exit('Error:画像がありません'); // tmpフォルダにデータがない
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>file_upload</title>
</head>

<body>
  <?= $img ?>
</body>

</html>