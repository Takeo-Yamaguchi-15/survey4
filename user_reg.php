<?php
// user_reg.php
session_start();
require __DIR__ . '/funcs.php';
sschk();
if ((int)$_SESSION['kanri_flg'] !== 1) { exit('NO PERMISSION'); }

?>
<!doctype html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>ユーザー登録</title>
</head>
<body>
  <h1>ユーザー登録</h1>
  <p>
    <a href="post.php">ブックマーク登録</a> |
    <a href="bm_list_view.php">ブックマーク表示</a> |
    <a href="user_reg.php">ユーザー登録</a> |
    <a href="user_list.php">ユーザー表示</a> |
    <a href="logout.php">ログアウト</a>
  </p>

  <form action="user_insert.php" method="post" accept-charset="UTF-8">
    <p><label>名前<br><input type="text" name="name" required></label></p>
    <p><label>ログインID（lid）<br><input type="text" name="lid" required></label></p>
    <p><label>パスワード<br><input type="password" name="lpw" required></label></p>
    <p>
      <label>権限（kanri_flg）<br>
        <select name="kanri_flg" required>
          <option value="0">一般</option>
          <option value="1">管理</option>
        </select>
      </label>
    </p>
    <p>
      <label>ステータス（life_flg）<br>
        <select name="life_flg" required>
          <option value="1">有効</option>
          <option value="0">無効</option>
        </select>
      </label>
    </p>
    <p><button type="submit">登録</button>　<a href="bm_list_view.php">戻る</a></p>
  </form>
</body>
</html>
