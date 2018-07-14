<div style="width:90%;height:97%">
		<canvas id="myChart"></canvas>
	</div>
<script>

$(function () {
   var ctx = document.getElementById("myChart").getContext('2d');
   var myChart = new Chart(ctx, {
       type: 'line',
       data: {
           labels: ["星期一", "星期二", "星期三", "星期四", "星期五", "星期六","星期日"],
           datasets: [{
               label: '利润波动图',
               data: [21999, 19000, 30000, 35000, 41000, 30000,29000],
              
               borderWidth: 1
           }]
       },
       options: {
           scales: {
               yAxes: [{
                   ticks: {
                       beginAtZero:true
                   }
               }]
           }
       }
   }); 
});
</script>