<?php require_once __DIR__."/PHP/Security/session_bootstrap.php";   /* session_start含む。 */ ?>
<?php require_once __DIR__.'/PHP/htmlspecialchars_as_e()/htmlspecialchars_as_e().php'; ?>
<?php require_once __DIR__.'/PHP/LogWriting/function_LogWriting.php'; ?>
<?php require_once __DIR__.'/PHP/PDO/PDOError_as_echo_e().php'; ?>
<?php require_once __DIR__.'/PHP/Security/csrf.php'; ?>
<?php require_once __DIR__.'/PHP/Security/regex.php'; ?>
<?php  // リクエストの検証。認証・認可・CSRFはDB操作より先に行う。
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
   if (!isset($_POST['MClub_updateAcct_U_Id']) || !is_scalar($_POST['MClub_updateAcct_U_Id']) ||
       !ctype_digit((string)$_POST['MClub_updateAcct_U_Id']) ||
       (int)$_POST['MClub_updateAcct_U_Id'] !== (int)$_SESSION['User']['u_id']){
      http_response_code(403);
      exit('会員情報の更新対象が一致しません。');
   }
?>
<?php 
   require_once __DIR__.'/PHP/PDO/newPDO_as_getDb().php'; 
   $PDO = getDb();  //$PDOにPDOインスタンスが格納されている。
?>
<?php header("Content-Type: text/html;charset=UTF-8"); ?>
<?php   //正規表現での判定結果がOKならDB書き込み、NGならエラーメッセージ。
   //入力値が正規表現に適合するか確認する。
   $frag_Name;
   $frag_Age;
   $frag_Sex;
   $frag_Address1;
   $frag_Address2;
   $frag_Address3;
   $reg_Tel;
   $reg_Mail;

   $allFrag;
   $r = regex();   //正規表現配列呼び出し自作関数。
   $string_reg = [
      [
         'string' => !empty(rawurldecode($_POST['MClub_updateAcct_Name'])) ? rawurldecode($_POST['MClub_updateAcct_Name']) : "" ,
         'reg' => $r['Name'],
         'frag' => $frag_Name
      ],
      [
         'string' => !empty((int)rawurldecode($_POST['MClub_updateAcct_Age'])) ? (int)rawurldecode($_POST['MClub_updateAcct_Age']) : "" ,
         'reg' => $r['Age'],
         'frag' => $frag_Age],
      [
         'string' => !empty(rawurldecode($_POST['MClub_updateAcct_Sex'])) ? rawurldecode($_POST['MClub_updateAcct_Sex']) : "" ,
         'reg' => $r['Sex'],
         'frag' => $frag_Sex
      ],
      [
         'string' => !empty(rawurldecode($_POST['MClub_updateAcct_Address1'])) ? rawurldecode($_POST['MClub_updateAcct_Address1']) : "" ,
         'reg' => $r['Address1'],
         'frag' => $frag_Address1
      ],
      [
         'string' => !empty(rawurldecode($_POST['MClub_updateAcct_Address2'])) ? rawurldecode($_POST['MClub_updateAcct_Address2']) : "" ,
         'reg' => $r['Address2'],
         'frag' => $frag_Address2
      ],
      [
         'string' => !empty(rawurldecode($_POST['MClub_updateAcct_Address3'])) ? rawurldecode($_POST['MClub_updateAcct_Address3']) : "" ,
         'reg' => $r['Address3'],
         'frag' => $frag_Address3
      ],
      [
         'string' => !empty(rawurldecode($_POST['MClub_updateAcct_Tel'])) ? rawurldecode($_POST['MClub_updateAcct_Tel']) : "" ,
         'reg' => $r['Tel'],
         'frag' => $frag_Tel
      ],
      [
         'string' => !empty(rawurldecode($_POST['MClub_updateAcct_Mail'])) ? rawurldecode($_POST['MClub_updateAcct_Mail']) : "" ,
         'reg' => $r['Mail'],
         'frag' => $frag_Mail
      ],
   ];

   //判定結果OKorNGを配列$judgeに順番に格納。順番にOK、NGが格納される。
   $judge = [];

   foreach ($string_reg as ['string'=>$string, 'reg'=>$reg, 'frag'=>$frag]){
      if (preg_match($reg, $string) == 1 && !$string == ''){
         //入力値検証OK
         $frag = "OK";
         array_push($judge, $frag);
         //var_dump($string);
         //print_r("フラグOK".$frag);
      } else {
         $frag = "NG";
         array_push($judge, $frag);
         //var_dump($string);
         //print_r("フラグNG".$frag);
      }
   }
   //print_r("ジャッジ".$judge);

   //$judgeをもとに入力情報すべてに誤りがないかを確認する。
   if ($judge[0]=="OK" && $judge[1]=="OK" && $judge[2]=="OK" && $judge[3]=="OK" && $judge[4]=="OK" && $judge[5]=="OK" && $judge[6]=="OK" && $judge[7]=="OK"){
      $allFrag = "OK";
   } else {
      $allFrag = "NG";
   }

   //判定したフラグを$_SESSION['BuyTicket_input'][0]へ格納（すでに情報が入っていても、挿入された時点でのインデックスは「0」である）
   //array_push($_SESSION['BuyTicket_input'], ['Button' => $allFrag]);
