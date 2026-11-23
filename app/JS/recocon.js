//グローバル変数-------------------------------------------------------------------------

//AJAXのXMLHttpRequestのための変数。（リクエストのたびに書き換えられるようにグローバル変数として定義）
var target_url;
var funcRef;
var contentType;
var send_data;

//CSRF対策用のトークン取得用の変数。
var token;

//カルーセル用の変数
var timer_carousel;
var timeout_sec_carousel = 4;
var carousel_1 = 1;
var carousel_2 = 2;
var carousel_3 = 3;
var carousel_4 = 4;
var carousel_5 = 5;
var carousel_6 = 6;
var carousel_7 = 7;
var carousel_8 = 8;
var carousel_9 = 9;
var carousel_10 = 10;
var carousel_11 = 11;
var carousel_12 = 12;
var carousel_13 = 13;
var carousel_14 = 14;

//ハンバーガーメニューをクリックした回数カウント用の変数
var menu_i = 2;

//新規アカウント作成時の入力フォームチェッカー
var reg;

var U_Input_IdChecker;
var PassChecker;
var NameChecker;
var AgeChecker;
var SexChecker;
var Address1Checker;
var Address2Checker;
var Address3Checker;
var TelChecker;
var MailChecker;

var AllChecker;

var U_Input_Id;
var Pass;
var Name;
var Age;
var Sex;
var Address1;
var Address2;
var Address3;
var Tel;
var Mail;


var U_Input_Id_check;
var Pass_check;
var Name_check;
var Age_check;
var Sex_check;
var Address1_check;
var Address2_check;
var Address3_check;
var Tel_check;
var Mail_check;

var Button;

//チケット購入フォーム入力時の入力フォームチェッカー
var buyTicket_nameChecker = 0;
var buyTicket_ageChecker = 0;
var buyTicket_sexChecker = 0;
var buyTicket_address1Checker = 0;
var buyTicket_address2Checker = 0;
var buyTicket_address3Checker = 0;
var buyTicket_telChecker = 0;
var buyTicket_mailChecker = 0;

//アカウント更新フォームの入力フォームチェッカー
var updateAcct_nameChecker = 1;
var updateAcct_ageChecker = 1;
var updateAcct_sexChecker = 1;
var updateAcct_address1Checker = 1;
var updateAcct_address2Checker = 1;
var updateAcct_address3Checker = 1;
var updateAcct_telChecker = 1;
var updateAcct_mailChecker = 1;

//アカウント更新フォームのボタンの判定用。
var updateAcct_Button_state = 0;

//座席選択フォームのボタンの判定用。
var selectSeats_Button_state = 1;

//チケット購入フォームの進むボタンを1をtrue扱いでdisabledをtrueに。
var BuyTicket_input_Button_state = 1;

//椅子のチェック状態の判定用。
var chairCheckCount = 0;

//arrowをクリックした回数カウント用の変数
var next_arrowClick_i = 2;
var stayTuned1_arrowClick_i = 2;
var stayTuned2_arrowClick_i = 2;
var close1_arrowClick_i = 2;
var close2_arrowClick_i = 2;
var close3_arrowClick_i = 2;
var close4_arrowClick_i = 2;
var close5_arrowClick_i = 2;





//カルーセル-------------------------------------------------------------------------

function AJAX_carousel () {

   target_url = "RecoCon_TOP_AJAX_ConcertSchedule_Disc.php";

   funcRef = function (text_data){

      //JSONの処理。普通の配列にする。
      var array_JSON = JSON.parse(text_data);
      //console.log(array_JSON);

      var index = [carousel_1, carousel_2, carousel_3, carousel_4, carousel_5, carousel_6, carousel_7, carousel_8, carousel_9, carousel_10, 
                     carousel_11, carousel_12, carousel_13, carousel_14];

      for (var i=1; i <= 14; i++){
         //初期設定。2秒後に左へずれるアニメーション。
         item_setAttribute_src ("#carousel_d" + i + "_a_img", "photo/" + array_JSON[index[i-1]]['d_path']);
         new Item_Styles_Animate ("#carousel_d" + i, {transform:"translate(-153px)",}, "normal", 400, 2000, "ease-in-out", "forwards", 1).setStylesAnimate();
      }

      //カルーセルのタイマー（1秒ずつカウント）
      timer_carousel = setInterval(timeoutCheck, 1000);

      function timeoutCheck () {
         timeout_sec_carousel--;

         //「2秒たったら」もとの位置に戻る。carousel_1。
         if(timeout_sec_carousel == 2){
            if(carousel_1 == Object.keys(array_JSON).length){
               carousel_1 = 1;
               new Item_Styles_Animate ("#carousel_d1", {transform:"translate(0px)",}, "normal", 0, 2000, "ease-in-out", "forwards", 1).setStylesAnimate();
            } else {
               carousel_1++;
               new Item_Styles_Animate ("#carousel_d1", {transform:"translate(0px)",}, "normal", 0, 2000, "ease-in-out", "forwards", 1).setStylesAnimate();
            }
         }

         //「2秒たったら」もとの位置に戻る。carousel_2。
         if(timeout_sec_carousel == 2){
            if(carousel_2 == Object.keys(array_JSON).length){
               carousel_2 = 1;
               new Item_Styles_Animate ("#carousel_d2", {transform:"translate(0px)",}, "normal", 0, 2000, "ease-in-out", "forwards", 1).setStylesAnimate();
            } else {
               carousel_2++;
               new Item_Styles_Animate ("#carousel_d2", {transform:"translate(0px)",}, "normal", 0, 2000, "ease-in-out", "forwards", 1).setStylesAnimate();
            }
         }

         //「2秒たったら」もとの位置に戻る。carousel_3。
         if(timeout_sec_carousel == 2){
            if(carousel_3 == Object.keys(array_JSON).length){
               carousel_3 = 1;
               new Item_Styles_Animate ("#carousel_d3", {transform:"translate(0px)",}, "normal", 0, 2000, "ease-in-out", "forwards", 1).setStylesAnimate();
            } else {
               carousel_3++;
               new Item_Styles_Animate ("#carousel_d3", {transform:"translate(0px)",}, "normal", 0, 2000, "ease-in-out", "forwards", 1).setStylesAnimate();
            }
         }

         //「2秒たったら」もとの位置に戻る。carousel_4。
         if(timeout_sec_carousel == 2){
            if(carousel_4 == Object.keys(array_JSON).length){
               carousel_4 = 1;
               new Item_Styles_Animate ("#carousel_d4", {transform:"translate(0px)",}, "normal", 0, 2000, "ease-in-out", "forwards", 1).setStylesAnimate();
            } else {
               carousel_4++;
               new Item_Styles_Animate ("#carousel_d4", {transform:"translate(0px)",}, "normal", 0, 2000, "ease-in-out", "forwards", 1).setStylesAnimate();
            }
         }

         //「2秒たったら」もとの位置に戻る。carousel_1。
         if(timeout_sec_carousel == 2){
            if(carousel_5 == Object.keys(array_JSON).length){
               carousel_5 = 1;
               new Item_Styles_Animate ("#carousel_d5", {transform:"translate(0px)",}, "normal", 0, 2000, "ease-in-out", "forwards", 1).setStylesAnimate();
            } else {
               carousel_5++;
               new Item_Styles_Animate ("#carousel_d5", {transform:"translate(0px)",}, "normal", 0, 2000, "ease-in-out", "forwards", 1).setStylesAnimate();
            }
         }

         //「2秒たったら」もとの位置に戻る。carousel_2。
         if(timeout_sec_carousel == 2){
            if(carousel_6 == Object.keys(array_JSON).length){
               carousel_6 = 1;
               new Item_Styles_Animate ("#carousel_d6", {transform:"translate(0px)",}, "normal", 0, 2000, "ease-in-out", "forwards", 1).setStylesAnimate();
            } else {
               carousel_6++;
               new Item_Styles_Animate ("#carousel_d6", {transform:"translate(0px)",}, "normal", 0, 2000, "ease-in-out", "forwards", 1).setStylesAnimate();
            }
         }

         //「2秒たったら」もとの位置に戻る。carousel_4。
         if(timeout_sec_carousel == 2){
            if(carousel_7 == Object.keys(array_JSON).length){
               carousel_7 = 1;
               new Item_Styles_Animate ("#carousel_d7", {transform:"translate(0px)",}, "normal", 0, 2000, "ease-in-out", "forwards", 1).setStylesAnimate();
            } else {
               carousel_7++;
               new Item_Styles_Animate ("#carousel_d7", {transform:"translate(0px)",}, "normal", 0, 2000, "ease-in-out", "forwards", 1).setStylesAnimate();
            }
         }

                                 //「2秒たったら」もとの位置に戻る。carousel_1。
         if(timeout_sec_carousel == 2){
            if(carousel_8 == Object.keys(array_JSON).length){
               carousel_8 = 1;
               new Item_Styles_Animate ("#carousel_d8", {transform:"translate(0px)",}, "normal", 0, 2000, "ease-in-out", "forwards", 1).setStylesAnimate();
            } else {
               carousel_8++;
               new Item_Styles_Animate ("#carousel_d8", {transform:"translate(0px)",}, "normal", 0, 2000, "ease-in-out", "forwards", 1).setStylesAnimate();
            }
         }

         //「2秒たったら」もとの位置に戻る。carousel_2。
         if(timeout_sec_carousel == 2){
            if(carousel_9 == Object.keys(array_JSON).length){
               carousel_9 = 1;
               new Item_Styles_Animate ("#carousel_d9", {transform:"translate(0px)",}, "normal", 0, 2000, "ease-in-out", "forwards", 1).setStylesAnimate();
            } else {
               carousel_9++;
               new Item_Styles_Animate ("#carousel_d9", {transform:"translate(0px)",}, "normal", 0, 2000, "ease-in-out", "forwards", 1).setStylesAnimate();
            }
         }

         //「2秒たったら」もとの位置に戻る。carousel_3。
         if(timeout_sec_carousel == 2){
            if(carousel_10 == Object.keys(array_JSON).length){
               carousel_10 = 1;
               new Item_Styles_Animate ("#carousel_d10", {transform:"translate(0px)",}, "normal", 0, 2000, "ease-in-out", "forwards", 1).setStylesAnimate();
            } else {
               carousel_10++;
               new Item_Styles_Animate ("#carousel_d10", {transform:"translate(0px)",}, "normal", 0, 2000, "ease-in-out", "forwards", 1).setStylesAnimate();
            }
         }

         //「2秒たったら」もとの位置に戻る。carousel_4。
         if(timeout_sec_carousel == 2){
            if(carousel_11 == Object.keys(array_JSON).length){
               carousel_11 = 1;
               new Item_Styles_Animate ("#carousel_d11", {transform:"translate(0px)",}, "normal", 0, 2000, "ease-in-out", "forwards", 1).setStylesAnimate();
            } else {
               carousel_11++;
               new Item_Styles_Animate ("#carousel_d11", {transform:"translate(0px)",}, "normal", 0, 2000, "ease-in-out", "forwards", 1).setStylesAnimate();
            }
         }

         //「2秒たったら」もとの位置に戻る。carousel_1。
         if(timeout_sec_carousel == 2){
            if(carousel_12 == Object.keys(array_JSON).length){
               carousel_12 = 1;
               new Item_Styles_Animate ("#carousel_d12", {transform:"translate(0px)",}, "normal", 0, 2000, "ease-in-out", "forwards", 1).setStylesAnimate();
            } else {
               carousel_12++;
               new Item_Styles_Animate ("#carousel_d12", {transform:"translate(0px)",}, "normal", 0, 2000, "ease-in-out", "forwards", 1).setStylesAnimate();
            }
         }

         //「2秒たったら」もとの位置に戻る。carousel_2。
         if(timeout_sec_carousel == 2){
            if(carousel_13 == Object.keys(array_JSON).length){
               carousel_13 = 1;
               new Item_Styles_Animate ("#carousel_d13", {transform:"translate(0px)",}, "normal", 0, 2000, "ease-in-out", "forwards", 1).setStylesAnimate();
            } else {
               carousel_13++;
               new Item_Styles_Animate ("#carousel_d13", {transform:"translate(0px)",}, "normal", 0, 2000, "ease-in-out", "forwards", 1).setStylesAnimate();
            }
         }

         //「2秒たったら」もとの位置に戻る。carousel_3。
         if(timeout_sec_carousel == 2){
            if(carousel_14 == Object.keys(array_JSON).length){
               carousel_14 = 1;
               new Item_Styles_Animate ("#carousel_d14", {transform:"translate(0px)",}, "normal", 0, 2000, "ease-in-out", "forwards", 1).setStylesAnimate();
            } else {
               carousel_14++;
               new Item_Styles_Animate ("#carousel_d14", {transform:"translate(0px)",}, "normal", 0, 2000, "ease-in-out", "forwards", 1).setStylesAnimate();
            }
         }


         //「4秒たったら」リンクを差し替えて、初めと同じ左へずれるアニメーション。
         if(timeout_sec_carousel == 0){
            timeout_sec_carousel = 4;

            item_setAttribute_src ("#carousel_d1_a_img", "photo/" + array_JSON[carousel_1]['d_path']);
            new Item_Styles_Animate ("#carousel_d1", {transform:"translate(-153px)",}, "normal", 400, 2000, "ease-in-out", "forwards", 1).setStylesAnimate();

            item_setAttribute_src ("#carousel_d2_a_img", "photo/" + array_JSON[carousel_2]['d_path']);
            new Item_Styles_Animate ("#carousel_d2", {transform:"translate(-153px)",}, "normal", 400, 2000, "ease-in-out", "forwards", 1).setStylesAnimate();

            item_setAttribute_src ("#carousel_d3_a_img", "photo/" + array_JSON[carousel_3]['d_path']);
            new Item_Styles_Animate ("#carousel_d3", {transform:"translate(-153px)",}, "normal", 400, 2000, "ease-in-out", "forwards", 1).setStylesAnimate();

            item_setAttribute_src ("#carousel_d4_a_img", "photo/" + array_JSON[carousel_4]['d_path']);
            new Item_Styles_Animate ("#carousel_d4", {transform:"translate(-153px)",}, "normal", 400, 2000, "ease-in-out", "forwards", 1).setStylesAnimate();

            item_setAttribute_src ("#carousel_d5_a_img", "photo/" + array_JSON[carousel_5]['d_path']);
            new Item_Styles_Animate ("#carousel_d5", {transform:"translate(-153px)",}, "normal", 400, 2000, "ease-in-out", "forwards", 1).setStylesAnimate();

            item_setAttribute_src ("#carousel_d6_a_img", "photo/" + array_JSON[carousel_6]['d_path']);
            new Item_Styles_Animate ("#carousel_d6", {transform:"translate(-153px)",}, "normal", 400, 2000, "ease-in-out", "forwards", 1).setStylesAnimate();

            item_setAttribute_src ("#carousel_d7_a_img", "photo/" + array_JSON[carousel_7]['d_path']);
            new Item_Styles_Animate ("#carousel_d7", {transform:"translate(-153px)",}, "normal", 400, 2000, "ease-in-out", "forwards", 1).setStylesAnimate();

            item_setAttribute_src ("#carousel_d8_a_img", "photo/" + array_JSON[carousel_8]['d_path']);
            new Item_Styles_Animate ("#carousel_d8", {transform:"translate(-153px)",}, "normal", 400, 2000, "ease-in-out", "forwards", 1).setStylesAnimate();

            item_setAttribute_src ("#carousel_d9_a_img", "photo/" + array_JSON[carousel_9]['d_path']);
            new Item_Styles_Animate ("#carousel_d9", {transform:"translate(-153px)",}, "normal", 400, 2000, "ease-in-out", "forwards", 1).setStylesAnimate();

            item_setAttribute_src ("#carousel_d10_a_img", "photo/" + array_JSON[carousel_10]['d_path']);
            new Item_Styles_Animate ("#carousel_d10", {transform:"translate(-153px)",}, "normal", 400, 2000, "ease-in-out", "forwards", 1).setStylesAnimate();

            item_setAttribute_src ("#carousel_d11_a_img", "photo/" + array_JSON[carousel_11]['d_path']);
            new Item_Styles_Animate ("#carousel_d11", {transform:"translate(-153px)",}, "normal", 400, 2000, "ease-in-out", "forwards", 1).setStylesAnimate();

            item_setAttribute_src ("#carousel_d12_a_img", "photo/" + array_JSON[carousel_12]['d_path']);
            new Item_Styles_Animate ("#carousel_d12", {transform:"translate(-153px)",}, "normal", 400, 2000, "ease-in-out", "forwards", 1).setStylesAnimate();

            item_setAttribute_src ("#carousel_d13_a_img", "photo/" + array_JSON[carousel_13]['d_path']);
            new Item_Styles_Animate ("#carousel_d13", {transform:"translate(-153px)",}, "normal", 400, 2000, "ease-in-out", "forwards", 1).setStylesAnimate();

            item_setAttribute_src ("#carousel_d14_a_img", "photo/" + array_JSON[carousel_14]['d_path']);
            new Item_Styles_Animate ("#carousel_d14", {transform:"translate(-153px)",}, "normal", 400, 2000, "ease-in-out", "forwards", 1).setStylesAnimate();

         }

      }
   }

   httpRequest_Get (target_url, funcRef);

}




