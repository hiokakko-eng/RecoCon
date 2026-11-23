<?php require_once __DIR__."/PHP/Security/session_bootstrap.php";   /* session_start含む。 */ ?>
<?php header("Content-Type: text/html;charset=UTF-8"); ?>
<?php require_once __DIR__.'/PHP/Security/csrf.php'; ?>
<?php require_once __DIR__.'/PHP/Security/regex.php'; ?>
<?php require_once __DIR__.'/PHP/htmlspecialchars_as_e()/htmlspecialchars_as_e().php'; ?>
<?php 
   $_SESSION['Create_Acct'] = [
      'U_Input_Id' => rawurldecode($_POST['U_Input_Id']) ?: ($_SESSION['Create_Acct']['U_Input_Id'] ?: ""),
      'Pass'       => rawurldecode($_POST['Pass'])       ?: ($_SESSION['Create_Acct']['Pass']       ?: ""),
      'Name'       => rawurldecode($_POST['Name'])       ?: ($_SESSION['Create_Acct']['Name']       ?: ""),
      'Age'        => rawurldecode($_POST['Age'])        ?: ($_SESSION['Create_Acct']['Age']        ?: ""),
      'Sex'        => rawurldecode($_POST['Sex'])        ?: ($_SESSION['Create_Acct']['Sex']        ?: ""),
      'Address1'   => rawurldecode($_POST['Address1'])   ?: ($_SESSION['Create_Acct']['Address1']   ?: ""),
      'Address2'   => rawurldecode($_POST['Address2'])   ?: ($_SESSION['Create_Acct']['Address2']   ?: ""),
      'Address3'   => rawurldecode($_POST['Address3'])   ?: ($_SESSION['Create_Acct']['Address3']   ?: ""),
      'Tel'        => rawurldecode($_POST['Tel'])        ?: ($_SESSION['Create_Acct']['Tel']        ?: ""),
      'Mail'       => rawurldecode($_POST['Mail'])       ?: ($_SESSION['Create_Acct']['Mail']       ?: ""),
   ];
?>
<?php
   $allFrag;
   $r = regex();   //正規表現配列呼び出し自作関数。
   $string_reg = [
      [
         'string' => !empty($_SESSION['Create_Acct']['U_Input_Id']) ? $_SESSION['Create_Acct']['U_Input_Id'] : "" ,
         'reg'    => $r['Id'],
         'frag'   => $frag_U_Input_Id
      ],
      [
         'string' => !empty($_SESSION['Create_Acct']['Pass']) ? $_SESSION['Create_Acct']['Pass'] : "" ,
         'reg'    => $r['Password'],
         'frag'   => $frag_Pass
      ],
      [
         'string' => !empty($_SESSION['Create_Acct']['Name']) ? $_SESSION['Create_Acct']['Name'] : "" ,
         'reg'    => $r['Name'],
         'frag'   => $frag_Name
      ],
      [
         'string' => !empty($_SESSION['Create_Acct']['Age']) ? $_SESSION['Create_Acct']['Age'] : "" ,
         'reg'    => $r['Age'],
         'frag'   => $frag_Age
      ],
      [
         'string' => !empty($_SESSION['Create_Acct']['Sex']) ? $_SESSION['Create_Acct']['Sex'] : "" ,
         'reg'    => $r['Sex'],
         'frag'   => $frag_Sex
      ],
      [
         'string' => !empty($_SESSION['Create_Acct']['Address1']) ? $_SESSION['Create_Acct']['Address1'] : "" ,
         'reg'    => $r['Address1'],
         'frag'   => $frag_Address1
      ],
      [
         'string' => !empty($_SESSION['Create_Acct']['Address2']) ? $_SESSION['Create_Acct']['Address2'] : "" ,
         'reg'    => $r['Address2'],
         'frag'   => $frag_Address2
      ],
      [
         'string' => !empty($_SESSION['Create_Acct']['Address3']) ? $_SESSION['Create_Acct']['Address3'] : "" ,
         'reg'    => $r['Address3'],
         'frag'   => $frag_Address3
      ],
      [
         'string' => !empty($_SESSION['Create_Acct']['Tel']) ? $_SESSION['Create_Acct']['Tel'] : "" ,
         'reg'    => $r['Tel'],
         'frag'   => $frag_Tel
      ],
      [
         'string' => !empty($_SESSION['Create_Acct']['Mail']) ? $_SESSION['Create_Acct']['Mail'] : "" ,
         'reg'    => $r['Mail'],
         'frag'   => $frag_Mail
      ],
   ];

   $judge = [];

   foreach ($string_reg as ['string'=>$string, 'reg'=>$reg, 'frag'=>$frag]){
      if (preg_match($reg, $string) == 1){

         //入力値検証OK
         $frag = "OK";
         array_push($judge, $frag);

      } else {

         $frag = "NG";
         array_push($judge, $frag);

      }
   }

   if (
      $judge[0]=="OK" && $judge[1]=="OK" && $judge[2]=="OK" && $judge[3]=="OK" && $judge[4]=="OK" && 
      $judge[5]=="OK" && $judge[6]=="OK" && $judge[7]=="OK" && $judge[8]=="OK" && $judge[9]=="OK"
   ){

      $allFrag = "OK";

   } else {

      $allFrag = "NG";

   }

   array_push($_SESSION['Create_Acct'], ['Button' => $allFrag]);

