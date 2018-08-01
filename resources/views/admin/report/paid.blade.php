
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
                <td>
                <input name="trade_ids" type="hidden" value="{{$items['trade_ids']}}" />
              
                </td>
            </tr>            
            @endforeach
        
        </tbody>
            <tr>
            <td><b>合计</b></td>
            <td>-</td>
            <td></td>                 
            <td><b>{{ $arrsum['media_prices'] }}元</b></td>
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
<script type="text/javascript" src="{{ env('APP_URL') }}/js/trade.list.js"></script>

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