//ハンバーガーメニューをクリックした時のアクション。メニューアイコンの入れ替えとdisplay部分の表示/非表示の切り替え------------------------------------------------

function menu_click (e) {

   switch (e.target.id) {

      case "menu":

         if (menu_i % 2 == 0){

            /*非表示*/ new Item_Styles_Animate ("#main", {display:"none",},).setStyles();
            new Item_Styles_Animate ("#main", {opacity: [0, 1], filter: ["blur(1px)", "blur(0)"]}, 
                             "reverse", 0, 0, "ease", "forwards", 1).setStylesAnimate();
            /*表  示*/ new Item_Styles_Animate ("#navi", {display:"flex", flexDirection:"column", alignItems:"center"},).setStyles();
            new Item_Styles_Animate ("#navi", {opacity: [0, 1], filter: ["blur(1px)", "blur(0)"]}, 
                             "normal", 800, 0, "ease", "forwards", 1).setStylesAnimate();
            item_setAttribute_src("#menu",  "./SVG/menu_close.svg");
            menu_i++;

         } else {

            /*表  示*/ new Item_Styles_Animate ("#main", {display:"block",},).setStyles();
            new Item_Styles_Animate ("#main", {opacity: [0, 1], filter: ["blur(1px)", "blur(0)"]}, 
                             "normal", 800, 0, "ease", "forwards", 1).setStylesAnimate();
            /*非表示*/ new Item_Styles_Animate ("#navi", {display:"none",},).setStyles();
            new Item_Styles_Animate ("#navi", {opacity: [0, 1], filter: ["blur(1px)", "blur(0)"]}, 
                             "reverse", 0, 0, "ease", "forwards", 1).setStylesAnimate();
            item_setAttribute_src("#menu",  "./SVG/menu.svg");
            menu_i++;

         }

         break;

      default :

         break;

   }
}





//メニューの目次をクリックした時のイベント------------------------------------------------

function menuContents_click (e) {

   //e.stopPropagation();
   //e.stopImmediatePropagation();
   //e.preventDefault();

   //AJAXのfunctionReferenceの無名関数版----------------------------------------------------------------------

   //target_urlの定義。var target_urlは、グローバル変数としてこのファイル最上部にある。
   switch (e.target.id) {

      case "navi_Top":

         break;

      case "navi_RecoConInfo":

         clearInterval(timer_carousel);
         target_url = "RecoCon_AJAX_pageRecoConInfo.php";
         break;

      case "navi_News":

         clearInterval(timer_carousel);
         target_url = "RecoCon_AJAX_pageNews.php";
         break;

      case "navi_buyTicket":

         clearInterval(timer_carousel);
         target_url = "RecoCon_AJAX_pageBuyTicket.php";
         break;

      case "navi_Access":

         clearInterval(timer_carousel);
         target_url = "RecoCon_AJAX_pageAccess.php";
         break;

      case "navi_MClub":
      case "pageMClub_login_back":
      case "pageMClub_createAcct_back":
      case "pageMClub_mypage_Acct_back":
      case "pageMClub_mypage_Logout_back":
      case "pageMClub_mypage_Delete_back":

         clearInterval(timer_carousel);

         target_url = "RecoCon_AJAX_pageMClub.php";

         funcRef = function (text_data){

            /*表  示*/ new Item_Styles_Animate ("#main", {display:"block",},).setStyles();
            new Item_Styles_Animate ("#main", {opacity: [0, 1], filter: ["blur(1px)", "blur(0)"]}, 
                              "normal", 800, 0, "ease", "forwards", 1).setStylesAnimate();
            /*非表示*/ new Item_Styles_Animate ("#navi", {display:"none",},).setStyles();
            new Item_Styles_Animate ("#navi", {opacity: [0, 1], filter: ["blur(1px)", "blur(0)"]}, 
                              "reverse", 0, 0, "ease", "forwards", 1).setStylesAnimate();
            item_setAttribute_src("#menu",  "./SVG/menu.svg");

            main.innerHTML = text_data;
            //console.log(text_data);

         }

         break;

      case "navi_Request":

         clearInterval(timer_carousel);
         target_url = "RecoCon_AJAX_pageRequest.php";
         break;

      default:

         break;
   }

   //funcRefからhttpRequestをなげるまでの内容の振り分け。
   switch (e.target.id) {

      case "navi_Top":

         location.href = "RecoCon_TOP_XAMPP.php";
         break;

      case "navi_RecoConInfo":
      case "navi_News":
      case "navi_Access":

         funcRef = function (text_data){

            /*表  示*/ new Item_Styles_Animate ("#main", {display:"block",},).setStyles();
            new Item_Styles_Animate ("#main", {opacity: [0, 1], filter: ["blur(1px)", "blur(0)"]}, 
                              "normal", 800, 0, "ease", "forwards", 1).setStylesAnimate();
            /*非表示*/ new Item_Styles_Animate ("#navi", {display:"none",},).setStyles();
            new Item_Styles_Animate ("#navi", {opacity: [0, 1], filter: ["blur(1px)", "blur(0)"]}, 
                              "reverse", 0, 0, "ease", "forwards", 1).setStylesAnimate();
            item_setAttribute_src("#menu",  "./SVG/menu.svg");
            menu_i++;

            main.innerHTML = text_data;
            //console.log(text_data);

         }

         httpRequest_Get (target_url, funcRef);

         break;

      case "navi_buyTicket":

         funcRef = function (text_data){

            /*表  示*/ new Item_Styles_Animate ("#main", {display:"block",},).setStyles();
            new Item_Styles_Animate ("#main", {opacity: [0, 1], filter: ["blur(1px)", "blur(0)"]}, 
                              "normal", 800, 0, "ease", "forwards", 1).setStylesAnimate();
            /*非表示*/ new Item_Styles_Animate ("#navi", {display:"none",},).setStyles();
            new Item_Styles_Animate ("#navi", {opacity: [0, 1], filter: ["blur(1px)", "blur(0)"]}, 
                              "reverse", 0, 0, "ease", "forwards", 1).setStylesAnimate();
            item_setAttribute_src("#menu",  "./SVG/menu.svg");
            menu_i++;

            main.innerHTML = text_data;
            //console.log(text_data);

         }

         contentType = 'application/x-www-form-urlencoded;charset=UTF-8';

         send_data = encodeURIComponent("Frag_Clear") + "=" + encodeURIComponent("Clear");

         httpRequest_Post (target_url, funcRef, contentType, send_data);

         break;

      case "navi_MClub":

         menu_i++;

         httpRequest_Get (target_url, funcRef);

         break;

      case "pageMClub_login_back":
      case "pageMClub_createAcct_back":
      case "pageMClub_mypage_Acct_back":
      case "pageMClub_mypage_Logout_back":
      case "pageMClub_mypage_Delete_back":

         httpRequest_Get (target_url, funcRef);

         break;


      case "navi_Request":

         funcRef = function (text_data){

            /*表  示*/ new Item_Styles_Animate ("#main", {display:"block",},).setStyles();
            new Item_Styles_Animate ("#main", {opacity: [0, 1], filter: ["blur(1px)", "blur(0)"]}, 
                              "normal", 800, 0, "ease", "forwards", 1).setStylesAnimate();
            /*非表示*/ new Item_Styles_Animate ("#navi", {display:"none",},).setStyles();
            new Item_Styles_Animate ("#navi", {opacity: [0, 1], filter: ["blur(1px)", "blur(0)"]}, 
                              "reverse", 0, 0, "ease", "forwards", 1).setStylesAnimate();
            item_setAttribute_src("#menu",  "./SVG/menu.svg");
            menu_i++;

            main.innerHTML = text_data;
            //console.log(text_data);

         }

         httpRequest_Get (target_url, funcRef);

         break;

      default:

         break;

   }

}   //function menuContents_clickの閉じかっこ






//ログイン、新規登録のイベント設定。
document.addEventListener("click", function(e){

   //e.stopPropagation();
   //e.stopImmediatePropagation();
   //e.preventDefault();

   //「ログイン」ボタンをクリックした時
   if (e.target.id == "MClub_login") {

      target_url = "RecoCon_AJAX_pageMClub_login.php";

      funcRef = function (text_data){
         /*表  示*/ new Item_Styles_Animate ("#main", {display:"block",},).setStyles();
         new Item_Styles_Animate ("#main", {opacity: [0, 1], filter: ["blur(1px)", "blur(0)"]}, 
                             "normal", 800, 0, "ease", "forwards", 1).setStylesAnimate();

         main.innerHTML = text_data;
         //console.log(text_data);
      }

      httpRequest_Get (target_url, funcRef);


   //「新規登録」ボタンをクリックした時
   } else if (e.target.id == "MClub_createAcct") {

      target_url = "RecoCon_AJAX_pageMClub_createAcct.php";

      funcRef = function (text_data){
         /*表  示*/ new Item_Styles_Animate ("#main", {display:"block",},).setStyles();
         new Item_Styles_Animate ("#main", {opacity: [0, 1], filter: ["blur(1px)", "blur(0)"]}, 
                             "normal", 800, 0, "ease", "forwards", 1).setStylesAnimate();

         main.innerHTML = text_data;
         //console.log(text_data);
      }

      contentType = 'application/x-www-form-urlencoded;charset=UTF-8';

      send_data = encodeURIComponent("createAcct_Frag_Clear") + "=" + encodeURIComponent("createAcct_Frag_Clear");

      httpRequest_Post (target_url, funcRef, contentType, send_data);

   }

});






//id、パスワード入力後、「ログイン」ボタンをクリックした時
document.addEventListener("click", function(e){

   //e.stopPropagation();
   //e.stopImmediatePropagation();
   //e.preventDefault();

   if (e.target.id == "MClub_input_login") {

      target_url = "RecoCon_AJAX_pageMClub_login_response.php";

      funcRef = function (text_data){
         /*表  示*/ new Item_Styles_Animate ("#main", {display:"block",},).setStyles();
         new Item_Styles_Animate ("#main", {opacity: [0, 1], filter: ["blur(1px)", "blur(0)"]}, 
                             "normal", 800, 0, "ease", "forwards", 1).setStylesAnimate();

         var body = document.querySelector("#body");
         body.innerHTML = text_data;
         //console.log(text_data);
      }

      contentType = 'application/x-www-form-urlencoded;charset=UTF-8';

      var MembersId = document.querySelector("#MClub_inputId");
      var MembersPass = document.querySelector("#MClub_inputPassword");
      send_data = encodeURIComponent("MembersId") + "=" + encodeURIComponent(MembersId.value) + "&" + encodeURIComponent("MembersPass") + "=" + encodeURIComponent(MembersPass.value);

      httpRequest_Post (target_url, funcRef, contentType, send_data);

   }   //if (e.target.id == "MClub_input_login")の閉じかっこ

});






