function NvsG_bar() {
    var charts;
    var options = {
        chart: {
            renderTo: 'for_chart6',
            type: 'column',
            //marginRight: 130,
            //marginBottom: 25
        },
        title: {
            text: 'Neighbourhood vs Graffiti and Vandalism Requests',
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
    
    $.getJSON("chart2.php", function(json) {
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