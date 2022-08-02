anychart.onDocumentReady(function () {

// create a data set on our data
var dataSet = anychart.data.set(getData());

// map data for the first series,
// take x from the zero column and value from the first column
var firstSeriesData = dataSet.mapAs({ x: 0, value: 1 });

// map data for the second series,
// take x from the zero column and value from the second column
var secondSeriesData = dataSet.mapAs({ x: 0, value: 2 });

// map data for the third series,
// take x from the zero column and value from the third column 
//var thirdSeriesData = dataSet.mapAs({ x: 0, value: 3 });

// map data for the fourth series,
// take x from the zero column and value from the fourth column
//var fourthSeriesData = dataSet.mapAs({ x: 0, value: 4 });

// create a line chart
var chart = anychart.line();

// turn on the line chart animation
chart.animation(true);

// configure the chart title text settings
chart.title('Yearly P/L');

// set the y axis title
chart.yAxis().title('$P/L');

// turn on the crosshair
chart.crosshair().enabled(true).yLabel(false).yStroke(null);

// create the first series with the mapped data
var firstSeries = chart.spline(firstSeriesData);
firstSeries
    .name('Account')
    .stroke('2 #a8d9f6')
    .tooltip()
    .format("Account : ${%value}");

// create the second series with the mapped data
var secondSeries = chart.spline(secondSeriesData);
secondSeries
    .name('Trailing Threshold')
    .stroke('2 #f49595')
    .tooltip()
    .format("Threshold : ${%value}");

/*// create the third series with the mapped data
var thirdSeries = chart.spline(thirdSeriesData);
thirdSeries
    .name('35-49')
    .stroke('3 #f9eb97')
    .tooltip()
    .format("Age group 35-49 : {%value}%");*/


/*// create the fourth series with the mapped data
var fourthSeries = chart.line(fourthSeriesData);
fourthSeries
    .name('65+')
    .stroke('3 #e2bbfd')
    .tooltip()
    .format("Age group 65+ : {%value}%");*/

// turn the legend on
chart.legend().enabled(true);

// set the container id for the line chart
chart.container('grid-item-top');

// draw the line chart
chart.draw();

});

function getData() {
    return [
    ['Jan',50000,47500],
    ['Feb',51500,49000],
    ['Mar',54000,51000],
    ['Apr',59000,51000],
    ['May',59500,51000],
    ['Jun',64200,51000],
    ['Jul',66000,51000],
    ['Aug',63800,51000],
    ['Sep',66000,51000],
    ['Nov',69500,51000],
    ['Dec',72630,51000],
];
}