?>
<?php
   if ($allFrag == "OK"){
      //try_catch①。入力情報をもとにデータベースを更新。
      try {
         $PDO -> beginTransaction();   //トランザクション処理開始

         $PDOState = $PDO -> prepare(
             'UPDATE User 
              SET 
                  u_name=:u_name, 
                  u_age=:u_age, 
                  u_sex=:u_sex, 
                  u_address_1=:u_address_1, 
                  u_address_2=:u_address_2, 
                  u_address_3=:u_address_3, 
                  u_tel=:u_tel, 
                  u_mail=:u_mail 
              WHERE u_id=:u_id'
         );

         $PDOState -> bindParam(':u_id', $update_U_Id);
         //$PDOState -> bindParam(':u_input_id', $update_U_Input_Id);
         //$PDOState -> bindParam(':u_input_pass', $update_Pass);
         $PDOState -> bindParam(':u_name', $update_Name);
         $PDOState -> bindParam(':u_age', $update_Age);
         $PDOState -> bindParam(':u_sex', $update_Sex);
         $PDOState -> bindParam(':u_address_1', $update_Address1);
         $PDOState -> bindParam(':u_address_2', $update_Address2);
         $PDOState -> bindParam(':u_address_3', $update_Address3);
         $PDOState -> bindParam(':u_tel', $update_Tel);
         $PDOState -> bindParam(':u_mail', $update_Mail);

         $update_U_Id = (int)$_SESSION['User']['u_id'];
         //$update_U_Input_Id = rawurldecode($_POST['MClub_updateAcct_U_Input_Id']);
         //$update_Pass = rawurldecode($_POST['MClub_updateAcct_Pass']);
         $update_Name = rawurldecode($_POST['MClub_updateAcct_Name']);
         $update_Age = (int)rawurldecode($_POST['MClub_updateAcct_Age']);
         $update_Sex = rawurldecode($_POST['MClub_updateAcct_Sex']);
         $update_Address1 = rawurldecode($_POST['MClub_updateAcct_Address1']);
         $update_Address2 = rawurldecode($_POST['MClub_updateAcct_Address2']);
         $update_Address3 = rawurldecode($_POST['MClub_updateAcct_Address3']);
         $update_Tel = rawurldecode($_POST['MClub_updateAcct_Tel']);
         $update_Mail = rawurldecode($_POST['MClub_updateAcct_Mail']);

         $PDOState -> execute();

         $PDO -> commit();   //トランザクションコミット

         LogWriting($e=(isset($e) ? $e : ""), $msg="アカウント更新");

      } catch ( PDOException $e ){
         $PDO -> rollback();   //トランザクションロールバック

         $e_message[] = 'データを更新できませんでした。';

         LogWriting($e=(isset($e) ? $e : ""), $msg="アカウント更新");
      }

      //try_catch②。$_SESSION['User']を更新。
      //全会員は取得せず、ログイン中の本人だけをDBから取得する。
      if (empty($e_message)){
         try {
            $PDOState = $PDO -> prepare('SELECT u_id, u_name, u_age, u_sex, u_input_id, u_address_1, u_address_2, u_address_3, u_tel, u_mail FROM User WHERE u_id=:u_id');
            $PDOState -> bindValue(':u_id', (int)$_SESSION['User']['u_id'], PDO::PARAM_INT);
            $PDOState -> execute();

            $row = $PDOState -> fetch(PDO::FETCH_ASSOC);
            if (!$row){
               throw new RuntimeException('更新後の会員情報がありません。');
            }

            session_regenerate_id(true);
            $_SESSION['User'] = $row;   //パスワードハッシュはセッションに格納しない。
         } catch (Throwable $e){
            $e_message[] = '会員情報の再取得に失敗しました。';
            error_log('RecoCon: account update session refresh failed');
         }
      }
   }   //ifの閉じかっこ。
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
         <?= isset($e_message) ? 'エラーが発生しました。' : 'アカウント情報が更新されました。'; ?>
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
               print 'アカウント情報が正常に更新されました。<br>引き続きReco.Con.をご利用ください。';
            }
         ?>

         </p>
      </div>

      <div class="backMark">
         <a id="toTop" class="toTop" href="RecoCon_TOP_XAMPP.php"><img src="SVG/back.svg" alt="back"></a>
      </div>

   </main>






