<?php require_once __DIR__."/PHP/Security/session_bootstrap.php";   /* session_start含む。 */ ?>
<?php header("Content-Type: text/html;charset=UTF-8"); ?>
<?php require_once __DIR__.'/PHP/Security/csrf.php'; ?>
<?php require_once __DIR__.'/PHP/Security/validate_guest.php'?>
<?php require_once __DIR__.'/PHP/Security/regex.php'; ?>
<?php require_once __DIR__.'/PHP/htmlspecialchars_as_e()/htmlspecialchars_as_e().php'; ?>
<?php require_once __DIR__.'/PHP/LogWriting/function_LogWriting.php'; ?>
<?php require_once __DIR__.'/PHP/PDO/PDOError_as_echo_e().php'; ?>
<?php require_once __DIR__.'/PHP/Class_sendMail/Class_sendMail.php'; ?>
<?php require_once __DIR__.'/PHP/Class_sendMail/function_sendRecoconMail.php'; ?>
<?php 
   require_once __DIR__.'/PHP/PDO/newPDO_as_getDb().php'; 
   $PDO = getDb();  //$PDOにPDOインスタンスが格納されている。
?>
<?php 
   if (
      $_SERVER['REQUEST_METHOD'] !== 'POST' ||
      !recoConCsrfValid($_POST['token'] ?? null)  // CSRF対策のトークンとの照合。
   ){
      LogWriting(null, 'CSRFトークンエラー');
      http_response_code(403);
      die('正規画面からご利用下さい。');
   }
?>
<?php   //購入者区分を判定。ユーザーかゲストか。
   $isMember = !empty($_SESSION['User']['u_id']);
?>
<?php   //ゲスト情報の検証。
   if (
      !$isMember &&
      !validateGuestInput($_SESSION['BuyTicket_input'] ?? null)
   ) {
      //var_dump("BuTicket_input: \n".$_SESSION['BuyTicket_input']);
      //var_dump("User u_id: \n".$_SESSION['User']['u_id']);
      http_response_code(400);
      header('Content-Type: text/plain; charset=UTF-8');
      exit('入力情報に誤りがあります。再度ご確認ください。');
   }
