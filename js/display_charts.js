/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// This script creats highcharts and display it while clicking corresponding tabs
// Charts creating function is a copy of display.php, display1.php, display2.php, display3.php, piechart.php and piechart1.php
// in "charts" folder
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$(document).ready(function(){
    Math.easeOutBounce = function (pos) {
        if ((pos) < (1 / 2.75)) {
            return (7.5625 * pos * pos);
        }
        if (pos < (2 / 2.75)) {
            return (7.5625 * (pos -= (1.5 / 2.75)) * pos + 0.75);
        }
        if (pos < (2.5 / 2.75)) {
            return (7.5625 * (pos -= (2.25 / 2.75)) * pos + 0.9375);
        }
        return (7.5625 * (pos -= (2.625 / 2.75)) * pos + 0.984375);
    };
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
        //Properties of the chart
        chart: {
            renderTo: 'for_chart1',
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
                colorByPoint: true,
                animation: {
                    duration: 2000,
                    easing: 'easeOutBounce'
                }
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
}

function NvsR_pie() {
    var charts;
    //Properties of the chart
    var options = {
        chart: {
            renderTo: 'for_chart2',
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
            
        },
         //Add title to the chart
        title: {
            text: ' Neighbourhood vs. Request Count',
            x: -30, //center
             style: {
                color: '#FF00FF',
                fontWeight: 'bold'
            }
        },
         //Add subtitle to the chart
        subtitle: {
            text: 'Pie Chart for Request',
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
                text: 'Request Count'
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
           series:[{
           name: "Request Count",
           data: []
          }]
    }
    
    $.getJSON("charts1.php", function(json) {
         
            dataArrayFinal = options.series[0].data; //Array to store data for y column
            xData = options.xAxis.categories; //Array to store data for x column
            //Names of neighbourhood
            xDataObj = json[0];
            //request Count for each neighbourhood
            yDataObj = json[1];
            //length of xDataObj which contains neighbourhood name
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
}

function NvsC_bar() {
    var charts;
    //Properties of the chart
    var options = {
        chart: {
            renderTo: 'for_chart3',
            //Type of chart i.e column
            type: 'column',
            
        },
        //Add title to the chart
        title: {
            text: 'Neighbourhood vs. Complaint Count',
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
                text: 'Complaint Count'
            },
        // An array of objects representing plot lines on the X axis
             plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        //Add color to each column
          plotOptions: {
            series: {
                colorByPoint: true,
                animation: {
                    duration: 2000,
                    easing: 'easeOutBounce'
                }

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
           series:[{
           name: "Complaint Count",
           data: []
          }]
    }
    //Get the json file
    $.getJSON("charts.php", function(json) {
            
            yData = options.series[0].data; //Array to store data for y column
            xData = options.xAxis.categories; //Array to store data for x column
           //Names of neighbourhood
            xDataObj = json[0];
            //Complaint Count for each neighbourhood
            yDataObj = json[1];
            //Push the data present in xDataObj to xData
            for(var key in xDataObj){
                 xData.push(xDataObj[key]);
            }
            //Push the data present in yDataObj to yData
            for(var key in yDataObj){
                yData.push(parseFloat(yDataObj[key]));
            }
         //Function to create charts
        chart = new Highcharts.Chart(options);
    });
}

function NvsC_pie() {
    var charts;
    //Properties of the chart
    var options = {
        chart: {
            renderTo: 'for_chart4',
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
}

function NvsS_bar() {
    var charts;
    //Properties of the chart
    var options = {
        chart: {
            renderTo: 'for_chart5',
            type: 'column',
            
        },
        //Add title to the chart
        title: {
            text: 'Neighbourhood vs Snow and Ice Sidewalk Maintenance',
            x: -20,//center
              style: {
                color: '#FF0011',
                fontWeight: 'bold'
            }
        },
        //Add subtitle to the chart
        subtitle: {
            text: 'Average time in days to close the request',
            x: -20,
             style: {
                color: '#FF00FF',
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
                text: 'Average days'
            },
             //An array of objects representing plot lines on the X axis
             plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        //Add color to each column
          plotOptions: {
            series: {
                colorByPoint: true,
                animation: {
                    duration: 2000,
                    easing: 'easeOutBounce'
                }

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
           series:[{
           name: "Average days",
           data: []
          }]
    }
      //Get the json file
    $.getJSON("chart3.php", function(json) {
        
            yData = options.series[0].data; //Array to store data for y column
            xData = options.xAxis.categories; //Array to store data for x column
            //Names of neighbourhood
            xDataObj = json[0];
            //Graffiti and vandalism request and average time count required to close the request for each neighbourhood
            yDataObj = json[1];
            //Push the data present in xDataObj to xData
            for(var key in xDataObj){
                 xData.push(xDataObj[key]);
            }
            //Push the data present in yDataObj to yData
            for(var key in yDataObj){
                yData.push(parseFloat(yDataObj[key]));
            }
            //Function to create charts
        chart = new Highcharts.Chart(options);
    });
}

function NvsG_bar() {
    var charts;
    //Properties of the chart
    var options = {
        chart: {
            renderTo: 'for_chart6',
            type: 'column',
            
        },
        //Add title to the chart
        title: {
            text: 'Neighbourhood Graffiti and Vandalism Requests',
            x: -20,//center
              style: {
                color: '#FF0011',
                fontWeight: 'bold'
            }
        },
        //Add subtitle to the chart
        subtitle: {
            text: 'Average time in days to close the request',
            x: -20,
             style: {
                color: '#FF00FF',
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
                text: 'Average days'
            },
             //An array of objects representing plot lines on the X axis
             plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
         //Add color to each column
          plotOptions: {
            series: {
                colorByPoint: true,
                animation: {
                    duration: 2000,
                    easing: 'easeOutBounce'
                }

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
           series:[{
           name: "Average days",
           data: []
          }]
    }
      //Get the json file
    $.getJSON("chart2.php", function(json) {
        
            yData = options.series[0].data; //Array to store data for y column
            xData = options.xAxis.categories; //Array to store data for x column
            //Names of neighbourhood
            xDataObj = json[0];
            //Graffiti and vandalism request and average time count required to close the request for each neighbourhood
            yDataObj = json[1];
            //Push the data present in xDataObj to xData
            for(var key in xDataObj){
                 xData.push(xDataObj[key]);
            }
            //Push the data present in yDataObj to yData
            for(var key in yDataObj){
                yData.push(parseFloat(yDataObj[key]));
            }
        //Function to create charts
        chart = new Highcharts.Chart(options);
    });
}