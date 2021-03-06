<style>
    .dataTables_wrapper .dataTables_length {
        display: inline-block;
        float: left;
        margin-top: 10px;
        margin-bottom: 5px;
    }

    .dataTables_wrapper .dt-button {
        display: inline-block;
        float: right;

    }
</style>
<div class="box">
    <div class="box-header">
        <form action="{{ url('/admin/trade/check') }}"  id="formsearch" class="form-inline">
            <input type="hidden" name="ver" value="1">
            <div class="form-group">
                <label for="customerName" class="control-label">客户名称: </label>
                <div class="input-group mr_2">
                    <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                    <input name="customer_name" id="customerName" class="form-control mr_1" placeholder="请输入客户名称    "
                           value="{{$request_params->customer_name}}"/>
                </div>

                <label for="mediaName" class="control-label">媒体名称: </label>
                <div class="input-group mr_2">
                    <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                    <input name="media_name" id="mediaName" class="form-control mr_1" placeholder="请输入媒体名称       "
                           value="{{$request_params->media_name}}"/>
                </div>

                <label for="contributionTitle" class="control-label">稿件标题: </label>
                <div class="input-group  mr_2">
                    <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                    <input name="contribution" id="contributionTitle" class="form-control mr_1"
                           placeholder="请输入媒体名称       " value="{{$request_params->contribution}}"/>
                </div>

            </div>
            <div class="clearfix mt_1"></div>
            <div class="form-group">
                <label>开始时间: </label>
                <div class="input-group date mr_2 mt_1">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control mr_1" id="datepicker_start" name="start_day" value="{{$request_params->start_day}}">
                </div>

                <label>结束时间: </label>
                <div class="input-group date mr_1">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control" id="datepicker_end" name="end_day" value="{{ $request_params->end_day}}">
                </div>
                <label>负责人:</label>
                <div class="input-group  mr_2">
                    <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                    <input name="leader" id="contributionTitle" class="form-control mr_1"
                           placeholder="请输入负责人  " value="{{$request_params->leader}}"/>
                </div>

            </div>
            <div class="clearfix mt_1"></div>
            <div class="form-group mt_1">

                <label>是否审核: </label>
                <select name="is_check" class="form-control mr_2" id="is_check">
                    <option value="">请选择</option>
                    @foreach($checks as $ck=>$cv)
                        <option value="{{$ck}}">
                            {{$cv}}
                        </option>
                    @endforeach
                </select>

                <label>是否回款: </label>
                <select name="is_received" class="form-control mr_2" id="isReceived">
                    <option value="">请选择</option>
                    <option value="0">未回款</option>
                    <option value="1">已回款</option>
                </select>

                <label>是否出款: </label>
                <select name="is_paid" class="form-control mr_2" id="isPaid">
                    <option value="">请选择</option>
                    <option value="0">未出款</option>
                    <option value="1">已出款</option>
                </select>


            </div>
            <div class="form-group">
                <label class="mt_1 mr_2">
                    <input id="tradePageSize" type="hidden" name="pageSize" value="50" />
                    <button type="button" class="btn btn-primary" id="search"><i class="fa  fa-search"></i>搜索</button>
                </label>
                &nbsp;
            </div>

        </form>

    </div>

    <div style="width:100%;height:2px; background:#E0E0E0;"></div>
    <div class="box-body ">
        <div class="form-inline">
            <input type="checkbox" class="grid-select-all" />&nbsp;&nbsp;&nbsp;
            <div class="btn-group">
                <a class="btn btn-warning">通过审核</a>
                <button type="button" class="btn btn-warning dropdown-toggle mr_2" data-toggle="dropdown">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                </button>
                <ul class="dropdown-menu ml_1" role="menu">
                    <li><a href="#" class="grid-check" data="1">通过</a></li>
                    <li><a href="#" class="grid-check" data="2">不通过</a></li>
                </ul>
            </div>
            <div class="btn-group">
                <a class="btn btn-info ml_1"> 回款审核</a>
                <button type="button" class="btn btn-info dropdown-toggle mr_2" data-toggle="dropdown">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                </button>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="#" class="grid-receive" data="1">已回款</a></li>
                    <li><a href="#" class="grid-receive" data="0">未回款</a></li>

                </ul>
            </div>
            <div class="btn-group">
                <a class="btn btn-success">出款审核</a>
                <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                </button>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="#" class="grid-paid" data="1">已出款</a></li>
                    <li><a href="#" class="grid-paid" data="0">未出款</a></li>

                </ul>

            </div>

            <div class="btn-group">
                <button class="btn btn-warning batch_delete ml_1" >删除</button>

            </div>

            <div class="clearfix mt_1"></div>
            <div class="form-group" style="margin-top: 15px;">

                <label class="text-center no-padding no-margin">显示:</label>
                <select id="perPage" class="form-control input-sm" name='perPage' form="perPage">
                    <option  {{ $rows->perPage() == 100 ? 'selected': ''}} value="100">100</option>
                    <option {{ $rows->perPage() == 50 ? 'selected': ''}} value="50">50</option>
                    <option {{ $rows->perPage() == 30 ? 'selected': ''}} value="30">30</option>
                    <option {{ $rows->perPage() == 10 ? 'selected': ''}} value="10">10</option>

                </select>
                <label class="text-center no-padding no-margin">项结果</label>


            </div>

            <div class="form-group" style="float:right">
                <input id="trade_export"  class="btn btn-warning" type="button" value="Excel导出"/>
            </div>

            <div>

                <table id="dataTables" class="table table-bordered table-hover display nowrap" style="width:100%">
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
                            <td><input type="checkbox" class="grid-row-checkbox" data-id="{{$items['trade_id']}}"/></td>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $items['trade_ts'] }}</td>
                            <td>{{ $items['customer_name']}}</td>
                            <td>{{ $items['media_name'] }}</td>
                            <td>{{ $items['contribution'] }}</td>
                            <td>
                                <?php
                                $link = preg_match('/^http(s)?:\\/\\/.+/', $items['project']) ? $items['project'] : 'http://' . $items['project'];
                                echo '<a href="' . $link . '" target="_blank">查看</a>';
                                ?>

                            </td>
                            <td>{{(int)$items['words'] }}</td>
                            <td>{{ (float)$items['price']}}</td>
                            <td>{{ $items['customer_price']}}</td>
                            <td>{{ $items['media_price']}}</td>
                            <td>{{ $items['profit'] }}</td>
                            <td>{!! $items['is_received'] !!}</td>
                            <td>{!! $items['is_paid'] !!}</td>
                            <td>{!! $items['is_check'] !!}</td>
                            <td>{!! $items['leader'] !!}</td>
                            <td>
                                <a href="{!! url('/admin/trade/check/'. $items['trade_id'].'/edit') !!}">
                                    <i   class="fa fa-edit"></i>
                                </a>

                                <a href="javascript:void(0);" data-id="{!! $items['trade_id'] !!}" class="grid-row-delete" onClick="rowdelete('{!! $items['trade_id'] !!}')">
                                    <i class="fa fa-trash"></i>
                                </a>

                            </td>


                        </tr>
                    @endforeach

                    </tbody>
                    <tr>
                        <td><b>合计</b></td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td><b>{{ $arrsum['prices'] }}元</b></td>
                        <td><b>{{ $arrsum['customer_prices'] }}元</b></td>
                        <td><b>{{ $arrsum['media_prices'] }}元</b></td>
                        <td><b>{{ $arrsum['profits'] }}元</b></td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                    </tr>

                </table>
                {{$rows->appends($request_params->all())->render()}}
            </div>
        </div>


    </div>
