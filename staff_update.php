<?php

session_start();
// DB接続の設定
// DB名は`gsacf_x00_00`にする
// 関数ファイルの読み込み
include('functions.php');
check_session_id();

// 送信データのチェック

// 送信されたidをgetで受け取る
$id = $_GET['id'];
// $Felica_id = $_POST['Felica_id'];
// var_dump($_GET['id']);
// exit();


// DB接続
$pdo = connect_to_db();


// UPDATE文を作成&実行
$sql = 'SELECT * FROM users_table WHERE id=:id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

// var_dump($status);

// fetch()で1レコード取得できる．
if ($status == false) {
    $error = $stmt->errorInfo();
    echo json_encode(["error_msg" => "{$error[2]}"]);
    exit();
} else {
    $record = $stmt->fetch(PDO::FETCH_ASSOC);
}

// var_dump($record)

?>


<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IDカードユーザアップデート画面</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <form action="staff_update_act.php" method="POST">
        <fieldset>
            <legend>IDカードユーザアップデート画面</legend>
            <div>
                FelicaID: <input type="text" name="felica_id" value="<?= $record["felica_id"] ?>">
                <!-- <button>CARD読取</button> -->
                <button a href="#" class="btn-square">CARD読取</button>
            </div>
            <div>
                名前: <input type="text" name="name" value="<?= $record["name"] ?>">
            </div>
            <div>
                password: <input type=" password" name="password" value="<?= $record["password"] ?>">
                <p>※12文字以内</p>
            </div>
            <div>
                status: <input type=" text" name="status" value="<?= $record["status"] ?>">
            </div>
            <div>
                is_admin: <input type=" text" name="is_admin" value="<?= $record["is_admin"] ?>">
            </div>
            <div>
                is_deleted: <input type=" text" name="is_deleted" value="<?= $record["is_deleted"] ?>">
            </div>

            <div>
                <!-- <button>Update</button> -->
                <button a href="#" class="btn-square">Update</button>
            </div>
            <a href=" staff_login.php" class="btn-square">or login</a>
        </fieldset>

        <input type="hidden" name="id" value="<?= $record['id'] ?>">

    </form>

</body>

</html>