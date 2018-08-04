
<div class="box">
    <div class="box-header">
    <form action="{{ url('/admin/report/paid') }}" method="post" id="formsearch" class="form-inline">
        <div class="form-group">
           <label for="mediaName" class="control-label">媒体名称: </label>  
           <div class="input-group mr_2">
             <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
             <input name="media_name" id="mediaName" class="form-control mr_1" placeholder="请输入媒体名称    " value="" />            
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
                <label>是否出款: </label>
                 <select name="is_paid" class="form-control mr_2">
                  <option value ="all">请选择</option>
                  <option value ="0">否</option>
                  <option value ="1">是</option> 
               </select>
        </div>
        <div class="clearfix mt_1" ></div>
        
          
    </form>
     

    </div>
    <!-- /.box-header -->
    <div class="box-body ">
        <table id="example1" class="table table-bordered table-hover">
         <thead>
            <tr>
                <th>序号</th>
                <th>日期 </th>
                <th>媒体名称 </th>
                <th>金额</th>
                <th>是否出款</th>
                <th>交易明细</th>
            </tr>
          <thead>
          <tbody>
             @foreach($rows as $key=>$items)
            <tr>
                <td>{{ $key+1 }}</td>             
                <td>{{ $items['trade_ts'] }}</td>
                <td>{{ $items['media_name']}}</td>              
                <td>{{ $items['media_price']}}</td>                                       
                <td>{!! $items['is_paid'] !!}</td>
                <td><a href="javascript:void(0)" onClick="getTradeDetails([{!! $items['trade_ids'] !!}]);" 
                class="btn btn-primary"  data-toggle="modal">查看明细</a></td>
                
            </tr>            
            @endforeach
        
        </tbody>
            <tr>
            <td><b>合计</b></td>
            <td>-</td>
            <td></td>                 
            <td><b>{{ $arrsum['media_prices'] }}元</b></td>
            <td></td>
            <td></td>
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
<script>
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
</script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.34.5/css/bootstrap-dialog.min.css" rel="stylesheet" type="text/css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.34.5/js/bootstrap-dialog.min.js"></script>
<script>
$(function () {
	$(".trade_show").hide();
});
//更新回款状态
function updatePaid(ids,status){
        $.ajax({
            method: 'post',
            url: "{!! url('/admin/report/paidupdate') !!}",
            data: {
                _token:LA.token,
                ids: ids,
                action: status
            },
            success: function () {
                $.pjax.reload('#pjax-container');
                toastr.success('更新成功');
            }
        });
}

//查看交易明细
function getTradeDetails(ids){
	$.ajax({
        method: 'get',
        url: "{!! url('/admin/report/tradedetails') !!}",
        data: {
            _token:LA.token,
            ids: ids,
        },
        success: function (data) {
            if(data.status == 1){
            	getTradeSuccess(data.data);
            }else{
           	 ajaxalert('错误:','查询失败','关闭');
           }
        
        }
    });

function getTradeSuccess(res){
    var htmls ='<table class="table">';        
    htmls += '<tr><th>日期 </th><th>媒体名称 </th><th>稿件标题</th><th>出款金额</th><th>是否出款</th></tr>';
    var tbody="";
    for (i=0;i<res.length;i++){
    	console.log(res[i].trade_id);
    	str = res[i].contribution;
    	tbody += "<tr>";
    	tbody +="<td>"+res[i].trade_ts+"</td>";
    	tbody +="<td>"+res[i].media_name+"</td>";
    	tbody +="<td>"+str.substring(0,24)+"...</td>";
    	tbody +="<td>"+res[i].customer_price+"</td>";
    	tbody +="<td>"+res[i].is_paid+"</td>";
    	tbody += "</tr>";
    }
    htmls += tbody;
    htmls += "</table>";
               
    BootstrapDialog.show({
    	title: '交易明细',
        message: htmls,
        cssClass: 'trade_dialog',
        buttons: [{
       		label: '关闭',
            action: function(dialog) {
            	dialog.close();
            }
        }],
    });
        
    }
}
</script>




