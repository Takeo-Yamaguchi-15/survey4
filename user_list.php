<?php
// user_list.php
session_start();
require __DIR__ . '/funcs.php';
sschk();
if ((int)$_SESSION['kanri_flg'] !== 1) { exit('NO PERMISSION'); }

$pdo = db_conn();
$stmt = $pdo->query('SELECT id,name,lid,kanri_flg,life_flg FROM gs_user_table ORDER BY id DESC');
$rows = $stmt->fetchAll();
?>
<!doctype html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>ユーザー一覧</title>
</head>
<body>
  <h1>ユーザー一覧</h1>
  <p>
    <a href="post.php">ブックマーク登録</a> |
    <a href="bm_list_view.php">ブックマーク表示</a> |
    <a href="user_reg.php">ユーザー登録</a> |
    <a href="user_list.php">ユーザー表示</a> |
    <a href="logout.php">ログアウト</a>
  </p>

  <?php if (!$rows): ?>
    <p>ユーザーなし</p>
  <?php else: ?>
    <table border="1" cellpadding="6" cellspacing="0">
      <thead><tr>
        <th>ID</th><th>名前</th><th>lid</th><th>kanri_flg</th><th>life_flg</th>
      </tr></thead>
      <tbody>
        <?php foreach($rows as $r): ?>
          <tr>
            <td><?= (int)$r['id'] ?></td>
            <td><?= h($r['name']) ?></td>
            <td><?= h($r['lid']) ?></td>
            <td><?= (int)$r['kanri_flg'] ?></td>
            <td><?= (int)$r['life_flg'] ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</body>
</html>
