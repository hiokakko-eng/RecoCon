<?php require_once __DIR__."/PHP/Security/session_bootstrap.php";   /* session_start含む。 */ ?>
<?php require_once __DIR__.'/PHP/Security/regex.php'; ?>
<?php require_once __DIR__.'/PHP/htmlspecialchars_as_e()/htmlspecialchars_as_e().php'; ?>
<?php 
   //「進む」でこのページに来た場合
   if (isset($_POST['Frag_Clear'])){
      $_SESSION['BuyTicket_input'] = null;
      $_SESSION['SelectSeats'] = null;
   } 
?>
<?php 
   //購入者情報入力画面の状況を保存
   $_SESSION['BuyTicket_input'] = [

      'u_input_id' => rawurldecode($_POST['BuyTicket_u_input_id']) ?: ($_SESSION['BuyTicket_input']['u_input_id'] ?: ($_SESSION['User']['u_input_id'] ?: "guest")),
      'Name'       => rawurldecode($_POST['BuyTicket_Name'])       ?: ($_SESSION['BuyTicket_input']['Name']       ?: ($_SESSION['User']['u_name'] ?: "")),
      'Age'        => rawurldecode($_POST['BuyTicket_Age'])        ?: ($_SESSION['BuyTicket_input']['Age']        ?: ($_SESSION['User']['u_age'] ?: "")),
      'Sex'        => rawurldecode($_POST['BuyTicket_Sex'])        ?: ($_SESSION['BuyTicket_input']['Sex']        ?: ($_SESSION['User']['u_sex'] ?: "")),
      'Address1'   => rawurldecode($_POST['BuyTicket_Address1'])   ?: ($_SESSION['BuyTicket_input']['Address1']   ?: ($_SESSION['User']['u_address_1'] ?: "")),
      'Address2'   => rawurldecode($_POST['BuyTicket_Address2'])   ?: ($_SESSION['BuyTicket_input']['Address2']   ?: ($_SESSION['User']['u_address_2'] ?: "")),
      'Address3'   => rawurldecode($_POST['BuyTicket_Address3'])   ?: ($_SESSION['BuyTicket_input']['Address3']   ?: ($_SESSION['User']['u_address_3'] ?: "")),
      'Tel'        => rawurldecode($_POST['BuyTicket_Tel'])        ?: ($_SESSION['BuyTicket_input']['Tel']        ?: ($_SESSION['User']['u_tel'] ?: "")),
      'Mail'       => rawurldecode($_POST['BuyTicket_Mail'])       ?: ($_SESSION['BuyTicket_input']['Mail']       ?: ($_SESSION['User']['u_mail'] ?: "")),

   ];

   //var_dump($_POST['selectSeats_Button_state']);
   //var_dump($_SESSION['SelectSeats']);
   //var_dump($_SESSION['BuyTicket_input']);
