xhr=new XMLHttpRequest,xhr.onreadystatechange=function(){4==xhr.readyState&&200==xhr.status&&($("body").append(xhr.responseText),/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)&&($("#imochat-frame").css("height","40px"),imochat_open=!1))},xhr.open("GET","http://imoboard.gravi.com.br/?c=014aadd8bdc01ba6b30a3db2a72deb8e",!0),xhr.send();var imochat_open=!0;$(document).on("click","#imochat-minimize",function(){imochat_open?($("#imochat-frame").animate({height:"40px"},400),imochat_open=!1):($("#imochat-frame").animate({height:"357px"},400),imochat_open=!0)});