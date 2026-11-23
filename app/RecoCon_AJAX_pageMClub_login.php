<?php require_once __DIR__."/PHP/Security/session_bootstrap.php";   /* session_start含む。 */ ?>
<?php require_once __DIR__.'/PHP/htmlspecialchars_as_e()/htmlspecialchars_as_e().php'; ?>
<?php header("Content-Type: text/html;charset=UTF-8"); ?>


<div>

   <h2 id="MClub_title" class="title_white color_perple">Reco.Con.メンバーズクラブ</h2>
   <h2 id="MClub_message" class="title_glay color_pink">アカウント情報を入力してください。</h2>

   <div class="space_white flex_column">

      <div class="space_55px"></div>

      <div class="input_attension_space">
         <p>ID</p>
         <div>
            <input id="MClub_inputId">
         </div>
      </div>

      <div class="input_attension_space">
         <p>パスワード</p>
         <div>
            <input id="MClub_inputPassword" type="password">
         </div>
      </div>

      <div class="space_55px"></div>

      <div class="flex_row">
         <button id="MClub_input_login" class ="button_pink color_white">ログイン</button>
         <button id="pageMClub_login_back" class ="button_glay color_white">戻る</button>
      </div>
   </div>

   <div class="backMark">
      <a id="toTop" class="toTop" href="RecoCon_TOP_XAMPP.php"><img src="SVG/back.svg" alt="back"></a>
   </div>

</div>
