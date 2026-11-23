//グローバル変数
//var target_url;
//var funcRef;

//引数を定義してリクエストを実行
//target_url = "";   キーと値をGETで送る時は「 "...URL...?キー=値&キー=値&キー=値&..." 」というふうに、URLにクエリを追加する。
//funcRef = function ●●●● (){   }
//httpRequest_Get (target_url, funcRef);


//以下がXMLHttpRequest本体
function httpRequest_Get (target_url, functionReference) {

   var httpObj;

   try{
      if(window.XMLHttpRequest){
         httpObj = new XMLHttpRequest();
      }else if(window.ActiveXObject){
         httpObj = new ActiveXObject("Microsoft.XMLHTTP");
      }else{
         httpObj = false;
      }
   } catch(e){
      httpObj = false;
      console.log(e);
   }

   if(httpObj == false){
      window.alert("ご利用のブラウザではサポートされていません。");
      return false;
   }

   var timeout_sec = 10;
   var timerId = setInterval(timeoutCheck, 1000);

   function timeoutCheck () {
      timeout_sec--;
      if (timeout_sec <= 0){
         clearInterval(timerId);
         httpObj.abort();
         console("タイムアウトです。");
         return false;
      }
   }

   httpObj.open("GET", target_url, true);
   httpObj.onreadystatechange = function(){
      if (httpObj.readyState == 4){
         clearInterval(timerId);
         if(httpObj.status == 200){
            functionReference(httpObj.response);
         } else if (httpObj.status == 429) {
            window.alert("ログイン試行回数の上限に達しました。\n15分ほど時間をあけてから再度お試しください。" );
            return false;
         } else {
            window.alert("Httpレスポンスコード：" + httpObj.status);
            return false;
         }
      }
   }

   httpObj.send("");

}
