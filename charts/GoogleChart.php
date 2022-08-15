<html>
    <script>
      /*---------------------------------------------------------------------------
        % Win ratio donut chart
      ---------------------------------------------------------------------------*/
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawWinRatioChart);

      function drawWinRatioChart() {

        var data = google.visualization.arrayToDataTable([  
          ['Winners', 'Loosers'],  
          <?php  
          $i = 0;
          while($i < 2)
          {
              echo "['".$labels[$i]."', ".$result[$i]."],";
              $i++;
          }
          ?>  
        ]);

        var options = {
          //Title and text
          title : '% Win Ratio',
          titleTextStyle: { color: 'grey',  fontSize: 12 },
          legend: 'none',
          pieSliceText: 'none',
          //Donut
          pieHole: 0.6,
          pieStartAngle: 180,
          colors:['green','red'],
          //colors:['red','#004411']
          //Chart
          chartArea:{left:25,right:25,top:30, width:'100%',height:'100%'}
        };

        var chart = new google.visualization.PieChart(document.getElementById('winratiochart'));
        chart.draw(data, options);
      }
    
    /*---------------------------------------------------------------------------
      Long vs short donut chart
    ---------------------------------------------------------------------------*/
    google.charts.setOnLoadCallback(drawLongShortChart);

    function drawLongShortChart() {

      var data = google.visualization.arrayToDataTable([  
          ['Long', 'Short'],  
          <?php  
          $i = 0;
          while($i < 2)
          {
              echo "['".$labels_ls[$i]."', ".$result_ls[$i]."],";
              $i++;
          }
          ?>  
        ]);

      var options = {
        //Title and text
        title : 'Long vs Short',
        titleTextStyle: { color: 'grey',  fontSize: 12 },
        legend: 'none',
        pieSliceText: 'none',
        //Donut
        pieHole: 0.6,
        pieStartAngle: 180,
        colors:['#1a8cff','#ff884d','#ffbb99'],
        //Chart
        chartArea:{left:25,right:25,top:30, width:'100%',height:'100%'}
      };

      var chart = new google.visualization.PieChart(document.getElementById('longshortchart'));
      chart.draw(data, options);
    }
    </script>
</html>