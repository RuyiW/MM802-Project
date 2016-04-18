<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Highcharts Example</title>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
        <script type="text/javascript">
        var charts;
        $(document).ready(function() {
            var options = {
                //Properties of the chart
                chart: {
                    renderTo: 'container',
                    type: 'column',
                },
                //Add title to the chart
                title: {
                    text: 'Neighbourhood vs. Request Count',
                    x: -20 //center
                },
                //The X axis or category axis
                xAxis: {
                     title: {
                        text: 'Neighbourhood'
                    },
                    categories: []
                },
                //The Y axis or value axis
                 yAxis: {
                    
                     title: {
                        text: 'Request Count'
                    },
                //An array of objects representing plot lines on the X axis
                     plotLines: [{
                        value: 0,
                        width: 1,
                        color: '#808080'
                    }],
                   
                },
                //Add color to each column
                   plotOptions: {
                    series: {
                        colorByPoint: true
                    }
                },
               // Options for the tooltip that appears when the user hovers over a series or point.
                tooltip: {
                    formatter: function() {
                            return '<b>'+ this.series.name +'</b><br/>'+
                            this.x +': '+ this.y;
                    }
                },
                 // The legend is a box containing a symbol and name for each series item or point item in the chart. 
               // Each series (or points in case of pie charts) is represented by a symbol and its name in the legend.
                legend: {
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'top',
                    x: -10,
                    y: 100,
                    borderWidth: 0
                },
               // series: []
                // The actual series to append to the chart.
                   series:[
                  {
                    name: "Count",
                   data: []
                  }]
            }
            //Get the json file
            $.getJSON("charts1.php", function(json) {
                
                    yData1 = options.series[0].data; //Array to store data for y column
                    xData = options.xAxis.categories; //Array to store data for x column
                    //Names of neighbourhood
                    xDataObj = json[0];
                   //request Count for each neighbourhood
                    yDataObj1 = json[1];
                    //Push the data present in xDataObj to xData
                    for(var key in xDataObj){
                         xData.push(xDataObj[key]);
                    }
                    
                    //Push the data present in yDataObj to yData
                    for(var key in yDataObj1){
                        yData1.push(parseFloat(yDataObj1[key]));
                    }
                //Function to create charts
                chart = new Highcharts.Chart(options);
            });
        });
        //Libraries to create high charts, container where the chart will be drawn
        </script>
        <script src="http://code.highcharts.com/highcharts.js"></script>
        <script src="http://code.highcharts.com/modules/exporting.js"></script>
    </head>
    <body>
        <div id="container" style="min-width: 400px; height: 400px; margin: 0 auto"></div>
    </body>
</html>