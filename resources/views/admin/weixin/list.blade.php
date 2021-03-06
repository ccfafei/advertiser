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
        <form action="{{ url('/admin/weixin/index')}}" method="post" id="weixin_search" class="form-inline">
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
                <label for="Name" class="control-label">微信名称: </label>
                <div class="input-group mr_2">
                    <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                    <input name="weixin_name" id="weixinName" class="form-control mr_1" placeholder="请输入微信名称       "
                           value="{!! $search_arr['weixin_name'] !!}"/>
                </div>


            </div>
            <div class="clearfix mt_2"></div>
            <div class="form-group">

                <label for="contributionTitle" class="control-label">行业分类: </label>
                <div class="input-group  mr_2">

                    <select name="weixin_category" class="form-control mr_2" id="weixin_category">
                        <option value="all">请选择</option>
                        @foreach($category as $k=>$v)
                            <option value="{!! $k !!}">{!! $v !!}</option>
                        @endforeach
                    </select>
                </div>
                <label for="" class="control-label">负责人: </label>
                <div class="input-group  mr_2">
                    <select name="leader" class="form-control mr_2" id="leader">
                        <option value="all">请选择</option>
                        @foreach($leader as $lk=>$lv)
                            <option value="{!! $lk !!}">{!! $lv !!}</option>
                        @endforeach
                    </select>
                </div>


                <label class="mt_1 mr_2">
                    <button type="button" class="btn btn-primary" id="search"><i class="fa  fa-search"></i>搜索</button>
                </label>
                &nbsp;&nbsp;
                <label class="mt_1">
                    <a href="/admin/weixin/create" class="btn  btn-success">
                        <i class="fa fa-save"></i>&nbsp;&nbsp;新增
                    </a>
                </label>
                &nbsp;&nbsp;
                <!--
                   <label  class="mt_1">
                      <button type="button" class="btn btn-warning"  id="export"><i class="fa  fa-download"></i>导出</button>
                   </label>
                   -->
            </div>
        </form>
    </div>


    <!-- /.box-header -->
    <div class="box-body ">
        <table id="example1" class="table table-bordered table-hover display nowrap">
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

                    <td>{!! $row['weixin_ts'] !!}</td>
                    <td>{!! $row['weixin_name'] !!}</td>
                    <td>
                        @if(key_exists($row['weixin_category'],$category))
                            {!! $category[$row['weixin_category']] !!}
                        @endif
                    </td>
                    <td>{!! $row['ID'] !!}</td>
                    <td>{!! $row['fans'] !!}</td>
                    <td>{!! $row['headline'] !!}</td>
                    <td>{!! $row['secondline'] !!}</td>
                    <td>{!! $row['thirdline'] !!}</td>
                    <td>{!! $row['readers'] !!}</td>
                    <td>
                        <?php
                        $link = preg_match('/^http(s)?:\\/\\/.+/', $row['cases']) ? $row['cases'] : 'http://' . $row['cases'];
                        echo '<a href="' . $link . '" target="_blank">查看</a>';
                        ?>
                    </td>

                    <td>
                        @if(key_exists($row['leader'],$leader))
                            {!! $leader[$row['leader']] !!}
                        @endif
                    </td>
                    <td>{!! $row['remark'] !!}</td>
                    <td>
                        <a href="{!! url('/admin/weixin/'.$row['weixin_id'].'/edit') !!}"><i class="fa fa-edit"></i></a>

                        <a href="javascript:void(0);" class="grid-row-delete"
                           onClick="rowdelete('{!! $row['weixin_id'] !!}')"> <i class="fa fa-trash"></i></a>

                    </td>
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
    function LA() {
    }

    LA.token = "{{ csrf_token() }}";
</script>
<script type="text/javascript">
    $(function () {
        var category = "{!! $search_arr['weixin_category'] !!}";
        if(category != ''){
            $('#weixin_category').val(category);
        }

        var leader = "{!! $search_arr['leader'] !!}";
        if(leader != ''){
            $('#leader').val(leader);
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


        //开始时间
        var start_ts = "{!! $search_arr['start_day'] !!}";
        if (start_ts == "") {
            var lastday = "2000-01-01";
            $("#datepicker_start").val(lastday);
            $("#datepicker_start").datepicker("update", lastday);
        }else{
            $("#datepicker_start").val(start_ts);
            $("#datepicker_start").datepicker("update", start_ts);
        }

        //结束时间
        var end_ts = "{!! $search_arr['end_day'] !!}";
        if (end_ts == "") {
            $("#datepicker_end").val(nowtime);
            $("#datepicker_end").datepicker("update", nowtime);
        }else{
            $("#datepicker_end").val(end_ts);
            $("#datepicker_end").datepicker("update", end_ts);
        }
        //搜索提交
        $("#search").on('click', function () {

            $("#weixin_search").submit();

        });

        //导出
        $("#export").on('click', function () {

            window.open('/admin/weixin/?%5C_pjax=%23pjax-container&_export_=all');
        });

    });

    //datatables
    $(function () {

        $('#example1').DataTable({
            'dom': 'lBtip',
            buttons: {
                buttons: [
                    {
                        extend: 'excel',
                        className: 'excelbutton dt-button btn btn-warning',
                        'text': 'Excel导出',
                        'title': '微信列表',
                        exportOptions: {
                            format: {
                                body: function (data, row, column ) {
                                    var dt = data;
                                    if (column ==9)
                                    {
                                        var dt = httpString(dt);
                                    }
                                    if (column ==12)
                                    {
                                        var dt = '';
                                    }
                                    return dt;
                                }
                            }
                        }
                    }
                ]
            },
            "scrollX": true,
            'paging': true,
            'lengthChange': true,
            'searching': false,
            'ordering': true,
            'info': true,
            'autoWidth': false,
            "columnDefs": [{
                "targets": [6, 10],
                "orderable": false
            }],
            "language": {
                "sProcessing": "处理中...",
                "sLengthMenu": "显示 _MENU_ 项结果",
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


            }

        });
    });

    //-->

    function rowdelete(id) {


        var id = id;

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
                    url: '/admin/weixin/destory',
                    data: {
                        weixin_id: id,
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