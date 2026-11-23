<?php require_once __DIR__."/PHP/Security/session_bootstrap.php";   /* session_start含む。 */ ?>
<?php require_once __DIR__.'/PHP/Security/csrf.php'; ?>
<?php require_once __DIR__.'/PHP/htmlspecialchars_as_e()/htmlspecialchars_as_e().php'; ?>
<?php require_once __DIR__.'/PHP/LogWriting/function_LogWriting.php'; ?>
<?php 
   if (
      $_SERVER['REQUEST_METHOD'] !== 'POST' ||
      !recoConCsrfValid($_POST['token'] ?? null)   // CSRF対策のトークンとの照合。
   ){
      LogWriting(null, 'CSRFトークンエラー');
      http_response_code(403);
      die('正規画面からご利用下さい。');
   }
?>
<?php
   $_SESSION['User'] = null;

   LogWriting($e=(isset($e) ? $e : ""), $msg="ログアウト");
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


<!-- メイン（ヘッダー以外すべてくるむ） -->

   <main id="main">

      <div>

         <h2 id="MClub_title" class="title_white color_perple">Reco.Con.メンバーズクラブ</h2>
         <h2 id="MClub_message" class="title_glay color_pink">ログアウトしました。</h2>

         <div class="space_white">

            <div class="space_11px"></div>

            <p class="p_center">今後ともReco.Con.をよろしくお願いいたします。</p>

            <div class="space_22px"></div>

         </div>

         <div class="backMark">
            <a id="toTop" class="toTop" href="RecoCon_TOP_XAMPP.php"><img src="SVG/back.svg" alt="back"></a>
         </div>

      </div>

   </main>


