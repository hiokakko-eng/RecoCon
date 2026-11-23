<?php require_once __DIR__."/PHP/Security/session_bootstrap.php";   /* session_start含む。 */ ?>
<?php require_once __DIR__.'/PHP/htmlspecialchars_as_e()/htmlspecialchars_as_e().php'; ?>
<?php require_once __DIR__.'/PHP/PDO/PDOError_as_echo_e().php'; ?>
<?php 
   require_once __DIR__.'/PHP/PDO/newPDO_as_getDb().php'; 
   $PDO = getDb();  //$PDOにPDOインスタンスが格納されている。
?>
<?php require __DIR__.'/HTML_Header_Footer/HTML_header.php'; ?>


<!-- ここより上はHTMLヘッダー -->


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
         <a id="toTop" href="RecoCon_TOP_XAMPP.php">
         <img src="SVG/back.svg" alt="back"></a>
      </div>

   </nav>






<!-- メイン（ヘッダー以外すべてくるむ） -->

<main id="main">


<!-- Next Concert 見出し -->
   <div id="next_concert_title" class="topFirstAnimate">
      <h1 class="color_white">次の公演</h1>
   </div>
   <div id="next_concert_title_p" class="topFirstAnimate">
      <!-- <img src="photo/woman_violin_p_L.png"> -->
   </div>


<!-- Next Concert -->
   <?php
      try {
         $PDOState = $PDO -> prepare(
             'SELECT 
                 Concert_Schedule.cs_id, 
                 Concert_Schedule.cs_date, 
                 Concert_Schedule.cs_open, 
                 Concert_Schedule.cs_start, 
                 Concert_Schedule.cs_composer_en, 
                 Concert_Schedule.cs_title_en, 
                 Concert_Schedule.cs_composer_jn, 
                 Concert_Schedule.cs_title_jn, 
                 Disc.d_id, 
                 Disc.d_title, 
                 Disc.d_detail, 
                 Disc.d_path 
              FROM Concert_Schedule 
              INNER JOIN Disc ON Concert_Schedule.d_id=Disc.d_id 
              WHERE cs_id=(
                  SELECT COUNT(cs_id) 
                  FROM Concert_Schedule)-2 
              ORDER BY cs_id ASC'
         );
         $PDOState -> execute();

         while ($row = $PDOState -> fetch(PDO::FETCH_ASSOC)){
            ?>
               <div id="next_div1">
                  <div id="next_concert_date" class="topFirstAnimate">
                     <h2><span id="kaisaibi" class="h2_little">開催日</span>'<?= mb_substr(str_replace('-', '.', e($row['cs_date'])), 2);?> &nbsp;&nbsp;</h2>
                     <h2><span id="kaijo" class="h2_little">開場</span><?= mb_substr(e($row['cs_open']), 0, 5);?> &nbsp;&nbsp;</h2>
                     <h2><span id="kaien" class="h2_little">開演</span><?= mb_substr(e($row['cs_start']), 0, 5);?></h2>
                  </div>
               </div>
               <div id="next_text_arrow" class="topFirstAnimate">
                  <div>
                     <h2 class="color_perple"><?= e($row['cs_composer_jn']).' : '.e($row['cs_title_jn']);?></h2>
                     <p><?= e($row['cs_composer_en']). ' / ' .e($row['cs_title_en']);?></p>
                  </div>
                  <div>
                     <img id="next_div1_div2_img" class="arrow cursor" src="SVG/arrow_glay.svg" alt="arrow">
                  </div>
               </div>

               <div id="next_div2" class="disc_info">
                  <div id="next_div2_div1">
                     <p><?= e($row['d_title']);?><br>より</p>
                     <div id="next_div2_div_div" class="ongen_mark" name="<?= e($row['d_id'])?>">音源詳細</div>
                  </div>
                  <div id="next_div2_div2">
                     <img class="middle_p" src="photo/<?= e($row['d_path']);?>" alt="d_photo">
                  </div>
               </div>
            <?php
         }

      } catch ( PDOException $e ){
         //$error = echo_e($e);
         ?>

            <p class="top_ErrorMessage color_glay">「次の公演」の登録情報にアクセスできませんでした。<br>ページを更新してください。</p>

         <?php
      }
   ?>