?>
<?php
   //入力値が正規表現に適合するか確認する。
   $frag_Name;
   $frag_Age;
   $frag_Sex;
   $frag_Address1;
   $frag_Address2;
   $frag_Address3;
   $reg_Tel;
   $reg_Mail;

   $allFrag;
   $r = regex();   //正規表現配列呼び出し自作関数。
   $string_reg = [
      [
         'string' => !empty($_SESSION['BuyTicket_input']['Name']) ? $_SESSION['BuyTicket_input']['Name'] : "" ,
         'reg' => $r['Name'],
         'frag' => $frag_Name
      ],
      [
         'string' => !empty($_SESSION['BuyTicket_input']['Age']) ? $_SESSION['BuyTicket_input']['Age'] : "" ,
         'reg' => $r['Age'],
         'frag' => $frag_Age
      ],
      [
         'string' => !empty($_SESSION['BuyTicket_input']['Sex']) ? $_SESSION['BuyTicket_input']['Sex'] : "" ,
         'reg' => $r['Sex'],
         'frag' => $frag_Sex
      ],
      [
         'string' => !empty($_SESSION['BuyTicket_input']['Address1']) ? $_SESSION['BuyTicket_input']['Address1'] : "" ,
         'reg' => $r['Address1'],
         'frag' => $frag_Address1
      ],
      [
         'string' => !empty($_SESSION['BuyTicket_input']['Address2']) ? $_SESSION['BuyTicket_input']['Address2'] : "" ,
         'reg' => $r['Address2'],
         'frag' => $frag_Address2
      ],
      [
         'string' => !empty($_SESSION['BuyTicket_input']['Address3']) ? $_SESSION['BuyTicket_input']['Address3'] : "" ,
         'reg' => $r['Address3'],
         'frag' => $frag_Address3
      ],
      [
         'string' => !empty($_SESSION['BuyTicket_input']['Tel']) ? $_SESSION['BuyTicket_input']['Tel'] : "" ,
         'reg' => $r['Tel'],
         'frag' => $frag_Tel
      ],
      [
         'string' => !empty($_SESSION['BuyTicket_input']['Mail']) ? $_SESSION['BuyTicket_input']['Mail'] : "" ,
         'reg' => $r['Mail'],
         'frag' => $frag_Mail
      ],
   ];

   //判定結果OKorNGを配列$judgeに順番に格納。順番にOK、NGが格納される。
   $judge = [];

   foreach ($string_reg as ['string'=>$string, 'reg'=>$reg, 'frag'=>$frag]){
      if (preg_match($reg, $string) == 1){
         //入力値検証OK
         $frag = "OK";
         array_push($judge, $frag);
         //var_dump($string);
         //print_r("フラグOK".$frag);
      } else {
         $frag = "NG";
         array_push($judge, $frag);
         //var_dump($string);
         //print_r("フラグNG".$frag);
      }
   }
   //print_r("ジャッジ".$judge);

   //$judgeをもとに入力情報すべてに誤りがないかを確認する。
   if ($judge[0]=="OK" && $judge[1]=="OK" && $judge[2]=="OK" && $judge[3]=="OK" && $judge[4]=="OK" && $judge[5]=="OK" && $judge[6]=="OK" && $judge[7]=="OK"){
      $allFrag = "OK";
   } else {
      $allFrag = "NG";
   }

   //判定したフラグを$_SESSION['BuyTicket_input'][0]へ格納（すでに情報が入っていても、挿入された時点でのインデックスは「0」である）
   array_push($_SESSION['BuyTicket_input'], ['Button' => $allFrag]);

   //var_dump($allFrag);
   //var_dump($frag_Name);
   //var_dump($frag_Age);
   //var_dump($frag_Sex);
   //var_dump($frag_Address1);
   //var_dump($frag_Address2);
   //var_dump($frag_Address3);
   //var_dump($reg_Tel);
   //var_dump($reg_Mail);
   //var_dump($_SESSION['BuyTicket_input']);
?>
<?php require_once __DIR__.'/PHP/PDO/PDOError_as_echo_e().php'; ?>
<?php 
   require_once __DIR__.'/PHP/PDO/newPDO_as_getDb().php'; 
   $PDO = getDb();  //$PDOにPDOインスタンスが格納されている。
?>
<?php header("Content-Type: text/html;charset=UTF-8"); ?>
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
           INNER JOIN 
           Disc ON Concert_Schedule.d_id=Disc.d_id 
           WHERE cs_id=(SELECT COUNT(cs_id) 
           FROM Concert_Schedule)-2 
           ORDER BY cs_id ASC'
      );

      $PDOState -> execute();

      $i=1;

      while ($row = $PDOState -> fetch(PDO::FETCH_ASSOC)){
         $array_cs_d[$i] = [
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
            "d_path" => e($row['d_path']),

         ];
         $i++;
      }
   } catch ( PDOException $e ){ 

      //$error = echo_e($e);
      $e_message[0] = 'コンサート情報を取得できませんでした。<br>再読み込みしてください。';

   }