?>


<!--以下、HTML-->

<div>

   <h2 id="MClub_title" class="title_white color_perple">Reco.Con.メンバーズクラブ</h2>
   <h2 id="MClub_message" class="title_glay color_pink">入力内容をご確認ください。</h2>

   <div class="space_white">

      <div class="flex_column">

         <div>

            <input type="hidden" id="token" value="<?= e(recoConCsrfToken()); ?>">

            <p><お客さま情報></p>

            <table class="table_general">

               <tr>
                  <th>ID</th>
                  <td id="MClub_createAcct_confirm_Id"><?= e($_SESSION['Create_Acct']['U_Input_Id']); ?></td>
               </tr>

               <tr>
                  <th>パスワード</th>
                  <td id="MClub_createAcct_confirm_Pass">*****</td>
               </tr>

               <tr>
                  <th>お名前</th>
                  <td id="MClub_createAcct_confirm_Name"><?= e($_SESSION['Create_Acct']['Name']); ?></td>
               </tr>

               <tr>
                  <th>年　齢</th>
                  <td id="MClub_createAcct_confirm_Age"><?= e($_SESSION['Create_Acct']['Age']); ?></td>
               </tr>

               <tr>
                  <th>性　別</th>
                  <td id="MClub_createAcct_confirm_Sex"><?= e($_SESSION['Create_Acct']['Sex']); ?></td>
               </tr>

               <tr>
                  <th>都道府県</th>
                  <td id="MClub_createAcct_confirm_Address1"><?= e($_SESSION['Create_Acct']['Address1']); ?></td>
               </tr>

               <tr>
                  <th>市区町村</th>
                  <td id="MClub_createAcct_confirm_Address2"><?= e($_SESSION['Create_Acct']['Address2']); ?></td>
               </tr>

               <tr>
                  <th>番地以下</th>
                  <td id="MClub_createAcct_confirm_Address3"><?= e($_SESSION['Create_Acct']['Address3']); ?></td>
               </tr>

               <tr>
                  <th>電話番号</th>
                  <td id="MClub_createAcct_confirm_Tel"><?= e($_SESSION['Create_Acct']['Tel']); ?></td>
               </tr>

               <tr>
                  <th>メールアドレス</th>
                  <td id="MClub_createAcct_confirm_Mail"><?= e($_SESSION['Create_Acct']['Mail']); ?></td>
               </tr>

            </table>

         </div>

      </div>

      <div class="space_11px"></div>

      <div class="flex_row">
         <button id="MClub_createAcct_confirm_cofirm_confirm" 
            class="<?= $_SESSION['Create_Acct'][0]['Button']=='OK' ? 'button_pink color_white' : 'button_glayout color_white';?>"
            <?= $_SESSION['Create_Acct'][0]['Button']=='OK' ? '' : 'disabled';?>>確定</button>
         <button id="pageMClub_createAcct_confirm_back" class="button_glay color_white">修正する</button>
      </div>

</div>

   <div class="backMark">
      <a id="toTop" class="toTop" href="RecoCon_TOP_XAMPP.php"><img src="SVG/back.svg" alt="back"></a>
   </div>

</div>
