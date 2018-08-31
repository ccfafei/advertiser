<style>
    .dataTables_wrapper .dataTables_length{
        display:inline-block;
        float:left;
        margin-bottom: 5px;
    }
    .dataTables_wrapper .dt-button {
        display:inline-block;
        float:right;
    }
</style>
<div class="box">
    <div class="box-header">
        <form action="{{ url('/admin/media/index')}}" method="post" id="media_search" class="form-inline">
            <div class="form-group">
                <label>开发日期: </label>
                <div class="input-group date">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control mr_1" id="datepicker_start" name="start_day" value="{!! $search_arr['start_day'] !!}">
                </div>

                <label>~ </label>
                <div class="input-group date mr_1">
                    <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control" id="datepicker_end" name="end_day" value="{!! $search_arr['end_day'] !!}">
                </div>


                <label for="mediaName" class="control-label">媒体名称: </label>
                <div class="input-group mr_2">
                    <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                    <input name="media_name" id="mediaName" class="form-control mr_1" placeholder="请输入媒体名称       "
                           value="{!! $search_arr['media_name'] !!}"/>
                </div>
                <label for="contributionTitle" class="control-label">媒体分类: </label>
                <div class="input-group  mr_2">

                    <select name="category" class="form-control mr_2" id="category">
                        <option value="all">请选择</option>
                        @foreach($category as $k=>$v)
                            <option value="{!! $k !!}">{!! $v !!}</option>
                        @endforeach
                    </select>
                </div>


            </div>
            <div class="clearfix mt_2"></div>
            <div class="form-group">

                <label for="" class="control-label">频道: </label>
                <div class="input-group  mr_2">
                    <select name="channel" class="form-control mr_2"  id="channel">
                        <option value="all">请选择</option>
                        @foreach($channel as $ck=>$cv)
                            <option value="{!! $ck !!}">{!! $cv !!}</option>
                        @endforeach
                    </select>
                </div>

                <label for="" class="control-label">负责人: </label>
                <div class="input-group  mr_2">
                    <select name="leader" class="form-control mr_2"  id="leader">
                        <option value="all">请选择</option>
                        @foreach($leader as $lk=>$lv)
                            <option value="{!! $lk !!}">{!! $lv !!}</option>
                        @endforeach
                    </select>
                </div>
                <label class="control-label">区域: </label>
                <div class="input-group mr_2">
                    <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                    <input name="area" id="mediaArea" class="form-control mr_1" placeholder="请输入区域" value="{!! $search_arr['area'] !!}"/>
                </div>
                <label for="" class="control-label">收录: </label>
                <div class="input-group mr_2">
                    <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                    <input name="collection" id="collection" class="form-control mr_1" placeholder="请输入收录" value="{!! $search_arr['collection'] !!}"/>
                </div>
            </div>
            <div class="clearfix mt_2"></div>
            <div class="form-group">
                <label class="mt_1">
                    <button type="button" class="btn btn-primary" id="search"><i class="fa  fa-search"></i>搜索</button>
                </label>
                &nbsp;&nbsp;
                <label class="mt_1">
                    <button type="reset" class="btn btn-warning"><i class="fa  fa-undo">重置</i></button>
                </label>
                &nbsp;&nbsp;
             <label class="mt_1">
                 <a href="/admin/media/create" class="btn  btn-success">
                     <i class="fa fa-save"></i>&nbsp;&nbsp;新增
                 </a>
             </label>
             &nbsp;&nbsp;
                <!--
                             <label class="mt_1">
                                 <button type="button" class="btn btn-warning excel-export" id="export"><i class="fa  fa-download"></i>导出</button>
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

                    <td>{!! $row['media_ts'] !!}</td>
                    <td>{!! $row['area'] !!}</td>
                    <td>{!! $row['media_name'] !!}</td>
                    <td>
                        <?php
                        if (!empty($row['category']) && !empty($category)) {
                            $category_name = array_key_exists($row['category'], $category) ? $category[$row['category']] : null;
                            echo $category_name;
                        } else {
                        }?>
                    </td>
                    <td>
                        <?php
                        if (!empty($row['channel']) && !empty($channel)) {
                            $channel_name = array_key_exists($row['channel'], $channel) ? $channel[$row['channel']] : null;
                            echo $channel_name;
                        }?>
                    </td>
                    <td>{!! $row['price'] !!}</td>
                    <td>{!! $row['collection'] !!}</td>
                    <td>
                        <?php
                        $link = preg_match('/^http(s)?:\\/\\/.+/', $row['cases']) ? $row['cases'] : 'http://' . $row['cases'];
                        echo '<a href="' . $link . '" target="_blank">查看</a>';
                        ?>
                    </td>
                    <td>
                        <?php if (!empty($row['leader']) && !empty($leader)) {
                            $leader_name = array_key_exists($row['leader'], $leader) ? $leader[$row['leader']] : null;
                            echo $leader_name;
                        }?>
                    </td>
                    <td>{!! trim($row['remark']) !!}</td>
                    <td>
                        <a href="{!! url('/admin/media/'.$row['media_id'].'/edit') !!}"><i class="fa fa-edit"></i></a>
                        <a href="javascript:void(0);" class="grid-row-delete" onClick="rowdelete('{!! $row['media_id'] !!}')">  <i class="fa fa-trash"></i></a>
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
        var category = "{!! $search_arr['category'] !!}";
        if(category != ''){
            $('#category').val(category);
        }

        var channel = "{!! $search_arr['channel'] !!}";
        if(channel != ''){
            $('#channel').val(channel);
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
        //回款
        $('#isReceived').iCheck({checkboxClass: 'icheckbox_minimal-blue'});
        $('#isPaid').iCheck({checkboxClass: 'icheckbox_minimal-blue'});
        $('#isReceived').on('ifChanged', function (event) {
            if (this.checked) {
                $('#isReceived').val('1');
            } else {
                $('#isReceived').val('0');
            }
        });
        //出款
        $('#isPaid').on('ifChanged', function (event) {
            if (this.checked) {
                $('#isPaid').val('1');
            } else {
                $('#isPaid').val('0');
            }
        });
        //开始时间
        var starttime = $("#datepicker_start").val();
        if (starttime == "") {
            var lastday = getBeforeDate(-30);
            $("#datepicker_start").val(lastday);
            $("#datepicker_start").datepicker("update", lastday);
        }else{
            $("#datepicker_start").datepicker("update", starttime);
        }
        //结束时间
        var endtime = $("#datepicker_end").val();
        if (endtime == "") {
            $("#datepicker_end").val(nowtime);
            $("#datepicker_end").datepicker("update", nowtime);
        }else{
            $("#datepicker_end").datepicker("update", endtime);
        }
        //搜索提交
        $("#search").on('click', function () {
            $("#media_search").submit();
        });
        //导出
        // $("#export").on('click', function () {
        //
        //     window.open("/admin/media/?%5C_pjax=%23pjax-container&_export_=all");
        // });
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
                        'title': '网络媒体列表',
                    }
                ]
            },
            "scrollX": true,
            'paging': true,
            'extend':true,
            'lengthChange': true,
            'searching': false,
            'ordering': true,
            'info': true,
            'autoWidth': true,
            'columnDefs': [{
                "targets": [6, 8],
                "orderable": false
            }],
            'language': {
                "sProcessing": "处理中...",
                "sLengthMenu": "显示 _MENU_ 项结果",
                "sZeroRecords": "没有匹配结果",
                "sInfo": "从 _START_ 至 _END_ ，共 _TOTAL_ 条",
                "sInfoEmpty": "显示第 0 至 0 项结果，共 0 项",
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
    //-->
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
                    url: '/admin/media/destory',
                    data: {
                       media_id: id,
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