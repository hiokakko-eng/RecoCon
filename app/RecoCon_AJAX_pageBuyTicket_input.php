<?php require_once __DIR__."/PHP/Security/session_bootstrap.php";   /* session_start含む。 */ ?>
<?php require_once __DIR__.'/PHP/Security/regex.php'; ?>
<?php header("Content-Type: text/html;charset=UTF-8"); ?>
<?php require_once __DIR__.'/PHP/htmlspecialchars_as_e()/htmlspecialchars_as_e().php'; ?>
<?php  //座席の選択状況、入力状況、進む戻るボタンの状態を保存。
   //シート選択画面の状況
   $_SESSION['SelectSeats'] = [
      'seat1'  => isset($_POST['seat1']) ? $_POST['seat1'] : $_SESSION['SelectSeats']['seat1'],
      'seat2'  => isset($_POST['seat2']) ? $_POST['seat2'] : $_SESSION['SelectSeats']['seat2'],
      'Button' => isset($_POST['selectSeats_Button_state']) ? $_POST['selectSeats_Button_state'] : $_SESSION['SelectSeats']['Button'],
   ];
?>
<?php
   //ログイン判定
   $isMember = !empty($_SESSION['User']['u_id']);

   //ゲストユーザーのとき編集内容を保存。
   //POSTがあればその値を使う。なければSESSIONの値を使う。入力フォームで往来しても値を保持する処理。
   $oldInput = $_SESSION['BuyTicket_input'] ?? [];
   $postName = $_POST['BuyTicket_Name'] ?? null;
   $postAge = $_POST['BuyTicket_Age'] ?? null;
   $postSex = $_POST['BuyTicket_Sex'] ?? null;
   $postAddress1 = $_POST['BuyTicket_Address1'] ?? null;
   $postAddress2 = $_POST['BuyTicket_Address2'] ?? null;
   $postAddress3 = $_POST['BuyTicket_Address3'] ?? null;
   $postTel = $_POST['BuyTicket_Tel'] ?? null;
   $postMail = $_POST['BuyTicket_Mail'] ?? null;

   $_SESSION['BuyTicket_input'] = [
      'u_input_id' => 'guest',
      'Name' => isset($postName) ? rawurldecode($postName) : ($oldInput['Name'] ?? ''),
      'Age' => isset($postAge) ? rawurldecode($postAge) : ($oldInput['Age'] ?? ''),
      'Sex' => isset($postSex) ? rawurldecode($postSex) : ($oldInput['Sex'] ?? ''),
      'Address1' => isset($postAddress1) ? rawurldecode($postAddress1) : ($oldInput['Address1'] ?? ''),
      'Address2' => isset($postAddress2) ? rawurldecode($postAddress2) : ($oldInput['Address2'] ?? ''),
      'Address3' => isset($postAddress3) ? rawurldecode($postAddress3) : ($oldInput['Address3'] ?? ''),
      'Tel' => isset($postTel) ? rawurldecode($postTel) : ($oldInput['Tel'] ?? ''),
      'Mail' => isset($postMail) ? rawurldecode($postMail) : ($oldInput['Mail'] ?? ''),
   ];

   //ログインユーザーのときセッションの値に書き換える。
   if ($isMember){
      $_SESSION['BuyTicket_input'] = [
         'u_input_id' => (string)$_SESSION['User']['u_id']  ?? '',
         'Name'       => $_SESSION['User']['u_name']        ?? '',
         'Age'        => $_SESSION['User']['u_age']         ?? '',
         'Sex'        => $_SESSION['User']['u_sex']         ?? '',
         'Address1'   => $_SESSION['User']['u_address_1']   ?? '',
         'Address2'   => $_SESSION['User']['u_address_2']   ?? '',
         'Address3'   => $_SESSION['User']['u_address_3']   ?? '',
         'Tel'        => $_SESSION['User']['u_tel']         ?? '',
         'Mail'       => $_SESSION['User']['u_mail']        ?? '',
      ];
   }
