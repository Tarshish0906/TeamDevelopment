<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>利用状況確認リストログイン画面</title>
  <link rel="stylesheet" href="css/style.css">
</head>

<body>
  <form action="staff_login_act.php" method="POST">
    <fieldset>
      <legend>利用状況確認リストログイン画面</legend>
      <table>
        <tr>
          <td>
            名前: <input type="text" name="name">
        </tr>
        </td>
        <tr>
          <td>
            password: <input type="text" name="password">
        </tr>
        </td>
      </table>

      <div>
        <button a href="#" class="btn-square">Login</button>
      </div>
      <div>
        <a href="staff_register.php" class="btn-square">or register</a>
      </div>
    </fieldset>
  </form>

</body>

</html>