/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// This script creats highcharts and display it while clicking corresponding tabs
// Charts creating function is a copy of display.php, display1.php, display2.php, display3.php, piechart.php and piechart1.php
// in "charts" folder
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$(document).ready(function(){
    NvsR_bar();
    $("#chart_1").click(function(){
        NvsR_bar();
    });
    $("#chart_1_bar").click(function(){
        NvsR_bar();
    });
    $("#chart_1_pie").click(function(){
        NvsR_pie();
    });
    $("#chart_2").click(function(){
        NvsC_bar();
    });
    $("#chart_2_bar").click(function(){
        NvsC_bar();
    });
    $("#chart_2_pie").click(function(){
        NvsC_pie();
    });
    $("#chart_3").click(function(){
        NvsS_bar();
    });
    $("#chart_4").click(function(){
        NvsG_bar();
    });
    chart.reflow();
});
function NvsR_bar(){
    var charts;

    var options = {
        chart: {
            renderTo: 'for_chart1',
            type: 'column', 
            //marginRight: 130,
            //marginBottom: 25
        },
        title: {
            text: 'Neighbourhood vs. Request Count',
            x: -20 //center
        },
        // subtitle: {
        //     text: '',
        //     x: -20
        // },
        xAxis: {
             title: {
                text: 'Neighbourhood'
            },
            categories: []
        },
         yAxis: {
            
             title: {
                text: 'Request Count'
            },
             plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }],
           // categories:[]
        },
           plotOptions: {
            series: {
                colorByPoint: true
            }
        },

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
           series:[
          {
            name: "Count",
           data: []
          }]
    }

    $.getJSON("charts1.php", function(json) {
        // options.xAxis.categories = json[0];//['Bylaw Neighbourhood'];
        // options.yAxis.categories = json[1];//['Bylaw Neighbourhood'];
        // options.series[0] = json[0];
        // options.series[1] = json[1];
           // yData = options.yAxis.categories; //Array to store data for y column
            yData1 = options.series[0].data;
            xData = options.xAxis.categories; //Array to store data for x column

            xDataObj = json[0];
           // yDataObj = json[1];
            yDataObj1 = json[1];

            for(var key in xDataObj){
                 xData.push(xDataObj[key]);
            }
            
            // for(var key in yDataObj){
            //     yData.push((yDataObj[key]));
            // }
            for(var key in yDataObj1){
                yData1.push(parseFloat(yDataObj1[key]));
            }
        chart = new Highcharts.Chart(options);
    });
}

function NvsR_pie() {
    var charts;
    var options = {
        chart: {
            renderTo: 'for_chart2',
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
            //marginRight: 130,
            //marginBottom: 25
        },
        title: {
            text: ' Neighbourhood vs. Request Count',
            x: -30, //center
             style: {
                color: '#FF00FF',
                fontWeight: 'bold'
            }
        },
        subtitle: {
            text: 'Pie Chart for Request',
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
                text: 'Request Count'
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
           name: "Request Count",
           data: []
          }]
    }

    $.getJSON("charts1.php", function(json) {
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
}

function NvsC_bar() {
    var charts;
    var options = {
        chart: {
            renderTo: 'for_chart3',
            type: 'column',
            //marginRight: 130,
            //marginBottom: 25
        },
        title: {
            text: 'Neighbourhood vs. Complaint Count',
            x: -20 //center
        },
        // subtitle: {
        //     text: '',
        //     x: -20
        // },
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
}

function NvsC_pie() {
    var charts;
    var options = {
        chart: {
            renderTo: 'for_chart4',
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
}

function NvsS_bar() {
    var charts;
    var options = {
        chart: {
            renderTo: 'for_chart5',
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
}

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
}