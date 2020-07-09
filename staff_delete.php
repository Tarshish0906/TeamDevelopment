<?php
session_start();
include("functions.php");
check_session_id();

// ユーザ名取得
$user_id = $_SESSION['id'];

// DB接続
$pdo = connect_to_db();


// いいね数カウント


// データ取得SQL作成
$sql =

  'SELECT inout_table.id, users_table.name, inout_table.in_time, inout_table.out_time FROM inout_table LEFT OUTER JOIN users_table ON users_table.id = inout_table.user_id ORDER BY in_time DESC';

// SQL準備&実行
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

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
    $output .= "<td>{$record["name"]}</td>";
    $output .= "<td>{$record["in_time"]}</td>";
    $output .= "<td>{$record["out_time"]}</td>";
    // edit deleteリンクを追加
    // $output .= "<a href='like_create.php?user_id={$user_id}&todo_id={$record["id"]}'>like{$record["cnt"]}</a>";
    $output .= "<td><a href='staff_delete_act.php?id={$record["id"]}'>delete</a></td>";
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
  <title>タイムカード記録（一覧画面）</title>
</head>

<body class="m-5">
  <fieldset>
    <legend>タイムカード記録（一覧画面）</legend>
    <a href="staff_read.php">戻る</a>
    <a href="staff_logout.php">logout</a>
    <table class="table">
      <thead>
        <tr>
          <th>id</th>
          <th>名前</th>
          <th>入場時間</th>
          <th>退場時間</th>
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