?>
<?php   //購入情報のDB書き込み
   $purchaseSucceeded = null;   //購入に成功したかどうかのフラグ。
   $purchaseCount = 0;          //この操作でのの購入数。
   $guestData = null;           //ゲスト情報の保存先変数。

   try {
      $PDO -> beginTransaction();

      //購入者情報の取得。
      $userId = $isMember ? (int)$_SESSION['User']['u_id'] : null;
      $guestId = null;

      //ゲストならここでGuestテーブルにINSERTする。
      if (!$isMember){
         $PDOState = $PDO -> prepare(
            'INSERT INTO Guest 
                (g_name, g_age, g_sex, g_address_1, g_address_2, g_address_3, g_tel, g_mail) 
             VALUES 
                (:g_name, :g_age, :g_sex, :g_address_1, :g_address_2, :g_address_3, :g_tel, :g_mail)');
         $PDOState -> bindValue(':g_name', $_SESSION['BuyTicket_input']['Name']);  //PDOStatementのbindValueメソッド。
         $PDOState -> bindValue(':g_age', (int)$_SESSION['BuyTicket_input']['Age'], PDO::PARAM_INT);
         $PDOState -> bindValue(':g_sex', $_SESSION['BuyTicket_input']['Sex']);
         $PDOState -> bindValue(':g_address_1', $_SESSION['BuyTicket_input']['Address1']);
         $PDOState -> bindValue(':g_address_2', $_SESSION['BuyTicket_input']['Address2']);
         $PDOState -> bindValue(':g_address_3', $_SESSION['BuyTicket_input']['Address3']);
         $PDOState -> bindValue(':g_tel', $_SESSION['BuyTicket_input']['Tel']);
         $PDOState -> bindValue(':g_mail', $_SESSION['BuyTicket_input']['Mail']);

         $PDOState -> execute();

         //直前のINSERTで発行されたIDを取得。
         $guestId = (int)$PDO -> lastInsertId();
         if ($guestId <= 0){
            throw new RuntimeException('ゲストIDを取得できませんでした。');
         }
      }

      //ゲストID取得時に、購入者IDの整合性を確認。
      if (($userId===null)===($guestId===null)){   //ユーザーかゲストである。そうでなければエクセプション。
          throw new RuntimeException('購入者情報を確認できません。');
      }

      //コミット後にセッションへ登録する情報
      $guestData = [
          'g_id'        => $guestId,
          'g_name'      => $_SESSION['BuyTicket_input']['Name'],
          'g_age'       => $_SESSION['BuyTicket_input']['Age'],
          'g_sex'       => $_SESSION['BuyTicket_input']['Sex'],
          'g_address_1' => $_SESSION['BuyTicket_input']['Address1'],
          'g_address_2' => $_SESSION['BuyTicket_input']['Address2'],
          'g_address_3' => $_SESSION['BuyTicket_input']['Address3'],
          'g_tel'       => $_SESSION['BuyTicket_input']['Tel'],
          'g_mail'      => $_SESSION['BuyTicket_input']['Mail']
      ];

      //メンバーの場合にロック。
      if ($isMember){
          $PDOState = $PDO -> prepare(
             'SELECT u_id 
              FROM User 
              WHERE u_id=:u_id 
              FOR UPDATE'
          );   //コミットまでロック。
          $PDOState -> bindValue(':u_id', (int)$userId, PDO::PARAM_INT);
          $PDOState -> execute();
          if ($PDOState -> fetchColumn()===false){
              throw new RuntimeException('会員情報が見つかりません。');
          }
      }

      //次回公演のIDを取得。
      $PDOState = $PDO -> prepare(
        'SELECT cs_id
         FROM Concert_Schedule
         WHERE cs_id = (
             SELECT COUNT(cs_id) 
             FROM Concert_Schedule
         ) - 2'
      );
      $PDOState -> execute();
      $csId = $PDOState -> fetchColumn();
      if ($csId === false){
          throw new RuntimeException('次回の公演が見つかりません。');
      }

      //座席番号を座席名に変換する。
      $seatMap = [
          'A-1', 'A-2', 'A-3',
          'B-1', 'B-2', 'B-3',
          'C-1', 'C-2', 'C-3',
          'D-1', 'D-2', 'D-3',
      ];
      $seat1 = $_SESSION['SelectSeats']['seat1'] ?? null;   //座席の番号0-11
      $seat2 = $_SESSION['SelectSeats']['seat2'] ?? null;   //座席の番号0-11
      foreach ([$seat1, $seat2] as $i){
          if (!preg_match('/^([0-9]|10|11)$/', (string)$i)){
              throw new RuntimeException('座席番号が正しくありません。');
          }
      }
      $seatName1 = $seatMap[(int)$seat1];
      $seatName2 = $seatMap[(int)$seat2];

      //1公演につき2席までの購入制限。
      if ($isMember){
          //今回購入する座席数を取得。
          $purchaseCount = ($_SESSION['SelectSeats']['seat1'] != $_SESSION['SelectSeats']['seat2']) ? 2 : 1;

          //この会員が同じ公演で購入済みの座席数。
          $PDOState = $PDO -> prepare(
             'SELECT COUNT(*) 
              FROM Ticket_Sale 
              WHERE cs_id=:cs_id AND u_id=:u_id AND sale=1'
          );
          $PDOState -> bindValue(':cs_id', (int)$csId, PDO::PARAM_INT);
          $PDOState -> bindValue(':u_id', (int)$userId, PDO::PARAM_INT);
          $PDOState -> execute();
          $alreadyPurchased = (int)$PDOState -> fetchColumn();

          //購入済み座席数と今回購入する座席数を合計して購入制限の2と比較する。
          if ($alreadyPurchased + $purchaseCount > 2){
              throw new RuntimeException('1公演につき購入できるのは2席までです。');
          }
      }

      //ひとつ目の席の購入処理。 
      $PDOState = $PDO -> prepare(
          'UPDATE Ticket_Sale 
           SET sale=:sale, u_id=:u_id, g_id=:g_id 
           WHERE cs_id=:cs_id AND seat=:seat AND sale=0'
      );   //sale=0で二重購入を防止。
      $PDOState -> bindValue(':sale', (int)1);   //PDOStatementのbindValueメソッド。
      $PDOState -> bindValue(':u_id', $userId, $userId===null ? PDO::PARAM_NULL : PDO::PARAM_INT);   //型を明示
      $PDOState -> bindValue(':g_id', $guestId, $guestId===null ? PDO::PARAM_NULL : PDO::PARAM_INT);  //同上
      $PDOState -> bindValue(':cs_id', (int)$csId, PDO::PARAM_INT);
      $PDOState -> bindValue(':seat', $seatName1, PDO::PARAM_STR);
      $PDOState -> execute();
      if ($PDOState -> rowCount() !== 1){
          throw new RuntimeException('この座席はすでに予約されています。');
      }

      //ふたつ目の席の購入処理。座席がふたつ選択されている場合（$_SESSION['SelectSeats']の値が違うものになる）。
      if ($_SESSION['SelectSeats']['seat1'] != $_SESSION['SelectSeats']['seat2']){
          $PDOState = $PDO -> prepare(
              'UPDATE Ticket_Sale 
               SET sale=:sale, u_id=:u_id, g_id=:g_id 
               WHERE cs_id=:cs_id AND seat=:seat AND sale=0'
          );
          $PDOState -> bindValue(':sale', (int)1);   //PDOStatementのbindValueメソッド。
          $PDOState -> bindValue(':u_id', $userId, $userId===null ? PDO::PARAM_NULL : PDO::PARAM_INT);   //型を明示
          $PDOState -> bindValue(':g_id', $guestId, $guestId===null ? PDO::PARAM_NULL : PDO::PARAM_INT);  //同上
          $PDOState -> bindValue(':cs_id', (int)$csId, PDO::PARAM_INT);
          $PDOState -> bindValue(':seat', $seatName2, PDO::PARAM_STR);
          $PDOState -> execute();
          if ($PDOState -> rowCount() !== 1){
              throw new RuntimeException('この座席はすでに予約されています。');
          }
      }

      $PDO -> commit();   //トランザクションコミット。ロックもここで解除される。

      $purchaseSucceeded = true;   //購入に成功！

      if (!$isMember && $guestData !== null){
          $_SESSION['Guest'] = $guestData;
      }

      LogWriting(null, "購入処理完了");   //正常終了ログ。メッセージは随時書き換え。

   } catch ( Throwable $e ){ 
      if ($PDO -> inTransaction()){
          $PDO -> rollback();   //トランザクションロールバック
      }

      $purchaseSucceeded = false;

      $e_message[] = '購入を確定できませんでした。空席状況をご確認ください。';

      LogWriting($e, "購入処理失敗");   //異常終了ログ。メッセージは随時書き換え。

   }
?>
<?php   //メール送信。※プロパティへの登録時は「-」でなく「_」の使用が必須。
   $mailSent = false;

   if ($purchaseSucceeded) {
      $mailTo = $_SESSION['User']['u_mail']
          ?? $_SESSION['Guest']['g_mail']
          ?? '';

      $name = $_SESSION['User']['u_name']
          ?? $_SESSION['Guest']['g_name']
          ?? 'お客様';

      try {
          //メールに必要な情報を取得する。
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
             // var_dump($array_cs_d[$i]);
             $i++;
          }

          $mailTo = $_SESSION['User']['u_mail']
              ?? $_SESSION['Guest']['g_mail']
              ?? '';
          $name = $_SESSION['User']['u_name']
              ?? $_SESSION['Guest']['g_name']
              ?? 'お客様';
          $date = (new DateTimeImmutable($array_cs_d[1]['cs_date'])) -> format('Y年n月j日') ?? '';
          $open = substr($array_cs_d[1]['cs_open'], 0, 5) ?? '';
          $start = substr($array_cs_d[1]['cs_start'], 0, 5) ?? '';
          $composerJn = $array_cs_d[1]['cs_composer_jn'] ?? '';
          $titleJn = $array_cs_d[1]['cs_title_jn'] ?? '';
          $seat1ForMail = $seatName1 ?? ''; 
          $seat2ForMail = !($seatName1 === $seatName2) ? ' / '.$seatName2 : '';

          //メールを送信する。
          $mailSent = sendRecoconMail(
              $mailTo,
              'Reco.Con. チケット購入完了のお知らせ',
              "{$name}さま

チケットをご購入いただき、ありがとうございます。

【ご購入内容】
公演日: {$date}
開場: {$open}
開演: {$start}
座席: {$seat1ForMail}{$seat2ForMail}
作曲: {$composerJn}
曲目: {$titleJn}

ご予約のご購入内容は以上です。
※このメールは送信専用です。
※お心当たりがない場合は、このメールを削除してください。

Reco.Con.事務局"
          );
      } catch (Throwable $e) {
          LogWriting($e, '購入メール送信失敗');
      }
   }
