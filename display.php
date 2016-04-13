<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Highcharts Example</title>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
        <script type="text/javascript">
        $(document).ready(function() {
            var options = {
                chart: {
                    renderTo: 'container',
                    type: 'column',
                    marginRight: 130,
                    marginBottom: 25
                },
                // title: {
                //     text: 'Revenue vs. Overhead',
                //     x: -20 //center
                // },
                // subtitle: {
                //     text: '',
                //     x: -20
                // },
                xAxis: {
                    categories: []
                },
                 yAxis: {
                     min: 0,
                     title: {
                        text: 'Count'
                    }
                },
                // yAxis: {
                //     title: {
                //         text: 'Amount'
                //     },
                //     plotLines: [{
                //         value: 0,
                //         width: 1,
                //         color: '#808080'
                //     }]
                // },
                // tooltip: {
                //     formatter: function() {
                //             return '<b>'+ this.series.name +'</b><br/>'+
                //             this.x +': '+ this.y;
                //     }
                // },
                // legend: {
                //     layout: 'vertical',
                //     align: 'right',
                //     verticalAlign: 'top',
                //     x: -10,
                //     y: 100,
                //     borderWidth: 0
                // },
               // series: []
                   series:[{
                   name: "Complaint Count",
                   data: []
                  }]
            }
            
            $.getJSON("charts.php", function(json) {
                // options.xAxis.categories = json[0];//['Bylaw Neighbourhood'];
                // options.yAxis.categories = json[1];//['Bylaw Neighbourhood'];
                // options.series[0] = json[0];
                // options.series[1] = json[1];
                    yData = options.series[0].data; //Array to store data for y column
                    xData = options.xAxis.categories; //Array to store data for x column

                    xDataObj = json[0];
                    yDataObj = json[1];

                    for(var key in xDataObj){
                        xData.push(xDataObj[key]);
                    }

                    for(var key in yDataObj){
                        yData.push(parseFloat(yDataObj[key]));
                    }
                chart = new Highcharts.Chart(options);
            });
        });
        </script>
        <script src="http://code.highcharts.com/highcharts.js"></script>
        <script src="http://code.highcharts.com/modules/exporting.js"></script>
    </head>
    <body>
        <div id="container" style="min-width: 400px; height: 400px; margin: 0 auto"></div>
    </body>
</html>