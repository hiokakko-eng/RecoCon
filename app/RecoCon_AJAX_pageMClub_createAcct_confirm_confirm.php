<?php require_once __DIR__."/PHP/Security/session_bootstrap.php";   /* session_start含む。 */ ?>
<?php header("Content-Type: text/html;charset=UTF-8"); ?>
<?php require_once __DIR__.'/PHP/Security/csrf.php'; ?>
<?php require_once __DIR__.'/PHP/htmlspecialchars_as_e()/htmlspecialchars_as_e().php'; ?>
<?php require_once __DIR__.'/PHP/LogWriting/function_LogWriting.php'; ?>
<?php require_once __DIR__.'/PHP/PDO/PDOError_as_echo_e().php'; ?>
<?php require_once __DIR__.'/PHP/Class_sendMail/function_sendRecoconMail.php'; ?>
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
   //フラグ
   $accountCreated = false;
   $mailSent = false;

   if ($_SESSION['Create_Acct'][0]['Button'] == 'OK'){
      //DB書き込み。
      try {
         $PDO -> beginTransaction();   //トランザクション処理開始

         $PDOState = $PDO -> prepare(
            'INSERT INTO User ( 
                 u_name, 
                 u_age, 
                 u_sex, 
                 u_address_1, 
                 u_address_2, 
                 u_address_3, 
                 u_tel, 
                 u_mail, 
                 u_input_id, 
                 u_input_pass
             ) 
             VALUES ( 
                 :u_name, 
                 :u_age, 
                 :u_sex, 
                 :u_address_1, 
                 :u_address_2, 
                 :u_address_3, 
                 :u_tel, 
                 :u_mail, 
                 :u_input_id, 
                 :u_input_pass
             )'
         );
         //prepareでPDOStatementを格納。SQL命令の「:名前」はプレイスホルダー。SQLインジェクション対策になる

         $PDOState -> bindValue(':u_name', $_SESSION['Create_Acct']['Name']);  //PDOStatementのbindValueメソッド。
         $PDOState -> bindValue(':u_age', (int)$_SESSION['Create_Acct']['Age']);
         $PDOState -> bindValue(':u_sex', $_SESSION['Create_Acct']['Sex']);
         $PDOState -> bindValue(':u_address_1', $_SESSION['Create_Acct']['Address1']);
         $PDOState -> bindValue(':u_address_2', $_SESSION['Create_Acct']['Address2']);
         $PDOState -> bindValue(':u_address_3', $_SESSION['Create_Acct']['Address3']);
         $PDOState -> bindValue(':u_tel', $_SESSION['Create_Acct']['Tel']);
         $PDOState -> bindValue(':u_mail', $_SESSION['Create_Acct']['Mail']);
         $PDOState -> bindValue(':u_input_id', $_SESSION['Create_Acct']['U_Input_Id']);
         $PDOState -> bindValue(':u_input_pass', password_hash($_SESSION['Create_Acct']['Pass'], PASSWORD_ARGON2ID));

         $PDOState -> execute();   //⬅️ PDOStatementのexecuteメソッドで実行。

         //今作成した会員のIDを取得。
         $newUserId = (int)$PDO -> lastInsertId();

         $PDO -> commit();   //トランザクションコミット

         $accountCreated = true;

         LogWriting($e=(isset($e) ? $e : ""), $msg="アカウント登録");

      } catch ( PDOException $e ){
         $PDO -> rollback();   //トランザクションロールバック

         //$error = echo_e($e);
         $e_message[] = 'データを登録できませんでした。';

         LogWriting($e=(isset($e) ? $e : ""), $msg="アカウント登録");
      }
   } else {
      $e_message[] = '入力データが正しくありません。';
      LogWriting($e=(isset($e) ? $e : ""), $msg="アカウント登録");
   }
?>
<?php
   //上記で新規アカウント情報の書き込みが完了したらログイン操作をする。
   if (empty($e_message)){
      try {
         //作成した会員の情報だけを取得する。
         $PDOState = $PDO -> prepare(
            'SELECT u_id, u_name, u_age, u_sex, u_input_id,
                    u_address_1, u_address_2, u_address_3,
                    u_tel, u_mail
             FROM User
             WHERE u_id = :u_id
             LIMIT 1'
         );
         $PDOState -> bindValue(':u_id', $newUserId, PDO::PARAM_INT);
         $PDOState -> execute();
         $user = $PDOState -> fetch(PDO::FETCH_ASSOC);

         if ($user === false){
            throw new RuntimeException('登録会員が取得できません。');
         }

         //ログイン時にセッションIDを再生成。
         if (!session_regenerate_id(true)){
            throw new RuntimeException('セッションを更新できません。');
         }

         //ログイン情報を格納。
         $_SESSION['User'] = $user;

         LogWriting($e=(isset($e) ? $e : ""), $msg="ログイン");

      } catch (Throwable $e){
         $e_message[] = 'アカウントは作成できましたが、ログインできませんでした。';
         $_SESSION['User'] = null;

         LogWriting($e, $msg="ログイン");
      }
   }
?>
<?php
   if ($accountCreated) {

       $mailTo = $_SESSION['Create_Acct']['Mail'] ?? '';
       $name = $_SESSION['Create_Acct']['Name'] ?? '';
       $loginId = $_SESSION['Create_Acct']['U_Input_Id'] ?? '';
       $subject = 'Reco.Con. メンバーズクラブ登録完了のお知らせ';
       $body = "{$name}さま

Reco.Con.メンバーズクラブへのご登録ありがとうございます。

ご登録いただいたログインID：
{$loginId}

※このメールにはパスワードを記載していません。
※お心当たりのない場合は、このメールを削除してください。

Reco.Con.事務局";

       try {
          $mailSent = sendRecoconMail($mailTo, $subject, $body);
          LogWriting(null, $mailSent ? '登録メール送信受付成功' : '登録メール送信失敗');
       } catch (Throwable $e) {
          $mailSent = false;
          LogWriting($e, '登録メール送信失敗');
       }
   }
?>
<?php  //処理終了後、アカウント作成用の一時情報だけ破棄する。
   //ログイン情報は維持する。
   unset($_SESSION['Create_Acct']);
?>


<!--以下、HTML-->


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
         <?= isset($e_message) ? 'エラーが発生しました。' : '新規アカウントを作成しログインしました。'; ?>
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
               } else {
                  print "Reco.Con.メンバーズクラブへようこそ！<br>"
                     . e($_SESSION['User']['u_name'])
                     . "さま。<br>"
                     . "ご登録ありがとうございました。<br>"
                     . ($mailSent
                        ? 'ご登録メールアドレスへ登録完了のお知らせを送信しました。'
                        : '登録は完了しましたが、通知メールを送信できませんでした。')
                     . "<br>今後ともReco.Con.をよろしくお願いいたします。";
               }
            ?>

         </p>

         <div class="space_22px"></div>

      </div>

      <div class="backMark">
         <a id="toTop" class="toTop" href="RecoCon_TOP_XAMPP.php"><img src="SVG/back.svg" alt="back"></a>
      </div>

   </main>




