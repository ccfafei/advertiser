<style>
    .dataTables_wrapper .dataTables_length {
        display: inline-block;
        float: left;
        margin-bottom: 5px;
    }

    .dataTables_wrapper .dt-button {
        display: inline-block;
        float: right;
    }
</style>

<div class="box">
    <div class="box-header">
    <form action="{{ url('/admin/report/receive') }}" method="post" id="formsearch" class="form-inline">
        <div class="form-group">
           <label for="customerName" class="control-label">客户名称: </label>  
           <div class="input-group mr_2">
             <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
             <input name="customer_name" id="customerName" class="form-control mr_1" placeholder="请输入客户名称    " value="" />            
           </div>          
     
                <label>月份: </label>
                <div class="input-group date mr_2 mt_1">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                  <input type="text" class="form-control mr_1" id="datepicker_start" name="month" value="">
                </div>
             <!--
               <label>结束时间: </label>
                <div class="input-group date mr_1">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                   <input type="text" class="form-control" id="datepicker_end" name="end_day" value="">
                </div>
                -->
                <label>是否回款: </label>
                 <select name="is_received" class="form-control mr_2">
                  <option value ="all">请选择</option>
                  <option value ="0">否</option>
                  <option value ="1">是</option> 
               </select>
        </div>
        <div class="clearfix mt_1" ></div>
        <div class="form-group">  
            
           <label class="mt_1 mr_2">
              <button type="button" class="btn btn-primary" id="search"><i class="fa  fa-search" ></i>搜索</button>
           </label>  
          &nbsp;&nbsp;

        </div>
          
    </form>
     

    </div>
    <!-- /.box-header -->
    <div class="box-body ">
        <table id="example2" class="table table-bordered table-hover">
         <thead>
            <tr>
                <th>序号</th>
                <th>月份 </th>
                <th>客户名称 </th>
                <th>已回款</th>
                <th>未回款</th>
                <th>负责人</th>
            </tr>
          <thead>
          <tbody>
             @foreach($rows as $key=>$items)
            <tr>
                <td>{{ $key+1 }}</td>             
                <td>{{ $items['trade_month'] }}</td>
                <td>{{ $items['customer_name']}}</td>              
                <td>{{ $items['received_prices']}}</td>
                <td>{{ $items['no_received_prices']}}</td>
                <td>{!! $items['leader'] !!}</td>
            </tr>
            @endforeach
        
        </tbody>
            <tr>
            <td><b>合计</b></td>
            <td>-</td>
            <td></td>                 
            <td><b>{{ $arrsum['received_prices'] }}元</b></td>
            <td><b>{{ $arrsum['no_received_prices'] }}元</b</td>
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
    $.fn.datepicker.defaults.todayHighlight = 'true';
    $.fn.datepicker.defaults.format = "yyyy-mm";
    $.fn.datepicker.defaults.startView = 'months';
    $.fn.datepicker.defaults.maxViewMode = 'years';
    $.fn.datepicker.defaults.minViewMode = 'months';
    $.fn.datepicker.defaults.autoclose = 'true';

	 //开始时间
	 var starttime=$("#datepicker_start").val();
     if(starttime == ""){
         //var lastday = getBeforeDate(-
         var date=new Date;
         var year=date.getFullYear();
         var month=date.getMonth()+1;
         month =(month<10 ? "0"+month:month);
         var mydate = (year.toString()+"-"+month.toString());
         $("#datepicker_start").val(mydate);
         $("#datepicker_start").datepicker("update", mydate);
     }
     //结束时间
     // var endtime=$("#datepicker_end").val();
     // if(endtime == ""){
     //     $("#datepicker_end").val(nowtime);
     //     $("#datepicker_end").datepicker("update", nowtime);
     // }
     //

     //搜索提交 
     $("#search").on('click',function(){
    	 
 	    $("#formsearch").submit();
 	    
     });

     //导出
     // $("#export").on('click',function(){
     //
   	//      window.open('/admin/trade/index?%5C_pjax=%23pjax-container&_export_=all');
     //   });
     //
});

//datatables
$(function () {

    $('#example2').DataTable({
        'dom': 'lBtip',
        buttons: {
            buttons: [
                {
                    extend: 'excel',
                    className: 'excelbutton dt-button btn btn-warning',
                    'text': 'Excel导出',
                    'title': '回款列表',
                }
            ]
        },
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
    htmls += '<tr><th>日期 </th><th>客户名称 </th><th>稿件标题</th><th>回款金额</th><th>是否回款</th></tr>';
    var tbody="";
    for (i=0;i<res.length;i++){
    	console.log(res[i].trade_id);
    	str = res[i].contribution;
    	tbody += "<tr>";
    	tbody +="<td>"+res[i].trade_ts+"</td>";
    	tbody +="<td>"+res[i].customer_name+"</td>";
    	tbody +="<td>"+str.substring(0,24)+"...</td>";
    	tbody +="<td>"+res[i].customer_price+"</td>";
    	tbody +="<td>"+res[i].is_received+"</td>";
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




