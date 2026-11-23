<?php require_once __DIR__."/PHP/Security/session_bootstrap.php";   /* session_start含む。 */ ?>
<?php require_once __DIR__.'/PHP/htmlspecialchars_as_e()/htmlspecialchars_as_e().php'; ?>
<?php require_once __DIR__.'/PHP/Security/csrf.php'; ?>
<?php // 退会画面はログイン済みの本人だけに表示する。
   if (empty($_SESSION['User']['u_id']) || empty($_SESSION['User']['u_input_id'])){
      http_response_code(401);
      exit('ログインし直してください。');
   }
?>
<?php header("Content-Type: text/html;charset=UTF-8"); ?>

<div>

   <h2 id="MClub_title" class="title_white color_perple">Reco.Con.メンバーズクラブ</h2>

   <h2 id="MClub_message" class="title_glay color_pink">退会フォーム</h2>

   <div class="space_white">

      <div class="space_11px"></div>

      <p class="p_center"><?= e($_SESSION['User']['u_name'])."さま。<br>本当に退会しますか?" ?></p>
      <input type="hidden" id="token" value="<?php print e(recoConCsrfToken()); ?>">   <!--CSRF対策のトークン埋め込み-->

      <div class="space_22px"></div>

      <div class="flex_column">
         <button id="MClub_Delete" class="button_pink color_white">本当に退会する</button>
         <button id="pageMClub_mypage_Delete_back" class="button_glay color_white" >戻る</button>
      </div>

   </div>

   <div class="backMark">
      <a id="toTop" class="toTop" href="RecoCon_TOP_XAMPP.php"><img src="SVG/back.svg" alt="back"></a>
   </div>

</div>
