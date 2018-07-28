<style>
	canvas {
		-moz-user-select: none;
		-webkit-user-select: none;
		-ms-user-select: none;
	}
</style>
<div class="box">
	<div class="box-header">
		<H4 class="mt_1">待办事项</h4>

		<!-- Info boxes -->
		<div class="row ">
        
			<div class="col-md-3 col-sm-6 col-xs-12">
				<div class="info-box">
					<span class="info-box-icon bg-aqua"><i class="fa fa-flag-o"></i></span>

					<div class="info-box-content">
						<span class="info-box-text"><a
							href="{!! url('/admin/trade/check') !!}">待审核</a></span> <span
							class="info-box-number">{!! $notices['no_check'] !!}<small>个</small></span>
					</div>
					<!-- /.info-box-content -->
				</div>
				<!-- /.info-box -->
			</div>
			<!-- /.col -->
			<div class="col-md-3 col-sm-6 col-xs-12">
				<div class="info-box">
					<span class="info-box-icon bg-red"><i class="fa fa-cc-visa"></i></span>

					<div class="info-box-content">
						<span class="info-box-text"><a
							href="{!! url('/admin/report/receive') !!}">待回款</a></span> <span
							class="info-box-number">{!! $notices['no_received'] !!}元</span>
					</div>
					<!-- /.info-box-content -->
				</div>
				<!-- /.info-box -->
			</div>
			<!-- /.col -->

			<!-- fix for small devices only -->
			<div class="clearfix visible-sm-block"></div>

			<div class="col-md-3 col-sm-6 col-xs-12">
				<div class="info-box">
					<span class="info-box-icon bg-green"><i
						class="fa fa-circle-o-notch"></i></span>

					<div class="info-box-content">
						<span class="info-box-text"><a
							href="{!! url('/admin/report/paid') !!}">待出款</a></span> <span
							class="info-box-number">{!! $notices['no_paid'] !!}元</span>
					</div>
					<!-- /.info-box-content -->
				</div>
				<!-- /.info-box -->
			</div>
			<!-- /.col -->

		</div>
		<!-- /.row -->

   <div class="col-md-10">
		<!-- LINE CHART -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">10天业绩波动图</h3>

            </div>
            <div class="box-body">
              <div class="chart">
                <canvas id="canvas" style="heigth:250px;width:90%"></canvas>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
    </div>
    </div>
    </div>
<div>
</div>
<script>
var str ='{!! $items !!}';
console.log(str);
var json = JSON.parse(str);
console.log(json);

var data = {
	    labels: json.day,
	    datasets: [
	        {
	        	label: "报价",
	        	backgroundColor: "rgb(255, 99, 132)",
				borderColor: "rgb(255, 99, 132)",
				fill: false,	            
	            data: json.customer_price
	        },
	        {
	        	label:"媒体价",
	        	backgroundColor: "rgb(54, 162, 235)",
				borderColor: "rgb(54, 162, 235)",
				fill: false,	            
	            data: json.media_price
	        },
	        {
	        	label:"利润",
	        	backgroundColor: "rgb(255, 205, 86)",
				borderColor: "rgb(255, 205, 86)",
				fill: false,	            
	            data: json.profit
	        }
	    ]
	}

	$(function () {
		var ctx = document.getElementById("canvas").getContext("2d");
		var myChart = new Chart(ctx, {
			type: 'line',
		    data: data,
			options: {
				responsive: true,
				title: {
					display: true,
					text: '波动图'
				},
				scales: {
					xAxes: [{
						display: true,
					}],
					yAxes: [{
						display: true,
						ticks: {
                            beginAtZero: true,
                            steps: 100,
                            stepValue: 50,
                            max: 1000
                        }
					}]
				}
			}
		});
	});
   
</script>