/*---------------------------------------------------------------------------
  % Win ratio donut chart
---------------------------------------------------------------------------*/
/*google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawWinRatioChart);

function drawWinRatioChart() {

  var data = google.visualization.arrayToDataTable([
    ['Effort', 'Amount given'],
    ['Winners', 56],
    ['Losers', 8],
  ]);

  var options = {
    //Title and text
    title : '% Win Ratio',
    titleTextStyle: { color: 'grey',  fontSize: 12 },
    legend: 'none',
    pieSliceText: 'none',
    //Donut
    pieHole: 0.7,
    pieStartAngle: 180,
    colors:['green','red'],
    //colors:['red','#004411']
    //Chart
    chartArea:{left:25,right:25,top:30, width:'100%',height:'100%'}
  };

  var chart = new google.visualization.PieChart(document.getElementById('winratiochart'));
  chart.draw(data, options);
}*/

//https://developers.google.com/chart/interactive/docs/php_example

// Load the Visualization API and the piechart package.
google.charts.load('current', {'packages':['corechart']});
// Set a callback to run when the Google Visualization API is loaded.
google.charts.setOnLoadCallback(drawChart);
  
function drawChart() {
  var jsonData = $.ajax({
      url: "./charts/data_win-ratio.php.php",
      dataType: "json",
      async: false
      }).responseText;
  
  var options = {
    //Title and text
    title : '% Win Ratio',
    titleTextStyle: { color: 'grey',  fontSize: 12 },
    legend: 'none',
    pieSliceText: 'none',
    //Donut
    pieHole: 0.7,
    pieStartAngle: 180,
    colors:['green','red'],
    //colors:['red','#004411']
    //Chart
    chartArea:{left:25,right:25,top:30, width:'100%',height:'100%'}
  };

  // Create our data table out of JSON data loaded from server.
  var data = new google.visualization.DataTable(jsonData);

  // Instantiate and draw our chart, passing in some options.
  var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
  chart.draw(data, options);
}

/*---------------------------------------------------------------------------
  Long vs short donut chart
---------------------------------------------------------------------------*/
google.charts.setOnLoadCallback(drawLongShortChart);

function drawLongShortChart() {

  var data = google.visualization.arrayToDataTable([
    ['Long', 'Short'],
    ['Long', 31],
    ['Short', 13],
    ['Long Losses', 3],
    ['Short', 13],
    ['Short Losses', 2]
  ]);

  var options = {
    //Title and text
    title : 'Long vs Short',
    titleTextStyle: { color: 'grey',  fontSize: 12 },
    legend: 'none',
    pieSliceText: 'none',
    //Donut
    pieHole: 0.7,
    pieStartAngle: 180,
    colors:['#1a8cff','lightblue','#ff884d','#ffbb99'],
    //Chart
    chartArea:{left:25,right:25,top:30, width:'100%',height:'100%'}
  };

  var chart = new google.visualization.PieChart(document.getElementById('longshortchart'));
  chart.draw(data, options);
}