</div>
    <script>
        function LA() {
        }

        LA.token = "{{ csrf_token() }}";
    </script>
<script type="text/javascript">
    $(function () {
        var is_check = "{{ $request_params->is_check }}";
        if(is_check != ''){
            $('#is_check').val(is_check);
        }
        var is_received = "{{  $request_params->is_received }}";
        if(is_received != ''){
            $('#isReceived').val(is_received);
        }
        var is_paid = "{{  $request_params->is_paid }}";
        if(is_paid !=''){
            $('#isPaid').val(is_paid);
        }
    });
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
            // $('#isReceived').iCheck({checkboxClass: 'icheckbox_minimal-blue'});
            // $('#isPaid').iCheck({checkboxClass: 'icheckbox_minimal-blue'});
            $('.grid-select-all').iCheck({checkboxClass: 'icheckbox_minimal-blue'});
            // $('input[type="checkbox"]').iCheck({
            //     handle : 'checkbox',
            //     checkboxClass : 'icheckbox_minimal-blue',
            // });

            // $('#isReceived').on('ifChanged', function (event) {
            //     if (this.checked) {
            //         $('#isReceived').val('1');
            //     } else {
            //         $('#isReceived').val('0');
            //     }
            // });

            //出款
            // $('#isPaid').on('ifChanged', function (event) {
            //     if (this.checked) {
            //         $('#isPaid').val('1');
            //     } else {
            //         $('#isPaid').val('0');
            //     }
            // });


            //开始时间
            var start_ts = "{{ $request_params->start_day }}" || getBeforeDate(-1);
            $("#datepicker_start").val(start_ts);
            $("#datepicker_start").datepicker("update", start_ts);

            //结束时间
            var end_ts = "{{ $request_params->end_day }}" || nowtime;
            $("#datepicker_end").val(end_ts);
            $("#datepicker_end").datepicker("update", end_ts);
            //搜索提交
            $("#search").on('click', function () {

                $("#formsearch").submit();

            });

            $("#trade_export").on('click', function () {
                var params = "{!! http_build_query($request_params->except('s','ver','pageSize','_pjax')) !!}"
                var url = "{!! url('/admin/exceltrade/export')!!}";
                var fullUrl = params == ""?url:url+"?"+params;
                console.log(fullUrl)
                window.location.href = fullUrl;
            });

            //选择等 icheckbox_minimal-blue
            $('.grid-row-checkbox').on('ifChanged', function () {
                if (this.checked) {
                    $(this).closest('tr').css('background-color', '#ffffd5');
                } else {
                    $(this).closest('tr').css('background-color', '');
                }
            });

            var selectedRows = function () {
                var selected = [];
                $('.grid-row-checkbox:checked').each(function () {
                    selected.push($(this).data('id'));
                });

                return selected;
            }

           // $('.grid-select-all').iCheck({checkboxClass: 'icheckbox'});
            $('.grid-select-all').on('ifChanged', function (event) {
                if (this.checked) {
                    //$('.grid-row-checkbox').iCheck('check');
                    $('.grid-row-checkbox').prop("checked",true);

                } else {
                    //$('.grid-row-checkbox').iCheck('uncheck');
                    $('.grid-row-checkbox').prop("checked",false);
                }
            });


            //审核操作
            optionOnCheck('.grid-check', selectedRows, "{!! url('/admin/trade/checkupdate') !!}");

            //回款操作
            optionOnCheck('.grid-receive', selectedRows, "{!! url('/admin/trade/receiveupdate') !!}");

            //出款操作
            optionOnCheck('.grid-paid', selectedRows, "{!! url('/admin/trade/paidupdate') !!}");

            //删除
            batchdelte(selectedRows);


        });

        //datatables
        $(function () {

            $('#dataTables').DataTable({
                'dom': 'lBtip',
                // buttons: {
                //     buttons: [
                //         {
                //             extend: 'excel',
                //             className: 'excelbutton dt-button btn btn-warning',
                //             'text': 'Excel导出',
                //             'title': '业务流量列表',
                //             exportOptions: {
                //                 format: {
                //                     body: function (data, row, column ) {
                //
                //                         if (column ==6)
                //                         {
                //                             var dt = httpString(data);
                //                         }else{
                //                             var dt =  strip( data);
                //                         }
                //
                //                         return dt;
                //                     }
                //                 }
                //             }
                //         }
                //     ]
                // },
                buttons: {
                    buttons: [ ]
                },
                "scrollX": true,
                "paging": false,//开启表格分页
                'searching': false,
                'ordering': true,
                'info': false,
                "lengthChange": false,
                'autoWidth': false,
                "columnDefs": [{
                    "targets": [0, 13],
                    "orderable": false
                }],

                "oLanguage": {
                    "sProcessing": "处理中...",
                    "sLengthMenu": "每页显示 _MENU_ 条记录",
                    "sZeroRecords": "没有匹配结果",
                    "sInfo": "从 _START_ 到 _END_ ，共 _TOTAL_ 条",
                    "sInfoEmpty": "共0条",
                    "sInfoFiltered": "(由 _MAX_ 项结果过滤)",
                    "sInfoPostFix": "",
                    "sSearch": "搜索:",
                    "sUrl": "",
                    "sEmptyTable": "表中数据为空",
                    "sLoadingRecords": "载入中...",
                    "sInfoThousands": ",",
                    "oPaginate": {
                        "sFirst": "首页",
                        "sPrevious": "上页",
                        "sNext": "下页",
                        "sLast": "末页"
                    },
                    "oAria": {
                        "sSortAscending": ": 以升序排列此列",
                        "sSortDescending": ": 以降序排列此列"
                    }
                }

            });
        });


        function optionOnCheck(divclass, func, posturl) {
            $(divclass).on('click', function () {
                //func = function(){return e();}
                ids = func().join();
                //alert(ids);
                if (ids === "") {
                    ajaxalert('错误!', '请选择数据!', '关闭');
                    return false;
                }
                var status = $(this).attr('data');
                console.log(ids);

                //alert(status);
                $.ajax({
                    method: 'post',
                    url: posturl,
                    data: {
                        ids: ids,
                        action: status,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (data) {
                        console.log(data);
                        if (data.status == 0) {
                            ajaxalert('成功!', data.msg, '关闭');

                        } else {
                            ajaxalert('错误!', data.msg, '关闭');
                        }

                        $.pjax.reload('#pjax-container');

                    }
                });

            });
        }

        function batchdelte(func){
            $('.batch_delete').on('click', function () {
                ids = func().join();
                //alert(ids);

                swal({
                        title: "确认删除?",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "确认",
                        closeOnConfirm: false,
                        cancelButtonText: "取消"
                    },
                    function () {
                        $.ajax({
                            method: 'post',
                            url: '/admin/tradecheck/destory',
                            data: {
                                trade_id: ids,
                                _token: LA.token,
                            },
                            success: function (data) {
                                $.pjax.reload('#pjax-container');

                                if (typeof data === 'object') {
                                    if (data.status == 0) {
                                        swal(data.msg, '', 'success');
                                    } else {
                                        swal(data.msg, '', 'error');
                                    }
                                }
                            }
                        });
                    });

            });

        }

      function rowdelete(id){
    

                var id =id;

                swal({
                        title: "确认删除?",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "确认",
                        closeOnConfirm: false,
                        cancelButtonText: "取消"
                    },
                    function () {
                        $.ajax({
                            method: 'post',
                            url: '/admin/tradecheck/destory',
                            data: {
                                trade_id: id,
                                _token: LA.token,
                            },
                            success: function (data) {
                                $.pjax.reload('#pjax-container');

                                if (typeof data === 'object') {
                                    if (data.status == 0) {
                                        swal(data.msg, '', 'success');
                                    } else {
                                        swal(data.msg, '', 'error');
                                    }
                                }
                            }
                        });
                    });

}

 </script>

<script type="text/javascript">
    $(function(){
        // 每页显示条数
        $('#perPage').change(function(){
            var per_page = $(this).val();
            console.log(per_page);
            $("#tradePageSize").val(per_page);
            $('#formsearch').submit();
        })

    });
</script>
    