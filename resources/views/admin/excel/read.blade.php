<div class="box">
    <div class="box-header">

        <h3 class="box-title"></h3>

    </div>
    <!-- /.box-header -->
    <div class="box-body table-responsive ">
        <table class="table table-hover">          

            @foreach($result as $key=>$row)
            <tr>
             @if($key ==0)
               <td>序号</td>
              @else  
                <td>{{ $key }}</td>                                                                   
            @endif

                @foreach($row as $name)
               
                <td>
                    {{ $name }}
                </td>
                @endforeach
            </tr>
            @endforeach

        </table>
    </div>

    <!-- /.box-body -->
</div>
