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
                chart: {
                    renderTo: 'container',
                    type: 'column',
                    //marginRight: 130,
                    //marginBottom: 25
                },
                title: {
                    text: 'Neighbourhood vs Snow and Ice Sidewalk Maintenance',
                    x: -20,//center
                      style: {
                        color: '#FF0011',
                        fontWeight: 'bold'
                    }
                },
                subtitle: {
                    text: 'Average time in days to close the request',
                    x: -20,
                     style: {
                        color: '#FF00FF',
                        fontWeight: 'bold'
                    }
                },
                xAxis: {
                     title: {
                        text: 'Neighbourhood'
                    },
                    categories: []
                },
                 yAxis: {
                    
                     title: {
                        text: 'Average days'
                    },
                     plotLines: [{
                        value: 0,
                        width: 1,
                        color: '#808080'
                    }]
                },
                  plotOptions: {
                    series: {
                        colorByPoint: true
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
                tooltip: {
                    formatter: function() {
                            return '<b>'+ this.series.name +'</b><br/>'+
                            this.x +': '+ this.y;
                    }
                },
                legend: {
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'top',
                    x: -10,
                    y: 100,
                    borderWidth: 0
                },
               // series: []
                   series:[{
                   name: "Average days",
                   data: []
                  }]
            }
            
            $.getJSON("chart3.php", function(json) {
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