?>
<?php
   $allFrag;
   $r = regex();   //正規表現配列呼び出し自作関数。
   $string_reg = [
      [
         'string' => !empty($_SESSION['BuyTicket_input']['Name']) ? $_SESSION['BuyTicket_input']['Name'] : "" ,
         'reg'    => $r['Name'],
         'frag'   => $frag_Name
      ],
      [
         'string' => !empty($_SESSION['BuyTicket_input']['Age']) ? $_SESSION['BuyTicket_input']['Age'] : "" ,
         'reg'    => $r['Age'],
         'frag'   => $frag_Age
      ],
      [
         'string' => !empty($_SESSION['BuyTicket_input']['Sex']) ? $_SESSION['BuyTicket_input']['Sex'] : "" ,
         'reg'    => $r['Sex'], 
         'frag'   => $frag_Sex
      ],
      [
         'string' => !empty($_SESSION['BuyTicket_input']['Address1']) ? $_SESSION['BuyTicket_input']['Address1'] : "" ,
         'reg'    => $r['Address1'], 
         'frag'   => $frag_Address1
      ],
      [
         'string' => !empty($_SESSION['BuyTicket_input']['Address2']) ? $_SESSION['BuyTicket_input']['Address2'] : "" ,
         'reg'    => $r['Address2'], 
         'frag'   => $frag_Address2
      ],
      [
         'string' => !empty($_SESSION['BuyTicket_input']['Address3']) ? $_SESSION['BuyTicket_input']['Address3'] : "" ,
         'reg'    => $r['Address3'],
         'frag'   => $frag_Address3
      ],
      [
         'string' => !empty($_SESSION['BuyTicket_input']['Tel']) ? $_SESSION['BuyTicket_input']['Tel'] : "" ,
         'reg'    => $r['Tel'],
         'frag'   => $frag_Tel
      ],
      [
         'string' => !empty($_SESSION['BuyTicket_input']['Mail']) ? $_SESSION['BuyTicket_input']['Mail'] : "" ,
         'reg'    => $r['Mail'],
         'frag'   => $frag_Mail
      ],
   ];

   //判定結果OKorNGを配列$judgeに順番に格納。順番にOK、NGが格納される。
   $judge = [];

   foreach ($string_reg as ['string'=>$string, 'reg'=>$reg, 'frag'=>$frag]){
      if (preg_match($reg, $string) == 1 && !$string == ''){
         //入力値検証OK
         $frag = "OK";
         array_push($judge, $frag);
      } else {
         $frag = "NG";
         array_push($judge, $frag);
      }
   }

   //$judgeをもとに入力情報すべてに誤りがないかを確認する。
   if (
      $judge[0]=="OK" && $judge[1]=="OK" && $judge[2]=="OK" && $judge[3]=="OK" && 
      $judge[4]=="OK" && $judge[5]=="OK" && $judge[6]=="OK" && $judge[7]=="OK"
   ){
      $allFrag = "OK";
   } else {
      $allFrag = "NG";
   }

   //判定したフラグを$_SESSION['BuyTicket_input'][0]へ格納（すでに情報が入っていても、挿入された時点でのインデックスは「0」である）
   array_push($_SESSION['BuyTicket_input'], ['Button' => $allFrag]);
?>

<!--以下、HTML-->


