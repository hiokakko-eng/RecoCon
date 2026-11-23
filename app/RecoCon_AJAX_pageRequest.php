<?php require_once __DIR__."/PHP/Security/session_bootstrap.php";   /* session_start含む。 */ ?>
<?php require_once __DIR__.'/PHP/Security/csrf.php'; ?>
<?php require_once __DIR__.'/PHP/htmlspecialchars_as_e()/htmlspecialchars_as_e().php'; ?>
<?php header("Content-Type: text/html;charset=UTF-8"); ?>

<div>

   <input type="hidden" id="token" value="<?= e(recoConCsrfToken()); ?>">   <!--CSRF対策のトークン埋め込み-->

   <h2 id="Request_title" class="title_white color_perple">ご感想・ご要望</h2>

   <div id="Request">

      <h2 class="title_glay color_perple">ご感想やご要望をお寄せくださいませ。</h2>

      <div id="request_textarea">
         <textarea id="input_request" placeholder="入力してください。" maxlength="400"></textarea>
      </div>

      <div id="requestLength">
         <h3 id="textLength" class="color_black">0 / 400文字</h3>
      </div>

      <div class="flex_row">
         <Button id="submit_request" class="button_perple color_white">送信する</div>
      </div>

   </div>

   <div class="backMark">
      <a id="toTop" class="toTop" href="RecoCon_TOP_XAMPP.php"><img src="SVG/back.svg" alt="back"></a>
   </div>

</div>
