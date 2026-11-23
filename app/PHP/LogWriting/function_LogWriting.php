<?php
   function LogWriting ($e, $msg) {

      //日付を日本時間に。
         date_default_timezone_set('Asia/Tokyo');

      //表記法ごとに時刻を取得。$T1と$T2。
         $time = new DateTime();
         $T1 = $time -> format('Y.m.d H:i:s');

         $time2 = new DateTime();
         $T2 = $time2 -> format('Ymd');

      //ログ内容の定義。$eをcatchしている場合としていない場合。
         $userId = $_SESSION['User']['u_id'] ?? '-';
         $requestMethod = $_SERVER['REQUEST_METHOD'] ?? 'CLI';
         $requestUri = $_SERVER['REQUEST_URI'] ?? '-';
         $remoteIp = $_SERVER['REMOTE_ADDR'] ?? '-';
         $remotePort = $_SERVER['REMOTE_PORT'] ?? '-';
         $serverIp = $_SERVER['SERVER_ADDR'] ?? '-';
         $serverPort = $_SERVER['SERVER_PORT'] ?? '-';
         $serverProtocol = $_SERVER['SERVER_PROTOCOL'] ?? '-';

         $LogMessage = $T1.
             " UserID:".$userId." ".$msg.
             " Method:".$requestMethod.
             " URI:".$requestUri.
             " RemoteIP:".$remoteIp."(port:".$remotePort.
             ") ServerIP:".$serverIp."(port:".$serverPort.
             ") ".$serverProtocol."\r\n";

         if ($e instanceof Throwable){
            $LogMessage .=
                " Error:".get_class($e). 
                " Code:".$e -> getCode().
                " File:".$e -> getFile().
                " Line:".$e -> getLine()."\r\n";
         }

      //ログファイルに追記（ファイルがなければ新規ファイル作成）(a)。日が変わるとT2でファイル名が書き換わり新規ログファイルが作成される。
         $fileURI = __DIR__.'/RecoCon_Log/RecoCon_Log_'.$T2.'.txt';

         // ①/⑤access.logを追記書き込みモードで開く。
         $file = @fopen($fileURI, 'a');
         if ($file === false){
             error_log('RecoCon: ログファイルを開けませんでした。');
             return;
         }

         // ②/⑤ファイルのロック
         if (!flock($file, LOCK_EX)){
             error_log('RecoCon: ログファイルをロックできませんでした。');
             fclose($file);
             return;
         }

         // ③/⑤ファイルの書き込み
         $result = @fwrite($file, $LogMessage);

         // ④/⑤ロックの解除
         flock($file, LOCK_UN);

         // ⑤/⑤ファイルのクローズ
         fclose($file);
         //print 'アクセスログを記録しました。';

         if ($result === false || $result < strlen($LogMessage)){
             error_log('RecoCon: ログの書き込みに失敗しました。');
         }

      //関数終了
         return;

   }
?>
