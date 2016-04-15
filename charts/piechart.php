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
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie'
                    //marginRight: 130,
                    //marginBottom: 25
                },
                title: {
                    text: ' Neighbourhood vs. Complaint Count',
                    x: -30, //center
                     style: {
                        color: '#FF00FF',
                        fontWeight: 'bold'
                    }
                },
                subtitle: {
                    text: 'Pie Chart for Complaints',
                    x: -20,
                      style: {
                        color: '#FF0011',
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
                        text: 'Complaint Count'
                    },
                     //plotLines: [{
                    //     value: 0,
                    //     width: 1,
                    //     color: '#808080'
                    // }]
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</b>',
                            style: {
                                color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                            }
                        }
                    }
                },
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
                   // yData = options.series[0].data; //Array to store data for y column
                    dataArrayFinal = options.series[0].data;
                    xData = options.xAxis.categories; //Array to store data for x column

                    xDataObj = json[0];
                    yDataObj = json[1];
                    length = xDataObj.length;
                    var name = Array();
                    var data = Array();
                    //console.log(length);
                    for(i=0;i<length;i++) { 
                    name[i] = xDataObj[i]; 
                    data[i] = yDataObj[i];  
                    }
                    for(j=0;j<length;j++) { 
                     var temp = new Array(name[j],data[j]); 
                    dataArrayFinal[j] = temp;     
                    }

                    for(var key in xDataObj){
                         xData.push(xDataObj[key]);
                    }
                    
                    // for(var key in yDataObj){
                    //     yData.push(parseFloat(yDataObj[key]));
                    // }
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