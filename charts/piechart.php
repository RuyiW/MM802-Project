<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Highcharts Example</title>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
        <script type="text/javascript">
        var charts;
        $(document).ready(function() {
            //Properties of the chart
            var options = {
                chart: {
                    renderTo: 'container',
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie'
                    
                },
                //Add title to the chart
                title: {
                    text: ' Neighbourhood vs. Complaint Count',
                    x: -30, //center
                     style: {
                        color: '#FF00FF',
                        fontWeight: 'bold'
                    }
                },
               //Add subtitle to the chart
                subtitle: {
                    text: 'Pie Chart for Complaints',
                    x: -20,
                      style: {
                        color: '#FF0011',
                        fontWeight: 'bold'
                    }
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
                        text: 'Complaint Count'
                    },
                    
                },
                tooltip: {
                    //The HTML of the point's line in the tooltip.
                    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                },
                plotOptions: {
                    pie: {
                        //Allow this series' points to be selected by clicking on the markers, bars or pie slices
                        allowPointSelect: true,
                        //Set the cursor to "pointer" if you have click events attached to the series, to signal to the user that the points and lines can be clicked.
                        cursor: 'pointer',
                        dataLabels: {
                            //Enable or disable the data labels
                            enabled: true,
                            //A format string for the data label. Available variables are the same as for formatter. Defaults to {y}
                            format: '<b>{point.name}</b>',
                           // Styles for the label
                            style: {
                                color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                            }
                        }
                    }
                },
                       // series: []
                       // The actual series to append to the chart.
                   series:[{
                   name: "Complaint Count",
                   data: []
                  }]
            }
            
            $.getJSON("charts.php", function(json) {
                
                    dataArrayFinal = options.series[0].data;//Array to store data for y column
                    xData = options.xAxis.categories; //Array to store data for x column
                   //Names of neighbourhood
                    xDataObj = json[0];
                    //complaint Count for each neighbourhood
                    yDataObj = json[1];
                    //length of xDataObj which contains neighbourhood names
                    length = xDataObj.length;
                    //Create an empty array
                    var name = Array();
                    var data = Array();
                    //Copy the data in name and data array
                    for(i=0;i<length;i++) { 
                    name[i] = xDataObj[i]; 
                    data[i] = yDataObj[i];  
                    }
                    for(j=0;j<length;j++) { 
                    //Create new temp array and add name and data to that 
                     var temp = new Array(name[j],data[j]); 
                    dataArrayFinal[j] = temp;     
                    }
                   //Push the neighbourhood names in the xdata array
                    for(var key in xDataObj){
                         xData.push(xDataObj[key]);
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