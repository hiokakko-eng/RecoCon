<?php require_once __DIR__."/PHP/Security/session_bootstrap.php";   /* session_start含む。 */ ?>
<?php require_once __DIR__.'/PHP/htmlspecialchars_as_e()/htmlspecialchars_as_e().php'; ?>
<?php header("Content-Type: text/html;charset=UTF-8"); ?>
<?php   // ログインの状態によって表示を変える
   if (
      isset($_SESSION['User']) &&
      is_array($_SESSION['User']) &&
      !empty($_SESSION['User']['u_id']) &&
      !empty($_SESSION['User']['u_input_id'])
   ) {
      ?>

      <div>
         <h2 id="MClub_title" class="title_white color_perple">Reco.Con.メンバーズクラブ</h2>
         <h2 id="MClub_title" class="title_pink color_white">Reco.Con.メンバーズクラブ マイページ</h2>

         <div class="MClub_message space_white">

            <p class="p_justify">ID: <?= e($_SESSION['User']['u_input_id']) ?></p>
            <p class="p_justify"><?= e($_SESSION['User']['u_name']) ?>さま</p><br>

            <p class="p_justify">Reco.Con.メンバーズクラブでは、あらかじめお客さま情報を登録することによって、予約購入がしやすくなり、さらにちょっとお得な割引を受けられる、そんなサービスを展開しております。<br>今後は、コメントアップシステムなど、さらにサービスを向上させていく予定です。</p>

            <div class="space_22px"></div>

            <div class="flex_column">
               <button id="MClub_Acct" class="button_pink color_white">アカウント情報変更</button>
               <button id="MClub_Logout" class="button_pink color_white">ログアウト</button>
               <button id="MClub_deleteAcct" class="button_glay color_white">退 会</button>
            </div>

         </div>

         <div class="backMark">
            <a id="toTop" class="toTop" href="RecoCon_TOP_XAMPP.php"><img src="SVG/back.svg" alt="back"></a>
         </div>

      </div>

      <?php
   } else {
      ?>

      <div>
         <h2 id="MClub_title" class="title_white color_perple">Reco.Con.メンバーズクラブ</h2>
         <h2 class="title_pink color_white">Reco.Con.メンバーズクラブへようこそ！</h2>

         <div class="MClub_message space_white">

            <p class="p_justify">Reco.Con.メンバーズでは、あらかじめお客さま情報を登録することによって、予約購入がしやすくなり、さらにちょっとお得な割引を受けられる、そんなサービスを展開しております。<br>今後は、コメントアップシステムなど、さらにサービスを向上させていく予定です。</p>

            <div class="space_22px"></div>

            <div class="flex_column">
               <button id="MClub_login" class="button_pink color_white">ログイン</button>
               <button id="MClub_createAcct" class="button_pink color_white">新規アカウント</button>
            </div>

         </div>

         <div class="backMark">
            <a id="toTop" class="toTop" href="RecoCon_TOP_XAMPP.php"><img src="SVG/back.svg" alt="back"></a>
         </div>

      </div>

      <?php
   }
?>