//新規アカウント作成時の入力フォームの入力値チェック。
//input、changeで発火。
//スマホでのIME対応に、e.isComposingでのイベントキャンセルと、compositionendでの発火。
["input", "compositionend", "change"].forEach(type => document.addEventListener(type, function inputCheck (e){
   if(e.isComposing) return;

   switch (e.target.id){

      case "MClub_createAcct_U_Input_Id":
      case "MClub_createAcct_Pass":
      case "MClub_createAcct_Name":
      case "MClub_createAcct_Age":
      case "MClub_createAcct_Sex":
      case "MClub_createAcct_Address1":
      case "MClub_createAcct_Address2":
      case "MClub_createAcct_Address3":
      case "MClub_createAcct_Tel":
      case "MClub_createAcct_Mail":

         U_Input_Id = document.getElementById("MClub_createAcct_U_Input_Id");
         Pass = document.getElementById("MClub_createAcct_Pass");
         Name = document.getElementById("MClub_createAcct_Name");
         Age = document.getElementById("MClub_createAcct_Age");
         Sex = document.getElementById("MClub_createAcct_Sex");
         Address1 = document.getElementById("MClub_createAcct_Address1");
         Address2 = document.getElementById("MClub_createAcct_Address2");
         Address3 = document.getElementById("MClub_createAcct_Address3");
         Tel = document.getElementById("MClub_createAcct_Tel");
         Mail = document.getElementById("MClub_createAcct_Mail");


         U_Input_Id_check = document.getElementById("MClub_createAcct_U_Input_Id_check");
         Pass_check = document.getElementById("MClub_createAcct_Pass_check");
         Name_check = document.getElementById("MClub_createAcct_Name_check");
         Age_check = document.getElementById("MClub_createAcct_Age_check");
         Sex_check = document.getElementById("MClub_createAcct_Sex_check");
         Address1_check = document.getElementById("MClub_createAcct_Address1_check");
         Address2_check = document.getElementById("MClub_createAcct_Address2_check");
         Address3_check = document.getElementById("MClub_createAcct_Address3_check");
         Tel_check = document.getElementById("MClub_createAcct_Tel_check");
         Mail_check = document.getElementById("MClub_createAcct_Mail_check");

         Button = document.getElementById("MClub_createAcct_next");


         //U_Input_ID

            //半角カナを全角に
            U_Input_Id.value = kana_HANKAKU_to_ZENKAKU(U_Input_Id.value);

            //全角アルファベットと数字を半角に
            U_Input_Id.value = alphanumeric_ZENKAKU_to_HANKAKU(U_Input_Id.value);

            //全角スペースを半角スペースに
            var hyphen = /[　]/gi;
            U_Input_Id.value = U_Input_Id.value.replace(hyphen, " ");

            //全角アンダーバーを半角アンダーバーに
            var hyphen = /[＿]/gi;
            U_Input_Id.value = U_Input_Id.value.replace(hyphen, "_");

         //「U_Input_ID」の入力内容の判定

            reg = /^[A-Za-z0-9_]{12,16}$/;

            if (U_Input_Id.value.length === 0) {
               U_Input_Id_check.textContent = "※入力してください。";
               U_Input_IdChecker = 0;

            } else if (!reg.test(U_Input_Id.value)) {
               U_Input_Id_check.textContent = "※正しく入力してください。";
               U_Input_IdChecker = 0;

            } else {
               U_Input_Id_check.textContent = "";
               U_Input_IdChecker = 1;
            }

         //パスワード

            //全角ーを-に
            //var hyphen = /[ー]/gi;
            //Pass.value = Pass.value.replace(hyphen, "-");

            //全角アンダーバーを半角アンダーバーに
            //var hyphen = /[＿]/gi;
            //Pass.value = Pass.value.replace(hyphen, "_");

         //「パスワード」の入力内容の判定

            reg = /^[^\x00-\x1F\x7F]+$/u;
            var length = Array.from(Pass.value).length;   //Array.fromにより絵文字もUnicode文字数に近い数え方。

            if (length === 0) {
               Pass_check.textContent = "※入力してください。";
               PassChecker = 0;

            } else if (length < 12 || length > 128 || !reg.test(Pass.value)) {
               Pass_check.textContent = "※正しく入力してください。";
               PassChecker = 0;

            } else {
               Pass_check.textContent = "";
               PassChecker = 1;
            }

         //名前

            //半角カナを全角に
            Name.value = kana_HANKAKU_to_ZENKAKU(Name.value);

            //全角アルファベットと数字を半角に
            Name.value = alphanumeric_ZENKAKU_to_HANKAKU(Name.value);

            //全角スペースを半角スペースに
            var hyphen = /[　]/gi;
            Name.value = Name.value.replace(hyphen, " ");

         //「名前」の入力内容の判定

            reg = /^[ぁ-んァ-ヶー\u30a0-\u30ff\u3040-\u309f\u3005-\u3006\u30e0-\u9fcf\s]*$/giu;

            if (Name.value.length == 0){
               Name_check.textContent = "※入力してください。";
               NameChecker = 0;
            } else if (!(Name.value.match(reg))){
               Name_check.textContent = "※正しく入力してください。";
               NameChecker = 0;
            } else {
               Name_check.textContent = "";
               NameChecker = 1;
            }


         //年齢

            //半角カナを全角に
            Age.value = kana_HANKAKU_to_ZENKAKU(Age.value);

            //全角アルファベットと数字を半角に
            Age.value = alphanumeric_ZENKAKU_to_HANKAKU(Age.value);

            //全角ーを-に
            var hyphen = /[ー]/gi;
            Age.value = Age.value.replace(hyphen, "-");

            //全角スペースを半角スペースに
            var hyphen = /[　]/gi;
            Age.value = Age.value.replace(hyphen, " ");

         //「年齢」の入力内容の判定

            reg = /^[0-9]*$/gi;

            if (Age.value.length == 0){
               Age_check.textContent = "※入力してください。";
               AgeChecker = 0;
            } else if (!(Age.value.match(reg))){
               Age_check.textContent = "※正しく入力してください。";
               AgeChecker = 0;
            } else {
               Age_check.textContent = "";
               AgeChecker = 1;
            }

         //性別

            //半角カナを全角に
            Sex.value = kana_HANKAKU_to_ZENKAKU(Sex.value);

            //全角アルファベットと数字を半角に
            Sex.value = alphanumeric_ZENKAKU_to_HANKAKU(Sex.value);

            //全角ーを-に
            var hyphen = /[ー]/gi;
            Sex.value = Sex.value.replace(hyphen, "-");

            //全角スペースを半角スペースに
            var hyphen = /[　]/gi;
            Sex.value = Sex.value.replace(hyphen, " ");

         //「性別」の入力内容の判定

            reg = /^[0-9a-zA-Zぁ-んァ-ヶー\u30a0-\u30ff\u3040-\u309f\u3005-\u3006\u30e0-\u9fcf\-\s]*$/giu;

            if (Sex.value.length == 0){
               Sex_check.textContent = "※入力してください。";
               SexChecker = 0;
            } else if (!(Sex.value=="男" || Sex.value=="女")){
               Sex_check.textContent = "※正しく入力してください。";
               SexChecker = 0;
            } else {
               Sex_check.textContent = "";
               SexChecker = 1;
            }

         //住所（都道府県）

            //半角カナを全角に
            Address1.value = kana_HANKAKU_to_ZENKAKU(Address1.value);

            //全角アルファベットと数字を半角に
            Address1.value = alphanumeric_ZENKAKU_to_HANKAKU(Address1.value);

            //全角ーを-に
            var hyphen = /[ー]/gi;
            Address1.value = Address1.value.replace(hyphen, "-");

            //全角スペースを半角スペースに
            var hyphen = /[　]/gi;
            Address1.value = Address1.value.replace(hyphen, " ");

         //「住所（都道府県）」の入力内容の判定

            reg = /^[0-9a-zA-Zぁ-んァ-ヶー\u30a0-\u30ff\u3040-\u309f\u3005-\u3006\u30e0-\u9fcf\-\s]*$/giu;

            if (Address1.value.length == 0){
               Address1_check.textContent = "※入力してください。";
               Address1Checker = 0;
            } else if (!(Address1.value.match(reg))){
               Address1_check.textContent = "※正しく入力してください。";
               Address1Checker = 0;
            } else {
               Address1_check.textContent = "";
               Address1Checker = 1;
            }

         //住所（市区町村）

            //半角カナを全角に
            Address2.value = kana_HANKAKU_to_ZENKAKU(Address2.value);

            //全角アルファベットと数字を半角に
            Address2.value = alphanumeric_ZENKAKU_to_HANKAKU(Address2.value);

            //全角ーを-に
            var hyphen = /[ー]/gi;
            Address2.value = Address2.value.replace(hyphen, "-");

            //全角スペースを半角スペースに
            var hyphen = /[　]/gi;
            Address2.value = Address2.value.replace(hyphen, " ");

         //「住所（市区町村）」の入力内容の判定

            reg = /^[0-9a-zA-Zぁ-んァ-ヶー\u30a0-\u30ff\u3040-\u309f\u3005-\u3006\u30e0-\u9fcf\-\s]*$/giu;

            if (Address2.value.length == 0){
               Address2_check.textContent = "※入力してください。";
               Address2Checker = 0;
            } else if (!(Address2.value.match(reg))){
               Address2_check.textContent = "※正しく入力してください。";
               Address2Checker = 0;
            } else {
               Address2_check.textContent = "";
               Address2Checker = 1;
            }

         //住所（番地以下）

            //半角カナを全角に
            Address3.value = kana_HANKAKU_to_ZENKAKU(Address3.value);

            //全角アルファベットと数字を半角に
            Address3.value = alphanumeric_ZENKAKU_to_HANKAKU(Address3.value);

            //全角ーを-に
            var hyphen = /[ー]/gi;
            Address3.value = Address3.value.replace(hyphen, "-");

            //全角スペースを半角スペースに
            var hyphen = /[　]/gi;
            Address3.value = Address3.value.replace(hyphen, " ");

         //「住所（番地以下）」の入力内容の判定

            reg = /^[0-9a-zA-Zぁ-んァ-ヶー\u30a0-\u30ff\u3040-\u309f\u3005-\u3006\u30e0-\u9fcf\-\s]*$/giu;

            if (Address3.value.length == 0){
               Address3_check.textContent = "※入力してください。";
               Address3Checker = 0;
            } else if (!(Address3.value.match(reg))){
               Address3_check.textContent = "※正しく入力してください。";
               Address3Checker = 0;
            } else {
               Address3_check.textContent = "";
               Address3Checker = 1;
            }

         //電話番号

            //半角カナを全角に
            Tel.value = kana_HANKAKU_to_ZENKAKU(Tel.value);

            //全角アルファベットと数字を半角に
            Tel.value = alphanumeric_ZENKAKU_to_HANKAKU(Tel.value);

            //全角ーを-に
            var hyphen = /[ー]/gi;
            Tel.value = Tel.value.replace(hyphen, "-");

            //全角スペースを半角スペースに
            var hyphen = /[　]/gi;
            Tel.value = Tel.value.replace(hyphen, " ");

         //「電話番号」の入力内容の判定

            reg = /^\d{2,5}-\d{1,4}-\d{4}$/gi;

            if (Tel.value.length == 0){
               Tel_check.textContent = "※入力してください。";
               TelChecker = 0;
            } else if (!(Tel.value.match(reg))){
               Tel_check.textContent = "※正しく入力してください。";
               TelChecker = 0;
            } else {
               Tel_check.textContent = "";
               TelChecker = 1;
            }

         //メールアドレス

            //半角カナを全角に
            Mail.value = kana_HANKAKU_to_ZENKAKU(Mail.value);

            //全角アルファベットと数字を半角に
            Mail.value = alphanumeric_ZENKAKU_to_HANKAKU(Mail.value);

            //全角ーを-に
            var hyphen = /[ー]/gi;
            Mail.value = Mail.value.replace(hyphen, "-");

            //全角スペースを半角スペースに
            var hyphen = /[　]/gi;
            Mail.value = Mail.value.replace(hyphen, " ");

         //「メールアドレス」の入力内容の判定

            reg = /^[0-9a-zA-Z]{1}[\w.-]{0,}@{1}[0-9a-zA-Z]{1}[\w.-]{0,}\.{1,}[0-9a-zA-Z]{1}[\w.-]{0,}$/gi;

            if (Mail.value.length == 0){
               Mail_check.textContent = "※入力してください。";
               MailChecker = 0;
            } else if (!(Mail.value.match(reg))){
               Mail_check.textContent = "※正しく入力してください。";
               MailChecker = 0;
            } else {
               Mail_check.textContent = "";
               MailChecker = 1;
            }


         //入力するたびに全入力フォームのOKNGフラグをチェック。すべて1なら進むボタン起動。

            if (U_Input_IdChecker==1 && PassChecker==1 && NameChecker==1 && AgeChecker==1 && SexChecker==1 && Address1Checker==1 && Address2Checker==1 && Address3Checker==1 && TelChecker==1 && MailChecker==1){
               Button.disabled = false;
               AllChecker = 0;
            } else {
               Button.disabled = true;
               AllChecker = 1;
            }
         

         break;

      default:

         break;

   }
}));





//情報入力後、進むをクリックした時
document.addEventListener("click", function(e){

   //e.stopPropagation();
   //e.stopImmediatePropagation();
   //e.preventDefault();

   if (e.target.id == "MClub_createAcct_next") {

      target_url = "RecoCon_AJAX_pageMClub_createAcct_confirm.php";

      funcRef = function (text_data){
         /*表  示*/ new Item_Styles_Animate ("#main", {display:"block",},).setStyles();
         new Item_Styles_Animate ("#main", {opacity: [0, 1], filter: ["blur(1px)", "blur(0)"]}, 
                             "normal", 800, 0, "ease", "forwards", 1).setStylesAnimate();

         main.innerHTML = text_data;
         //console.log(text_data);
      }

      contentType = 'application/x-www-form-urlencoded;charset=UTF-8';

         U_Input_Id = document.getElementById("MClub_createAcct_U_Input_Id");
         Pass = document.getElementById("MClub_createAcct_Pass");
         Name = document.getElementById("MClub_createAcct_Name");
         Age = document.getElementById("MClub_createAcct_Age");
         Sex = document.getElementById("MClub_createAcct_Sex");
         Address1 = document.getElementById("MClub_createAcct_Address1");
         Address2 = document.getElementById("MClub_createAcct_Address2");
         Address3 = document.getElementById("MClub_createAcct_Address3");
         Tel = document.getElementById("MClub_createAcct_Tel");
         Mail = document.getElementById("MClub_createAcct_Mail");

         Button = document.getElementById("MClub_createAcct_next");

      send_data = encodeURIComponent("U_Input_Id") + "=" + encodeURIComponent(U_Input_Id.value) + "&" + 
                  encodeURIComponent("Pass") + "=" + encodeURIComponent(Pass.value) + "&" + 
                  encodeURIComponent("Name") + "=" + encodeURIComponent(Name.value) + "&" + 
                  encodeURIComponent("Age") + "=" + encodeURIComponent(Age.value) + "&" + 
                  encodeURIComponent("Sex") + "=" + encodeURIComponent(Sex.value) + "&" + 
                  encodeURIComponent("Address1") + "=" + encodeURIComponent(Address1.value) + "&" + 
                  encodeURIComponent("Address2") + "=" + encodeURIComponent(Address2.value) + "&" + 
                  encodeURIComponent("Address3") + "=" + encodeURIComponent(Address3.value) + "&" + 
                  encodeURIComponent("Tel") + "=" + encodeURIComponent(Tel.value) + "&" + 
                  encodeURIComponent("Mail") + "=" + encodeURIComponent(Mail.value) + "&" +
                  encodeURIComponent("AllChecker") + "=" + encodeURIComponent(AllChecker);

      httpRequest_Post (target_url, funcRef, contentType, send_data);
 
   }   //if (e.target.id == "MClub_createAcct_next")の閉じかっこ

});






//確認画面で「修正する」ボタンをクリックした時
document.addEventListener("click", function(e){
   if (e.target.id == "pageMClub_createAcct_confirm_back") {

      target_url = "RecoCon_AJAX_pageMClub_createAcct.php";

      funcRef = function (text_data){
         /*表  示*/ new Item_Styles_Animate ("#main", {display:"block",},).setStyles();
         new Item_Styles_Animate ("#main", {opacity: [0, 1], filter: ["blur(1px)", "blur(0)"]}, 
                             "normal", 800, 0, "ease", "forwards", 1).setStylesAnimate();

         main.innerHTML = text_data;
         //console.log(text_data);
      }

      contentType = 'application/x-www-form-urlencoded;charset=UTF-8';

      send_data = encodeURIComponent("Frag") + "=" + encodeURIComponent("back");

      httpRequest_Post (target_url, funcRef, contentType, send_data);

   }
});






