<?php require_once __DIR__."/PHP/Security/session_bootstrap.php";   /* session_start含む。 */ ?>
<?php header("Content-Type: text/html;charset=UTF-8"); ?>
<?php require_once __DIR__.'/PHP/Security/regex.php'; ?>
<?php require_once __DIR__.'/PHP/htmlspecialchars_as_e()/htmlspecialchars_as_e().php'; ?>
<?php 
   //「進む」でこのページに来た場合
   if (isset($_POST['createAcct_Frag_Clear'])){
      $_SESSION['Create_Acct'] = null;
   } 
?>
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

   <h2 id="MClub_message" class="title_glay color_pink">お客さま情報を情報を入力してください。</h2>

   <div class="space_white flex_column">

      <div class="space_55px"></div>

      <div class="input_attension_space">
         <p>ID（12〜16文字・半角英数・アンダースコア）</p>
         <div>
            <input type="text" id="MClub_createAcct_U_Input_Id" value="<?= e($_SESSION['Create_Acct']['U_Input_Id']) ?: ''; ?>" maxlength="16">
         </div>
         <p id="MClub_createAcct_U_Input_Id_check" style="color:rgb(250, 78, 174)">
            <?= $judge[0]=='NG' ? ($_SESSION['Create_Acct']['u_input_id']=="" ? '※入力してください。' : '※正しく入力してください。') : ''; ?>
         </p>
      </div>

      <div class="input_attension_space">
         <p>パスワード（12〜128文字・文字種の制限なし）</p>
         <div>
            <input id="MClub_createAcct_Pass" type="password" value="<?= e($_SESSION['Create_Acct']['Pass']) ?: ''; ?>" maxlength="128">
         </div>
         <p id="MClub_createAcct_Pass_check" style="color:rgb(250, 78, 174)">
            <?= $judge[1]=='NG' ? ($_SESSION['Create_Acct']['Pass']=="" ? '※入力してください。' : '※正しく入力してください。') : ''; ?>
         </p>
      </div>

      <div class="input_attension_space">
         <p>お名前</p>
         <div>
            <input id="MClub_createAcct_Name" value="<?= e($_SESSION['Create_Acct']['Name']) ?: ''; ?>" maxlength="50">
         </div>
         <p id="MClub_createAcct_Name_check" style="color:rgb(250, 78, 174)">
            <?= $judge[2]=='NG' ? ($_SESSION['Create_Acct']['Name']=="" ? '※入力してください。' : '※正しく入力してください。') : ''; ?>
         </p>
      </div>

      <div class="input_attension_space">
         <p>年齢</p>
         <div>
            <input id="MClub_createAcct_Age" value="<?= e($_SESSION['Create_Acct']['Age']) ?: ''; ?>" maxlength="3">
         </div>
         <p id="MClub_createAcct_Age_check" style="color:rgb(250, 78, 174)">
            <?= $judge[3]=='NG' ? ($_SESSION['Create_Acct']['Age']=="" ? '※入力してください。' : '※正しく入力してください。') : ''; ?>
         </p>
      </div>

      <div class="input_attension_space">
         <p>性別（男または女）</p>
         <div>
            <input id="MClub_createAcct_Sex" value="<?= e($_SESSION['Create_Acct']['Sex']) ?: ''; ?>" maxlength="10">
         </div>
         <p id="MClub_createAcct_Sex_check" style="color:rgb(250, 78, 174)">
            <?= $judge[4]=='NG' ? ($_SESSION['Create_Acct']['Sex']=="" ? '※入力してください。' : '※正しく入力してください。') : ''; ?>
         </p>
      </div>

      <div  class="input_attension_space">
         <p>ご住所（都道府県）</p>
         <div>
            <input id="MClub_createAcct_Address1" value="<?= e($_SESSION['Create_Acct']['Address1']) ?: ''; ?>" maxlength="10">
         </div>
         <p id="MClub_createAcct_Address1_check" style="color:rgb(250, 78, 174)">
            <?= $judge[5]=='NG' ? ($_SESSION['Create_Acct']['Address1']=="" ? '※入力してください。' : '※正しく入力してください。') : ''; ?>
         </p>
      </div>

      <div class="input_attension_space">
         <p>ご住所（市区町村）</p>
         <div>
            <input id="MClub_createAcct_Address2" value="<?= e($_SESSION['Create_Acct']['Address2']) ?: ''; ?>" maxlength="25">
         </div>
         <p id="MClub_createAcct_Address2_check" style="color:rgb(250, 78, 174)">
            <?= $judge[6]=='NG' ? ($_SESSION['Create_Acct']['Address2']=="" ? '※入力してください。' : '※正しく入力してください。') : ''; ?>
         </p>
      </div>

      <div class="input_attension_space">
         <p>ご住所（番地以下）</p>
         <div>
            <input id="MClub_createAcct_Address3" value="<?= e($_SESSION['Create_Acct']['Address3']) ?: ''; ?>" maxlength="50">
         </div>
         <p id="MClub_createAcct_Address3_check" style="color:rgb(250, 78, 174)">
            <?= $judge[7]=='NG' ? ($_SESSION['Create_Acct']['Address3']=="" ? '※入力してください。' : '※正しく入力してください。') : ''; ?>
         </p>
      </div>

      <div class="input_attension_space">
         <p>電話番号（ハイフン必須）</p>
         <div>
            <input id="MClub_createAcct_Tel" value="<?= e($_SESSION['Create_Acct']['Tel']) ?: ''; ?>" maxlength="13">
         </div>
         <p id="MClub_createAcct_Tel_check" style="color:rgb(250, 78, 174)">
            <?= $judge[8]=='NG' ? ($_SESSION['Create_Acct']['Tel']=="" ? '※入力してください。' : '※正しく入力してください。') : ''; ?>
         </p>
      </div>

      <div class="input_attension_space">
         <p>メールアドレス</p>
         <div>
            <input id="MClub_createAcct_Mail" value="<?= e($_SESSION['Create_Acct']['Mail']) ?: ''; ?>" maxlength="50">
         </div>
         <p id="MClub_createAcct_Mail_check" style="color:rgb(250, 78, 174)">
            <?= $judge[9]=='NG' ? ($_SESSION['Create_Acct']['Mail']=="" ? '※入力してください。' : '※正しく入力してください。') : ''; ?>
         </p>
      </div>

      <div class="space_11px"></div>

      <div class="flex_row">
         <button type="button" id="MClub_createAcct_next" 
            class="<?= $_SESSION['Create_Acct'][0]['Button']=='OK' ? 'button_pink color_white' : 'button_glayout color_white';?>" 
            <?= $_SESSION['Create_Acct'][0]['Button']=='OK' ? '' : 'disabled';?>>進む
         </button>

         <button type="button" id="pageMClub_createAcct_back" class="button_glay color_white">戻る</button>
      </div>

   </div>

   <div class="backMark">
      <a id="toTop" class="toTop" href="RecoCon_TOP_XAMPP.php"><img src="SVG/back.svg" alt="back"></a>
   </div>

</div>
