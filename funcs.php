<?php
//XSS対応（ echoする場所で使用！それ以外はNG ）
function h($str){ return htmlspecialchars($str, ENT_QUOTES, 'UTF-8'); }

// DB接続
function db_conn(){
  try {
    // 本番は config.php を自動利用（無ければローカル既定で接続）
    if (file_exists(__DIR__ . '/config.php')) {
      require __DIR__ . '/config.php'; // $dsn, $user, $pass を想定
      return new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      ]);
    } else {
      $db_name = "gs_db4";    // ローカル開発DB名
      $db_id   = "root";      // ローカルユーザー
      $db_pw   = "";          // ローカルPW（XAMPPは空）
      $db_host = "localhost"; // ローカルホスト
      return new PDO('mysql:dbname='.$db_name.';charset=utf8mb4;host='.$db_host, $db_id, $db_pw, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      ]);
    }
  } catch (PDOException $e) {
    exit('DB Connection Error:'.$e->getMessage());
  }
}

// SQLエラー
function sql_error($stmt){
  $error = $stmt->errorInfo();
  exit("SQLError:".$error[2]);
}

// リダイレクト
function redirect($file_name){
  header("Location: ".$file_name);
  exit();
}

// SessionCheck
function sschk(){
  if(!isset($_SESSION['chk_ssid']) || $_SESSION['chk_ssid'] != session_id()){
    redirect('login.php'); // 未ログインはログイン画面へ
  }else{
    session_regenerate_id(true);
    $_SESSION['chk_ssid'] = session_id();
  }
}
