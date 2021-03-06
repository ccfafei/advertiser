<style xmlns="http://www.w3.org/1999/html">
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
        <form action="{{ url('/admin/media')}}" method="get" id="media_search" class="form-inline">
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
                    <input id="mediaPageSize" type="hidden" name="pageSize" value="100" />
                </div>
            </div>

        </form>

        <div class="form-group">
            <label class="mt_1">
                <button type="button" class="btn btn-primary" id="search"><i class="fa  fa-search"></i>搜索</button>
            </label>
            <label class="mt_1" style="margin-left: 20px;">
                <button id="addMedia" class="btn  btn-success">
                    <i class="fa fa-save"></i>&nbsp;&nbsp;新增
                </button>
            </label>
        </div>
    </div>
    <div class="box-body ">
        <div class="form-inline">
            <div class="form-group">
                <input type="checkbox" class="grid-select-all ml_l" />&nbsp;
                <button class="btn btn-warning batch_delete ml_1" >删除</button>
            </div>
            <div class="form-group" style="margin-left: 1em;">
                <label class="text-center no-padding no-margin">显示:</label>
                <select id="perPage" class="form-control input-sm" name='perPage' form="perPage">
                    <option {{ $rows->perPage() == 15 ? 'selected': ''}} value="15">15</option>
                    <option {{ $rows->perPage() == 30 ? 'selected': ''}} value="30">30</option>
                    <option {{ $rows->perPage() == 50 ? 'selected': ''}} value="50">50</option>
                    <option  {{ $rows->perPage() == 100 ? 'selected': ''}} value="100">100</option>

                </select>
                <label class="text-center no-padding no-margin">项结果</label>
            </div>
            <div class="form-group" style="float:right">
               <button id="export-excel"  class="btn btn-warning" type="button">
                   <span>Excel导出</span>
               </button>
            </div>
        </div>
    </div>


    <!-- /.box-header -->
    <div class="box-body ">
        <table id="example1" class="table table-bordered table-hover display nowrap">
            <thead>
            <tr>
                <th class="thfirst" width="28">选择</th>
                @foreach($headers as $header)
                    <th>{!!  $header !!} </th>
                @endforeach
            </tr>
            <thead>
            <tbody>
            @foreach($rows as $row)
                <tr>
                    <td><input type="checkbox" class="grid-row-checkbox" data-id="{{$row['media_id']}}"/></td>
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
        {{--采用后台分页，将js分页设置为false --}}
        {{$rows->appends($request_params->all())->render()}}
    </div>
    <div class="box-footer clearfix">

    </div>
    <!-- /.box-body -->
</div>

<script>
    function LA() {
    }
    LA.token = "{{ csrf_token() }}";

    function GetUrlPara()
    {
        var url = document.location.toString();
        var arrUrl = url.split("?");
        var para = arrUrl[1];
        return para;

    }

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

        $('.grid-select-all').iCheck({checkboxClass: 'icheckbox_minimal-blue'});

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
            var per_page = $("#perPage").val();
            $("#mediaPageSize").val(per_page);
            $("#media_search").submit();
        });

        $("#addMedia").on('click', function () {
            window.location.href="{!! url('/admin/media/create')!!}"
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

        //删除
        batchdelte(selectedRows);


        $("#export-excel").on('click', function () {
            var params = "{!! http_build_query($request_params->except('s','pageSize')) !!}"
            var url = "{!! url('/admin/excelmedia/export')!!}";
            var fullUrl = params == ""?url:url+"?"+params;
            console.log(fullUrl)
            window.location.href = fullUrl;
        });


    });
    //datatables
    $(function () {
        $('#example1').DataTable({
            'dom': 'lBtip',
            buttons: {
                buttons: [ ]
            },
            "scrollX": true,
            'paging': false, //后台分页的话为false,前台为true
            'extend':true,
            'lengthChange': true,
            'searching': false,
            'ordering': true,
            'info': false,
            'autoWidth': true,
            'columnDefs': [{
                "targets": [0,7,8, 9],
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
            },
            "fnDrawCallback": function( oSettings ) {
                $(".thfirst").removeClass("sorting_asc");//移除checkbox列的排序箭头
            },
        });
    });
    //-->

    function batchdelte(func){
        $('.batch_delete').on('click', function () {
            ids = func().join();
            rowdelete(ids)
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

{{--分页跳转--}}
<script type="text/javascript">
    $(function(){
        // 每页显示条数
        $('#perPage').change(function(){
            var per_page = $(this).val();
            console.log(per_page);
            $("#mediaPageSize").val(per_page);
            $("#media_search").submit();
        })

    });
</script>
