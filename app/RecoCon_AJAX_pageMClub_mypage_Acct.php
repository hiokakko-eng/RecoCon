<?php require_once __DIR__."/PHP/Security/session_bootstrap.php";   /* session_start含む。 */ ?>
<?php
   // ログイン状態の確認
   if (
       !isset($_SESSION['User']) ||
       !is_array($_SESSION['User']) ||
       empty($_SESSION['User']['u_input_id'])
   ) {
       http_response_code(401);
       header('Content-Type: text/plain; charset=UTF-8');
       exit('ログインが必要です。');
   }
?>
<?php require_once __DIR__.'/PHP/htmlspecialchars_as_e()/htmlspecialchars_as_e().php'; ?>
<?php header("Content-Type: text/html;charset=UTF-8"); ?>


<div>

   <h2 id="MClub_title" class="title_white color_perple">Reco.Con.メンバーズクラブ</h2>
   <h2 id="MClub_message" class="title_glay color_pink">マイページ</h2>

   <div class="space_white">

      <div class="flex_column">

         <div>

            <p><アカウント情報></p>

            <table class="table_general">

               <tr>
                  <th>ID</th>
                  <td id="MClub_createAcct_confirm_Id"><?= e($_SESSION['User']['u_input_id']) ?></td>
               </tr>

               <tr>
                  <th>お名前</th>
                  <td id="MClub_createAcct_confirm_Name"><?= e($_SESSION['User']['u_name']) ?></td>
               </tr>

               <tr>
                  <th>年　齢</th>
                  <td id="MClub_createAcct_confirm_Age"><?= e($_SESSION['User']['u_age']) ?></td>
               </tr>

               <tr>
                  <th>性　別</th>
                  <td id="MClub_createAcct_confirm_Sex"><?= e($_SESSION['User']['u_sex']) ?></td>
               </tr>

               <tr>
                  <th>都道府県</th>
                  <td id="MClub_createAcct_confirm_Address1"><?= e($_SESSION['User']['u_address_1']) ?></td>
               </tr>

               <tr>
                  <th>市区町村</th>
                  <td id="MClub_createAcct_confirm_Address2"><?= e($_SESSION['User']['u_address_2']) ?></td>
               </tr>

               <tr>
                  <th>番地以下</th>
                  <td id="MClub_createAcct_confirm_Address3"><?= e($_SESSION['User']['u_address_3']) ?></td>
               </tr>

               <tr>
                  <th>電話番号</th>
                  <td id="MClub_createAcct_confirm_Tel"><?= e($_SESSION['User']['u_tel']) ?></td>
               </tr>

               <tr>
                  <th>メールアドレス</th>
                  <td id="MClub_createAcct_confirm_Mail"><?= e($_SESSION['User']['u_mail']) ?></td>
               </tr>

            </table>

         </div>

      </div>

      <div class="space_11px"></div>

      <div class="flex_row">
         <button id="MClub_updateAcct" class="button_pink color_white">内容を変更する</button>
         <button id="pageMClub_mypage_Acct_back" class="button_glay color_white">戻る</button>
      </div>

   </div>

   <div class="backMark">
      <a id="toTop" class="toTop" href="RecoCon_TOP_XAMPP.php"><img src="SVG/back.svg" alt="back"></a>
   </div>

