anychart.onDocumentReady(function () {
    
    var $nbroftrades = 7;
    
    
    //DB query
    con.connect(function(err) {
        if (err) throw err;
        con.query("SELECT * FROM trades", function (err, result, fields) {
        if (err) throw err;
        console.log(result);
        });
    });

    //count all the points > 0 and where contrat > 0
    //count all the points < 0 and where contrat > 0

    //calculate the P/L
    for (var $i = 1; $i <= $nbroftrades; $i++) {
        
        if ($_POST['main_pts0'.$i] > 0) {

            //Calculate P&L per green trade
            $tradePL = abs($_POST['main_cnt0'.$i]) * ($_POST['main_pts0'.$i] * $benefitPerPoint);
            $gain = $gain + $tradePL;
            $pos_main ++;

        }elseif ($_POST['main_pts0'.$i] <= 0 AND $_POST['main_cnt0'.$i] != 0) {
            
            //Calculate P&L per red trade. Had to test contract to be able to to 0 points into account
            $tradePL = abs($_POST['main_cnt0'.$i]) * ($_POST['main_pts0'.$i] * $benefitPerPoint);
            $loss = $loss + $tradePL;
            $neg_main ++;
        }

        //Increment total contracts for fee calculation
        $total_contracts = $total_contracts + abs($_POST['main_cnt0'.$i]);


    }


    





    // define sample data
    var data = [
    { name: 'Win', value: 122, group: 'win' },
    { name: 'Loss', value: 18, group: 'loss' }
    ];

    // pre process data points, to define indexes groups and set color from palette
    var groupsPalette = ['#A1F89A', '#FFA28E'];
    var dataPointsCount = data.length;
    var groupsMap = {};
    var groupsIndex = 0;
    var explodedGroupName;

    for (var i = 0; i < dataPointsCount; i++) {
    var point = data[i];
    var groupName = point.group;
    var group = groupsMap[groupName];

    if (!group) {
        group = {};
        group.index = groupsIndex;
        group.sum = 0;
        group.palette = anychart.palettes.distinctColors(
        anychart.color.singleHueProgression(
            groupsPalette[groupsIndex],
            dataPointsCount
        )
        );
        group.lastPointIndex = -1;
        group.indexes = [];
        groupsMap[groupName] = group;
        groupsIndex++;
    }
    group.lastPointIndex++;
    group.sum += point.value;
    var groupPalette = group.palette;
    var lastPointIndex = group.lastPointIndex;
    var groupIndexes = group.indexes;
    groupIndexes.push(i);

    point.fill = groupPalette.itemAt(lastPointIndex);
    point.stroke = groupPalette.itemAt(lastPointIndex);
    }

    // create pie chart with passed data
    var chart = anychart.pie(data);

    // set chart title text settings
    chart
    .title('Win vs Loss')
    .interactivity('single')
    // disable chart legend
    .legend(false)
    // set chart radius
    .radius('48%')
    .labels(false)
    // create empty area in pie chart
    .innerRadius('78%');

    createChartLabel(chart, 0, 'right-top', 'win');
    createChartLabel(chart, 1, 'left-top', 'loss');

    // set container id for the chart
    chart.container('grid-item-menu-2');
    // initiate chart drawing
    chart.draw();

    chart.listen('pointMouseOver', function (evt) {
    var pointIndex = evt.pointIndex;
    var groupName = chart.data().get(pointIndex, 'group');
    var group = groupsMap[groupName];
    var groupIndexes = group.indexes;

    chart.unhover();
    chart.hover(groupIndexes);
    });

    chart.listen('pointMouseOut', function () {
    chart.unhover();
    });

    function createChartLabel(chart, index, anchor, groupName) {
    var label = chart.label(index);
    label
        .position('center')
        .anchor(anchor)
        .offsetY(-10)
        .offsetX(10)
        .hAlign('center')
        .useHtml(true)
        .text(
        '<span style="font-size: 25px; color: ">' +
        groupsMap[groupName].sum +
        '</span><br><span style="font-size: 9px; font-weight: bold">' +
        groupName.toUpperCase() +
        '</span>'
        );

    label.listen('mouseOver', function () {
        document.body.style.cursor = 'pointer';
        var group = groupsMap[groupName];
        var groupIndexes = group.indexes;

        chart.unhover();
        chart.hover(groupIndexes);
    });

    label.listen('mouseOut', function () {
        document.body.style.cursor = '';
        chart.unhover();
    });

    label.listen('mouseDown', function () {
        var group = groupsMap[groupName];

        if (explodedGroupName === groupName) {
        chart.unselect();
        explodedGroupName = '';
        } else {
        var groupIndexes = group.indexes;
        explodedGroupName = groupName;
        chart.select(false);
        chart.select(groupIndexes, true);
        }
    });
    }
});