<!-- Stay tuned! 見出し -->
   <div id="stay_tuned_title" class="topFirstAnimate">
      <h1 class="color_white">後日の公演</h1>
   </div>
   <div id="stay_tuned_title_p" class="topFirstAnimate">
      <!-- <img src="photo/woman_cello_p_L.png"> -->
   </div>


<!-- Stay tuned! 1 -->
   <?php
      try {
         $PDOState = $PDO -> prepare(
             'SELECT 
                 Concert_Schedule.cs_id, 
                 Concert_Schedule.cs_date, 
                 Concert_Schedule.cs_open, 
                 Concert_Schedule.cs_start, 
                 Concert_Schedule.cs_composer_en, 
                 Concert_Schedule.cs_title_en, 
                 Concert_Schedule.cs_composer_jn, 
                 Concert_Schedule.cs_title_jn, 
                 Disc.d_id, 
                 Disc.d_title, 
                 Disc.d_detail, 
                 Disc.d_path 
              FROM Concert_Schedule 
              INNER JOIN Disc ON Concert_Schedule.d_id=Disc.d_id 
              WHERE cs_id=(
                  SELECT COUNT(cs_id) 
                  FROM Concert_Schedule)-1 
              ORDER BY cs_id ASC'
         );
         $PDOState -> execute();

         while ($row = $PDOState -> fetch(PDO::FETCH_ASSOC)){
            ?>
               <div id="stayTuned1_text_arrow" class="topFirstAnimate">
                  <div>
                     <h2 class="color_perple"><?=e($row['cs_composer_jn']). ' : ' .e($row['cs_title_jn'])?></h2>
                     <p><?=e($row['cs_composer_en']). ' / ' .e($row['cs_title_en'])?></p>
                  </div>
                  <div>
                     <img id="stayTuned1_div1_div2_img" class="cursor arrow" src="SVG/arrow_glay.svg" alt="arrow">
                  </div>
               </div>

               <div id="stayTuned1_div2" class="disc_info">
                  <div id="stayTuned1_div2_div1">
                     <p><?=e($row['d_title']);?><br>より</p>
                     <div id="stayTuned1_div2_div1_div" class="ongen_mark" name="<?= e($row['d_id'])?>">音源詳細</div>
                  </div>
                  <div id="stayTuned1_div2_div2">
                     <img class="middle_p" src="<?= 'photo/' . e($row['d_path']);?>" alt="d_photo">
                  </div>
               </div>
            <?php
         }

      } catch ( PDOException $e ){
         //$error = echo_e($e);
         ?>

            <p class="top_ErrorMessage color_glay">「後日の公演1」の登録情報にアクセスできませんでした。<br>ページを更新してください。</p>

         <?php
      }
   ?>


