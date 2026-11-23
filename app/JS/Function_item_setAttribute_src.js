//対象の表示/非表示の設定。
//第一引数は対象のセレクター「  "#●●●●●●"  」、
//第二引数はsetAttributeのsrcの設定「  "abc.jpg"  」や「 "photo/" + JSON[i] 」など。

function item_setAttribute_src (query, src_setting) {

   var query = document.querySelector(query);

   return query.setAttribute("src", src_setting);

}