<?php

session_start();
require __DIR__ . '/funcs.php';
sschk();                 // ← 認証チェック

$pdo = db_conn();        // DB接続

function h2($v){ return htmlspecialchars($v, ENT_QUOTES, 'UTF-8'); } // 補助

// 初回だけの保険（運用安定後は消してOK）
$pdo->exec("
  CREATE TABLE IF NOT EXISTS responses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(30) NULL,
    book VARCHAR(255) NOT NULL,
    rating TINYINT NOT NULL,
    reason TEXT NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
");

$stmt = $pdo->query('
  SELECT id, name, email, phone, book, rating, reason, created_at
  FROM responses
  ORDER BY created_at DESC, id DESC
');
$rows = $stmt->fetchAll();
?>
<!doctype html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>ブックマーク一覧</title>
</head>
<body>
  <h1>ブックマークアプリ</h1>

  <!-- メニュー（権限別） -->
  <p>
    ようこそ、<?= h2($_SESSION['name']) ?> さん |
    <a href="post.php">ブックマーク登録</a> |
    <a href="bm_list_view.php">ブックマーク表示</a>
    <?php if ((int)$_SESSION['kanri_flg'] === 1): ?>
      | <a href="user_reg.php">ユーザー登録</a>
      | <a href="user_list.php">ユーザー表示</a>
    <?php endif; ?>
      | <a href="logout.php">ログアウト</a>
  </p>

  <?php if (isset($_GET['msg'])):
    $m = $_GET['msg'];
    $msg = $m==='updated' ? '更新しました。' : ($m==='deleted' ? '削除しました。' : ($m==='error' ? '処理に失敗しました。' : ''));
    if ($msg) echo '<p>'.$msg.'</p>';
  endif; ?>

  <?php if (empty($rows)): ?>
    <p>データなし</p>
  <?php else: ?>
    <table border="1" cellpadding="6" cellspacing="0">
      <thead>
        <tr>
          <th>ID</th><th>日時</th><th>名前</th><th>Email</th><th>電話番号</th>
          <th>対象の書籍</th><th>評価</th><th>評価の理由</th><th>操作</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($rows as $r): ?>
          <tr>
            <td><?= (int)$r['id'] ?></td>
            <td><?= h2($r['created_at']) ?></td>
            <td><?= h2($r['name']) ?></td>
            <td><?= h2($r['email']) ?></td>
            <td><?= h2($r['phone']) ?></td>
            <td><?= h2($r['book']) ?></td>
            <td><?= (int)$r['rating'] ?></td>
            <td><?= nl2br(h2($r['reason'])) ?></td>
            <td><a href="bm_update_view.php?id=<?= (int)$r['id'] ?>">編集</a></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</body>
</html>
