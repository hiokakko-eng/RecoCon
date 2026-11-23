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
           ORDER BY d_id ASC'
      );

      $PDOState -> execute();

      $i=1;
      while ($row = $PDOState -> fetch(PDO::FETCH_ASSOC)){
         $array[$i] = [
            "cs_id"          => e($row['cs_id']), 
            "cs_date"        => e($row['cs_date']),
            "cs_open"        => e($row['cs_open']),
            "cs_start"       => e($row['cs_start']),
            "cs_composer_en" => e($row['cs_composer_en']),
            "cs_title_en"    => e($row['cs_title_en']),
            "cs_composer_jn" => e($row['cs_composer_jn']),
            "cs_title_jn"    => e($row['cs_title_jn']),

            "d_id"           => e($row['d_id']), 
            "d_title"        => e($row['d_title']),
            "d_detail"       => e($row['d_detail']),
            "d_path"         => e($row['d_path'])
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

         <h2 id="MClub_title" class="title_white color_perple">トップページ</h2>
         <h2 id="MClub_message" class="title_glay color_perple">エラーが発生しました。</h2>

         <div class="space_white">

            <div class="space_11px"></div>

            <p class="p_center">
               <?php 
                  for ($i=0; $i < count($e_message); $i++){ 
                     print $e_message[$i].'<br>';
                   } 
               ?>
            </p>

            <div class="space_22px"></div>
 
         </div>

         <div class="backMark">
            <a id="toTop" class="toTop" href="RecoCon_TOP_XAMPP.php"><img src="SVG/back.svg" alt="back"></a>
         </div>

      <?php
   } else {
      ?>

         <h1 class="title_glay color_perple">音源詳細</h1>
         <div class="ongen_photo_div"><img class="ongen_photo" src="<?= 'photo/' . $array[e($_POST['disc_id'])]['d_path'];?>"></div>
         <div id="ongen_text_div">
            <h2><?= nl2br($array[e($_POST['disc_id'])]['d_title']);?></h2>
            <p class="p_justify"><?= nl2br($array[e($_POST['disc_id'])]['d_detail']);?></p>
         </div>

         <div class="backMark">
            <a id="toTop" class="toTop" href="RecoCon_TOP_XAMPP.php"><img src="SVG/back.svg" alt="back"></a>
         </div>

      <?php
   }
?>