//情報確認後、確定をクリックした時
document.addEventListener("click", function(e){

   //e.stopPropagation();
   //e.stopImmediatePropagation();
   //e.preventDefault();

   if (e.target.id == "MClub_createAcct_confirm_cofirm_confirm") {

      target_url = "RecoCon_AJAX_pageMClub_createAcct_confirm_confirm.php";

      funcRef = function (text_data){
         /*表  示*/ new Item_Styles_Animate ("#main", {display:"block",},).setStyles();
         new Item_Styles_Animate ("#main", {opacity: [0, 1], filter: ["blur(1px)", "blur(0)"]}, 
                                  "normal", 800, 0, "ease", "forwards", 1).setStylesAnimate();

         var body = document.querySelector("#body");
         body.innerHTML = text_data;
         //console.log(text_data);
      }

      contentType = 'application/x-www-form-urlencoded;charset=UTF-8';

      var token = document.querySelector("#token");
      var MClub_createAcct_confirm_Id = document.querySelector("#MClub_createAcct_confirm_Id");
      var MClub_createAcct_confirm_Pass = document.querySelector("#MClub_createAcct_confirm_Pass");
      var MClub_createAcct_confirm_Name = document.querySelector("#MClub_createAcct_confirm_Name");
      var MClub_createAcct_confirm_Age = document.querySelector("#MClub_createAcct_confirm_Age");
      var MClub_createAcct_confirm_Sex = document.querySelector("#MClub_createAcct_confirm_Sex");
      var MClub_createAcct_confirm_Address1 = document.querySelector("#MClub_createAcct_confirm_Address1");
      var MClub_createAcct_confirm_Address2 = document.querySelector("#MClub_createAcct_confirm_Address2");
      var MClub_createAcct_confirm_Address3 = document.querySelector("#MClub_createAcct_confirm_Address3");
      var MClub_createAcct_confirm_Tel = document.querySelector("#MClub_createAcct_confirm_Tel");
      var MClub_createAcct_confirm_Mail = document.querySelector("#MClub_createAcct_confirm_Mail");

      send_data = encodeURIComponent("token") + "=" + encodeURIComponent(token.value) + "&" +
                  encodeURIComponent("MClub_createAcct_confirm_Id") + "=" + encodeURIComponent(MClub_createAcct_confirm_Id.textContent) + "&" + 
                  encodeURIComponent("MClub_createAcct_confirm_Pass") + "=" + encodeURIComponent(MClub_createAcct_confirm_Pass.textContent) + "&" + 
                  encodeURIComponent("MClub_createAcct_confirm_Name") + "=" + encodeURIComponent(MClub_createAcct_confirm_Name.textContent) + "&" + 
                  encodeURIComponent("MClub_createAcct_confirm_Age") + "=" + encodeURIComponent(MClub_createAcct_confirm_Age.textContent) + "&" + 
                  encodeURIComponent("MClub_createAcct_confirm_Sex") + "=" + encodeURIComponent(MClub_createAcct_confirm_Sex.textContent) + "&" + 
                  encodeURIComponent("MClub_createAcct_confirm_Address1") + "=" + encodeURIComponent(MClub_createAcct_confirm_Address1.textContent) + "&" + 
                  encodeURIComponent("MClub_createAcct_confirm_Address2") + "=" + encodeURIComponent(MClub_createAcct_confirm_Address2.textContent) + "&" + 
                  encodeURIComponent("MClub_createAcct_confirm_Address3") + "=" + encodeURIComponent(MClub_createAcct_confirm_Address3.textContent) + "&" + 
                  encodeURIComponent("MClub_createAcct_confirm_Tel") + "=" + encodeURIComponent(MClub_createAcct_confirm_Tel.textContent) + "&" + 
                  encodeURIComponent("MClub_createAcct_confirm_Mail") + "=" + encodeURIComponent(MClub_createAcct_confirm_Mail.textContent);

      httpRequest_Post (target_url, funcRef, contentType, send_data);

   }   //if (e.target.id == "MClub_createAcct_confirm_cofirm_confirm")の閉じかっこ

});






//マイページのアカウント画面へ。
document.addEventListener("click", function(e){

   //e.stopPropagation();
   //e.stopImmediatePropagation();
   //e.preventDefault();

   if (e.target.id == "MClub_Acct" || e.target.id == "pageMClub_mypage_Acct_update_back") {

      target_url = "RecoCon_AJAX_pageMClub_mypage_Acct.php";

      funcRef = function (text_data){
         /*表  示*/ new Item_Styles_Animate ("#main", {display:"block",},).setStyles();
                    main.style = "display: block";
         new Item_Styles_Animate ("#main", {opacity: [0, 1], filter: ["blur(1px)", "blur(0)"]}, 
                             "normal", 800, 0, "ease", "forwards", 1).setStylesAnimate();

         main.innerHTML = text_data;
         //console.log(text_data);
      }

      httpRequest_Get (target_url, funcRef);
 
   }   //if (e.target.id == "MClub_Acct")の閉じかっこ

});






//アカウントの更新画面へ。
document.addEventListener("click", function(e){

   //e.stopPropagation();
   //e.stopImmediatePropagation();
   //e.preventDefault();

   if (e.target.id == "MClub_updateAcct") {

      target_url = "RecoCon_AJAX_pageMClub_mypage_Acct_update.php";

      funcRef = function (text_data){
         /*表  示*/ new Item_Styles_Animate ("#main", {display:"block",},).setStyles();
         new Item_Styles_Animate ("#main", {opacity: [0, 1], filter: ["blur(1px)", "blur(0)"]}, 
                             "normal", 800, 0, "ease", "forwards", 1).setStylesAnimate();

         main.innerHTML = text_data;
         //console.log(text_data);
      }

      httpRequest_Get (target_url, funcRef);
 
   }   //if (e.target.id == "MClub_Acct")の閉じかっこ

});





//情報修正後、更新をクリックした時
document.addEventListener("click", function(e){   

   //e.stopPropagation();
   //e.stopImmediatePropagation();
   //e.preventDefault();

   if (e.target.id == "MClub_Acct_Update") {

      target_url = "RecoCon_AJAX_pageMClub_mypage_Acct_update_confirm.php";

      funcRef = function (text_data){
         /*表  示*/ new Item_Styles_Animate ("#body", {display:"block",},).setStyles();
         new Item_Styles_Animate ("#main", {opacity: [0, 1], filter: ["blur(1px)", "blur(0)"]}, 
                                  "normal", 800, 0, "ease", "forwards", 1).setStylesAnimate();

         var body = document.querySelector("#body");
         body.innerHTML = text_data;
         //console.log(text_data);
      }

      contentType = 'application/x-www-form-urlencoded;charset=UTF-8';

      var MClub_updateAcct_U_Id = document.querySelector("#MClub_updateAcct_U_Id");
      var MClub_updateAcct_U_Input_Id = document.querySelector("#MClub_updateAcct_U_Input_Id");
      var MClub_updateAcct_Name = document.querySelector("#MClub_updateAcct_Name");
      var MClub_updateAcct_Age = document.querySelector("#MClub_updateAcct_Age");
      var MClub_updateAcct_Sex = document.querySelector("#MClub_updateAcct_Sex");
      var MClub_updateAcct_Address1 = document.querySelector("#MClub_updateAcct_Address1");
      var MClub_updateAcct_Address2 = document.querySelector("#MClub_updateAcct_Address2");
      var MClub_updateAcct_Address3 = document.querySelector("#MClub_updateAcct_Address3");
      var MClub_updateAcct_Tel = document.querySelector("#MClub_updateAcct_Tel");
      var MClub_updateAcct_Mail = document.querySelector("#MClub_updateAcct_Mail");
      token = document.querySelector("#token");

      send_data = encodeURIComponent("MClub_updateAcct_U_Id") + "=" + encodeURIComponent(MClub_updateAcct_U_Id.value) + "&" + 
                  //encodeURIComponent("MClub_updateAcct_U_Input_Id") + "=" + encodeURIComponent(MClub_updateAcct_U_Input_Id.value) + "&" + 
                  //encodeURIComponent("MClub_updateAcct_Pass") + "=" + encodeURIComponent(MClub_updateAcct_Pass.value) + "&" + 
                  encodeURIComponent("MClub_updateAcct_Name") + "=" + encodeURIComponent(MClub_updateAcct_Name.value) + "&" + 
                  encodeURIComponent("MClub_updateAcct_Age") + "=" + encodeURIComponent(MClub_updateAcct_Age.value) + "&" + 
                  encodeURIComponent("MClub_updateAcct_Sex") + "=" + encodeURIComponent(MClub_updateAcct_Sex.value) + "&" + 
                  encodeURIComponent("MClub_updateAcct_Address1") + "=" + encodeURIComponent(MClub_updateAcct_Address1.value) + "&" + 
                  encodeURIComponent("MClub_updateAcct_Address2") + "=" + encodeURIComponent(MClub_updateAcct_Address2.value) + "&" + 
                  encodeURIComponent("MClub_updateAcct_Address3") + "=" + encodeURIComponent(MClub_updateAcct_Address3.value) + "&" + 
                  encodeURIComponent("MClub_updateAcct_Tel") + "=" + encodeURIComponent(MClub_updateAcct_Tel.value) + "&" + 
                  encodeURIComponent("MClub_updateAcct_Mail") + "=" + encodeURIComponent(MClub_updateAcct_Mail.value) + "&" + 
                  encodeURIComponent("token") + "=" + encodeURIComponent(token.value);

      httpRequest_Post (target_url, funcRef, contentType, send_data);

   }   //if (e.target.id == "MClub_updateAcct")の閉じかっこ

});



//ログアウト処理の意思確認ページへ。
document.addEventListener("click", function(e){

   //e.stopPropagation();
   //e.stopImmediatePropagation();
   //e.preventDefault();

   if (e.target.id == "MClub_Logout") {

      target_url = "RecoCon_AJAX_pageMClub_mypage_Logout.php";

      funcRef = function (text_data){
         /*表  示*/ new Item_Styles_Animate ("#main", {display:"block",},).setStyles();
         new Item_Styles_Animate ("#main", {opacity: [0, 1], filter: ["blur(1px)", "blur(0)"]}, 
                             "normal", 800, 0, "ease", "forwards", 1).setStylesAnimate();

         main.innerHTML = text_data;
         //console.log(text_data);
      }

      httpRequest_Get (target_url, funcRef);

   }   //ifの閉じかっこ
});



//ログアウト処理。$_SESSION破棄後、トップページへロケーション変更。
document.addEventListener("click", function(e){

   //e.stopPropagation();
   //e.stopImmediatePropagation();
   //e.preventDefault();

   if (e.target.id == "MClub_Logout_confirm_Yes") {

      target_url = "RecoCon_AJAX_pageMClub_mypage_Logout_LogoutMyPage.php";

      funcRef = function (text_data){
         /*表  示*/ new Item_Styles_Animate ("#main", {display:"block",},).setStyles();
         new Item_Styles_Animate ("#main", {opacity: [0, 1], filter: ["blur(1px)", "blur(0)"]}, 
                             "normal", 800, 0, "ease", "forwards", 1).setStylesAnimate();

         var body = document.querySelector("#body");
         body.innerHTML = text_data;
         //console.log(text_data);
      }

      contentType = 'application/x-www-form-urlencoded;charset=UTF-8';

      token = document.querySelector("#token");
      send_data = encodeURIComponent("token") + "=" + encodeURIComponent(token.value);

      httpRequest_Post (target_url, funcRef, contentType, send_data);

   }   //ifの閉じかっこ
});






//退会処理。本当に退会するか確認する。
document.addEventListener("click", function(e){

   //e.stopPropagation();
   //e.stopImmediatePropagation();
   //e.preventDefault();

   if (e.target.id == "MClub_deleteAcct") {

      target_url = "RecoCon_AJAX_pageMClub_mypage_Delete.php";

      funcRef = function (text_data){
         /*表  示*/ new Item_Styles_Animate ("#main", {display:"block",},).setStyles();
         new Item_Styles_Animate ("#main", {opacity: [0, 1], filter: ["blur(1px)", "blur(0)"]}, 
                             "normal", 800, 0, "ease", "forwards", 1).setStylesAnimate();

         main.innerHTML = text_data;
         //console.log(text_data);
      }

      httpRequest_Get (target_url, funcRef);

   }   //ifの閉じかっこ
});






//退会処理。$_SESSIONのユーザーidのユーザー情報を削除する。
document.addEventListener("click", function(e){

   //e.stopPropagation();
   //e.stopImmediatePropagation();
   //e.preventDefault();

   if (e.target.id == "MClub_Delete") {

      target_url = "RecoCon_AJAX_pageMClub_mypage_Delete_deleteAcct.php";

      funcRef = function (text_data){
         /*表  示*/ new Item_Styles_Animate ("#main", {display:"block",},).setStyles();
         new Item_Styles_Animate ("#main", {opacity: [0, 1], filter: ["blur(1px)", "blur(0)"]}, 
                             "normal", 800, 0, "ease", "forwards", 1).setStylesAnimate();

         var body = document.querySelector("#body");
         body.innerHTML = text_data;
         //console.log(text_data);
      }

      contentType = 'application/x-www-form-urlencoded;charset=UTF-8';

      token = document.querySelector("#token");
      send_data = encodeURIComponent("token") + "=" + encodeURIComponent(token.value);

      httpRequest_Post (target_url, funcRef, contentType, send_data);

   }   //ifの閉じかっこ
});






//ご感想ご要望ページ。ユーザーの入力内容をDBへ格納するAJAX送信クリックイベント。
document.addEventListener("click", function(e){

   //e.stopPropagation();
   //e.stopImmediatePropagation();
   //e.preventDefault();

   if (e.target.id == "submit_request") {

      target_url = "RecoCon_AJAX_pageRequestResponse.php";

      funcRef = function (text_data){
         /*表  示*/ new Item_Styles_Animate ("#main", {display:"block",},).setStyles();
         new Item_Styles_Animate ("#main", {opacity: [0, 1], filter: ["blur(1px)", "blur(0)"]}, 
                             "normal", 800, 0, "ease", "forwards", 1).setStylesAnimate();

         main.innerHTML = text_data;
         //console.log(text_data);
      }

      contentType = 'application/x-www-form-urlencoded;charset=UTF-8';

      var request = document.querySelector("#input_request");
      var requestToken = document.querySelector("#token");
      send_data = encodeURIComponent("token") + "=" + encodeURIComponent(requestToken.value) + "&" +
                  encodeURIComponent("request") + "=" + encodeURIComponent(request.value);

      httpRequest_Post (target_url, funcRef, contentType, send_data);

   }   //ifの閉じかっこ
});






//ご感想ご要望ページ。ユーザーの入力内容をDBへ格納するAJAX送信クリックイベント。
document.addEventListener("input", function(e){

   switch (e.target.id){

      case "input_request":

         document.getElementById("textLength").textContent = document.getElementById("input_request").value.length + " / 400文字";

         if(document.getElementById("input_request").value.length >= 400) {
            document.getElementById("requestLength").style = "color: rgb(255, 60, 60)";
         } else if (document.getElementById("input_request").value.length < 400){
            document.getElementById("requestLength").style = "color: rgb(0, 0, 0)";
         }

      break;

   default:

      break;

   }

});






