<?php require_once __DIR__."/PHP/Security/session_bootstrap.php";   /* session_start含む。 */ ?>
<?php require_once __DIR__.'/PHP/htmlspecialchars_as_e()/htmlspecialchars_as_e().php'; ?>
<?php require_once __DIR__.'/PHP/PDO/PDOError_as_echo_e().php'; ?>
<?php 
   require_once __DIR__.'/PHP/PDO/newPDO_as_getDb().php'; 
   $PDO = getDb();  //$PDOにPDOインスタンスが格納されている。
?>
<?php header("Content-Type: application/json;charset=UTF-8"); ?>
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
           WHERE cs_id<(SELECT COUNT(cs_id) FROM Concert_Schedule)-2 
           ORDER BY cs_id DESC'
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

      print json_encode($array, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);

      exit;

   } catch ( PDOException $e ){
      $error = echo_e($e);
      print $error;
   }
?>
