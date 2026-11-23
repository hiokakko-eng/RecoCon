//JavaScriptのHTMLエスケープ関数。（PHPのhtmlspecialchars関数。のつもり。。。）

function eHTML (str) {    
   return str.replace(/</gi, "&lt;").replace(/>/gi, "&gt;").replace(/&/gi, "&amp;").replace(/"/gi, "&quot;").replace(/'/gi, "&#39;").replace(/\\/gi, "\\");
}