//ヘッダーのログアイコンをクリックした時。
document.addEventListener("click", function(e){

   //e.stopPropagation();
   //e.stopImmediatePropagation();
   //e.preventDefault();

   //ボタンをクリックした時
   switch (e.target.id){
      case "LogoutMark":

         clearInterval(timer_carousel);

         target_url = "RecoCon_AJAX_pageMClub_login.php";

         funcRef = function (text_data){
            /*表  示*/ new Item_Styles_Animate ("#main", {display:"block",},).setStyles();
            new Item_Styles_Animate ("#main", {opacity: [0, 1], filter: ["blur(1px)", "blur(0)"]}, 
                                "normal", 800, 0, "ease", "forwards", 1).setStylesAnimate();
            /*非表示*/ new Item_Styles_Animate ("#navi", {display:"none",},).setStyles();
            new Item_Styles_Animate ("#navi", {opacity: [0, 1], filter: ["blur(1px)", "blur(0)"]}, 
                             "reverse", 0, 0, "ease", "forwards", 1).setStylesAnimate();
            item_setAttribute_src("#menu",  "./SVG/menu.svg");
            
            main.innerHTML = text_data;
            //console.log(text_data);
         }

         httpRequest_Get (target_url, funcRef);

         if (menu_i%2 == 0){return;} else {menu_i++;}

         break;

      case "LoginMark":

         clearInterval(timer_carousel);

         target_url = "RecoCon_AJAX_pageMClub.php";

         funcRef = function (text_data){
            /*表  示*/ new Item_Styles_Animate ("#main", {display:"block",},).setStyles();
            new Item_Styles_Animate ("#main", {opacity: [0, 1], filter: ["blur(1px)", "blur(0)"]}, 
                                "normal", 800, 0, "ease", "forwards", 1).setStylesAnimate();
            /*非表示*/ new Item_Styles_Animate ("#navi", {display:"none",},).setStyles();
            new Item_Styles_Animate ("#navi", {opacity: [0, 1], filter: ["blur(1px)", "blur(0)"]}, 
                             "reverse", 0, 0, "ease", "forwards", 1).setStylesAnimate();
            item_setAttribute_src("#menu",  "./SVG/menu.svg");
            
            main.innerHTML = text_data;
            //console.log(text_data);
         }

         httpRequest_Get (target_url, funcRef);

         if (menu_i%2 == 0){return;} else {menu_i++;}

         break;

      default:

         break;

   }
});






//アカウント情報更新時の入力フォームの入力値チェック。
["input", "compositionend", "change"].forEach(type => document.addEventListener(type, function inputCheck (e){
   if(e.isComposing) return;

   switch (e.target.id){

      case "MClub_updateAcct_Name":
      case "MClub_updateAcct_Age":
      case "MClub_updateAcct_Sex":
      case "MClub_updateAcct_Address1":
      case "MClub_updateAcct_Address2":
      case "MClub_updateAcct_Address3":
      case "MClub_updateAcct_Tel":
      case "MClub_updateAcct_Mail":

         var MClub_updateAcct_U_Id = document.querySelector("#MClub_updateAcct_U_Id");
         var MClub_updateAcct_U_Input_Id = document.querySelector("#MClub_updateAcct_U_Input_Id");
         var MClub_updateAcct_Name = document.querySelector("#MClub_updateAcct_Name");
         var MClub_updateAcct_Age = document.querySelector("#MClub_updateAcct_Age");
         var MClub_updateAcct_Sex = document.querySelector("#MClub_updateAcct_Sex");
         var MClub_updateAcct_Address1 = document.querySelector("#MClub_updateAcct_Address1");
         var MClub_updateAcct_Address2 = document.querySelector("#MClub_updateAcct_Address2");
         var MClub_updateAcct_Address3 = document.querySelector("#MClub_updateAcct_Address3");
         var MClub_updateAcct_Tel = document.querySelector("#MClub_updateAcct_Tel");
         var MClub_updateAcct_Mail = document.querySelector("#MClub_updateAcct_Mail");

         //名前

            //半角カナを全角に
            MClub_updateAcct_Name.value = kana_HANKAKU_to_ZENKAKU(MClub_updateAcct_Name.value);

            //全角アルファベットと数字を半角に
            MClub_updateAcct_Name.value = alphanumeric_ZENKAKU_to_HANKAKU(MClub_updateAcct_Name.value);

            //全角スペースを半角スペースに
            var hyphen = /[　]/gi;
            MClub_updateAcct_Name.value = MClub_updateAcct_Name.value.replace(hyphen, " ");

         //「名前」の入力内容の判定

            reg = /^[ぁ-んァ-ヶー\u30a0-\u30ff\u3040-\u309f\u3005-\u3006\u30e0-\u9fcf\s]*$/giu;
            if (MClub_updateAcct_Name.value.length == 0){
               item_textContent("#MClub_updateAcct_Name_check", "※入力してください。");
               new Item_Styles_Animate ("#MClub_updateAcct_Name_check", {color: "rgb(250, 78, 174)",}).setStyles();
               updateAcct_nameChecker = 0;
            } else if (!(MClub_updateAcct_Name.value.match(reg))){
               item_textContent("#MClub_updateAcct_Name_check", "※正しく入力してください。");
               new Item_Styles_Animate ("#MClub_updateAcct_Name_check", {color: "rgb(250, 78, 174)",}).setStyles();
               updateAcct_nameChecker = 0;
            } else {
               item_textContent("#MClub_updateAcct_Name_check", "");
               updateAcct_nameChecker = 1;
            }


         //年齢

            //半角カナを全角に
            MClub_updateAcct_Age.value = kana_HANKAKU_to_ZENKAKU(MClub_updateAcct_Age.value);

            //全角アルファベットと数字を半角に
            MClub_updateAcct_Age.value = alphanumeric_ZENKAKU_to_HANKAKU(MClub_updateAcct_Age.value);

            //全角ーを-に
            var hyphen = /[ー]/gi;
            MClub_updateAcct_Age.value = MClub_updateAcct_Age.value.replace(hyphen, "-");

            //全角スペースを半角スペースに
            var hyphen = /[　]/gi;
            MClub_updateAcct_Age.value = MClub_updateAcct_Age.value.replace(hyphen, " ");

         //「年齢」の入力内容の判定

            reg = /^[0-9]*$/gi;
            if (MClub_updateAcct_Age.value.length == 0){
               item_textContent("#MClub_updateAcct_Age_check", "※入力してください。");
               new Item_Styles_Animate ("#MClub_updateAcct_Age_check", {color: "rgb(250, 78, 174)",}).setStyles();
               updateAcct_ageChecker = 0;
            } else if (!(MClub_updateAcct_Age.value.match(reg))){
               item_textContent("#MClub_updateAcct_Age_check", "※正しく入力してください。");
               new Item_Styles_Animate ("#MClub_updateAcct_Age_check", {color: "rgb(250, 78, 174)",}).setStyles();
               updateAcct_ageChecker = 0;
            } else {
               item_textContent("#MClub_updateAcct_Age_check", "");
               updateAcct_ageChecker = 1;
            }

         //性別

            //半角カナを全角に
            MClub_updateAcct_Sex.value = kana_HANKAKU_to_ZENKAKU(MClub_updateAcct_Sex.value);

            //全角アルファベットと数字を半角に
            MClub_updateAcct_Sex.value = alphanumeric_ZENKAKU_to_HANKAKU(MClub_updateAcct_Sex.value);

            //全角ーを-に
            var hyphen = /[ー]/gi;
            MClub_updateAcct_Sex.value = MClub_updateAcct_Sex.value.replace(hyphen, "-");

            //全角スペースを半角スペースに
            var hyphen = /[　]/gi;
            MClub_updateAcct_Sex.value = MClub_updateAcct_Sex.value.replace(hyphen, " ");

         //「性別」の入力内容の判定

            reg = /^[0-9a-zA-Zぁ-んァ-ヶー\u30a0-\u30ff\u3040-\u309f\u3005-\u3006\u30e0-\u9fcf\-\s]*$/giu;
            if (MClub_updateAcct_Sex.value.length == 0){
               item_textContent("#MClub_updateAcct_Sex_check", "※入力してください。");
               new Item_Styles_Animate ("#MClub_updateAcct_Sex_check", {color: "rgb(250, 78, 174)",}).setStyles();
               updateAcct_sexChecker = 0;
            } else if (!(MClub_updateAcct_Sex.value=="男" || MClub_updateAcct_Sex.value=="女")){
               item_textContent("#MClub_updateAcct_Sex_check", "※正しく入力してください。");
               new Item_Styles_Animate ("#MClub_updateAcct_Sex_check", {color: "rgb(250, 78, 174)",}).setStyles();
               updateAcct_sexChecker = 0;
            } else {
               item_textContent("#MClub_updateAcct_Sex_check", "");
               updateAcct_sexChecker = 1;
            }

         //住所（都道府県）

            //半角カナを全角に
            MClub_updateAcct_Address1.value = kana_HANKAKU_to_ZENKAKU(MClub_updateAcct_Address1.value);

            //全角アルファベットと数字を半角に
            MClub_updateAcct_Address1.value = alphanumeric_ZENKAKU_to_HANKAKU(MClub_updateAcct_Address1.value);

            //全角ーを-に
            var hyphen = /[ー]/gi;
            MClub_updateAcct_Address1.value = MClub_updateAcct_Address1.value.replace(hyphen, "-");

            //全角スペースを半角スペースに
            var hyphen = /[　]/gi;
            MClub_updateAcct_Address1.value = MClub_updateAcct_Address1.value.replace(hyphen, " ");

         //「住所（都道府県）」の入力内容の判定

            reg = /^[0-9a-zA-Zぁ-んァ-ヶー\u30a0-\u30ff\u3040-\u309f\u3005-\u3006\u30e0-\u9fcf\-\s]*$/giu;
            if (MClub_updateAcct_Address1.value.length == 0){
               item_textContent("#MClub_updateAcct_Address1_check", "※入力してください。");
               new Item_Styles_Animate ("#MClub_updateAcct_Address1_check", {color: "rgb(250, 78, 174)",}).setStyles();
               updateAcct_address1Checker = 0;
            } else if (!(MClub_updateAcct_Address1.value.match(reg))){
               item_textContent("#MClub_updateAcct_Address1_check", "※正しく入力してください。");
               new Item_Styles_Animate ("#MClub_updateAcct_Address1_check", {color: "rgb(250, 78, 174)",}).setStyles();
               updateAcct_address1Checker = 0;
            } else {
               item_textContent("#MClub_updateAcct_Address1_check", "");
               updateAcct_address1Checker = 1;
            }

         //住所（市区町村）

            //半角カナを全角に
            MClub_updateAcct_Address2.value = kana_HANKAKU_to_ZENKAKU(MClub_updateAcct_Address2.value);

            //全角アルファベットと数字を半角に
            MClub_updateAcct_Address2.value = alphanumeric_ZENKAKU_to_HANKAKU(MClub_updateAcct_Address2.value);

            //全角ーを-に
            var hyphen = /[ー]/gi;
            MClub_updateAcct_Address2.value = MClub_updateAcct_Address2.value.replace(hyphen, "-");

            //全角スペースを半角スペースに
            var hyphen = /[　]/gi;
            MClub_updateAcct_Address2.value = MClub_updateAcct_Address2.value.replace(hyphen, " ");

         //「住所（市区町村）」の入力内容の判定

            reg = /^[0-9a-zA-Zぁ-んァ-ヶー\u30a0-\u30ff\u3040-\u309f\u3005-\u3006\u30e0-\u9fcf\-\s]*$/giu;
            if (MClub_updateAcct_Address2.value.length == 0){
               item_textContent("#MClub_updateAcct_Address2_check", "※入力してください。");
               new Item_Styles_Animate ("#MClub_updateAcct_Address2_check", {color: "rgb(250, 78, 174)",}).setStyles();
               updateAcct_address2Checker = 0;
            } else if (!(MClub_updateAcct_Address2.value.match(reg))){
               item_textContent("#MClub_updateAcct_Address2_check", "※正しく入力してください。");
               new Item_Styles_Animate ("#MClub_updateAcct_Address2_check", {color: "rgb(250, 78, 174)",}).setStyles();
               updateAcct_address2Checker = 0;
            } else {
               item_textContent("#MClub_updateAcct_Address2_check", "");
               updateAcct_address2Checker = 1;
            }

         //住所（番地以下）

            //半角カナを全角に
            MClub_updateAcct_Address3.value = kana_HANKAKU_to_ZENKAKU(MClub_updateAcct_Address3.value);

            //全角アルファベットと数字を半角に
            MClub_updateAcct_Address3.value = alphanumeric_ZENKAKU_to_HANKAKU(MClub_updateAcct_Address3.value);

            //全角ーを-に
            var hyphen = /[ー]/gi;
            MClub_updateAcct_Address3.value = MClub_updateAcct_Address3.value.replace(hyphen, "-");

            //全角スペースを半角スペースに
            var hyphen = /[　]/gi;
            MClub_updateAcct_Address3.value = MClub_updateAcct_Address3.value.replace(hyphen, " ");

         //「住所（番地以下）」の入力内容の判定

            reg = /^[0-9a-zA-Zぁ-んァ-ヶー\u30a0-\u30ff\u3040-\u309f\u3005-\u3006\u30e0-\u9fcf\-\s]*$/giu;
            if (MClub_updateAcct_Address3.value.length == 0){
               item_textContent("#MClub_updateAcct_Address3_check", "※入力してください。");
               new Item_Styles_Animate ("#MClub_updateAcct_Address3_check", {color: "rgb(250, 78, 174)",}).setStyles();
               updateAcct_address3Checker = 0;
            } else if (!(MClub_updateAcct_Address3.value.match(reg))){
               item_textContent("#MClub_updateAcct_Address3_check", "※正しく入力してください。");
               new Item_Styles_Animate ("#MClub_updateAcct_Address3_check", {color: "rgb(250, 78, 174)",}).setStyles();
               updateAcct_address3Checker = 0;
            } else {
               item_textContent("#MClub_updateAcct_Address3_check", "");
               updateAcct_address3Checker = 1;
            }

         //電話番号

            //半角カナを全角に
            MClub_updateAcct_Tel.value = kana_HANKAKU_to_ZENKAKU(MClub_updateAcct_Tel.value);

            //全角アルファベットと数字を半角に
            MClub_updateAcct_Tel.value = alphanumeric_ZENKAKU_to_HANKAKU(MClub_updateAcct_Tel.value);

            //全角ーを-に
            var hyphen = /[ー]/gi;
            MClub_updateAcct_Tel.value = MClub_updateAcct_Tel.value.replace(hyphen, "-");

            //全角スペースを半角スペースに
            var hyphen = /[　]/gi;
            MClub_updateAcct_Tel.value = MClub_updateAcct_Tel.value.replace(hyphen, " ");

         //「電話番号」の入力内容の判定

            reg = /^\d{2,5}-\d{1,4}-\d{4}$/gi;
            if (MClub_updateAcct_Tel.value.length == 0){
               item_textContent("#MClub_updateAcct_Tel_check", "※入力してください。");
               new Item_Styles_Animate ("#MClub_updateAcct_Tel_check", {color: "rgb(250, 78, 174)",}).setStyles();
               updateAcct_telChecker = 0;
            } else if (!(MClub_updateAcct_Tel.value.match(reg))){
               item_textContent("#MClub_updateAcct_Tel_check", "※正しく入力してください。");
               new Item_Styles_Animate ("#MClub_updateAcct_Tel_check", {color: "rgb(250, 78, 174)",}).setStyles();
               updateAcct_telChecker = 0;
            } else {
               item_textContent("#MClub_updateAcct_Tel_check", "");
               updateAcct_telChecker = 1;
            }

         //メールアドレス

            //半角カナを全角に
            MClub_updateAcct_Mail.value = kana_HANKAKU_to_ZENKAKU(MClub_updateAcct_Mail.value);

            //全角アルファベットと数字を半角に
            MClub_updateAcct_Mail.value = alphanumeric_ZENKAKU_to_HANKAKU(MClub_updateAcct_Mail.value);

            //全角ーを-に
            var hyphen = /[ー]/gi;
            MClub_updateAcct_Mail.value = MClub_updateAcct_Mail.value.replace(hyphen, "-");

            //全角スペースを半角スペースに
            var hyphen = /[　]/gi;
            MClub_updateAcct_Mail.value = MClub_updateAcct_Mail.value.replace(hyphen, " ");

         //「メールアドレス」の入力内容の判定

            reg = /^[0-9a-zA-Z]{1}[\w.-]{0,}@{1}[0-9a-zA-Z]{1}[\w.-]{0,}\.{1,}[0-9a-zA-Z]{1}[\w.-]{0,}$/gi;
            if (MClub_updateAcct_Mail.value.length == 0){
               item_textContent("#MClub_updateAcct_Mail_check", "※入力してください。");
               new Item_Styles_Animate ("#MClub_updateAcct_Mail_check", {color: "rgb(250, 78, 174)",}).setStyles();
               updateAcct_mailChecker = 0;
            } else if (!(MClub_updateAcct_Mail.value.match(reg))){
               item_textContent("#MClub_updateAcct_Mail_check", "※正しく入力してください。");
               new Item_Styles_Animate ("#MClub_updateAcct_Mail_check", {color: "rgb(250, 78, 174)",}).setStyles();
               updateAcct_mailChecker = 0;
            } else {
               item_textContent("#MClub_updateAcct_Mail_check", "");
               updateAcct_mailChecker = 1;
            }


         //入力するたびに全入力フォームのOKNGフラグをチェック。すべて1なら進むボタン起動。

            if (updateAcct_nameChecker==1 && updateAcct_ageChecker==1 && updateAcct_sexChecker==1 && updateAcct_address1Checker==1 && updateAcct_address2Checker==1 && updateAcct_address3Checker==1 && updateAcct_telChecker==1 && updateAcct_mailChecker==1){
               document.getElementById("MClub_Acct_Update").disabled = false;
               document.getElementById("MClub_Acct_Update").style = "background-color: rgb(250, 78, 174)";
               BuyTicket_input_Button_state = 0;
            } else {
               document.getElementById("MClub_Acct_Update").disabled = true;
               document.getElementById("MClub_Acct_Update").style = "background-color: #ddd";
               BuyTicket_input_Button_state = 1;
            }
         

         break;

      default:

         break;

   }
}));