?>
<?php
   try {
      $PDOState = $PDO -> prepare(
          'SELECT 
               ts_id, 
               cs_id, 
               seat, 
               sale, 
               u_id, 
               g_id
           FROM Ticket_Sale
           WHERE cs_id = (
               SELECT COUNT(cs_id) FROM Concert_Schedule
           ) - 2
           ORDER BY ts_id ASC');

      $PDOState -> execute();

      $i=1;

      while ($row = $PDOState -> fetch(PDO::FETCH_ASSOC)){
         $array_seat[$i] = [
            "ts_id" => e($row['ts_id']), 
            "cs_id" => e($row['cs_id']),
            "seat" => e($row['seat']),
            "sale" => e($row['sale']),
            "u_id" => (!empty($row['u_id'])) ? e($row['u_id']) : "NULL",
            "g_id" => (!empty($row['g_id'])) ? e($row['g_id']) : "NULL",
         ];
         $i++;
      }
   } catch ( PDOException $e ){ 
      //$error = echo_e($e);
      $e_message[1] = '座席情報を取得できませんでした。<br>再読み込みしてください。';
   }
?>

      <div>

         <h2 id="MClub_title" class="title_white color_perple">予約券・当日券の購入</h2>

         <div class="title_water">
            <h1 id="MClub_title2" class="color_white">ネットでの予約券購入</h1>
            <h2 class="color_white">1/4</h2>
         </div>


         <!-- コンサート情報パート -->
         <?php
            if (isset($e_message[0])){
               ?>
                  <p class="title_white color_glay"><?php print $e_message[0]; ?></p>
               <?php
            } else {
               ?>
                  <div id="jikai">
                     <p class="littleTitle_perple color_water">次回公演</p>
                     <div id="jikai_CS">
                        <h1 class="color_water">'<?= mb_substr(str_replace('-', '.', e($array_cs_d[1]['cs_date'])), 2);?></h1>
                        <h2 class="color_water"><?= e($array_cs_d[1]['cs_composer_jn']).' : '.e($array_cs_d[1]['cs_title_jn']);?></h2>
                        <div id="jikai_time">
                           <h3 class="color_water">開場:<?= mb_substr(e($array_cs_d[1]['cs_open']), 0, 5);?></h3>
                           <h3 class="color_water">開演:<?= mb_substr(e($array_cs_d[1]['cs_start']), 0, 5);?></h3>
                        </div>
                     </div>
                  </div>
               <?php
            }
         ?>


         <!-- 座席情報パート -->
         <?php
            if (isset($e_message[1]) || isset($e_message[0])){

               ?>
                  <p class="title_white color_glay"><?php print $e_message[1]; ?></p>
               <?php

            } else {

               ?>
                  <div id="zaseki">
                     <div id="zaseki_p">
                        <p class="littleTitle_perple color_water">座席選択</p>
                     </div>


                     <div id="zaseki_seat">
                        <p class="color_water">お一人さま2席まで選択してください。</p>
                        <div class="space_11px"></div>
                        <div class="AB_CD">
                           <div class="alpha_chairs">
                              <div class="chairsA">
                                 <div class="A">A</div>
                                 <div class="chairs_numA">
                                    <?php 
                                       for ($i=1, $j=1, $k=0; $i<=3; $i++, $j++, $k++){
                                          print '<div class="chair_num">';
                                          if($array_seat[$i]['sale']==0 && $array_seat[$i]['u_id']=='NULL' && $array_seat[$i]['g_id']=='NULL'){
                                             if ($_SESSION['SelectSeats']['seat1']===(string)$k || $_SESSION['SelectSeats']['seat2']===(string)$k){ 
                                                //print_r($_SESSION);
                                                print '<img id="chairA'.$j.'" class="chair cursor" src="'.'SVG/chair_checked.svg'.'" alt="A'.$j.'">';
                                             } else {
                                                //print_r($_SESSION);
                                                print '<img id="chairA'.$j.'" class="chair cursor" src="'.'SVG/chair.svg'.'" alt="A'.$j.'">';
                                             }
                                             print '<p>'.$j.'</p>';
                                          } else {
                                             print '<img id="chairA'.$j.'_disabled" class="chair" src="'.'SVG/chair_saled.svg'.'" alt="A'.$j.'">';
                                             print '<p>'.$j.'</p>';
                                          }
                                          print '</div>';
                                       }
                                    ?>
                                 </div>
                              </div>

                              <div class="spaceAB"></div>

                              <div class="chairsB">
                                 <div class="B">B</div>
                                 <div class="chairs_numB">
                                    <?php 
                                       for ($i=4, $j=1, $k=3; $i<=6; $i++, $j++, $k++){
                                          print '<div class="chair_num">';
                                          if($array_seat[$i]['sale']==0 && $array_seat[$i]['u_id']=='NULL' && $array_seat[$i]['g_id']=='NULL'){
                                             if ($_SESSION['SelectSeats']['seat1']===(string)$k || $_SESSION['SelectSeats']['seat2']===(string)$k){ 
                                                //print_r($_SESSION);
                                                print '<img id="chairB'.$j.'" class="chair cursor" src="'.'SVG/chair_checked.svg'.'" alt="B'.$j.'">';
                                             } else {
                                                //print_r($_SESSION);
                                                print '<img id="chairB'.$j.'" class="chair cursor" src="'.'SVG/chair.svg'.'" alt="B'.$j.'">';
                                             }
                                             print '<p>'.$j.'</p>';
                                          } else {
                                             print '<img id="chairB'.$j.'_disabled" class="chair" src="'.'SVG/chair_saled.svg'.'" alt="B'.$j.'">';
                                             print '<p>'.$j.'</p>';
                                          }
                                          print '</div>';
                                       }
                                    ?>
                                 </div>
                              </div>
                           </div><!--alpha_chairsの閉じ-->

                           <div class="alpha_chairs">
                              <div class="chairsC">
                                 <div class="C">C</div>
                                 <div class="chairs_numC">
                                    <?php 
                                       for ($i=7, $j=1, $k=6; $i<=9; $i++, $j++, $k++){
                                          print '<div class="chair_num">';
                                          if($array_seat[$i]['sale']==0 && $array_seat[$i]['u_id']=='NULL' && $array_seat[$i]['g_id']=='NULL'){
                                             if ($_SESSION['SelectSeats']['seat1']===(string)$k || $_SESSION['SelectSeats']['seat2']===(string)$k){ 
                                                //print_r($_SESSION);
                                                print '<img id="chairC'.$j.'" class="chair cursor" src="'.'SVG/chair_checked.svg'.'" alt="C'.$j.'">';
                                             } else {
                                                //print_r($_SESSION);
                                                print '<img id="chairC'.$j.'" class="chair cursor" src="'.'SVG/chair.svg'.'" alt="C'.$j.'">';
                                             }
                                             print '<p>'.$j.'</p>';
                                          } else {
                                             print '<img id="chairC'.$j.'_disabled" class="chair" src="'.'SVG/chair_saled.svg'.'" alt="C'.$j.'">';
                                             print '<p>'.$j.'</p>';
                                          }
                                          print '</div>';
                                       }
                                    ?>
                                 </div>
                              </div>

                              <div class="spaceCD"></div>

                              <div class="chairsD">
                                 <div class="D">D</div>
                                 <div class="chairs_numD">
                                    <?php 
                                       for ($i=10, $j=1, $k=9; $i<=12; $i++, $j++, $k++){
                                          print '<div class="chair_num">';
                                          if($array_seat[$i]['sale']==0 && $array_seat[$i]['u_id']=='NULL' && $array_seat[$i]['g_id']=='NULL'){
                                             if ($_SESSION['SelectSeats']['seat1']===(string)$k || $_SESSION['SelectSeats']['seat2']===(string)$k){ 
                                                //print_r($_SESSION);
                                                print '<img id="chairD'.$j.'" class="chair cursor" src="'.'SVG/chair_checked.svg'.'" alt="D'.$j.'">';
                                             } else {
                                                //print_r($_SESSION);
                                                print '<img id="chairD'.$j.'" class="chair cursor" src="'.'SVG/chair.svg'.'" alt="D'.$j.'">';
                                             }
                                             print '<p>'.$j.'</p>';
                                          } else {
                                             print '<img id="chairD'.$j.'_disabled" class="chair" src="'.'SVG/chair_saled.svg'.'" alt="D'.$j.'">';
                                             print '<p>'.$j.'</p>';
                                          }
                                          print '</div>';
                                       }
                                    ?>
                                 </div>
                              </div>
                           </div><!--alpha_chairsの閉じ-->
                        </div><!-- class="AB_CD"の閉じタグ -->

                        <div class="speaker">
                           <img id="speaker" src="SVG/speaker.svg" alt="speaker">
                        </div>

                        <div class="flex_row">
                           <button id="pageBuyTicket_Buy"
                              class="<?= (isset($_SESSION['SelectSeats']['Button']) ? ($_SESSION['SelectSeats']['Button']==0 ? 'button_water color_white' : 'button_glayout color_white') : 'button_glayout color_white'); ?>"
                              <?= (isset($_SESSION['SelectSeats']['Button']) ? ($_SESSION['SelectSeats']['Button']==0 ? '' : 'disabled') : 'disabled'); ?>>
                              予約券購入へ進む
                           </button>
                        </div>
                     </div>
                  </div><!-- id="zaseki"の閉じタグ -->

               <?php   //座席の選択パートの閉じphpタグ
            }
         ?>

         <div id="tojitsu">
            <h2 id="MClub_title" class="color_water">当日券について</h2>

            <div>
               <p class="p_justify">当日券購入は、Reco.Con.会場まで直接お越しください。<br>※なお、当日券につき、ご来場の時点でチケットが完売している場合も考えられます。ご来場をご検討の際は、Reco.Con.事務局までお問い合わせいただくと幸甚です。
               <p>Reco.Con.事務局（担当: 後藤080-6115-5811）</p>
               <h3>当日券（1席）税込<span>550</span>円</h2>
            </div>

         </div>

         <div class="backMark">
            <a id="toTop" class="toTop" href="RecoCon_TOP_XAMPP.php"><img src="SVG/back.svg" alt="back"></a>
         </div>

      </div>




