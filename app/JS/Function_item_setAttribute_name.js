//対象の表示/非表示の設定。
//第一引数は対象のセレクター「  "#●●●●●●"  」、
//第二引数はsetAttributeのnameの文字列。

function item_setAttribute_name (query, name_setting) {

   var query = document.querySelector(query);

   return query.setAttribute("name", name_setting);

}