//チケット購入。椅子をクリックしたらチェックがはいる。どれかひとつでも選択すると進むボタンがtrueになる。
document.addEventListener("click", function chairCheck (e){

   switch (e.target.id){

      case "chairA1":
      case "chairA2":
      case "chairA3":
      case "chairB1":
      case "chairB2":
      case "chairB3":
      case "chairC1":
      case "chairC2":
      case "chairC3":
      case "chairD1":
      case "chairD2":
      case "chairD3":

         if (e.target.getAttribute("src") == "SVG/chair.svg"){
            item_setAttribute_src('#'+e.target.id, "SVG/chair_checked.svg");
         } else if (e.target.getAttribute("src") == "SVG/chair_checked.svg"){
            item_setAttribute_src('#'+e.target.id, "SVG/chair.svg");
         } 

         var chairs = document.getElementsByClassName("chair");
         var arrayChairs = [];

         for (var i=0, j=0; i < chairs.length; i++){
            if (chairs[i].getAttribute("src") == "SVG/chair_checked.svg"){
               arrayChairs[j] = chairs[i].getAttribute("src");
               j++;
            }
         }
         //console.log('#'+e.target.id);
         //console.log(e.target.getAttribute("src"));
         //console.log(chairs);
         //console.log(chairs);
         //console.log(arrayChairs);
         //console.log(arrayChairs.length);

         if (arrayChairs.length >= 3){
            item_setAttribute_src('#'+e.target.id, "SVG/chair.svg");
         }

         if (arrayChairs.length == 0){
            document.querySelector("#pageBuyTicket_Buy").disabled = true;
            selectSeats_Button_state = 1;
         } else {
            document.querySelector("#pageBuyTicket_Buy").disabled = false;
            selectSeats_Button_state = 0;
         }

         break;

      default:

         break;

   }
});






//チケット購入のお客様情報入力画面。ログインしていればユーザー情報が自動ではいる。
document.addEventListener("click", function chairCheck (e){

   switch (e.target.id){

      case "pageBuyTicket_Buy":

         target_url = "RecoCon_AJAX_pageBuyTicket_input.php";

         funcRef = function (text_data){
            /*表  示*/ new Item_Styles_Animate ("#main", {display:"block",},).setStyles();
            new Item_Styles_Animate ("#main", {opacity: [0, 1], filter: ["blur(1px)", "blur(0)"]}, 
                                "normal", 800, 0, "ease", "forwards", 1).setStylesAnimate();
            /*非表示*/ new Item_Styles_Animate ("#navi", {display:"none",},).setStyles();
            new Item_Styles_Animate ("#navi", {opacity: [0, 1], filter: ["blur(1px)", "blur(0)"]}, 
                             "reverse", 0, 0, "ease", "forwards", 1).setStylesAnimate();
            item_setAttribute_src("#menu",  "./SVG/menu.svg");
            
            main.innerHTML = text_data;
            //console.log(text_data);
         }

         contentType = 'application/x-www-form-urlencoded;charset=UTF-8';

         var chairs = document.getElementsByClassName("chair");
         var arrayChairs = [];

         for (var i=0; i < chairs.length; i++){
               arrayChairs[i] = chairs[i].getAttribute("src");
         }
         //console.log(arrayChairs);
         //console.log(arrayChairs.length);

         var arrayCheckedChairsIndex = arrayChairs.indexOf("SVG/chair_checked.svg");
         var arrayCheckedChairsLastIndex = arrayChairs.lastIndexOf("SVG/chair_checked.svg");

         //console.log(arrayCheckedChairsIndex);
         //console.log(arrayCheckedChairsLastIndex);

         send_data = encodeURIComponent("seat1") + "=" + encodeURIComponent(arrayCheckedChairsIndex) + "&" +
                     encodeURIComponent("seat2") + "=" + encodeURIComponent(arrayCheckedChairsLastIndex) + "&" +
                     encodeURIComponent("selectSeats_Button_state") + "=" + encodeURIComponent(selectSeats_Button_state);

         httpRequest_Post (target_url, funcRef, contentType, send_data);

         break;

      default:

         break;

   }
});






//チケット購入時の入力フォームの入力値チェック。
["input", "compositionend", "change"].forEach(type => document.addEventListener(type, function inputCheck (e){
   if(e.isComposing) return;

   switch (e.target.id){

      case "BuyTicket_Name":
      case "BuyTicket_Age":
      case "BuyTicket_Sex":
      case "BuyTicket_Address1":
      case "BuyTicket_Address2":
      case "BuyTicket_Address3":
      case "BuyTicket_Tel":
      case "BuyTicket_Mail":


         //名前

            //半角カナを全角に
            BuyTicket_Name.value = kana_HANKAKU_to_ZENKAKU(BuyTicket_Name.value);

            //全角アルファベットと数字を半角に
            BuyTicket_Name.value = alphanumeric_ZENKAKU_to_HANKAKU(BuyTicket_Name.value);

            //全角スペースを半角スペースに
            var hyphen = /[　]/gi;
            BuyTicket_Name.value = BuyTicket_Name.value.replace(hyphen, " ");

         //「名前」の入力内容の判定

            reg = /^[ぁ-んァ-ヶー\u30a0-\u30ff\u3040-\u309f\u3005-\u3006\u30e0-\u9fcf\s]*$/giu;
            if (BuyTicket_Name.value.length == 0){
               item_textContent("#BuyTicket_Name_check", "※入力してください。");
               new Item_Styles_Animate ("#BuyTicket_Name_check", {color: "rgb(255, 60 ,60)",}).setStyles();
               buyTicket_nameChecker = 0;
            } else if (!(BuyTicket_Name.value.match(reg))){
               item_textContent("#BuyTicket_Name_check", "※正しく入力してください。");
               new Item_Styles_Animate ("#BuyTicket_Name_check", {color: "rgb(255, 60 ,60)",}).setStyles();
               buyTicket_nameChecker = 0;
            } else {
               item_textContent("#BuyTicket_Name_check", "");
               buyTicket_nameChecker = 1;
            }


         //年齢

            //半角カナを全角に
            BuyTicket_Age.value = kana_HANKAKU_to_ZENKAKU(BuyTicket_Age.value);

            //全角アルファベットと数字を半角に
            BuyTicket_Age.value = alphanumeric_ZENKAKU_to_HANKAKU(BuyTicket_Age.value);

            //全角ーを-に
            var hyphen = /[ー]/gi;
            BuyTicket_Age.value = BuyTicket_Age.value.replace(hyphen, "-");

            //全角スペースを半角スペースに
            var hyphen = /[　]/gi;
            BuyTicket_Age.value = BuyTicket_Age.value.replace(hyphen, " ");

         //「年齢」の入力内容の判定

            reg = /^[0-9]*$/gi;
            if (BuyTicket_Age.value.length == 0){
               item_textContent("#BuyTicket_Age_check", "※入力してください。");
               new Item_Styles_Animate ("#BuyTicket_Age_check", {color: "rgb(255, 60 ,60)",}).setStyles();
               buyTicket_ageChecker = 0;
            } else if (!(BuyTicket_Age.value.match(reg))){
               item_textContent("#BuyTicket_Age_check", "※正しく入力してください。");
               new Item_Styles_Animate ("#BuyTicket_Age_check", {color: "rgb(255, 60 ,60)",}).setStyles();
               buyTicket_ageChecker = 0;
            } else {
               item_textContent("#BuyTicket_Age_check", "");
               buyTicket_ageChecker = 1;
            }

         //性別

            //半角カナを全角に
            BuyTicket_Sex.value = kana_HANKAKU_to_ZENKAKU(BuyTicket_Sex.value);

            //全角アルファベットと数字を半角に
            BuyTicket_Sex.value = alphanumeric_ZENKAKU_to_HANKAKU(BuyTicket_Sex.value);

            //全角ーを-に
            var hyphen = /[ー]/gi;
            BuyTicket_Sex.value = BuyTicket_Sex.value.replace(hyphen, "-");

            //全角スペースを半角スペースに
            var hyphen = /[　]/gi;
            BuyTicket_Sex.value = BuyTicket_Sex.value.replace(hyphen, " ");

         //「性別」の入力内容の判定

            reg = /^[0-9a-zA-Zぁ-んァ-ヶー\u30a0-\u30ff\u3040-\u309f\u3005-\u3006\u30e0-\u9fcf\-\s]*$/giu;
            if (BuyTicket_Sex.value.length == 0){
               item_textContent("#BuyTicket_Sex_check", "※入力してください。");
               new Item_Styles_Animate ("#BuyTicket_Sex_check", {color: "rgb(255, 60 ,60)",}).setStyles();
               buyTicket_sexChecker = 0;
            } else if (!(BuyTicket_Sex.value=="男" || BuyTicket_Sex.value=="女")){
               item_textContent("#BuyTicket_Sex_check", "※正しく入力してください。");
               new Item_Styles_Animate ("#BuyTicket_Sex_check", {color: "rgb(255, 60 ,60)",}).setStyles();
               buyTicket_sexChecker = 0;
            } else {
               item_textContent("#BuyTicket_Sex_check", "");
               buyTicket_sexChecker = 1;
            }

         //住所（都道府県）

            //半角カナを全角に
            BuyTicket_Address1.value = kana_HANKAKU_to_ZENKAKU(BuyTicket_Address1.value);

            //全角アルファベットと数字を半角に
            BuyTicket_Address1.value = alphanumeric_ZENKAKU_to_HANKAKU(BuyTicket_Address1.value);

            //全角ーを-に
            var hyphen = /[ー]/gi;
            BuyTicket_Address1.value = BuyTicket_Address1.value.replace(hyphen, "-");

            //全角スペースを半角スペースに
            var hyphen = /[　]/gi;
            BuyTicket_Address1.value = BuyTicket_Address1.value.replace(hyphen, " ");

         //「住所（都道府県）」の入力内容の判定

            reg = /^[0-9a-zA-Zぁ-んァ-ヶー\u30a0-\u30ff\u3040-\u309f\u3005-\u3006\u30e0-\u9fcf\-\s]*$/giu;
            if (BuyTicket_Address1.value.length == 0){
               item_textContent("#BuyTicket_Address1_check", "※入力してください。");
               new Item_Styles_Animate ("#BuyTicket_Address1_check", {color: "rgb(255, 60 ,60)",}).setStyles();
               buyTicket_address1Checker = 0;
            } else if (!(BuyTicket_Address1.value.match(reg))){
               item_textContent("#BuyTicket_Address1_check", "※正しく入力してください。");
               new Item_Styles_Animate ("#BuyTicket_Address1_check", {color: "rgb(255, 60 ,60)",}).setStyles();
               buyTicket_address1Checker = 0;
            } else {
               item_textContent("#BuyTicket_Address1_check", "");
               buyTicket_address1Checker = 1;
            }

         //住所（市区町村）

            //半角カナを全角に
            BuyTicket_Address2.value = kana_HANKAKU_to_ZENKAKU(BuyTicket_Address2.value);

            //全角アルファベットと数字を半角に
            BuyTicket_Address2.value = alphanumeric_ZENKAKU_to_HANKAKU(BuyTicket_Address2.value);

            //全角ーを-に
            var hyphen = /[ー]/gi;
            BuyTicket_Address2.value = BuyTicket_Address2.value.replace(hyphen, "-");

            //全角スペースを半角スペースに
            var hyphen = /[　]/gi;
            BuyTicket_Address2.value = BuyTicket_Address2.value.replace(hyphen, " ");

         //「住所（市区町村）」の入力内容の判定

            reg = /^[0-9a-zA-Zぁ-んァ-ヶー\u30a0-\u30ff\u3040-\u309f\u3005-\u3006\u30e0-\u9fcf\-\s]*$/giu;
            if (BuyTicket_Address2.value.length == 0){
               item_textContent("#BuyTicket_Address2_check", "※入力してください。");
               new Item_Styles_Animate ("#BuyTicket_Address2_check", {color: "rgb(255, 60 ,60)",}).setStyles();
               buyTicket_address2Checker = 0;
            } else if (!(BuyTicket_Address2.value.match(reg))){
               item_textContent("#BuyTicket_Address2_check", "※正しく入力してください。");
               new Item_Styles_Animate ("#BuyTicket_Address2_check", {color: "rgb(255, 60 ,60)",}).setStyles();
               buyTicket_address2Checker = 0;
            } else {
               item_textContent("#BuyTicket_Address2_check", "");
               buyTicket_address2Checker = 1;
            }

         //住所（番地以下）

            //半角カナを全角に
            BuyTicket_Address3.value = kana_HANKAKU_to_ZENKAKU(BuyTicket_Address3.value);

            //全角アルファベットと数字を半角に
            BuyTicket_Address3.value = alphanumeric_ZENKAKU_to_HANKAKU(BuyTicket_Address3.value);

            //全角ーを-に
            var hyphen = /[ー]/gi;
            BuyTicket_Address3.value = BuyTicket_Address3.value.replace(hyphen, "-");

            //全角スペースを半角スペースに
            var hyphen = /[　]/gi;
            BuyTicket_Address3.value = BuyTicket_Address3.value.replace(hyphen, " ");

         //「住所（番地以下）」の入力内容の判定

            reg = /^[0-9a-zA-Zぁ-んァ-ヶー\u30a0-\u30ff\u3040-\u309f\u3005-\u3006\u30e0-\u9fcf\-\s]*$/giu;
            if (BuyTicket_Address3.value.length == 0){
               item_textContent("#BuyTicket_Address3_check", "※入力してください。");
               new Item_Styles_Animate ("#BuyTicket_Address3_check", {color: "rgb(255, 60 ,60)",}).setStyles();
               buyTicket_address3Checker = 0;
            } else if (!(BuyTicket_Address3.value.match(reg))){
               item_textContent("#BuyTicket_Address3_check", "※正しく入力してください。");
               new Item_Styles_Animate ("#BuyTicket_Address3_check", {color: "rgb(255, 60 ,60)",}).setStyles();
               buyTicket_address3Checker = 0;
            } else {
               item_textContent("#BuyTicket_Address3_check", "");
               buyTicket_address3Checker = 1;
            }

         //電話番号

            //半角カナを全角に
            BuyTicket_Tel.value = kana_HANKAKU_to_ZENKAKU(BuyTicket_Tel.value);

            //全角アルファベットと数字を半角に
            BuyTicket_Tel.value = alphanumeric_ZENKAKU_to_HANKAKU(BuyTicket_Tel.value);

            //全角ーを-に
            var hyphen = /[ー]/gi;
            BuyTicket_Tel.value = BuyTicket_Tel.value.replace(hyphen, "-");

            //全角スペースを半角スペースに
            var hyphen = /[　]/gi;
            BuyTicket_Tel.value = BuyTicket_Tel.value.replace(hyphen, " ");

         //「電話番号」の入力内容の判定

            reg = /^\d{2,5}-\d{1,4}-\d{4}$/gi;
            if (BuyTicket_Tel.value.length == 0){
               item_textContent("#BuyTicket_Tel_check", "※入力してください。");
               new Item_Styles_Animate ("#BuyTicket_Tel_check", {color: "rgb(255, 60 ,60)",}).setStyles();
               buyTicket_telChecker = 0;
            } else if (!(BuyTicket_Tel.value.match(reg))){
               item_textContent("#BuyTicket_Tel_check", "※正しく入力してください。");
               new Item_Styles_Animate ("#BuyTicket_Tel_check", {color: "rgb(255, 60 ,60)",}).setStyles();
               buyTicket_telChecker = 0;
            } else {
               item_textContent("#BuyTicket_Tel_check", "");
               buyTicket_telChecker = 1;
            }

         //メールアドレス

            //半角カナを全角に
            BuyTicket_Mail.value = kana_HANKAKU_to_ZENKAKU(BuyTicket_Mail.value);

            //全角アルファベットと数字を半角に
            BuyTicket_Mail.value = alphanumeric_ZENKAKU_to_HANKAKU(BuyTicket_Mail.value);

            //全角ーを-に
            var hyphen = /[ー]/gi;
            BuyTicket_Mail.value = BuyTicket_Mail.value.replace(hyphen, "-");

            //全角スペースを半角スペースに
            var hyphen = /[　]/gi;
            BuyTicket_Mail.value = BuyTicket_Mail.value.replace(hyphen, " ");

         //「メールアドレス」の入力内容の判定

            reg = /^[0-9a-zA-Z]{1}[\w.-]{0,}@{1}[0-9a-zA-Z]{1}[\w.-]{0,}\.{1,}[0-9a-zA-Z]{1}[\w.-]{0,}$/gi;
            if (BuyTicket_Mail.value.length == 0){
               item_textContent("#BuyTicket_Mail_check", "※入力してください。");
               new Item_Styles_Animate ("#BuyTicket_Mail_check", {color: "rgb(255, 60 ,60)",}).setStyles();
               buyTicket_mailChecker = 0;
            } else if (!(BuyTicket_Mail.value.match(reg))){
               item_textContent("#BuyTicket_Mail_check", "※正しく入力してください。");
               new Item_Styles_Animate ("#BuyTicket_Mail_check", {color: "rgb(255, 60 ,60)",}).setStyles();
               buyTicket_mailChecker = 0;
            } else {
               item_textContent("#BuyTicket_Mail_check", "");
               buyTicket_mailChecker = 1;
            }


         //入力するたびに全入力フォームのOKNGフラグをチェック。すべて1なら進むボタン起動。

            if (buyTicket_nameChecker==1 && buyTicket_ageChecker==1 && buyTicket_sexChecker==1 && buyTicket_address1Checker==1 && buyTicket_address2Checker==1 && buyTicket_address3Checker==1 && buyTicket_telChecker==1 && buyTicket_mailChecker==1){
               document.getElementById("BuyTicket_go").disabled = false;
               document.getElementById("BuyTicket_go").style = "background-color: rgb(78, 149, 250)";
               BuyTicket_input_Button_state = 0;
            } else {
               document.getElementById("BuyTicket_go").disabled = true;
               document.getElementById("BuyTicket_go").style = "background-color: #ddd";
               BuyTicket_input_Button_state = 1;
            }
         

         break;

      default:

         break;

   }
}));






