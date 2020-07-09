<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/style.css">
  <title>IDカードユーザ登録画面</title>
</head>

<body>
  <form action="staff_register_act.php" method="POST">
    <fieldset>
      <legend>IDカードユーザ登録画面</legend>
      <div>
        FelicaID: <input type="text" name="felica_id">
        <!-- <button>CARD読取</button> -->
        <button a href="#" class="btn-square">CARD読取</button>
      </div>
      <div>
        名前: <input type="text" name="name">
      </div>
      <div>
        password: <input type="password" name="password">
        <p>※12文字以内</p>
      </div>
      <div>
        status: <input type="text" name="status">
      </div>
      <div>
        is_admin: <input type="text" name="is_admin">
      </div>
      <div>
        is_deleted: <input type="text" name="is_deleted">
      </div>

      <div>
        <!-- <button>Register</button> -->
        <button a href="#" class="btn-square">Register</button>
      </div>
      <a href="staff_login.php" class="btn-square">or login</a>
    </fieldset>
  </form>

</body>

</html>