<div>

   <h2 id="MClub_title" class="title_white color_perple">予約券・当日券の購入</h2>

   <div class="title_water">
      <h1 id="MClub_title2" class="color_white">ネットでの予約券購入</h1>
      <h2 class="color_white">2/4</h2>
   </div>

   <h2 id="MClub_message" class="title_glay color_water">
      <?= $isMember ? 'ご登録情報をご確認ください。' : 'お客さま情報をご入力ください。';?>
   </h2>

   <div class="space_white flex_column">

      <div class="space_55px"></div>

      <div><input id="BuyTicket_u_input_id" type="hidden" value="<?= e($_SESSION['BuyTicket_input']['u_input_id']); ?>"></div>

      <div class="input_attension_space">
         <p>お名前</p>
         <div>
            <input id="BuyTicket_Name" value="<?= e($_SESSION['BuyTicket_input']['Name']); ?>" maxlength="50" <?= $isMember ? 'readonly' : ''; ?>>
         </div>
         <p id="BuyTicket_Name_check" style="color:rgb(255, 60 ,60)">
            <?= $judge[0]=='NG' ? ($_SESSION['BuyTicket_input']['Name']=="" ? '※入力してください。' : '※正しく入力してください。') : ''; ?>
         </p>
      </div>

      <div class="input_attension_space">
         <p>年齢</p>
         <div>
            <input id="BuyTicket_Age" value="<?= e($_SESSION['BuyTicket_input']['Age']); ?>" maxlength="3" <?= $isMember ? 'readonly' : ''; ?>>
         </div>
         <p id="BuyTicket_Age_check" style="color:rgb(255, 60 ,60)">
            <?= $judge[1]=='NG' ? ($_SESSION['BuyTicket_input']['Age']=="" ? '※入力してください。' : '※正しく入力してください。') : ''; ?>
         </p>
      </div>

      <div class="input_attension_space">
         <p>性別（男または女）</p>
         <div>
            <input id="BuyTicket_Sex" value="<?= e($_SESSION['BuyTicket_input']['Sex']); ?>" maxlength="10" <?= $isMember ? 'readonly' : ''; ?>>
         </div>
         <p id="BuyTicket_Sex_check" style="color:rgb(255, 60 ,60)">
            <?= $judge[2]=='NG' ? ($_SESSION['BuyTicket_input']['Sex']=="" ? '※入力してください。' : '※正しく入力してください。') : ''; ?>
         </p>
      </div>

      <div class="input_attension_space">
         <p>ご住所（都道府県）</p>
         <div>
            <input id="BuyTicket_Address1" value="<?= e($_SESSION['BuyTicket_input']['Address1']); ?>" maxlength="10" <?= $isMember ? 'readonly' : ''; ?>>
         </div>
         <p id="BuyTicket_Address1_check" style="color:rgb(255, 60 ,60)">
            <?= $judge[3]=='NG' ? ($_SESSION['BuyTicket_input']['Address1']=="" ? '※入力してください。' : '※正しく入力してください。') : ''; ?>
         </p>
      </div>

      <div class="input_attension_space">
         <p>ご住所（市区町村）</p>
         <div>
            <input id="BuyTicket_Address2" value="<?= e($_SESSION['BuyTicket_input']['Address2']); ?>" maxlength="25" <?= $isMember ? 'readonly' : ''; ?>>
         </div>
         <p id="BuyTicket_Address2_check" style="color:rgb(255, 60 ,60)">
            <?= $judge[4]=='NG' ? ($_SESSION['BuyTicket_input']['Address2']=="" ? '※入力してください。' : '※正しく入力してください。') : ''; ?>
         </p>
      </div>

      <div class="input_attension_space">
         <p>ご住所（番地以下）</p>
         <div>
            <input id="BuyTicket_Address3" value="<?= e($_SESSION['BuyTicket_input']['Address3']); ?>" maxlength="50" <?= $isMember ? 'readonly' : ''; ?>>
         </div>
         <p id="BuyTicket_Address3_check" style="color:rgb(255, 60 ,60)">
            <?= $judge[5]=='NG' ? ($_SESSION['BuyTicket_input']['Address3']=="" ? '※入力してください。' : '※正しく入力してください。') : ''; ?>
         </p>
      </div>

      <div class="input_attension_space">
         <p>電話番号（ハイフン必須）</p>
         <div>
            <input id="BuyTicket_Tel" value="<?= e($_SESSION['BuyTicket_input']['Tel']); ?>" maxlength="13" <?= $isMember ? 'readonly' : ''; ?>>
         </div>
         <p id="BuyTicket_Tel_check" style="color:rgb(255, 60 ,60)">
            <?= $judge[6]=='NG' ? ($_SESSION['BuyTicket_input']['Tel']=="" ? '※入力してください。' : '※正しく入力してください。') : ''; ?>
         </p>
      </div>

      <div class="input_attension_space">
         <p>メールアドレス</p>
         <div>
            <input id="BuyTicket_Mail" value="<?= e($_SESSION['BuyTicket_input']['Mail']); ?>" maxlength="50" <?= $isMember ? 'readonly' : ''; ?>>
         </div>
         <p id="BuyTicket_Mail_check" style="color:rgb(255, 60 ,60)">
            <?= $judge[7]=='NG' ? ($_SESSION['BuyTicket_input']['Mail']=="" ? '※入力してください。' : '※正しく入力してください。') : ''; ?>
         </p>
      </div>

      <div class="space_11px"></div>

      <div class="flex_row">
         <button type="button" id="BuyTicket_go" 
            class="<?= $_SESSION['BuyTicket_input'][0]['Button']=='OK' ? 'button_water color_white' : 'button_glayout color_white';?>" 
            <?= $_SESSION['BuyTicket_input'][0]['Button']=='OK' ? '' : 'disabled';?>>進む
         </button>

         <button type="button" id="BuyTicket_back" class="button_glay color_white">戻る</button>
      </div>

   </div>

   <div class="backMark">
      <a id="toTop" class="toTop" href="RecoCon_TOP_XAMPP.php"><img src="SVG/back.svg" alt="back"></a>
   </div>

</div>
