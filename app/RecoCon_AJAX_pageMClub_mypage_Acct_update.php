<?php require_once __DIR__."/PHP/Security/session_bootstrap.php";   /* session_start含む。 */ ?>
<?php require_once __DIR__.'/PHP/htmlspecialchars_as_e()/htmlspecialchars_as_e().php'; ?>
<?php require_once __DIR__.'/PHP/Security/csrf.php'; ?>
<?php // 変更画面はログイン済みの本人だけに表示する。
   if (empty($_SESSION['User']['u_id']) || empty($_SESSION['User']['u_input_id'])){
      http_response_code(401);
      exit('ログインし直してください。');
   }
?>
<?php header("Content-Type: text/html;charset=UTF-8"); ?>

<div>

   <input type="hidden" id="token" value="<?php print e(recoConCsrfToken()); ?>">   <!--CSRF対策のトークン埋め込み-->

   <h2 id="MClub_title" class="title_white color_perple">Reco.Con.メンバーズクラブ</h2>
   <h2 id="MClub_message" class="title_glay color_pink">変更内容を入力してください。</h2>

   <div class="space_white flex_column">

      <div class="space_55px"></div>

      <div>
         <input id="MClub_updateAcct_U_Id" type="hidden" value="<?= e($_SESSION['User']['u_id']); ?>">
      </div>

      <div class="input_attension_space flex_row">
         <p>ID:</p>
         <div><?= e($_SESSION['User']['u_input_id']); ?></div>
      </div>

      <div class="input_attension_space">
         <p>お名前</p>
         <div>
            <input id="MClub_updateAcct_Name" value="<?= e($_SESSION['User']['u_name']); ?>" maxlength="50">
         </div>
         <p id="MClub_updateAcct_Name_check" style="color:rgb(250, 78, 174)"></p>
      </div>

      <div class="input_attension_space">
         <p>年齢</p>
         <div>
            <input id="MClub_updateAcct_Age" value="<?= e($_SESSION['User']['u_age']); ?>" maxlength="3">
         </div>
         <p id="MClub_updateAcct_Age_check" style="color:rgb(250, 78, 174)"></p>
      </div>

      <div class="input_attension_space">
         <p>性別（男または女）</p>
         <div>
            <input id="MClub_updateAcct_Sex" value="<?= e($_SESSION['User']['u_sex']); ?>" maxlength="10">
         </div>
         <p id="MClub_updateAcct_Sex_check" style="color:rgb(250, 78, 174)"></p>
      </div>

      <div class="input_attension_space">
         <p>ご住所（都道府県）</p>
         <div>
            <input id="MClub_updateAcct_Address1" value="<?= e($_SESSION['User']['u_address_1']); ?>" maxlength="10">
         </div>
         <p id="MClub_updateAcct_Address1_check" style="color:rgb(250, 78, 174)"></p>
      </div>

      <div class="input_attension_space">
         <p>ご住所（市区町村）</p>
         <div>
            <input id="MClub_updateAcct_Address2" value="<?= e($_SESSION['User']['u_address_2']); ?>" maxlength="25">
         </div>
         <p id="MClub_updateAcct_Address2_check" style="color:rgb(250, 78, 174)"></p>
      </div>

      <div class="input_attension_space">
         <p>ご住所（番地以下）</p>
         <div>
            <input id="MClub_updateAcct_Address3" value="<?= e($_SESSION['User']['u_address_3']); ?>" maxlength="50">
         </div>
         <p id="MClub_updateAcct_Address3_check" style="color:rgb(250, 78, 174)"></p>
      </div>

      <div class="input_attension_space">
         <p>電話番号（ハイフン必須）</p>
         <div>
            <input id="MClub_updateAcct_Tel" value="<?= e($_SESSION['User']['u_tel']); ?>" maxlength="13">
         </div>
         <p id="MClub_updateAcct_Tel_check" style="color:rgb(250, 78, 174)"></p>
      </div>

      <div class="input_attension_space">
         <p>メールアドレス</p>
         <div>
            <input id="MClub_updateAcct_Mail" value="<?= e($_SESSION['User']['u_mail']); ?>" maxlength="50">
         </div>
         <p id="MClub_updateAcct_Mail_check" style="color:rgb(250, 78, 174)"></p>
      </div>

      <div class="space_11px"></div>

      <div class="flex_row">
         <button id="MClub_Acct_Update" class="button_pink color_white">更新</button>
         <button id="pageMClub_mypage_Acct_update_back" class="button_glay color_white">戻る</button>
      </div>

   </div>

   <div class="backMark">
      <a id="toTop" class="toTop" href="RecoCon_TOP_XAMPP.php"><img src="SVG/back.svg" alt="back"></a>
   </div>

</div>