//チケット購入のお客様情報入力画面から、座席選択画面へ戻る。
document.addEventListener("click", function chairCheck (e){

   switch (e.target.id){

      case "BuyTicket_back":

         target_url = "RecoCon_AJAX_pageBuyTicket.php";

         funcRef = function (text_data){
            /*表  示*/ new Item_Styles_Animate ("#main", {display:"block",},).setStyles();
            new Item_Styles_Animate ("#main", {opacity: [0, 1], filter: ["blur(1px)", "blur(0)"]}, 
                                "normal", 800, 0, "ease", "forwards", 1).setStylesAnimate();
            /*非表示*/ new Item_Styles_Animate ("#navi", {display:"none",},).setStyles();
            new Item_Styles_Animate ("#navi", {opacity: [0, 1], filter: ["blur(1px)", "blur(0)"]}, 
                             "reverse", 0, 0, "ease", "forwards", 1).setStylesAnimate();
            item_setAttribute_src("#menu",  "./SVG/menu.svg");
            
            main.innerHTML = text_data;
            //console.log(text_data);
         }

         contentType = 'application/x-www-form-urlencoded;charset=UTF-8';

         var BuyTicket_u_input_id = document.getElementById("BuyTicket_u_input_id");
         var BuyTicket_Name = document.getElementById("BuyTicket_Name");
         var BuyTicket_Age = document.getElementById("BuyTicket_Age");
         var BuyTicket_Sex = document.getElementById("BuyTicket_Sex");
         var BuyTicket_Address1 = document.getElementById("BuyTicket_Address1");
         var BuyTicket_Address2 = document.getElementById("BuyTicket_Address2");
         var BuyTicket_Address3 = document.getElementById("BuyTicket_Address3");
         var BuyTicket_Tel = document.getElementById("BuyTicket_Tel");
         var BuyTicket_Mail = document.getElementById("BuyTicket_Mail");

         send_data = encodeURIComponent("BuyTicket_u_input_id") + "=" + encodeURIComponent(BuyTicket_u_input_id.value) + "&" +
                     encodeURIComponent("BuyTicket_Name") + "=" + encodeURIComponent(BuyTicket_Name.value) + "&" +
                     encodeURIComponent("BuyTicket_Age") + "=" + encodeURIComponent(BuyTicket_Age.value) + "&" +
                     encodeURIComponent("BuyTicket_Sex") + "=" + encodeURIComponent(BuyTicket_Sex.value) + "&" +
                     encodeURIComponent("BuyTicket_Address1") + "=" + encodeURIComponent(BuyTicket_Address1.value) + "&" +
                     encodeURIComponent("BuyTicket_Address2") + "=" + encodeURIComponent(BuyTicket_Address2.value) + "&" +
                     encodeURIComponent("BuyTicket_Address3") + "=" + encodeURIComponent(BuyTicket_Address3.value) + "&" +
                     encodeURIComponent("BuyTicket_Tel") + "=" + encodeURIComponent(BuyTicket_Tel.value) + "&" +
                     encodeURIComponent("BuyTicket_Mail") + "=" + encodeURIComponent(BuyTicket_Mail.value) + "&" +
                     encodeURIComponent("BuyTicket_input_Button_state") + "=" + encodeURIComponent(BuyTicket_input_Button_state);

         httpRequest_Post (target_url, funcRef, contentType, send_data);

         break;

      default:

         break;

   }
});





//チケット購入内容のお客様情報の確認画面へ。
document.addEventListener("click", function chairCheck (e){

   switch (e.target.id){

      case "BuyTicket_go":

         target_url = "RecoCon_AJAX_pageBuyTicket_input_confirm.php";

         funcRef = function (text_data){
            /*表  示*/ new Item_Styles_Animate ("#main", {display:"block",},).setStyles();
            new Item_Styles_Animate ("#main", {opacity: [0, 1], filter: ["blur(1px)", "blur(0)"]}, 
                                "normal", 800, 0, "ease", "forwards", 1).setStylesAnimate();

            main.innerHTML = text_data;
            //console.log(text_data);
         }

         contentType = 'application/x-www-form-urlencoded;charset=UTF-8';

         var BuyTicket_u_input_id = document.getElementById("BuyTicket_u_input_id");
         var BuyTicket_Name = document.getElementById("BuyTicket_Name");
         var BuyTicket_Age = document.getElementById("BuyTicket_Age");
         var BuyTicket_Sex = document.getElementById("BuyTicket_Sex");
         var BuyTicket_Address1 = document.getElementById("BuyTicket_Address1");
         var BuyTicket_Address2 = document.getElementById("BuyTicket_Address2");
         var BuyTicket_Address3 = document.getElementById("BuyTicket_Address3");
         var BuyTicket_Tel = document.getElementById("BuyTicket_Tel");
         var BuyTicket_Mail = document.getElementById("BuyTicket_Mail");

         send_data = encodeURIComponent("BuyTicket_u_input_id") + "=" + encodeURIComponent(BuyTicket_u_input_id.value) + "&" +
                     encodeURIComponent("BuyTicket_Name") + "=" + encodeURIComponent(BuyTicket_Name.value) + "&" +
                     encodeURIComponent("BuyTicket_Age") + "=" + encodeURIComponent(BuyTicket_Age.value) + "&" +
                     encodeURIComponent("BuyTicket_Sex") + "=" + encodeURIComponent(BuyTicket_Sex.value) + "&" +
                     encodeURIComponent("BuyTicket_Address1") + "=" + encodeURIComponent(BuyTicket_Address1.value) + "&" +
                     encodeURIComponent("BuyTicket_Address2") + "=" + encodeURIComponent(BuyTicket_Address2.value) + "&" +
                     encodeURIComponent("BuyTicket_Address3") + "=" + encodeURIComponent(BuyTicket_Address3.value) + "&" +
                     encodeURIComponent("BuyTicket_Tel") + "=" + encodeURIComponent(BuyTicket_Tel.value) + "&" +
                     encodeURIComponent("BuyTicket_Mail") + "=" + encodeURIComponent(BuyTicket_Mail.value) + "&" +
                     encodeURIComponent("BuyTicket_input_Button_state") + "=" + encodeURIComponent(BuyTicket_input_Button_state);

         httpRequest_Post (target_url, funcRef, contentType, send_data);

         break;

      default:

         break;

   }
});





//チケット購入内容の確認画面の戻るをクリックした時。
document.addEventListener("click", function chairCheck (e){

   switch (e.target.id){

      case "pageBuyTicket_input_confirm_back":

         target_url = "RecoCon_AJAX_pageBuyTicket_input.php";

         funcRef = function (text_data){
            /*表  示*/ new Item_Styles_Animate ("#main", {display:"block",},).setStyles();
            new Item_Styles_Animate ("#main", {opacity: [0, 1], filter: ["blur(1px)", "blur(0)"]}, 
                                "normal", 800, 0, "ease", "forwards", 1).setStylesAnimate();

            main.innerHTML = text_data;
            //console.log(text_data);
         }

         httpRequest_Get (target_url, funcRef);

         break;

      default:

         break;

   }
});






//チケット購入内容の確認画面の確定をクリックした時。
document.addEventListener("click", function chairCheck (e){

   switch (e.target.id){

      case "pageBuyTicket_input_confirm_confirm":

         target_url = "RecoCon_AJAX_pageBuyTicket_input_confirm_confirm.php";

         funcRef = function (text_data){
            /*表  示*/ new Item_Styles_Animate ("#main", {display:"block",},).setStyles();
            new Item_Styles_Animate ("#main", {opacity: [0, 1], filter: ["blur(1px)", "blur(0)"]}, 
                                "normal", 800, 0, "ease", "forwards", 1).setStylesAnimate();

            main.innerHTML = text_data;
            //console.log(text_data);
         }

         contentType = 'application/x-www-form-urlencoded;charset=UTF-8';

         token = document.querySelector("#token");
         send_data = encodeURIComponent("token") + "=" + encodeURIComponent(token.value);

         httpRequest_Post (target_url, funcRef, contentType, send_data);

         break;

      default:

         break;

   }
});






//矢印をクリックした時のアクション。矢印の向きのアニメーションとdisplay部分の表示/非表示の切り替え------------------------------------------------

