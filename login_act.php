<?php
//最初にSESSIONを開始！！ココ大事！！
session_start();

//POST値
$lid = $_POST["lid"]; //lid
$lpw = $_POST["lpw"]; //lpw

//1.  DB接続します
include("funcs.php");
$pdo = db_conn();

//2. データ登録SQL作成
//* PasswordがHash化→条件はlidのみ！！
$stmt = $pdo->prepare("SELECT * FROM gs_user_table WHERE lid=:lid AND life_flg=1");
$stmt->bindValue(':lid', $lid, PDO::PARAM_STR);
$status = $stmt->execute();

//3. SQL実行時にエラーがある場合STOP
if($status==false){ sql_error($stmt); }

//4. 抽出データ数を取得（1レコード想定）
$val = $stmt->fetch();

//5. パスワード照合（ハッシュ検証）
if($val && password_verify($lpw, $val["lpw"])){
  //Login成功時
  $_SESSION["chk_ssid"]  = session_id();
  $_SESSION["kanri_flg"] = (int)$val['kanri_flg']; // 0/1
  $_SESSION["name"]      = $val['name'];
  $_SESSION["lid"]       = $val['lid'];

  // ブックマーク一覧へ
  redirect("bm_list_view.php");
}else{
  //Login失敗時(login.phpへ)
  redirect("login.php");
}
exit();
