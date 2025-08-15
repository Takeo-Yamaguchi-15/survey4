<?php

session_start();
require __DIR__ . '/funcs.php';
sschk();
if ((int)$_SESSION['kanri_flg'] !== 1) { redirect('bm_list_view.php?msg=error'); }

$name = trim($_POST['name'] ?? '');
$lid  = trim($_POST['lid']  ?? '');
$lpw  = $_POST['lpw'] ?? '';
$kan  = filter_input(INPUT_POST,'kanri_flg', FILTER_VALIDATE_INT);
$life = filter_input(INPUT_POST,'life_flg', FILTER_VALIDATE_INT);

if ($name==='' || $lid==='' || $lpw==='' || $kan===null || $life===null) {
  redirect('user_reg.php'); // 簡易バリデーション
}

$hash = password_hash($lpw, PASSWORD_DEFAULT);

try{
  $pdo = db_conn();
  $sql = 'INSERT INTO gs_user_table(name,lid,lpw,kanri_flg,life_flg) VALUES(?,?,?,?,?)';
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$name,$lid,$hash,(int)$kan,(int)$life]);
  redirect('user_list.php');
}catch(PDOException $e){
  sql_error($stmt);
}
