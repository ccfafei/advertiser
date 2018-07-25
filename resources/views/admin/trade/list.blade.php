
<div class="box">
    <div class="box-header">
    <form action="{{ url('/admin/trade/index') }}" method="post" id="formsearch" class="form-inline">
        <div class="form-group">
           <label for="customerName" class="control-label">客户名称: </label>  
           <div class="input-group mr_2">
             <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
             <input name="customer_name" id="customerName" class="form-control mr_1" placeholder="请输入客户名称    " value="" />            
           </div>          
         
          <label for="mediaName" class="control-label">媒体名称: </label> 
          <div class="input-group mr_2">
             <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
             <input name="media_name" id="mediaName" class="form-control mr_1" placeholder="请输入媒体名称       " value="" />            
           </div>
           
          <label for="contributionTitle" class="control-label">稿件标题: </label> 
          <div class="input-group  mr_2">
             <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
             <input name="contribution" id="contributionTitle" class="form-control mr_1" placeholder="请输入媒体名称       " value="" />            
           </div>
           
        </div>
        <div class="clearfix mt_1"></div>
        <div class="form-group">
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
        <div class="form-group mt_1">  

               <label>是否审核: </label>
                 <select name="is_check" class="form-control mr_2">
                  <option value ="">请选择</option>
                     @foreach($checks as $ck=>$cv)
                      <option value ="{{$ck}}">
                        {{$cv}}
                      </option>
                     @endforeach
                 </select>
                 <label class="mt_1 mr_2">
                    <input type="checkbox" name="is_received" id="isReceived"  class="minimal" value="">&nbsp;是否回款  &nbsp;&nbsp;                            
                  </label>

                  <label class="mt_1 mr_2">                 
                        <input type="checkbox" name="is_paid" id="isPaid"  class="minimal" value="">&nbsp;是否出款
                  </label>
                  
        </div> 
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
        <table id="example1" class="table table-bordered table-hover">
         <!-- ['序号','日期','客户名称','媒体名称','稿件标题','字数','单价','报价','媒体款','利润','是否回款',	'是否出款','是否审核']; -->
         <thead>
            <tr>
              @foreach($headers as $header)
                <th>{{  $header }} </th>
              @endforeach 
            </tr>
          <thead>
          <tbody>
             @foreach($rows as $key=>$items)
            <tr>
                <td>{{ $key+1 }}</td>             
                <td>{{ $items['trade_ts'] }}</td>
                <td>{{ $items['customer_name']}}</td>
                <td>{{ $items['media_name'] }}</td>
                <td>{{ $items['contribution'] }}</td>
                <td>{{(int)$items['words'] }}</td>
                <td>{{ (int)$items['price']}}</td>
                <td>{{ $items['customer_price']}}</td>                 
                <td>{{ $items['media_price']}}</td>
                <td>{{ $items['profit'] }}</td>
                <td>{{ $items['is_received']}}</td>
                <td>{{ $items['is_paid']}}</td>
                <td>{{ $items['is_check']}}</td>
            </tr>            
            @endforeach
        </tbody>
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
         'lengthChange': false,
         'searching'   : false,
         'ordering'    : true,
         'info'        : true,
         'autoWidth'   : false,
         'ordering':true, 
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
     $('#isReceived').on('ifChecked', function(event){ 
    	 $('#isReceived').val(1);
   	 }); 

     $('#isPaid').on('ifChecked', function(event){ 
    	 $('#isPaid').val(1);
   	 }); 


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