<!-- Stay tuned! 2 -->
   <?php
      try {
         $PDOState = $PDO -> prepare(
             'SELECT 
                 Concert_Schedule.cs_id, 
                 Concert_Schedule.cs_date, 
                 Concert_Schedule.cs_open, 
                 Concert_Schedule.cs_start, 
                 Concert_Schedule.cs_composer_en, 
                 Concert_Schedule.cs_title_en, 
                 Concert_Schedule.cs_composer_jn, 
                 Concert_Schedule.cs_title_jn, 
                 Disc.d_id, 
                 Disc.d_title, 
                 Disc.d_detail, 
                 Disc.d_path 
              FROM Concert_Schedule 
              INNER JOIN Disc ON Concert_Schedule.d_id=Disc.d_id 
              WHERE cs_id=(
                 SELECT COUNT(cs_id) 
                 FROM Concert_Schedule)-0 
                 ORDER BY cs_id ASC'
         );
         $PDOState -> execute();

         while ($row = $PDOState -> fetch(PDO::FETCH_ASSOC)){
            ?>
               <div id="stayTuned2_text_arrow" class="topFirstAnimate">
                  <div>
                     <h2 class="color_perple"><?= e($row['cs_composer_jn']). ' : ' .e($row['cs_title_jn'])?></h2>
                     <p><?= e($row['cs_composer_en']). ' / ' .e($row['cs_title_en'])?></p>
                  </div>
                  <div>
                     <img id="stayTuned2_div1_div2_img" class="cursor arrow" src="SVG/arrow_glay.svg" alt="arrow">
                  </div>
               </div>

               <div id="stayTuned2_div2" class="disc_info">
                  <div id="stayTuned2_div2_div1">
                     <p><?= e($row['d_title']);?><br>より</p>
                     <div id="stayTuned2_div2_div1_div" class="ongen_mark" name="<?= e($row['d_id'])?>">音源詳細</div>
                  </div>
                  <div id="stayTuned2_div2_div2">
                     <img class="middle_p" src="<?= 'photo/' . e($row['d_path']);?>" alt="d_photo">
                  </div>
               </div>
            <?php
         }

      } catch ( PDOException $e ){
         //$error = echo_e($e);
         ?>

            <p class="top_ErrorMessage color_glay">「後日の公演2」の登録情報にアクセスできませんでした。<br>ページを更新してください。</p>

         <?php
      }
   ?>


<!-- Close 見出し -->
   <div id="close_title" class="topFirstAnimate">
      <h1 class="color_white">過去の公演</h1>
   </div>
   <div id="close_title_p" class="topFirstAnimate">
      <!-- <img src="photo/man_base_p_L.png"> -->
   </div>


<!-- Close -->

      <?php
            try {
               $PDOState = $PDO -> prepare(
                   'SELECT 
                       Concert_Schedule.cs_id, 
                       Concert_Schedule.cs_date, 
                       Concert_Schedule.cs_open, 
                       Concert_Schedule.cs_start, 
                       Concert_Schedule.cs_composer_en, 
                       Concert_Schedule.cs_title_en, 
                       Concert_Schedule.cs_composer_jn, 
                       Concert_Schedule.cs_title_jn, 
                       Disc.d_id, 
                       Disc.d_title, 
                       Disc.d_detail, 
                       Disc.d_path 
                    FROM Concert_Schedule 
                    INNER JOIN Disc ON Concert_Schedule.d_id=Disc.d_id 
                    WHERE cs_id<(
                        SELECT COUNT(cs_id) 
                        FROM Concert_Schedule)-2 
                    ORDER BY cs_id DESC'
               );
               $PDOState -> execute();

               $i=1;
               while ($row = $PDOState -> fetch(PDO::FETCH_ASSOC)){
                  $array[$i] = [
                     "cs_id" => e($row['cs_id']), 
                     "cs_date" => e($row['cs_date']),
                     "cs_open" => e($row['cs_open']),
                     "cs_start" => e($row['cs_start']),
                     "cs_composer_en" => e($row['cs_composer_en']),
                     "cs_title_en" => e($row['cs_title_en']),
                     "cs_composer_jn" => e($row['cs_composer_jn']),
                     "cs_title_jn" => e($row['cs_title_jn']),

                     "d_id" => e($row['d_id']), 
                     "d_title" => nl2br(e($row['d_title'])),
                     "d_detail" => nl2br(e($row['d_detail'])),
                     "d_path" => e($row['d_path'])
                  ];
                  $i++;
               }

               for ($i=1; $i <= 5; $i++){
                  ?>
                        <div id="close<?= $i; ?>_text_arrow" class="topFirstAnimate">
                           <div id="close<?= $i; ?>_div1_div1">
                              <div id="close<?= $i; ?>_div1_div1_div">
                                 <h2 id="close<?= $i; ?>_div1_div1_div_h41" class="color_perple">'<?= mb_substr(str_replace('-', '.', $array[$i]['cs_date']), 2);?></h2>
                                 <h2 id="close<?= $i; ?>_div1_div1_div_h42" class="color_perple"><?= "&nbsp".$array[$i]['cs_composer_jn']." : ".$array[$i]['cs_title_jn'];?></h2>
                              </div>
                              <p id="close<?= $i; ?>_div1_div1_p"><?= $array[$i]['cs_composer_en']." / ".$array[$i]['cs_title_en'];?></p>
                           </div>
                           <div>
                              <img id="close<?= $i; ?>_div1_div2_img" class="cursor arrow" src="SVG/arrow_glay.svg">
                           </div>
                        </div>

                        <div id="close<?= $i; ?>_div2" class="disc_info">   <!-- モバイル版で←はCSSでdisplay:none -->
                           <div id="close<?= $i; ?>_div2_div1">
                              <p id="close<?= $i; ?>_div2_div1_p"><?= $array[$i]['d_title'];?><br>より</p>
                              <div id="close<?= $i; ?>_div2_div1_div" class="ongen_mark" name="<?= $array[$i]['d_id']?>">音源詳細</div>
                           </div>
                           <div id="close<?= $i; ?>_div2_div2">
                              <img id="close<?= $i; ?>_div2_div2_img" class="middle_p" src="photo/<?= $array[$i]['d_path'];?>">
                           </div>
                        </div>
                  <?php
               }

            } catch ( PDOException $e ){
               //$error = echo_e($e);
               ?>

                  <p class="top_ErrorMessage color_glay">「過去の公演」の登録情報にアクセスできませんでした。<br>ページを更新してください。</p>

               <?php
            }
         ?>



