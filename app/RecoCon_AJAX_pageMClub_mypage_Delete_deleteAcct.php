<?php require_once __DIR__."/PHP/Security/session_bootstrap.php";   /* session_start含む。 */ ?>
<?php require_once __DIR__.'/PHP/htmlspecialchars_as_e()/htmlspecialchars_as_e().php'; ?>
<?php require_once __DIR__.'/PHP/LogWriting/function_LogWriting.php'; ?>
<?php require_once __DIR__.'/PHP/PDO/PDOError_as_echo_e().php'; ?>
<?php require_once __DIR__.'/PHP/Security/csrf.php'; ?>
<?php  // リクエストの検証。DBを操作する前に判定する。
   if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST'){
      header('Allow: POST');
      http_response_code(405);
      exit('POSTで送信してください。');
   }
   if (empty($_SESSION['User']['u_id']) || empty($_SESSION['User']['u_input_id'])){
      http_response_code(401);
      exit('ログインし直してください。');
   }
   if (!recoConCsrfValid($_POST['token'] ?? null)){
      http_response_code(403);
      exit('正規画面からご利用ください。');
   }
?>
<?php require_once __DIR__.'/PHP/PDO/newPDO_as_getDb().php'; ?>
<?php
   //認証済み本人のアカウントのみ削除する。POST中のIDは信用しない。
   $PDO = null;
   try {
      $PDO = getDb();  //$PDOにPDOインスタンスが格納されている。
      $PDO -> beginTransaction();   //トランザクション処理開始

      $PDOState = $PDO -> prepare('DELETE FROM User WHERE u_id=:u_id');
          //⬆️ prepareでPDOStatementを格納。SQL命令の「:名前」はプレイスホルダー。

      $PDOState -> bindValue(':u_id', (int)$_SESSION['User']['u_id'], PDO::PARAM_INT);
      $PDOState -> execute();

      if ($PDOState -> rowCount() !== 1){
         throw new RuntimeException('Account deletion did not affect exactly one row.');
      }

      $PDO -> commit();   //トランザクションコミット

      //DBの削除に成功した場合だけ、セッションとCookieを破棄する。
      $_SESSION = [];
      if (ini_get('session.use_cookies')){
         $params = session_get_cookie_params();
         setcookie(session_name(), '', [
            'expires'  => time() - 42000,
            'path'     => $params['path'],
            'domain'   => $params['domain'],
            'secure'   => $params['secure'],
            'httponly' => $params['httponly'],
            'samesite' => $params['samesite'] ?: 'Lax',
         ]);
      }
      session_destroy();
      //旧LogWritingは書込失敗でdieするため、削除完了後はPHPのエラーログへ。
      error_log('RecoCon: account deleted');

   } catch (Throwable $e){

      if ($PDO instanceof PDO && $PDO -> inTransaction()){
         $PDO -> rollBack();   //トランザクションロールバック
      }
      http_response_code(500);
      $e_message[] = 'アカウント情報を削除できませんでした。再度退会処理を行ってください。';
      error_log('RecoCon: account deletion failed (' . get_class($e) . ')');
   }
?>
<?php header("Content-Type: text/html;charset=UTF-8"); ?>


<!-- ヘッダー -->

   <div id="header">

      <a href="RecoCon_TOP_XAMPP.php">
         <img src="SVG/RecoCon_logo.svg" alt="RecoCon_logo">
      </a>

      <div>
         <div> <!--ログインの状態によってログマークを変える-->
            <img id="<?= isset($_SESSION['User']) ? 'LoginMark' : 'LogoutMark'; ?>"
                src="<?= isset($_SESSION['User']) ? 'SVG/log_person.svg' : 'SVG/Login_mark.svg'; ?>" 
                alt="<?= isset($_SESSION['User']) ? 'Login-mark' : 'Logout-mark'; ?>"
            >
         </div>

         <div>
            <img id="menu" src="SVG/menu.svg" alt="menu">
         </div>
      </div>

   </div>


<!-- メニュー -->

   <nav id="navi">

      <div id="navi_Top" class="navi"> トップページ </div>
      <div id="navi_RecoConInfo" class="navi"> Reco.Con.について </div>
      <div id="navi_News" class="navi"> お知らせ </div>
      <div id="navi_buyTicket" class="navi"> 予約券・当日券の購入 </div>
      <div id="navi_Access" class="navi"> アクセス </div>
      <div id="navi_MClub" class="navi"> 
         <?= isset($_SESSION['User']) ? 'Reco.Con.メンバーズクラブ マイページ' : 'Reco.Con.メンバーズクラブ'; ?>
      </div>
      <div id="navi_Request" class="navi"> ご感想・ご要望 </div>

      <div id="navi_arrow">
         <a id="toTop" href="RecoCon_TOP_XAMPP.php"><img src="SVG/back.svg" alt="back"></a>
      </div>

   </nav>


<!-- メイン（ヘッダー以外すべてくるむ） -->

   <main id="main">

      <h2 id="MClub_title" class="title_white color_perple">Reco.Con.メンバーズクラブ</h2>
      <h2 id="MClub_message" class="title_glay color_pink">
         <?= isset($e_message) ? 'エラーが発生しました。' : '退会しました。'; ?>
      </h2>

      <div class="space_white">

         <div class="space_11px"></div>

         <p class="p_center">

         <?php 
            if (isset($e_message)){
               $i=0;
               while ($i < count($e_message)){ 
                  print e($e_message[$i]).'<br>';
                  $i++;
               }
            } else {
               print 'Reco.Con.のご利用ありがとうございました。<br><br>Reco.Con.スタッフ一同';
            }
         ?>

         </p>

         <div class="space_22px"></div>

      </div>

      <div class="backMark">
         <a id="toTop" class="toTop" href="RecoCon_TOP_XAMPP.php"><img src="SVG/back.svg" alt="back"></a>
      </div>
 
   </main>

