<?php

   class sendMail {

      //必須のプロパティ。
      public string $to;
      public string $subject;
      public string $message;
      public string $command;

      //その他のheader用の連想配列用の空配列。
      private array $headers = [];

      //未定義のプロパティを$headersにセット。
      public function __set ( string $name, mixed $value ) : void {        //__setメソッド。
         $this -> headers[ $name ] = $value;
      }

      //未定義のプロパティを取得する時、headersから該当するもの選択。
      public function __get ( string $name ) : mixed {                     //__getメソッド。
         return $this -> headers[ $name ];
      }

      //メールを送信するメソッド。
      public function send (){

         mb_language('Japanese');
         mb_internal_encoding('UTF-8');

         $others = '';

         foreach ( $this -> headers as $key => $value ){
            $key = str_replace( '_', '-', $key );             //プロパティに「-」が使えないので、「_」で登録。出力時に「-」に再び置き換える。
            $others .= "{$key}: {$value}\n";
         }

         return mb_send_mail(   //bookを返す 
             $this -> to, 
             $this -> subject, 
             $this -> message, 
             $others, 
             $this -> command 
         );

      }

   }

?>
