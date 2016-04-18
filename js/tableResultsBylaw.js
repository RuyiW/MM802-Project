
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// On the Map page, this file is executed after the user chooses what they want (the filter options) viewed on the //
// map and tables.                                                                                                 //
// The table that this script reads is "submitted_checked_bylaw" This script displays the                          //
// "submitted_checked_bylaw" table from the server's database for the user to see their results based on their     //
// filtered options                                                                                                //
//                                                                                                                 //
// The table first only show the information with attributes "complaint_number", "report_period", "bylaw_status",  //
// and "complaint". If the user clicks on a row then more information on that row will open up underneath.         //                                                                                            //
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


// Export the table "submitted_checked_bylaw" from the server's database to a CSV file.
d3.csv("./dataset/exportTableSubmittedBylaw.php", function(data) {
  var datasetCsv;
    csv = data.map(function(d) { return d; });


// For displaying everything in the row with informatioin
// Parameter: csv -> is the "submitted_checked_bylaw" table
function infoBox(csv) {
    var rowsInfo = [];
    var tableInfo = [];
    var testTable = document.getElementsByClassName("tableBody2");
    tableInfo = d3.select("body").select("tbody.tableBody2").selectAll("tr");
    rowsInfo = d3.select("body").select("tbody.tableBody2").selectAll("tr").data();
    
    // In the table create a new row that contains all the content related to the above row.
    // Assign the new row to the class "accordion-content", so that it would only be displayed when the user clicks on
    // the above row. 
    for (i = 0; i < rowsInfo.length; i++) {
       newRow = rowsInfo[i];
       var index = i + 1;
       var row = testTable[0].insertRow(index + i);
       row.setAttribute("class", "accordion-content");
       var cell = row.insertCell(0);
       cell.setAttribute("colspan", "4");
        
       // Turns the content into string and then remove unwanted characters, before inserting into the HTML table. 
       var infoString = [];
       infoString = JSON.stringify(newRow);
       infoString = infoString.replace(/["]/g, '');
       infoString = infoString.replace('{', '');
       infoString = infoString.replace('}', '');
       infoString = infoString.replace(/[_]/g, ' ');
       infoString = infoString.replace(/[:]/g, ' : ');
       infoString = infoString.replace(/(bylaw)/g, '');
       cell.innerHTML = infoString.split(',').join("<br>");

    }
    
}   
   
// Generate the table for "submitted_checked_bylaw"
// Parameter: csv -> is the "submitted_checked_bylaw" table
// Parameter: columns -> an array of columns we want to initially display on the table
function tabulate(csv, columns) {
    
    // Create the HTML table
    var table = d3.select("body").select("#detail2").append("table")
            .attr("id", "accordion2")
            .attr("style", "width: 100%");
        thead = table.append("thead"),
        tbody = table.append("tbody");
        tbody.attr("class", "tableBody2");

    // Create the Header for the table -> the columns we want to display
    thead.append("tr")
        .selectAll("th")
        .data(columns)
        .enter()
        .append("th")
         .attr("id","tablerow2")
            .text(function(column) { return column.replace(/[_]/g, ' '); });

    // Create a row for each object in the data and assign it the class "accordion-toggle", which is for
    // deciding if extra information will be displayed or not. 
    var rows = tbody.selectAll("tr")
        .data(csv)
        .enter()
        .append("tr")
        .attr("class", "accordion-toggle")

    // Create a cell in each row for each column
    var cells = rows.selectAll("td")
        .data(function(row) {
            return columns.map(function(column) {
                return {column: column, value: row[column]};
            });
        })
        .enter()
        .append("td")
        .attr("style", "font-family: Courier") // sets the font style
        .attr("style", "fill: blue") // sets the font style
        .attr("class", "DatasetTable")
        .attr("id", "results2")
            .html(function(d) { return d.value; });
            
            
    return table;
}

// Render the table
tabulate(csv, ["complaint_number", "report_period", "bylaw_status", "complaint" ]);
infoBox(csv); // add the row with all the information


// Shows extra information for the row the user clicks on, and hides all other rows' extra information. 
 $(document).ready(function(){
    
    $('#accordion2').find('.accordion-toggle').click(function() {     
          
        //Hide the other panels
        $(".accordion-content").not($(this).next()).slideUp('fast'); // other accordian


        // Show the exta information for the selected row. 
        $(this).next().slideDown('slow'); 
        
        // Highlight the selected row and unhighlight the other rows.
        $(this).closest("tr").siblings().removeClass("highlighted");
        $(this).toggleClass("highlighted");
         
    });
  });

});