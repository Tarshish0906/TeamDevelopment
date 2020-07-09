<?php



// ...関数ファイル読み込み処理を記述（認証関連は省略でOK）
include("functions.php");
// ...DB接続の処理を記述
$pdo = connect_to_db();

$search_word = $_GET["searchWord"];// GETのデータ受け取り
var_dump($search_word);
exit;
$sql = "SELECT * FROM todo_table WHERE todo LIKE '%{$search_Word}%'";
// ...SQL実行の処理を記述
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

if ($status == false) {
// ...エラー処理を記述
echo "エラーでっす";
} else {
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($result); // JSON形式にして出力
exit();
}