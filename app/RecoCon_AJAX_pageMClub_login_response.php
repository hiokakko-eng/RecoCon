<?php require_once __DIR__."/PHP/Security/session_bootstrap.php";   /* session_start含む。 */ ?>
<?php require_once __DIR__.'/PHP/htmlspecialchars_as_e()/htmlspecialchars_as_e().php'; ?>
<?php require_once __DIR__.'/PHP/PDO/PDOError_as_echo_e().php'; ?>
<?php require_once __DIR__.'/PHP/LogWriting/function_LogWriting.php'; ?>
<?php require_once __DIR__.'/PHP/Security/login_rate_limit.php'; ?>
<?php 
   require_once __DIR__.'/PHP/PDO/newPDO_as_getDb().php'; 
   $PDO = getDb();  //$PDOにPDOインスタンスが格納されている。
?>
<?php header('Content-Type: text/html;charset=UTF-8'); ?>
<?php
   $loginId = $_POST['MembersId'] ?? '';
   $password = $_POST['MembersPass'] ?? '';

   if (!is_string($loginId) || !is_string($password)) {
      $loginId = '';
      $password = '';
   }

   //DBの登録情報を配列へ。
   try {
      $PDOState = $PDO -> prepare('SELECT * FROM User WHERE u_input_id = :login_id LIMIT 1');
          //⬆️ prepareでPDOStatementを格納。SQL命令の「:名前」はプレイスホルダー。SQLインジェクション対策になる

      $PDOState -> execute([':login_id' => $loginId]);

      $user = $PDOState -> fetch(PDO::FETCH_ASSOC);

      LogWriting($e=(isset($e) ? $e : ""), $msg="重要情報の参照");

   } catch ( PDOException $e ){
      //print echo_e($e);
      $e_message[] = '登録情報にアクセスできませんでした。';

      LogWriting($e=(isset($e) ? $e : ""), $msg="重要情報の参照");

      $user = false;
   }
?>
<?php
   //ログイン試行の可不可をIDとIPの試行回数から判定。
   try {
      $authStatus = recoconLoginWithLimit($PDO, $loginId, $password, $user, ($_SERVER['REMOTE_ADDR'] ?? ''));
   } catch (Throwable $e) {
      error_log('Login rate limit processing failed');
      $authStatus = 'busy';
   }

   if ($authStatus === 'limited'){
      http_response_code(429);   //429: Too Many Requests
      header('Retry-After: 900');
      header('Content-Type: text/plain;charset=UTF-8');
      echo '時間をあけてから再度お試しください。';
      exit;
   }

   //ログイン情報の判定。
   if ($authStatus === 'ok'){

      session_regenerate_id(true);

      unset($user['u_input_pass']);
      $_SESSION['User'] = $user;

      LogWriting($e=(isset($e) ? $e : ""), $msg="ログイン");

      //print_r($array_uInputId);
      //print_r(array_search($_POST['MembersId'], $array_uInputId)+1);
      //print_r($_SESSION);

   } else {
      $_SESSION['User'] = null;

      LogWriting($e=(isset($e) ? $e : ""), $msg="ログイン");
   }
?>


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
      <div id="navi_RecoConInfo" class="navi"> Record Concertについて </div>
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


<!-- メイン（ヘッダー以外すべてくるむ）ログイン状態によって書き換え -->

   <?php   

      if (isset($e_message)){   

         ?>

            <main id="main">

               <h2 id="MClub_title" class="title_white color_perple">Reco.Con.メンバーズクラブ</h2>
               <h2 id="MClub_message" class="title_glay color_pink">エラーが発生しました。</h2>

               <div class="space_white">

                  <div class="space_11px"></div>

                  <p class="p_center">ログインに失敗しました。<br>
                     <?php 
                        $i=0;
                        while ($i < count($e_message)){ 
                           print $e_message[$i].'<br>';
                           $i++;
                        }
                        print $e_message[$i];
                     ?>
                  </p>

                  <div class="space_22px"></div>
 
               </div>

               <div class="backMark">
                  <a id="toTop" class="toTop" href="RecoCon_TOP_XAMPP.php"><img src="SVG/back.svg" alt="back"></a>
               </div>

            </main>

         <?php

      } else {

         ?>

            <main id="main">

               <h2 id="MClub_title" class="title_white color_perple">Reco.Con.メンバーズクラブ</h2>
               <h2 id="MClub_message" class="title_glay color_pink">
                  <?= isset($_SESSION['User']) ? 'ログインしました。' : '登録情報と一致しませんでした。' ?>
               </h2>

               <?php   

                  if (isset($_SESSION['User'])){

                     ?>

                        <div class="space_white">

                           <div class="space_11px"></div>

                           <p class="p_center"><?= e($_SESSION['User']['u_name']) ?>さま。<br>Reco.Con.へようこそ。</p>

                           <div class="space_22px"></div>
 
                        </div>

                     <?php   

                   } else {

                      ?>

                        <div class="space_white flex_column">

                           <div class="space_55px"></div>

                           <div class="input_attension_space">
                              <p>ID</p>
                              <div>
                                 <input id="MClub_inputId" class="input_style">
                              </div>
                           </div>

                           <div class="input_attension_space">
                              <p>パスワード</p>
                              <div>
                                 <input type="password" id="MClub_inputPassword" autocomplete="current-password" value="">
                               </div>
                           </div>

                           <div class="space_55px"></div>

                           <div class="flex_column">
                              <button id="MClub_input_login" class ="button_pink color_white">ログイン</button>
                              <button id="pageMClub_login_back" class ="button_glay color_white">戻る</button>
                           </div>

                        </div>

                     <?php
                  }
               ?>

               <div class="backMark">
                  <a id="toTop" class="toTop" href="RecoCon_TOP_XAMPP.php"><img src="SVG/back.svg" alt="back"></a>
               </div>

            </main>

         <?php
      }
   ?>

