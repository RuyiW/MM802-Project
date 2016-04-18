
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// On the Algorithm page, this file is executed after the user inputs the desired K value in one of the 3 sections //
// (By Days, By Distance, or By Neigbourhood). It places markers on the map by getting the latitude and lontitude  //
// information from one of the 3 tables ("match_resultdays", "match_resultdistance", and                           //
// "match_resultNeighbourhood"). In addition to placing markers, it also gives the frequeney of that marker,       //
// which is the frequency count of that ticket number from the table.                                              //
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



var markers = [];       // Array of the markers (which are the requests from the table)
var countDataset = [];  // The total number of complaints that the requests mactched in the corresponding markers array,
                        // or the frequecny count of that corresponding marker.

// Initialize the Google Map, using Google's API
function initMap() {
        var mapDiv = document.getElementById('algorithm_map');  // Get the HTML div with id "algorithm_map" to display the map.
        
        // Centre the map at Edmonton. 
        var map = new google.maps.Map(mapDiv, {
                center: {lat: 53.5466707, lng: -113.5196069},
                zoom: 10
        });
        
        // Load the the Neighbourhood Boundaries
        map.data.loadGeoJson('./dataset/City of Edmonton - Neighbourhood Boundaries (Map View).geojson');
        
        // Place all markers on the map
        loadMyData('Do not filter', false);
        
        // For creating a bubble window that pops up whenever the user hovers over a neighbourhoood region, displaying its name.
        // Currently not using it. 
        var bubbleWin = new google.maps.InfoWindow();
        
        // Color each neighbourhood black. Change the color to blue when the isHighlighted property
        // is set to true.
        map.data.setStyle(function(feature) {
          var color = 'black';
          var stroke = 2;
          if (feature.getProperty('isHighlighted')) {
                color = 'blue';
                //stroke = 8;
          }

          if (feature.getProperty('hover')) {
                stroke = 8;
          }
          if (feature.getProperty('hover') != true) {
                stroke = 2;
                if (feature.getProperty('isHighlighted')) {
                        //color = 'blue';
                        stroke = 8;
                }
          }
          return ({
                fillColor: color,
                strokeColor: color,
                strokeWeight: stroke    
          });
        });
      
        
        // When the user clicks, set 'isHighlighted' to true, changing the color of the region to blue.
        map.data.addListener('click', function(event) {
                
                // Set all regions "isHighlighted" property to false, so no region is in blue.
                map.data.forEach(function(features) {
                        features.setProperty('isHighlighted', false);
                });
                
                // Set the clicked region's property 'isHighlighted' property to true, making it blue.
                event.feature.setProperty('isHighlighted', true);
                
                // Get the Neighbourhood's name to display the bubble window (currently not using)
                neighbourName = event.feature.getProperty('name');
                
                // Only show the markers in the selected region
                loadMyData(neighbourName, true);
                
        });
        
        // When the user clicks outside the regions, reset the map to initial view
        map.addListener('click', function(event) {
               
                // Make sure all the regions are not highlighted
                map.data.forEach(function(features) {
                        features.setProperty('isHighlighted', false);
                });
                
                // Load all the markers again
                loadMyData('Do not filter', false);
                
                // Close the bubble window (currently not using)
                bubbleWin.close();
                
        });
        
        
        // If the mouse hovers over the region, setProperty "hover" to true, so the region will be outlined
        map.data.addListener('mouseover', function(event) {
                event.feature.setProperty('hover', true);
                neighbourName = event.feature.getProperty('name');
               
                // the bubble window will display the region name that the mouse is hovering over
                // Currently not in use
                bubbleWin.setPosition(event.latLng);
                bubbleWin.setContent(neighbourName);
                
                // Uncomment the line below to show the bubble window when hovering over the neighbourhoods. 
                //bubbleWin.open(map);
        });
      
        // If not hovering over a region do not outline the boudary.
        map.data.addListener('mouseout', function(event) {
                event.feature.setProperty('hover', false);
        });
        
        
        // The dataset from the CSV file
        // One of the 3 tables ("match_resultdays", "match_resultdistance", and "match_resultNeighbourhood")
        var dataset;
        
        
        // After the data is loaded, show the markers for the dataset
        // Parameter: data -> the dataset we use to get the longtitude and latitude to place a marker on the map. 
        function myDataLoaded(data) {
            
            // Frequency count of the Ticket number in the dataset
            var total;
            
            // If a region is selected the data would only contain the markers in the selected region.
            // So give the frequency count for the markers in the selected region.
            // Or else get the frequency count of all Ticket Numbers in the dataset. 
            if (data.length != dataset.length) {
                //console.log("filter length is not the same");
                //console.log(data.length);
                //console.log(dataset.length);
                
                for (count = 0; count < data.length; count++) {
                        //console.log("counting in here");
                        total = 0;
                        for (count2 = 0; count2 < dataset.length; count2++) {
                                if (data[count][2] == dataset[count2][3]) {
                                        //console.log("MATCHED");
                                        total++;
                                }   
                        }
                        //console.log(total);
                        countDataset.push(total);     
                }
                
            }
            else {
                for (count = 0; count < data.length; count++) {
                        //console.log("counting in here");
                        total = 1;
                        for (count2 = 0; count2 < data.length; count2++) {
                                if (count != count2) {
                                        if (data[count][3] == data[count2][3]) {
                                           //console.log("MATCHED");
                                          total++;
                                        }   
                                }
                        }
                        //console.log(total);
                        countDataset.push(total);     
                }
                
            }
            
            console.log(countDataset);
            
            // Create the markers and add them to the 'markers' array
            for( i = 0; i < data.length; i++ ) {
                var marker = new MarkerWithLabel({
                        position: {lat: data[i][0], lng: data[i][1]},
                        labelContent: countDataset[i].toString(),
                        labelAnchor: new google.maps.Point(22, 0),
                        labelClass: "labels", // the CSS class for the label
                        labelStyle: {opacity: 0.75},
                        map: map
                        //icon: icon
                });
                markers.push(marker);	
            }
            
            // Place the markers on the map.
            showAllMarkers(map);
        }
        
        
        // Show all the markers in the 'markers' array
        // Parameter: map -> the map to place the markers on. 
        function showAllMarkers(map) {
                console.log("NUMBER OF MARKERS");
                console.log(markers.length);
                for (var i = 0; i < markers.length; i++) {
                        markers[i].setMap(map);
                }
        }
        
        // Remove markers, resetting the 'markers' array and 'countDataset' to empty arrays.  
        function removeMarkers() {
            showAllMarkers(null);
            markers = [];
            countDataset = [];
        }
        
        // Loading the data, filter the data, to return markers only in that region, or show all markers
        // Parameter: keyWord -> the name of the Neighbourhood to find in our dataset. 
        // Parameter: doFilter -> If region is selected (True) filter the dataset, if a region is not selected
        //                        (false) get the whole dataset from the server's database table. 
        function loadMyData(keyWord, doFilter) {
                
            var filterData;

            // When a neighbourhood is selected
            if (doFilter) {
                
                // Export the table "311_explorer" from the server's database to a CSV file.
                d3.csv("./dataset/export311.php", function(data) {
                        
                        // Look for the neighbourhood's name that matches with the keyword. Then checks if the ticket number matches with the datase
                        // (which is one of the 3 tables mentioned earlier) and returns only those rows where a match is found.
                        dataFilter = data.filter(function(d) {
                            //console.log("first");
                                if (d["311_neighbourhood"].toLowerCase() == keyWord.toLowerCase()) {
                                    //console.log("second");
                                    for (j = 0; j<dataset.length; j++) {
                                        if (d["ticket_number"] == dataset[j][3]) {
                                            return d;
                                        }
                                        
                                    }
                                    
                                }
                        });
                        
                        // After filtering, for each row return only the columns with "311_latitude", "311_longtitude", and "ticket_number"
                        filterData = dataFilter.map(function(d) { return [ +d["311_latitude"], +d["311_longtitude"], +d["ticket_number"] ]; });
                        //console.log(filterData);
                        removeMarkers();                // Remove any existing markers
                        console.log(filterData);
                        //google.maps.event.trigger(map, 'resize');
                        myDataLoaded(filterData);       // Load the new filterDataset into the markers array. 
                });
            }
            else {
                // Region is not selected, so display all markers
                // One of the 3 table mentioned earlier are exported to a CSV file for the script to read
                d3.csv("./dataset/exportAlgorithmTable.php", function(data) {
                        dataset = data.map(function(d) { return [ +d["311_latitude"], +d["311_longtitude"], +d["complaint_number"], +d["matched_ticket_number"] ]; });
                        removeMarkers();
                        console.log(dataset);
                        myDataLoaded(dataset);
                });
                
            }
        }
               
}

