<?php require_once __DIR__."/PHP/Security/session_bootstrap.php";   /* session_start含む。 */ ?>
<?php require_once __DIR__.'/PHP/Security/csrf.php'; ?>
<?php require_once __DIR__.'/PHP/Security/regex.php'; ?>
<?php require_once __DIR__.'/PHP/htmlspecialchars_as_e()/htmlspecialchars_as_e().php'; ?>
<?php 
   //購入者情報入力画面の状況
   $_SESSION['BuyTicket_input'] = [

      'u_input_id' => rawurldecode($_POST['BuyTicket_u_input_id']) ?: ($_SESSION['BuyTicket_input']['u_input_id'] ?: ($_SESSION['User']['u_input_id']  ?: "guest")),
      'Name'       => rawurldecode($_POST['BuyTicket_Name'])       ?: ($_SESSION['BuyTicket_input']['Name']       ?: ($_SESSION['User']['u_name']      ?: "")),
      'Age'        => rawurldecode($_POST['BuyTicket_Age'])        ?: ($_SESSION['BuyTicket_input']['Age']        ?: ($_SESSION['User']['u_age']       ?: "")),
      'Sex'        => rawurldecode($_POST['BuyTicket_Sex'])        ?: ($_SESSION['BuyTicket_input']['Sex']        ?: ($_SESSION['User']['u_sex']       ?: "")),
      'Address1'   => rawurldecode($_POST['BuyTicket_Address1'])   ?: ($_SESSION['BuyTicket_input']['Address1']   ?: ($_SESSION['User']['u_address_1'] ?: "")),
      'Address2'   => rawurldecode($_POST['BuyTicket_Address2'])   ?: ($_SESSION['BuyTicket_input']['Address2']   ?: ($_SESSION['User']['u_address_2'] ?: "")),
      'Address3'   => rawurldecode($_POST['BuyTicket_Address3'])   ?: ($_SESSION['BuyTicket_input']['Address3']   ?: ($_SESSION['User']['u_address_3'] ?: "")),
      'Tel'        => rawurldecode($_POST['BuyTicket_Tel'])        ?: ($_SESSION['BuyTicket_input']['Tel']        ?: ($_SESSION['User']['u_tel']       ?: "")),
      'Mail'       => rawurldecode($_POST['BuyTicket_Mail'])       ?: ($_SESSION['BuyTicket_input']['Mail']       ?: ($_SESSION['User']['u_mail']      ?: "")),

   ];

   //var_dump($_POST['selectSeats_Button_state']);
   //var_dump($_SESSION['SelectSeats']);
   //var_dump($_SESSION['BuyTicket_input']);
?>
<?php
   //入力値が制御文字以外であることを確認する。
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

   if ($judge[0]=="OK" && $judge[1]=="OK" && $judge[2]=="OK" && $judge[3]=="OK" && $judge[4]=="OK" && $judge[5]=="OK" && $judge[6]=="OK" && $judge[7]=="OK"){
      $allFrag = "OK";
   } else {
      $allFrag = "NG";
   }

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
<?php header("Content-Type: text/html;charset=UTF-8"); ?>


