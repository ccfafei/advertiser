
<div class="box">
    <div class="box-header">
    <form action="{{ url('/admin/trade/index') }}" method="post" id="formsearch" class="form-inline">
        <div class="form-group">
           <label for="customerName" class="control-label">客户名称: </label>  
           <div class="input-group mr_2">
             <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
             <input name="customer_name" id="customerName" class="form-control mr_1" placeholder="请输入客户名称    " value="" />            
           </div>          
     
                <label>开始时间: </label>
                <div class="input-group date mr_2 mt_1">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                  <input type="text" class="form-control mr_1" id="datepicker_start" name="start_day" value="">
                </div>
             
               <label>结束时间: </label>
                <div class="input-group date mr_1">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                   <input type="text" class="form-control" id="datepicker_end" name="end_day" value="">
                </div>
              
        </div>
        <div class="clearfix mt_1" ></div>
        <div class="form-group">  
           <label class="mt_1 mr_2">
              <button type="button" class="btn btn-primary" id="search"><i class="fa  fa-search" ></i>搜索</button>
           </label>  
          &nbsp;&nbsp;
           <label  class="mt_1">
              <button type="button" class="btn btn-primary"  id="export"><i class="fa  fa-download"></i>导出</button>
           </label>
        </div>
          
    </form>
     

    </div>
    <!-- /.box-header -->
    <div class="box-body ">
        <table id="example2" class="table table-bordered table-hover">
         <thead>
            <tr>
                <th>序号</th>
                <th>日期 </th>
                <th>客户名称 </th>
                <th> </th>
            </tr>
          <thead>
          <tbody>
             @foreach($rows as $key=>$items)
            <tr>
                <td>{{ $key+1 }}</td>             
                <td>{{ $items['trade_ts'] }}</td>
                <td>{{ $items['customer_name']}}</td>              
                <td>{{ $items['customer_price']}}</td>                               
                <td>{{ $items['is_received']}}</td>
            </tr>            
            @endforeach
        
        </tbody>
            <tr>
            <td><b>合计</b></td>
            <td>-</td>
            <td><b>{{ $arrsum['customer_prices'] }}</b></td>                 
            <td>-</td>
            </tr>
        </table>
    </div>
    <div class="box-footer clearfix">
      
    </div>
    <!-- /.box-body -->
</div>

<script>
    function LA() {}
    LA.token = "{{ csrf_token() }}";
</script>

<!-- DataTables -->
<script>
    $(function () {

        $('#example1').DataTable({
       	 'paging'      : true,
         'lengthChange': true,
         'searching'   : false,
         'ordering'    : true,
         'info'        : true,
         'autoWidth'   : true,
      	  "language": {
       		 "url": "/css/Chinese.json"	
          }    
           
        });
    });
</script>



<script>
$(function () {
    
	$('#isReceived').iCheck({checkboxClass:'icheckbox_minimal-blue'});
	$('#isPaid').iCheck({checkboxClass:'icheckbox_minimal-blue'});
	
	$('#isReceived').on('ifChanged', function(event) {
	    if (this.checked) {
	        $('#isReceived').val('1');
	    } else {
	    	 $('#isReceived').val('0');
	    }
	});
	

	$('#isPaid').on('ifChanged', function(event) {
	    if (this.checked) {
	        $('#isPaid').val('1');
	    } else {
	    	 $('#isPaid').val('0');
	    }
	});
	
		

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
         var lastday = getBeforeDate(-10);
         $("#datepicker_start").val(lastday);    
         $("#datepicker_start").datepicker("update", lastday);        
     }
     //结束时间
     var endtime=$("#datepicker_end").val();
     if(endtime == ""){
         $("#datepicker_end").val(nowtime);    
         $("#datepicker_end").datepicker("update", nowtime);        
     }
     
     //设置值
//      $('#isReceived').on('ifChecked', function(event){ 
//     	 $('#isReceived').val(1);
//    	 }); 

//      $('#isPaid').on('ifChecked', function(event){ 
//     	 $('#isPaid').val(1);
//    	 }); 


     //搜索提交 
     $("#search").on('click',function(){
    	 
 	    $("#formsearch").submit();
 	    
     });

     //导出
     $("#export").on('click',function(){

   	     window.open('/admin/trade?%5C_pjax=%23pjax-container&_export_=all');   	    
       });
    
   
});

</script>
