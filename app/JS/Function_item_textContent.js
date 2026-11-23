//対象のテクストコンテンツの設定。
//第一引数は対象のセレクター「  "#●●●●●●"  」、
//第二引数はtextContentの文字列「  "●●●●●●"  」や文字列生成のコード。

function item_textContent (query, text) {

   var query = document.querySelector(query);

   return query.textContent = text;

}