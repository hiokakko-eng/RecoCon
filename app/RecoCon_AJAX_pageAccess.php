<?php require_once __DIR__."/PHP/Security/session_bootstrap.php";   /* session_start含む。 */ ?>
<?php require_once __DIR__.'/PHP/htmlspecialchars_as_e()/htmlspecialchars_as_e().php'; ?>
<?php header("Content-Type: text/html;charset=UTF-8"); ?>

<div>

   <h2 id="Access" class="title_white color_perple">アクセス</h2>

   <h2 class="title_glay color_perple">Reco.Con. 会場</h2>

   <div id="Access_place">

      <div id="access_iframe_div">
         <iframe id="access_iframe" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3277.828224882244!2d135.44676277534998!3d34.75991968003372!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6000eff87b119223%3A0x7500cc85f26d2fc!2z44CSNjYxLTA5NTMg5YW15bqr55yM5bC85bSO5biC5p2x5ZyS55Sw55S677yS5LiB55uu77yT77yZ4oiS77yRIOODoeOCvuODsyDjg6njg6vjgrQ!5e0!3m2!1sja!2sjp!4v1711795519451!5m2!1sja!2sjp" width="800" height="600" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
      </div>

      <div id="access_p">
         <p>673-0093  兵庫県尼崎市東園田町2-39-1 メゾンラルゴ</p>
         <p>阪急園田駅から徒歩13分</p>
      </div>

   </div>

   <div class="backMark">
      <a id="toTop" class="toTop" href="RecoCon_TOP_XAMPP.php"><img src="SVG/back.svg" alt="back"></a>
   </div>

</div>
