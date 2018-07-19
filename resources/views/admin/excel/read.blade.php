<div class="box">

    <div class="box-body table-responsive ">
        <table class="table table-hover">          
          <tr>
             @foreach($headers as $title)
             <th>{{ $title }}</th>
             @endforeach
          </tr>
            @foreach($result as $key=>$row)
            <tr>
               <td>

              @if(empty($row['error']))
              <font color="green"> 有效</font>
           
              @else
              <font color="red">无效 </font>
             @endif
               </td>
               <td>{{ $row['num']}}</td>
               <td>{{ $row['trade_ts'] }}</td>
               <td>{{ $row['customer_name']}}</td>
                <td>{{ $row['media_name'] }}</td>
                <td>{{ $row['contribution'] }}</td>
                <td>{{ $row['words'] }}</td>
                 <td>{{ $row['price']}}</td>
                 <td>{{ $row['media_price']}}</td>
                <td>{{ $row['profit'] }}</td>
                <td>{{ $row['is_received']}}</td>
                <td>{{ $row['is_paid']}}</td>
            </tr>
            @endforeach

        </table>
    </div>

</div>
