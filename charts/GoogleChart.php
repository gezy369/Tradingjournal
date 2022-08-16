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
        
        
    /*---------------------------------------------------------------------------
      P&L top line chart
    ---------------------------------------------------------------------------*/
    google.charts.setOnLoadCallback(drawPLtopChart);

    function drawPLtopChart() {
      var data = google.visualization.arrayToDataTable([
        ['Months',    'Balance', 'Threshold'],
        ['January',   50000,      47500],
        ['February',  52000,      47700],
        ['March',     51000,      47700],
        ['April',     55000,      48000],
        ['May',       58000,      48000],
        ['June',      59500,      48000],
        ['July',      57850,      48000],
        ['August',    58000,      48000],
        ['September', 60000,      48000],
        ['October',   59800,      48000],
        ['November',  62000,      48000],
        ['December',  62350,      48000],
      ]);

      var options = {
        title: 'Account Balance',
        curveType: 'function',
        legend: { position: 'top' },
        //animation: {startup: 'true', duration: 1000},
        crosshair: { trigger: 'both', orientation: 'vertical', color: 'grey' },
        tooltip: {trigger: 'both'}
      };

      var chart = new google.visualization.LineChart(document.getElementById('pltopchart'));

      chart.draw(data, options);
    }
    </script>
    
</html>