?>
<?php  //購入完了後、購入処理用の一時情報を破棄する。
   //ログイン情報は維持する。($_SESSION['User'])
   unset($_SESSION['SelectSeats']);
   unset($_SESSION['BuyTicket_input']);
   unset($_SESSION['Guest']);
?>


<div>

   <h2 id="MClub_title" class="title_white color_perple">予約券・当日券の購入</h2>

   <div class="title_water">
      <h1 id="MClub_title2" class="color_white">ネットでの予約券購入</h1>
      <h2 class="color_white">4/4</h2>
   </div>

   <h2 id="BuyTicket_message" class="title_glay color_water">
         <?= $purchaseSucceeded ? 'ご予約を確定しました。' : 'ご予約を確定できませんでした。';?>
   </h2>

   <div class="space_white">

   <div class="space_11px"></div>
   
   <?php if ($purchaseSucceeded): ?>
      <p class="p_center">ご購入ありがとうございました。 </p>

      <?php if ($mailSent): ?>
          <p class="p_center">ご登録いただいたメールアドレスへ確定した予約内容をメールにてお送りしました。</p>
      <?php else: ?>
          <p class="p_center">ご予約は確定できましたが、確認のメールを送信できませんでした。</p>
      <?php endif; ?>

   <?php else: ?>
      <p class="p_center">ご購入を確定できませんでした。</p>
   <?php endif;?>

   </div>

   <div class="backMark">
      <a id="toTop" class="toTop" href="RecoCon_TOP_XAMPP.php"><img src="SVG/back.svg" alt="back"></a>
   </div>

</div>