<!-- Close ノンブル -->
   <div id="close_noble" class="topFirstAnimate">
      <?php
            try {
               $PDOState = $PDO -> prepare('SELECT COUNT(cs_id) FROM Concert_Schedule');
               $PDOState -> execute();

               while ($row = $PDOState -> fetch(PDO::FETCH_ASSOC)){
                  $count = e($row['COUNT(cs_id)']);
               }

               for ($i=1; $i <= ceil($count/5); $i++){
                  ?>
                     <div id="noble<?= $i;?>" class="noble_cicle">
                        <div class="noble"><?= $i ?></div>
                     </div>
                  <?php
               }

            } catch ( PDOException $e ){
               //$error = echo_e($e);
               ?>

                  <p class="top_ErrorMessage color_glay">「過去の公演」の登録情報にアクセスできませんでした。<br>ページを更新してください。</p>

               <?php
            }
         ?>
   </div>


<!-- カルーセル -->
   <div id="carousel_view">
      <div id="carousel" class="topFirstAnimate">
         <?php
            try {
               $PDOState = $PDO -> prepare(
                   'SELECT 
                       Concert_Schedule.cs_id, 
                       Disc.d_id, 
                       Disc.d_path 
                    FROM Concert_Schedule 
                    INNER JOIN Disc ON Concert_Schedule.d_id=Disc.d_id 
                    WHERE Concert_Schedule.cs_id <= 14 
                    ORDER BY cs_id ASC'
               );
               $PDOState -> execute();

               $i=1;
               while ($row = $PDOState -> fetch(PDO::FETCH_ASSOC)){
                  ?>
                           <div id="carousel_d<?= $i; ?>">
                              <a  id="carousel_d<?= $i; ?>_a">
                                 <img id="carousel_d<?= $i; ?>_a_img" class="carousel" src="<?= 'photo/' . $row['d_path'] ?>">
                              </a>
                           </div>
                  <?php
                  $i++;
               }
            } catch ( PDOException $e ){
               //$error = echo_e($e);
               ?>

                  <p class="top_ErrorMessage color_glay">「カルーセル」の登録情報にアクセスできませんでした。<br>ページを更新してください。</p>

               <?php
            }
         ?>
      </div>
   </div>


</main>


<!-- ここより下はHTMLフッター -->

<?php require __DIR__.'/HTML_Header_Footer/HTML_footer.php'; ?>
