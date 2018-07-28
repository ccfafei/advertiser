$(function () {
	

	//datepicker
	var nowtime = getNow();
    $.fn.datepicker.dates['cn'] = {   //切换为中文显示  
            days: ["周日", "周一", "周二", "周三", "周四", "周五", "周六", "周日"],  
                    daysShort: ["日", "一", "二", "三", "四", "五", "六", "七"],  
                    daysMin: ["日", "一", "二", "三", "四", "五", "六", "七"],  
                    months: ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"],  
                    monthsShort: ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"],  
                    today: "今天",  
                    clear: "清除"  
    }; 

    $.fn.datepicker.defaults.language = 'cn';
    $.fn.datepicker.defaults.format = "yyyy-mm-dd";
    $.fn.datepicker.defaults.autoclose = 'true';
    
	 //开始时间
	 var starttime=$("#datepicker_start").val();
     if(starttime == ""){
         var lastday = getBeforeDate(-30);
         $("#datepicker_start").val(lastday);    
         $("#datepicker_start").datepicker("update", lastday);        
     }
     //结束时间
     var endtime=$("#datepicker_end").val();
     if(endtime == ""){
         $("#datepicker_end").val(nowtime);    
         $("#datepicker_end").datepicker("update", nowtime);        
     }
	
    //回款
	$('#isReceived').iCheck({checkboxClass:'icheckbox_minimal-blue'});
	$('#isPaid').iCheck({checkboxClass:'icheckbox_minimal-blue'});
	
	$('#isReceived').on('ifChanged', function(event) {
	    if (this.checked) {
	        $('#isReceived').val('1');
	    } else {
	    	 $('#isReceived').val('0');
	    }
	});
	
   //出款
	$('#isPaid').on('ifChanged', function(event) {
	    if (this.checked) {
	        $('#isPaid').val('1');
	    } else {
	    	 $('#isPaid').val('0');
	    }
	});
	
		

     //搜索提交 
     $("#search").on('click',function(){
    	 
 	    $("#formsearch").submit();
 	    
     });

     //导出
     $("#export").on('click',function(){

   	     window.open('/admin/trade/index?%5C_pjax=%23pjax-container&_export_=all');   	    
       });
       
});

//datatables
$(function () {

    $('#example1').DataTable({
   	 'paging'      : true,
     'lengthChange': true,
     'searching'   : false,
     'ordering'    : true,
     'info'        : true,
     'autoWidth'   : true,
  	  "language": {
	  		"sProcessing":   "处理中...",
	  		"sLengthMenu":   "显示 _MENU_ 项结果",
	  		"sZeroRecords":  "没有匹配结果",
	  		"sInfo":         "显示第 _START_ 至 _END_ 项结果，共 _TOTAL_ 项",
	  		"sInfoEmpty":    "显示第 0 至 0 项结果，共 0 项",
	  		"sInfoFiltered": "(由 _MAX_ 项结果过滤)",
	  		"sInfoPostFix":  "",
	  		"sSearch":       "搜索:",
	  		"sUrl":          "",
	  		"sEmptyTable":     "表中数据为空",
	  		"sLoadingRecords": "载入中...",
	  		"sInfoThousands":  ",",
	  		"oPaginate": {
	  			"sFirst":    "首页",
	  			"sPrevious": "上页",
	  			"sNext":     "下页",
	  			"sLast":     "末页"
	  		},
	  		"oAria": {
	  			"sSortAscending":  ": 以升序排列此列",
	  			"sSortDescending": ": 以降序排列此列"
	  		}
      }    
       
    });
});