<div>

   <input type="hidden" id="token" value="<?= e(recoConCsrfToken()); ?>">   <!--CSRF対策のトークン埋め込み-->

   <h2 id="MClub_title" class="title_white color_perple">予約券・当日券の購入</h2>

   <div class="title_water">
      <h1 id="MClub_title2" class="color_white">ネットでの予約券購入</h1>
      <h2 class="color_white">3/4</h2>
   </div>

   <h2 id="MClub_message" class="title_glay color_water">ご予約内容をご確認ください。</h2>

   <div class="space_white flex_column">

      <div>

      <p>ご購入チケット内容</p>

      <table class="table_general">

         <tr>
            <th>日　時</th>
            <td>
               開催日 : '<?= mb_substr(str_replace('-', '.', e($array_cs_d[1]['cs_date'])), 2);?><br>
               開　場 : <?= mb_substr(e($array_cs_d[1]['cs_open']), 0, 5);?><br>
               開　演 : <?= mb_substr(e($array_cs_d[1]['cs_start']), 0, 5);?>
             </td>
         </tr>

         <tr>
            <th>曲　目</th>
            <td><?= e($array_cs_d[1]['cs_composer_jn']).' : '.e($array_cs_d[1]['cs_title_jn']);?></td>
         </tr>

         <tr>
            <th>座　席</th>
            <td>
            <?php 
 
               $s1;

               switch ($_SESSION['SelectSeats']['seat1']){

                  case "0":
                     print "A-1";
                     $s1 = "A-1";
                     break;
                  case "1":
                     print "A-2";
                     $s1 = "A-2";
                     break;
                  case "2":
                     print "A-3";
                     $s1 = "A-3";
                     break;
                  case "3":
                     print "B-1";
                     $s1 = "B-1";
                     break;
                  case "4":
                     print "B-2";
                     $s1 = "B-2";
                     break;
                  case "5":
                     print "B-3";
                     $s1 = "B-3";
                     break;
                  case "6":
                     print "C-1";
                     $s1 = "C-1";
                     break;
                  case "7":
                     print "C-2";
                     $s1 = "C-2";
                     break;
                  case "8":
                     print "C-3";
                     $s1 = "C-3";
                     break;
                  case "9":
                     print "D-1";
                     $s1 = "D-1";
                     break;
                  case "10":
                     print "D-2";
                     $s1 = "D-2";
                     break;
                  case "11":
                     print "D-3";
                     $s1 = "D-3";
                     break;
                  default:
                     break;

               }
            ?>
            <?php 

               $s2;

               if (!($_SESSION['SelectSeats']['seat1'] == $_SESSION['SelectSeats']['seat2'])){
                  switch ($_SESSION['SelectSeats']['seat2']){

                    case "0":
                        print "A-1";
                        $s2 = "A-1";
                        break;
                     case "1":
                        print "A-2";
                        $s2 = "A-2";
                        break;
                     case "2":
                        print "A-3";
                        $s2 = "A-3";
                        break;
                     case "3":
                        print "B-1";
                        $s2 = "B-1";
                        break;
                     case "4":
                        print "B-2";
                        $s2 = "B-2";
                        break;
                     case "5":
                        print "B-3";
                        $s2 = "B-3";
                        break;
                     case "6":
                        print "C-1";
                        $s2 = "C-1";
                        break;
                     case "7":
                        print "C-2";
                        $s2 = "C-2";
                        break;
                     case "8":
                        print "C-3";
                        $s2 = "C-3";
                        break;
                     case "9":
                        print "D-1";
                        $s2 = "D-1";
                        break;
                     case "10":
                        print "D-2";
                        $s2 = "D-2";
                        break;
                     case "11":
                        print "D-3";
                        $s2 = "D-3";
                        break;
                     default:
                        $s2 = NULL;
                        break;

                  }
               }
            ?>
            </td>
         </tr>

         <tr>
            <th>価　格</th>

            <?php
               try {
                  $PDOState = $PDO -> prepare('SELECT * FROM Ticket ORDER BY seat ASC');

                  $PDOState -> execute();

                  $i=0;

                  while ($row = $PDOState -> fetch(PDO::FETCH_ASSOC)){
                     $array[$i] = [
                        "seat" => e($row['seat']), 
                        "price" => (int)e($row['price']),
                        "tax" => (int)e($row['tax']),
                        "price_tax" => (int)e($row['price_tax']),
                     ];
                     $i++;
                  }
               ?>

               <td>
                  <?php 

                     $p1 = $array[$_SESSION['SelectSeats']['seat1']]['price'];
                     $p1_tax = $array[$_SESSION['SelectSeats']['seat1']]['price_tax'];
                     $p2 = $array[$_SESSION['SelectSeats']['seat2']]['price'];
                     $p2_tax = $array[$_SESSION['SelectSeats']['seat2']]['price_tax'];

                     ?>

                        <div><?= '[' . $s1 . ']' . e($p1) . '円（税込' . e($p1_tax) . '円)' ; ?></div>
                        <div><?= !($s2==NULL) ? '[' . $s2 . ']' . e($p2) . '円（税込' . e($p2_tax) . '円)' : '' ; ?></div>

                        <div style="text-align: right">合計:<?= !($s2==NULL) ? (e($p1)+e($p2)) . '円' : e($p1) . '円' ; ?><?= !($s2==NULL) ? '（税込' . (e($p1_tax)+e($p2_tax)) . '円）' : '（税込' . e($p1_tax) . '円）' ; ?></div>

                     <?php

                  ?>
               </td>

            <?php
               } catch ( PDOException $e ){ 
                  //$error = echo_e($e);
                  $e_message[1] = '価格情報を取得できませんでした。<br>再読み込みしてください。';
               }
            ?>

         </tr>

      </table>

      </div>

      <div class="space_55px"></div>

      <div>

      <p>お客さま情報</p>

      <table class="table_general">

         <tr>
            <th>ID</th>
            <td id="MClub_createAcct_confirm_Id">
               <?php 
                  if (!empty($_SESSION['User']['u_id'])){ 
                     echo e($_SESSION['User']['u_input_id']);
                  } else {
                     echo "Guest";
                  } 
               ?>
            </td>
         </tr>

         <tr>
            <th>お名前</th>
            <td id="MClub_createAcct_confirm_Name"><?= e($_SESSION['BuyTicket_input']['Name']) ?></td>
         </tr>

         <tr>
            <th>年　齢</th>
            <td id="MClub_createAcct_confirm_Age"><?= e($_SESSION['BuyTicket_input']['Age']) ?></td>
         </tr>

         <tr>
            <th>性　別</th>
            <td id="MClub_createAcct_confirm_Sex"><?= e($_SESSION['BuyTicket_input']['Sex']) ?></td>
         </tr>

         <tr>
            <th>都道府県</th>
            <td id="MClub_createAcct_confirm_Address1"><?= e($_SESSION['BuyTicket_input']['Address1']) ?></td>
         </tr>

         <tr>
            <th>市区町村</th>
            <td id="MClub_createAcct_confirm_Address2"><?= e($_SESSION['BuyTicket_input']['Address2']) ?></td>
         </tr>

         <tr>
            <th>番地以下</th>
            <td id="MClub_createAcct_confirm_Address3"><?= e($_SESSION['BuyTicket_input']['Address3']) ?></td>
         </tr>

         <tr>
            <th>電話番号</th>
            <td id="MClub_createAcct_confirm_Tel"><?= e($_SESSION['BuyTicket_input']['Tel']) ?></td>
         </tr>

         <tr>
            <th>メールアドレス</th>
            <td id="MClub_createAcct_confirm_Mail"><?= e($_SESSION['BuyTicket_input']['Mail']) ?></td>
         </tr>

      </table>

      </div>



      <div class="space_11px"></div>

      <div class="flex_row">
         <button id="pageBuyTicket_input_confirm_confirm" class="button_water color_white">確定</button>
         <button id="pageBuyTicket_input_confirm_back" class="button_glay color_white">修正する</button>
      </div>

   </div>

   <div class="backMark">
      <a id="toTop" class="toTop" href="RecoCon_TOP_XAMPP.php"><img src="SVG/back.svg" alt="back"></a>
   </div>

</div>



