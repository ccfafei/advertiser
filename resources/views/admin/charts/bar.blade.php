<div style="width:90%;height:97%">
		<canvas id="myChart"></canvas>
	</div>
<script>

$(function () {
   var ctx = document.getElementById("myChart").getContext('2d');
   var myChart = new Chart(ctx, {
       type: 'line',
       data: {
           labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
           datasets: [{
               label: '# of Votes',
               data: [12, 19, 3, 5, 2, 3],
              
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