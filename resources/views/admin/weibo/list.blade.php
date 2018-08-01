
<div class="box">
    <div class="box-header">
        <form action="{{ url('/admin/weibo/index')}}" method="post" id="weibo_search" class="form-inline">
            <div class="form-group">
             <label>开发日期: </label>
                <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                  <input type="text" class="form-control mr_1" id="datepicker_start" name="start_day" value="">
                </div>
             
               <label>~ </label>
                <div class="input-group date mr_1">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                   <input type="text" class="form-control" id="datepicker_end" name="end_day" value="">
                </div>
          <label for="Name" class="control-label">微博名称: </label> 
          <div class="input-group mr_2">
             <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
             <input name="weibo_name" id="weiboName" class="form-control mr_1" placeholder="请输入微博名称       " value="" />            
           </div>
           
          
        </div>
        <div class="clearfix mt_2" ></div>
        <div class="form-group">
          
              <label for="contributionTitle" class="control-label">微博分类: </label> 
              <div class="input-group  mr_2">
             
                  <select name="category" class="form-control mr_2">
                      <option value ="all">请选择</option>
                       @foreach($category as $k=>$v)
                       <option value="{!! $k !!}">{!! $v !!}</option>
                       @endforeach
                  </select>
               </div>  
              <label for="" class="control-label">负责人: </label> 
              <div class="input-group  mr_2">
                  <select name="leader" class="form-control mr_2">
                      <option value ="all">请选择</option>
                       @foreach($leader as $lk=>$lv)
                       <option value="{!! $lk !!}">{!! $lv !!}</option>
                       @endforeach
                  </select>
              </div>
              
            
               <label class="mt_1 mr_2">
                  <button type="button" class="btn btn-primary" id="search"><i class="fa  fa-search" ></i>搜索</button>
               </label>  
              &nbsp;&nbsp;
               <label  class="mt_1">
               <a href="/admin/weibo/create" class="btn  btn-success">
                   <i class="fa fa-save"></i>&nbsp;&nbsp;新增
                </a>
               </label>
                &nbsp;&nbsp;
               <label  class="mt_1">
                  <button type="button" class="btn btn-warning"  id="export"><i class="fa  fa-download"></i>导出</button>
               </label>
        </div>  
        </form>  
      </div>          
      

    <!-- /.box-header -->
    <div class="box-body ">
        <table id="example1" class="table table-bordered table-hover">
         <thead>
            <tr>
              @foreach($headers as $header)
                <th>{!!  $header !!} </th>
              @endforeach 
            </tr>
          <thead>
          <tbody>
             @foreach($rows as $row)
              <tr>
         
                <td>{!! $row['weibo_ts'] !!}</td>
                <td>{!! $row['weibo_name'] !!}</td>
                <td>{!! $category[$row['weibo_category']] !!}</td>
                 <td>{!! $row['fans'] !!}</td>      
                <td>{!! $row['direct_price'] !!}</td>
                <td>{!! $row['forward_price'] !!}</td>
                <td><a href="{!! $row['cases'] !!}" target="_blank">查看</a></td>
                <td>{!! $row['direct_microtask'] !!}</td>
                <td>{!! $row['forward_microtask'] !!}</td>
                <td>{!! $leader[$row['leader']] !!}</td>
                <td><a href="{!! url('/admin/weibo/'.$row['weibo_id'].'/edit') !!}"><i class="fa fa-edit"></i></a></td>
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
<script type="text/javascript">

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
     //搜索提交 
     $("#search").on('click',function(){
    	 
 	    $("#weibo_search").submit();
 	    
     });

     //导出
     $("#export").on('click',function(){

   	     window.open('/admin/weibo/?%5C_pjax=%23pjax-container&_export_=all');   	    
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
     'autoWidth'   : false,
     "columnDefs": [ {
         "targets": [ 6,10],
         "orderable": false
       } ],
  	  "language": {
	  		"sProcessing":   "处理中...",
	  		"sLengthMenu":   "显示 _MENU_ 项结果",
	  		"sZeroRecords":  "没有匹配结果",
	  		"sInfo":         "从 _START_ 到 _END_ ，共 _TOTAL_ 条",
	  		"sInfoEmpty":    "共0条",
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
	  		
	  		
      }    
       
    });
});

//-->
</script>