//new Items_Styles_Animate (querysClass, styles).setStyles();
//  or
//new Items_Styles_Animate (querysClass, styles, "normal", 100, 0, "ease-in-out", "forwards", 1).setStylesAnimate();



//Items_Styles_Animateクラス



//コンストラクター
var Items_Styles_Animate = function (querysClass, styles, direction, duration, delay, easing, fill, iterations){

   //必須のプロパティ
   this.querysClass = querysClass;    //.classという形式で、クラス名。
   this.styles = styles;

   //アニメートする場合のプロパティ
   var setting = [];
      setting[0] = direction;
      setting[1] = duration;
      setting[2] = delay;
      setting[3] = easing;
      setting[4] = fill;
      setting[5] = iterations;

   if ((0 in setting) == true) {this.direction = direction;} else {this.direction = "";}
   if ((1 in setting) == true) {this.duration = duration;} else {this.duration = "";}
   if ((2 in setting) == true) {this.delay = delay;} else {this.delay = "";}
   if ((3 in setting) == true) {this.easing = easing;} else {this.easing = "";}
   if ((4 in setting) == true) {this.fill = fill;} else {this.fill = "";}
   if ((5 in setting) == true) {this.iterations = iterations;} else {this.iterations = "";}

}



//（プロトタイプ）setStylesメソッド     stylesの例 {transform:"rotate(90deg)", border:"3px solid black"}
Items_Styles_Animate.prototype.setStyles = function () {
   var items = document.querySelectorAll(this.querysClass);
   for (var i=0; i < Object.keys(items).length; i++){
      Object.assign(items[i].style, this.styles);
   }
}


//（プロトタイプ）setStylesAnimateメソッド     stylesの例 {transform:"rotate(90deg)", border:"3px solid black"}
Items_Styles_Animate.prototype.setStylesAnimate = function () {

   var items = document.querySelectorAll(this.querysClass);

   //動作設定（スタイル設定）
   var keyframes = this.styles;

   //動作オプション
   var options = {
      direction: this.direction,
      duration: this.duration,
      delay: this.delay,
      easing: this.easing,
      fill: this.fill,   
      iterations: this.iterations,
   }

   //矢印のアニメーションの命令
   for (var i=0; i < Object.keys(items).length; i++){
      items[i].animate(keyframes, options);
   }

}