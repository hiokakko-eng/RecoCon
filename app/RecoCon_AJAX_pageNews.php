<?php require_once __DIR__."/PHP/Security/session_bootstrap.php";   /* session_start含む。 */ ?>
<?php require_once __DIR__.'/PHP/htmlspecialchars_as_e()/htmlspecialchars_as_e().php'; ?>
<?php require_once __DIR__.'/PHP/PDO/PDOError_as_echo_e().php'; ?>
<?php 
   require_once __DIR__.'/PHP/PDO/newPDO_as_getDb().php'; 
   $PDO = getDb();  //$PDOにPDOインスタンスが格納されている。
?>
<?php header("Content-Type: text/html;charset=UTF-8"); ?>
<?php   // Concert_Scheduleテーブルのレコードをすべて書き出し、JSONにする。
   try {
      $PDOState = $PDO -> prepare('SELECT * FROM News ORDER BY n_id DESC');

      $PDOState -> execute();

      $i=1;
      while ($row = $PDOState -> fetch(PDO::FETCH_ASSOC)){
         $array[$i] = [
            "n_id"   => e($row['n_id']), 
            "n_date" => e($row['n_date']),
            "news"   => e($row['news'])   //←JSONにする場合も想定しているので最後のカンマは不要。
         ];
         $i++;
      }
   } catch ( PDOException $e ){
      //$error = echo_e($e);
      $e_message[] = '登録情報にアクセスできませんでした。<br>再読込してください。';
   }
?>
<?php
   if (isset($e_message)){
      ?>
         <div>

            <h2 id="MClub_title" class="title_white color_perple">お知らせ</h2>
            <h2 id="MClub_message" class="title_glay color_perple">エラーが発生しました。</h2>

            <div class="space_white">

               <div class="space_11px"></div>

               <p class="p_center">
                  <?php 
                     $i=0;
                     while ($i < count($e_message)){ 
                        print $e_message[$i].'<br>';
                        $i++;
                     }
                     print $e_message[$i];
                  ?>
               </p>

               <div class="space_22px"></div>
 
            </div>

            <div class="backMark">
               <a id="toTop" class="toTop" href="RecoCon_TOP_XAMPP.php"><img src="SVG/back.svg" alt="back"></a>
            </div>

         </div>

      <?php
   } else {
      ?>

         <div>

            <h2 id="News" class="title_from_navi color_perple">お知らせ</h2>

            <?php
               for ($i=1; $i <= count($array); $i++){
                  ?>
                     <div class="news">
                        <h3 class="color_perple">'<?= mb_substr(str_replace('-', '.', $array[$i]['n_date']), 2);?></h3>

                        <p class="p_justify"><?= $array[$i]['news']?></p>
                     </div>
                  <?php
               }
            ?>
               <div id="news_underSpace"></div>

            <div class="backMark">
               <a id="toTop" class="toTop" href="RecoCon_TOP_XAMPP.php"><img src="SVG/back.svg" alt="back"></a>
            </div>

         </div>

      <?php
   }
?>
