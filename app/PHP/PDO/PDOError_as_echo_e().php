<?php
function echo_e ( PDOException $e ) : string {

   //処理内容の定義
   $errorMessage = "エラーコード:{$e -> getCode()}<br>
                    エラーメッセージ:{$e -> getMessage()}<br>
                    エラーファイル:{$e -> getFile()}<br>
                    エラーの発生した行:{$e -> getLine()}<br>
                    前の例外:{$e -> getPrevious()}<br>
                    バックトレース（配列）:{$e -> getTrace()}<br>
                    バックトレース（文字列）:{$e -> getTraceAsString()}";

   //戻り値
   return $errorMessage;

}