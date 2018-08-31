
<div class="box">
    <div class="box-body table-responsive ">
        <table class="table table-hover">
        <tr>
            <td colspan="13">
            <form action="" method="post" name="form" >
             <?php 
                $data= base64_encode(json_encode($result));      
             ?>
            <input type="hidden" class="exceldata" name="ExcelData" value="{{ $data }}">
            <?php if($flag==1){$diable='disabled="disabled"';}else{$diable="";}?>
              <button type="button"  class="btn btn-info " {{ $diable }} onclick="saveExcel()">保存</button>
              
              <button type="button" class="btn btn-warning" style="margin-left:30px;" onclick="backExcel()">返回</button>
           </form> 
            </td>                           
        </tr>    
            
             
          <tr>
             @foreach($headers as $title)
             <th>{{ $title }}</th>
             @endforeach
          </tr>
            @foreach($result as $key=>$row)
            <tr>
               <td>

              @if(empty($row['error']))
               <font color=green><i class="fa fa-check-circle"></i></font>             
              @else
              
               <font color=red>
                <i class="fa fa-times-circle"></i>                 
               </font>
               <?php 
                    $errors =[];
                    foreach ($row['error'] as $items){
                        $errors []= config('error.'.$items);
                    }
                    $errormsg = json_encode($errors);
                ?>
               <a href="javascript:void(0);" onclick="checkerror('{{ $errormsg }}')" style="color:red;">查看</a>
 
             @endif
               </td>
               <td>{{ $row['num']}}</td>
               <td>{{ $row['trade_ts'] }}</td>
               <td>{{ $row['customer_name']}}</td>
                <td>{{ $row['media_name'] }}</td>
                <td>{{ $row['contribution'] }}</td>
                  <td>
                  <?php
                 $link = preg_match('/^http(s)?:\\/\\/.+/',$row['project'])?$row['project']:'http://'.$row['project'];
                 echo '<a href="'.$link.'" target="_blank">查看</a>'; 
                 ?>                
                
                </td>
                <td>{{ $row['words'] }}</td>
                 <td>{{ $row['price']}}</td>
                <td>{{ $row['customer_price']}}</td>                 
                 <td>{{ $row['media_price']}}</td>
                <td>{{ $row['profit'] }}</td>
                <td>{{ $row['is_received']}}</td>
                <td>{{ $row['is_paid']}}</td>
            </tr>            
            @endforeach
           
            <tr>
                <td colspan="13">
                <form action="" method="post" name="form" >
                 <?php 
                    $data= base64_encode(json_encode($result));      
                 ?>
                <input type="hidden" class="exceldata" name="ExcelData" value="{{ $data }}">
                <?php if($flag==1){$diable='disabled="disabled"';}else{$diable="";}?>
                  <button type="button"  class="btn btn-info " {{ $diable }} onclick="saveExcel()">保存</button>
                  
                  <button type="button" class="btn btn-warning" style="margin-left:30px;" onclick="backExcel()">返回</button>
               </form> 
                </td>                           
            </tr>
            
        </table>
    </div>

</div>
<script>
    //查看导入excel错误
    function checkerror(data){
    	var obj = JSON.parse(data);
    	console.log(obj);
    	var errormsg ="";
    	for (var i=0;i<obj.length;i++)
    	{
    		errormsg += (i+1)+". "+ obj[i]+"\n\r";
    	} 
    	ajaxalert("错误提示:",errormsg,"关闭")
    }

    //保存数据
    function saveExcel(){
        var saveurl ="{{url('admin/exceltrade/save')}}";
        var savedata=$(".exceldata").val();                
    	$.ajax({
        	url: saveurl, 
        	data: {"exceldata":savedata}, 
        	dataType:"json",
        	type:"POST",
        	success: function(ok){
       		 console.log(ok);

              	  if(ok.status == 1){
                        ajaxalert("保存提示:",ok.message,"关闭");
                		location.href="{{url('admin/trade')}}";
               	  }else{
                      ajaxalert("保存提示:",ok.message,"关闭");
                 		history.back(-1);
                  }
            },
            error:function(err){
        	   console.log(err);
        	   ajaxalert("保存提示:","保存失败","关闭");
        	   history.back(-1);
            }
        });
    }

    //返回到导入页
    function backExcel(){
        backurl ="{{url('admin/exceltrade/import')}}";
    	window.location.href = backurl;
    }
    
    //返回提醒
    function ajaxalert(title,msg,btn){
    	swal({
        	title:title,
            text:msg,
            confirmButtonText:btn,
            closeOnConfirm:true,
            timer:5000,
            html:true,
        });
    };
</script>
