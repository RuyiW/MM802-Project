d3.csv("./dataset/exportTable.php", function(data) {
  var datasetCsv;
    csv = data.map(function(d) { return d; });
    //csv = data.filter(function(d) {
    //    
    //    if(d["Request Status"] == "Open")
    //    {
    //
    //         return d;
    //    }
    //    
    //});

// for displaying everything in the row with informatioin
function infoBox(csv) {
    var rowsInfo = [];
    var tableInfo = [];
    var testTable = document.getElementsByClassName("tableBody");
    tableInfo = d3.select("body").select("tbody.tableBody").selectAll("tr");
    rowsInfo = d3.select("body").select("tbody.tableBody").selectAll("tr").data();
    //console.log(testTable[0]);
    //console.log(tableInfo[0]);
    //console.log(rowsInfo);
    
    for (i = 0; i < rowsInfo.length; i++) {
       newRow = rowsInfo[i];
       var index = i + 1;
       var row = testTable[0].insertRow(index + i);
       row.setAttribute("class", "accordion-content");
       var cell = row.insertCell(0);
       cell.setAttribute("colspan", "3");
       //cell.setAttribute("color", "purple");
       //if (i == 0) {
       // cell.setAttribute("class", "accordion-content default");
       //}
       //else {
       //}
       //cell.innerHTML = JSON.stringify(newRow); // PUT WHOLE STRING INTO CELL
       var infoString = [];
       infoString = JSON.stringify(newRow);
       infoString = infoString.replace(/["]/g, '');
       infoString = infoString.replace('{', '');
       infoString = infoString.replace('}', '');
       cell.innerHTML = infoString.split(',').join("<br>");
       //console.log("INFOSTRING");
       //console.log(infoString);
       //console.log(newRow);
    }
    
}   
   
// The table generation function
function tabulate(csv, columns) {
    var table = d3.select("body").select("#detail").append("table")
            .attr("id", "accordion")
            .attr("style", "width: 100%");
        thead = table.append("thead"),
        tbody = table.append("tbody");
        tbody.attr("class", "tableBody");
        //console.log(table);
    
    // append the header row
    thead.append("tr")
        .selectAll("th")
        .data(columns)
        .enter()
        .append("th")
         .attr("id","tablerow")
            .text(function(column) { return column; });

    // create a row for each object in the data
    var rows = tbody.selectAll("tr")
        .data(csv)
        .enter()
        .append("tr")
        .attr("class", "accordion-toggle")

    // create a cell in each row for each column
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
        .attr("id", "results")
            .html(function(d) { return d.value; });
            
            
    return table;
}

// render the table
 var peopleTable = tabulate(csv, ["ticket_number", "311_request_status", "service_category" ]);
 infoBox(csv); // add the row with all the information

 datasetCsv = csv;
 var val;
 var your_variable;

 // for displaying in the alert box NOT USING AT THE MOMENT
function displayContent(val){
  
  showPopup(val);
  //console.log(val);
 // d3.text(datasetCsv, function(datasetText){
    csv1 = datasetCsv.filter(function(d) {
        
        if(d["ticket_number"] == val)
        {

             return d["ticket_number"]==val;
        }
        
    });
    your_variable = csv1;
    //console.log(your_variable);
    

}

// alert box NOT USING ATM
    function showPopup(your_variable){
       //console.log("I am in pop up");
        //$("#popup").dialog({
        //    width: 500,
        //    //height: 300,
        //    //width: 'auto',
        //    height: 'auto',
            //open: function(){
                //whatIsThis = $(your_variable[0]).html(your_variable["Ticket Number"]);

                
                var acc = [];
                //var accNew = [];
                $.each(your_variable, function(index, value) {
                  acc.push(index + ': ' + value);
                });
                var accNew = JSON.stringify(acc);
                console.log("ACC STRING");
                console.log(accNew);
                //alert(accNew.split(',').join("\r\n"));
                //var peopleTable = tabulate(csv1, ["Ticket Number", "Request Status" ,"Service Details", "Neighbourhood", "Address"]);
                //whatIsThis = $(this).html(accNew.split(',').join("<br>"));
                //console.log("What IS THIS?");
                //console.log(whatIsThis);
                //whatIsThis = $(this).html(peopleTable[0]);
                //console.log(peopleTable[0]);

                //return your_variable;
            //}
        //});
    }
 $(document).ready(function(){
    //var init_height;
        // var table = $('#example').DataTable();
    //$(".accordion tr:not(.accordion-toggle)").hide();
    //$(".accordion tr:first-child").show();
    //$("#detail").height(($("#accordion").height()+80));
    
    $('#accordion').find('.accordion-toggle').click(function() {     
          
          // for parsing        
         // var colIndex = parseInt($(this).parent().children().index($(this)));
         // var rowIndex = parseInt($(this).parent().parent().children().index($(this).parent()));
         // // var texto = $('table tr:nth-child(2) td:nth-child(1)').text()
         //var rowContent = [];
         //rowContent = datasetCsv[rowIndex];
         //console.log(rowContent);
         //val = rowContent["ticket_number"];
          
          
          //Hide the other panels
        $(".accordion-content").not($(this).next()).slideUp('fast'); // other accordian


         
        $(this).next().slideDown('slow'); // other accordian
        // $("#detail").height(($("#accordion").height()+80));
        
        $(this).closest("tr").siblings().removeClass("highlighted");
        $(this).toggleClass("highlighted");
        
        //console.log("ROWCONTENT");
      
        //console.log(rowContent);
        //displayContent(rowContent);
         
    });
  });

});