             
//sweetalert定制化提醒
function ajaxalert(title,msg,btn){
	swal({
    	title:title,
        text:msg,
        confirmButtonText:btn,
        closeOnConfirm:true,
        timer:5000,
        html:true,
    });
}

//当前日期
function getNow(){
   var d= new Date();       
   year = d.getFullYear();
   mon = d.getMonth() + 1;
   day = d.getDate();
   d2 = year + "-" + (mon < 10 ? ('0' + mon) : mon) + "-" + (day < 10 ? ('0' + day) : day);
   return d2;
}

//前几天日期
function getBeforeDate(n) {   var n = n;
   var d = new Date();
   var year = d.getFullYear();
   var mon = d.getMonth() + 1;
   var day = d.getDate();
   if(day <= n) {
       if(mon > 1) {
           mon = mon - 1;
       } else {
           year = year - 1;
           mon = 12;
       }
   }
   d.setDate(d.getDate() +n);
   year = d.getFullYear();
   mon = d.getMonth() + 1;
   day = d.getDate();
   s = year + "-" + (mon < 10 ? ('0' + mon) : mon) + "-" + (day < 10 ? ('0' + day) : day);
   return s;
}