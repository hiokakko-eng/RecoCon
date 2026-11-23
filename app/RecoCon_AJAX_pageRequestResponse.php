<?php require_once __DIR__."/PHP/Security/session_bootstrap.php";   /* session_start含む。 */ ?>
<?php require_once __DIR__.'/PHP/Security/csrf.php'; ?>
<?php require_once __DIR__.'/PHP/htmlspecialchars_as_e()/htmlspecialchars_as_e().php'; ?>
<?php require_once __DIR__.'/PHP/PDO/PDOError_as_echo_e().php'; ?>
<?php require_once __DIR__.'/PHP/LogWriting/function_LogWriting.php'; ?>
<?php 
   if (
      $_SERVER['REQUEST_METHOD'] !== 'POST' ||
      !recoConCsrfValid($_POST['token'] ?? null)  // CSRF対策のトークンとの照合。
   ){
      LogWriting(null, 'CSRFトークンエラー');
      http_response_code(403);
      die('正規画面からご利用下さい。');
   }
?>
<?php 
   require_once __DIR__.'/PHP/PDO/newPDO_as_getDb().php'; 
   $PDO = getDb();  //$PDOにPDOインスタンスが格納されている。
?>
<?php
   try {
      $PDO -> beginTransaction();   //トランザクション処理開始

      $PDOState = $PDO -> prepare('INSERT INTO Request ( r_date, u_id, request, answer ) 
                                               VALUES ( :r_date, :u_id, :request, :answer )');
          //⬆️ prepareでPDOStatementを格納。SQL命令の「:名前」はプレイスホルダー。SQLインジェクション対策になる

      $now = new DateTime();
      $PDOState -> bindValue(':r_date', $now -> format("Y-m-j"));   //⬅️ PDOStatementのbindValueメソッド。
      $PDOState -> bindValue(':u_id', isset($_SESSION['User']['u_id']) ? (int)$_SESSION['User']['u_id'] : 0);   //guestを0。
      $PDOState -> bindValue(':request', rawurldecode($_POST['request']));
      $PDOState -> bindValue(':answer', "abc");

      $PDOState -> execute();   //⬅️ PDOStatementのexecuteメソッドで実行。

      $PDO -> commit();   //トランザクションコミット

      LogWriting($e=(isset($e) ? $e : ""), $msg="重要な操作");

   } catch ( PDOException $e ){
      $PDO -> rollback();   //トランザクションロールバック

      //$error = echo_e($e);
      $e_message[] = 'データを送信できませんでした。';

      LogWriting($e=(isset($e) ? $e : ""), $msg="重要な操作");
   }
?>
<?php header("Content-Type: text/html;charset=UTF-8"); ?>


<main id="main">

   <h2 id="MClub_title" class="title_white color_perple">ご感想・ご要望</h2>
   <h2 id="MClub_message" class="title_glay color_perple">
      <?= isset($e_message) ? 'エラーが発生しました。' : 'ご投稿を受け付けました。'; ?>
   </h2>

   <div class="space_white">

      <div class="space_11px"></div>

      <p class="p_center">

         <?php 
            if (isset($e_message)){
               $i=0;
               while ($i < count($e_message)){ 
                  print $e_message[$i].'<br>';
                  $i++;
               }
               print $e_message[$i];
            } else {
               print 'ご感想・ご要望を受け付けました。<br>ご投稿ありがとうございました。<br>今後ともReco.Con.をご愛顧下さいませ。<br><br>Reco.Con.スタッフ一同';
            }
         ?>

      </p>

      <div class="space_22px"></div>
 
   </div>

   <div class="backMark">
      <a id="toTop" class="toTop" href="RecoCon_TOP_XAMPP.php"><img src="SVG/back.svg" alt="back"></a>
   </div>

</main>







