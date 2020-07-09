<?php
session_start();
include("functions.php");
check_session_id();

// ユーザ名取得
$user_id = $_SESSION['id'];

// DB接続
$pdo = connect_to_db();

// var_dump("ログイン成功！");


// データ取得SQL作成
$sql = "SELECT *  FROM users_table
      --  LEFT OUTER JOIN (SELECT todo_id, COUNT(id) AS cnt FROM inout_table GROUP wBY todo_id) AS likes ON todo_table.id = likes.todo_id
      where is_deleted = 0 ";
// "SELECT * FROM tablea LEFT OUTER JOIN tableb ON tablea.id = tableb.id";
// SQL準備&実行
$stmt = $pdo->prepare($sql);
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
  // fetchAll()関数でSQLで取得したレコードを配列で取得できる
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);  // データの出力用変数（初期値は空文字）を設定
  $output = "";
  // <tr><td>deadline</td><td>todo</td><tr>の形になるようにforeachで順番に$outputへデータを追加
  // `.=`は後ろに文字列を追加する，の意味
  foreach ($result as $record) {
    $output .= "<tr>";
    $output .= "<td>{$record["id"]}</td>";
    $output .= "<td>{$record["felica_id"]}</td>";

    $output .= "<td><a href='staff_update.php?id={$record["id"]}'>{$record["name"]}</a></td>";

    $output .= "<td>{$record["status"]}</td>";
    $output .= "<td>{$record["is_admin"]}</td>";
    $output .= "<td>{$record["is_deleted"]}</td>";
    $output .= "<td>{$record["created_at"]}</td>";
    $output .= "<td>{$record["updated_at"]}</td>";

    $output .= "<td><a href='staff_delete.php?id={$record["id"]}'>タイムカード</a></td>";



    // $output .= "<td><a href='like_create.php?user_id={$user_id}&todo_id={$record["id"]}'>like{$record["cnt"]}</a></td>";
    // $output .= "<td><a href='todo_edit.php?id={$record["id"]}'>edit</a></td>";
    // $output .= "<td><a href='todo_delete.php?id={$record["id"]}'>delete</a></td>";
    // 画像出力を追加しよう
    // $output .= "<td><img src='{$record["image"]}' height=150px></td>";
    $output .= "</tr>";
  }
  // $valueの参照を解除する．解除しないと，再度foreachした場合に最初からループしない
  // 今回は以降foreachしないので影響なし
  unset($value);
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <title>継続会員一覧</title>
</head>

<body class="m-5">
  <fieldset>
    <legend>継続会員一覧</legend>
    <a href="staff_deletedmember.php" class="btn btn-primary">退会者一覧</a>
    <a href="staff_logout.php" class="btn btn-primary">logout</a>
    <table class="table">
      <thead>
        <tr>

          <th>会員番号</th>
          <th>FelicaID</th>
          <th>名前</th>
          <th>利用状況</th>
          <th>管理者</th>
          <th>退会状況</th>
          <th>会員登録日</th>
          <th>更新日</th>
          <th>利用履歴</th>


        </tr>
      </thead>
      <tbody>
        <!-- ここに<tr><td>deadline</td><td>todo</td><tr>の形でデータが入る -->
        <?= $output ?>
      </tbody>
    </table>
  </fieldset>
</body>

</html>