function arrow_click (e) {

   var category = e.target.id.split("_")[0];   //"next" or "stayTuned1" or "stayTuned2" or "close1" or "close2" or "close3" or "close4" or "close5"

   function displayAppear(){

      /*矢印転*/ new Item_Styles_Animate ("#"+category+"_div1_div2_img", {transform:"rotate(90deg)",}, "normal", 200, 0, "ease", "forwards", 1).setStylesAnimate();
      /*表  示*/ new Item_Styles_Animate ("#"+category+"_div2", {display:"flex", justifyContent:"space-between"}).setStyles();

      /*罫線非表示*/ new Item_Styles_Animate ("#"+category+"_text_arrow", {borderWidth: "0", borderStyle: "dashed", borderColor: "#DDD"}).setStyles();

      //ここで非表示、表示の設定を同時に行うこと。
      /*文字動*/ new Item_Styles_Animate ("#"+category+"_div2_div1", {opacity: [0, 1], filter: ["blur(1px)", "blur(0)"]}, 
                             "reverse", 0, 0, "ease", "forwards", 1).setStylesAnimate();
      /*文字動*/ new Item_Styles_Animate ("#"+category+"_div2_div1", {opacity: [0, 1], filter: ["blur(1px)", "blur(0)"]}, 
                             "normal", 800, 0, "ease", "forwards", 1).setStylesAnimate();

      //ここで非表示、表示の設定を同時に行うこと。
      /*画像戻*/ new Item_Styles_Animate ("#"+category+"_div2_div2 > img", {opacity: [0, 1], filter: ["blur(1px)", "blur(0)"]}, 
                             "reverse", 0, 0, "ease", "forwards", 1).setStylesAnimate();
      /*画像動*/ new Item_Styles_Animate ("#"+category+"_div2_div2 > img", {opacity: [0, 1], filter: ["blur(1px)", "blur(0)"]}, 
                             "normal", 800, 300, "ease", "forwards", 1).setStylesAnimate();

   }

   function displayDisapper(){

      /*矢印戻*/ new Item_Styles_Animate ("#"+category+"_div1_div2_img", {transform:"rotate(0deg)",}, "normal", 200, 0, "ease", "forwards", 1).setStylesAnimate();
      /*非表示*/ new Item_Styles_Animate ("#"+category+"_div2", {display:"none"}).setStyles();

      /*罫線表示*/ new Item_Styles_Animate ("#"+category+"_text_arrow", {borderWidth: "0 0 0.5px 0", borderStyle: "dashed", borderColor: "#DDD"}).setStyles();

   }


   switch (e.target.id) {

      case "next_div1_div2_img":   //次の公演の矢印

         //クリック回数に応じて、矢印を回転。ディスプレイ部分の表示/非表示の切り替え
         if (next_arrowClick_i % 2 == 0){

            displayAppear();
            next_arrowClick_i++;

         } else {

            displayDisapper();
            next_arrowClick_i++;

         }

         break;

      case "stayTuned1_div1_div2_img":   //乞うご期待1の矢印

         //クリック回数に応じて、矢印を回転。ディスプレイ部分の表示/非表示の切り替え
         if (stayTuned1_arrowClick_i % 2 == 0){

            displayAppear();
            stayTuned1_arrowClick_i++;

         } else {

            displayDisapper();
            stayTuned1_arrowClick_i++;

         }

         break;

      case "stayTuned2_div1_div2_img":   //乞うご期待2の矢印

         //クリック回数に応じて、矢印を回転。ディスプレイ部分の表示/非表示の切り替え
         if (stayTuned2_arrowClick_i % 2 == 0){

            displayAppear();
            stayTuned2_arrowClick_i++;

         } else {

            displayDisapper();
            stayTuned2_arrowClick_i++;

         }

         break;

      case "close1_div1_div2_img":   //過去の公演1の矢印

         //クリック回数に応じて、矢印を回転。ディスプレイ部分の表示/非表示の切り替え
         if (close1_arrowClick_i % 2 == 0){

            displayAppear();
            close1_arrowClick_i++;

         } else {

            displayDisapper();
            close1_arrowClick_i++;

         }

         break;

      case "close2_div1_div2_img":   //過去の公演2の矢印

         //クリック回数に応じて、矢印を回転。ディスプレイ部分の表示/非表示の切り替え
         if (close2_arrowClick_i % 2 == 0){

            displayAppear();
            close2_arrowClick_i++;

         } else {

            displayDisapper();
            close2_arrowClick_i++;

         }

         break;

      case "close3_div1_div2_img":   //過去の公演3の矢印

         //クリック回数に応じて、矢印を回転。ディスプレイ部分の表示/非表示の切り替え
         if (close3_arrowClick_i % 2 == 0){

            displayAppear();
            close3_arrowClick_i++;

         } else {

            displayDisapper();
            close3_arrowClick_i++;

         }

         break;

      case "close4_div1_div2_img":   //過去の公演4の矢印

         //クリック回数に応じて、矢印を回転。ディスプレイ部分の表示/非表示の切り替え
         if (close4_arrowClick_i % 2 == 0){

            displayAppear();
            close4_arrowClick_i++;

         } else {

            displayDisapper();
            close4_arrowClick_i++;

         }

         break;

      case "close5_div1_div2_img":   //過去の公演5の矢印

         //クリック回数に応じて、矢印を回転。ディスプレイ部分の表示/非表示の切り替え
         if(close5_arrowClick_i % 2 == 0){

            displayAppear();
            close5_arrowClick_i++;

         } else {

            displayDisapper();
            close5_arrowClick_i++;

         }

         break;

      default :

         break;

   }

}





//音源詳細マークのクリックイベント。詳細ページを表示。----------------------------------------------------------------------

function setListeners_2 (e) {

   document.addEventListener("click", function(e){

      //AJAXのfunctionReferenceの無名関数版----------------------------------------------------------------------

      target_url = "RecoCon_TOP_ongenMark_click.php";

      funcRef = function (text_data){

         switch (e.target.id) {

            case "next_div2_div_div":
            case "stayTuned1_div2_div1_div":
            case "stayTuned2_div2_div1_div":
            case "close1_div2_div1_div":
            case "close2_div2_div1_div":
            case "close3_div2_div1_div":
            case "close4_div2_div1_div":
            case "close5_div2_div1_div":

               clearInterval(timer_carousel);
               
               main.innerHTML = text_data;
               break;

            default :

               break;

         }
      }

      contentType = 'application/x-www-form-urlencoded;charset=UTF-8';

      send_data = encodeURIComponent("disc_id") + "=" + encodeURIComponent(e.target.getAttribute("name"));

      httpRequest_Post (target_url, funcRef, contentType, send_data);

   });   //document.addEventListenerの閉じかっこ

}   //function setListeners_2の閉じかっこ





//AJAX_close。過去の公演の内容定義-----------------------------------------------------------------------------

function AJAX_close (e) {

   target_url = "RecoCon_TOP_AJAX_ConcertSchedule_Disc_close.php";

   funcRef = function (text_data){


      //JSONの処理。普通の配列にする。
      var array_JSON = JSON.parse(text_data);
      //console.log(array_JSON);


      //表示件数
      var number = 5;


      //クリックしたノンブルナンバー。
      var noble_click = e.target.textContent;


      //クリックしたノンブルサークルのスタイルを変更する
      var noble = document.querySelectorAll(".noble");
      for (var i=1; i <= Object.keys(noble).length; i++){
         if (document.getElementById("noble" + i).classList == "noble_cicle_on"){
            document.getElementById("noble" + i).classList.remove("noble_cicle_on");
            document.getElementById("noble" + i).classList.add("noble_cicle");
         }
      }
      document.getElementById("noble" + e.target.textContent).classList.add("noble_cicle_on");
      document.getElementById("noble" + e.target.textContent).classList.remove("noble_cicle");


      //同一箇所で、あるノンブルをクリックした時のインデックスの上昇数。ノンブルをクリックすると、(表示件数×（クリックしたノンブル-1）) 上昇する。
      //1ページをクリックしたら0。2ページをクリックしたら5。3ページをクリックしたら10。
      var rise = number*(noble_click-1);


      //件数分繰り返して一気に組み立てる。
      for (var i=1; i <= number; i++){

         //前の捜査状況によって罫線が消えていたりするので、いったん破線をすべてにいれる。
         new Item_Styles_Animate ("#close"+i+"_text_arrow", {borderWidth: "0 0 0.5px 0", borderStyle: "dashed", borderColor: "#DDD"}).setStyles();

         //ちらつき防止の不透明度0。
         new Item_Styles_Animate ("#close"+i+"_div2_div2 > img", {opacity: 0,}).setStyles();

         //過去公演トップの組み立て。
         item_textContent("#close"+i+"_div1_div1_div_h41",  array_JSON[i+rise]  ?  array_JSON[i+rise]['cs_date'].replace(/^[0-9]{2}/gi, "'").replace(/[\-]/gi, ".")  :  "");
         document.querySelector("#close"+i+"_div1_div1_div_h42").innerHTML = array_JSON[i+(rise)]  ?  "&nbsp;" + eHTML(array_JSON[i+(rise)]['cs_composer_jn']) + " : " + eHTML(array_JSON[i+(rise)]['cs_title_jn'])  :  "";
         item_textContent("#close"+i+"_div1_div1_p", array_JSON[i+(rise)]  ?  array_JSON[i+(rise)]['cs_composer_en'] +" / "+ array_JSON[i+(rise)]['cs_title_en']  :  "");
         new Item_Styles_Animate ("#close"+i+"_div1_div2_img", {visibility: array_JSON[i+(rise)]  ?  "visible"  :  "hidden"}).setStyles();

         //過去公演ボトムの組み立て。
         item_textContent("#close"+i+"_div2_div1_p",  array_JSON[i+(rise)]  ?  array_JSON[i+(rise)]['d_title']  :  "");
         item_setAttribute_src("#close"+i+"_div2_div2_img",  array_JSON[i+(rise)]  ?  "photo/" + array_JSON[i+(rise)]['d_path']  :  "");
         item_setAttribute_name("#close"+i+"_div2_div1_div",   array_JSON[i+(rise)]  ?  array_JSON[i+(rise)]['d_id']  :  "");

      }


      //異常動作の対応。矢印をクリックして公演ボトムを表示させたまま別ページへ飛ぶと、表示させていた部分のdisplayが表示のままで空画像が表示されたり異常があるので、ページを切り替えたらいったんすべて非表示にして、矢印の状態カウント変数を初期値に戻す。
      new Item_Styles_Animate ("#close1_div1_div2_img", {transform:"rotate(0deg)",}, "normal", 100, 0, "ease-in-out", "forwards", 1).setStylesAnimate();
      new Item_Styles_Animate ("#close1_div2", {display:"none",}).setStyles();
      close1_arrowClick_i = 2;

      new Item_Styles_Animate ("#close2_div1_div2_img", {transform:"rotate(0deg)",}, "normal", 100, 0, "ease-in-out", "forwards", 1).setStylesAnimate();
      new Item_Styles_Animate ("#close2_div2", {display:"none",}).setStyles();
      close2_arrowClick_i = 2;

      new Item_Styles_Animate ("#close3_div1_div2_img", {transform:"rotate(0deg)",}, "normal", 100, 0, "ease-in-out", "forwards", 1).setStylesAnimate();
      new Item_Styles_Animate ("#close3_div2", {display:"none",}).setStyles();
      close3_arrowClick_i = 2;

      new Item_Styles_Animate ("#close4_div1_div2_img", {transform:"rotate(0deg)",}, "normal", 100, 0, "ease-in-out", "forwards", 1).setStylesAnimate();
      new Item_Styles_Animate ("#close4_div2", {display:"none",}).setStyles();
      close4_arrowClick_i = 2;

      new Item_Styles_Animate ("#close5_div1_div2_img", {transform:"rotate(0deg)",}, "normal", 100, 0, "ease-in-out", "forwards", 1).setStylesAnimate();
      new Item_Styles_Animate ("#close5_div2", {display:"none",}).setStyles();
      close5_arrowClick_i = 2;

   }

   httpRequest_Get (target_url, funcRef);

}




//
function bodyAnimate (){

   var topFirstAnimate = document.getElementsByClassName("topFirstAnimate");

   for(var i=0; i<topFirstAnimate.length; i++){
      var keyFrames = {
         opacity: [0, 0], 
      }

      const options = {
         direction: "normal",
         duration: 0,
         delay: 0,
         easing: "ease",
         fill: "forwards",   
         iterations: 0,
      }

      topFirstAnimate[i].animate(keyFrames, options);
}

   for(var i=0; i<topFirstAnimate.length; i++){

      var keyFrames = {
         opacity: [0, 1], 
         filter: ["blur(1px)", "blur(0)"]
      }

      const options = {
         direction: "normal",
         duration: 800,
         delay: 0*i,
         easing: "ease-in-out",
         fill: "forwards",   
         iterations: 1,
      }

      topFirstAnimate[i].animate(keyFrames, options);

   }

}





//ボタンのグレーアウト
document.addEventListener("click", function chairCheck (e){

   switch (e.target.id){

      case "chairA1":
      case "chairA2":
      case "chairA3":
      case "chairB1":
      case "chairB2":
      case "chairB3":
      case "chairC1":
      case "chairC2":
      case "chairC3":
      case "chairD1":
      case "chairD2":
      case "chairD3":

         if (document.getElementById("pageBuyTicket_Buy").disabled == false){
            document.getElementById("pageBuyTicket_Buy").style = "background-color: rgb(78, 149, 250)";
         } else {
            document.getElementById("pageBuyTicket_Buy").style = "background-color: #ddd";
         }

         break;

      default:

         break;

   }
});






//ボタンのグレーアウト
document.addEventListener("input", function (e){

   switch (e.target.id){

      case "MClub_createAcct_U_Input_Id":
      case "MClub_createAcct_Pass":
      case "MClub_createAcct_Name":
      case "MClub_createAcct_Age":
      case "MClub_createAcct_Sex":
      case "MClub_createAcct_Address1":
      case "MClub_createAcct_Address2":
      case "MClub_createAcct_Address3":
      case "MClub_createAcct_Tel":
      case "MClub_createAcct_Mail":

         if (document.getElementById("MClub_createAcct_next").disabled == false){
            document.getElementById("MClub_createAcct_next").style = "background-color: rgb(250, 78, 174)";
         } else {
            document.getElementById("MClub_createAcct_next").style = "background-color: #ddd";
         }

         break;

      default:

         break;

   }
});





//setListnersでイベントをセット。----------------------------------------------------------

function setListeners () {
   document.addEventListener("click", menu_click);
   document.addEventListener("click", menuContents_click);

   document.addEventListener("click", arrow_click);


   //ノンブルサークルのイベントとノンブルサークル1のスタイル設定
   var noble = document.querySelectorAll(".noble");
   for (var i=0; i < Object.keys(noble).length; i++){
      noble[i].addEventListener("click", AJAX_close);
   }
   document.getElementById("noble1").classList.remove("noble_cicle");
   document.getElementById("noble1").classList.add("noble_cicle_on");

}




//DOMContentLoaded後、初期設定とイベント設定を立ち上げる。

window.addEventListener("DOMContentLoaded", setListeners);
window.addEventListener("DOMContentLoaded", setListeners_2);
window.addEventListener("DOMContentLoaded", AJAX_carousel);
window.addEventListener("DOMContentLoaded", bodyAnimate);




//開発用コンソールログ。クリックしたもののIDを表示。
document.addEventListener("click", (e)=>{console.log(e.target.id);});
