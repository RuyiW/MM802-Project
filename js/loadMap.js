
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// On the Map page, this file is executed after the user chooses what they want (the filter options) viewed on the //
// map and tables.                                                                                                 //
// The two tables that this script reads are "submitted_checked_311" and "submitted_checked_bylaw"                 //
// On the map there are markers that represents the requests (from "submitted_checked_311") and have red regions   //
// represent the complaints (from "submitted_checked_bylaw")                                                       //
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

var markers = []; // array of the markers

// Initialize the Google Map, using Google's API
function initMap() {
        var mapDiv = document.getElementById('map');    // Get the HTML div with id "map" to display the map.
        
        // Centre the map at Edmonton. 
        var map = new google.maps.Map(mapDiv, {
                center: {lat: 53.5466707, lng: -113.5196069},
                zoom: 11
        });
        
        // Load the the Neighbourhood Boundaries
        map.data.loadGeoJson('./dataset/City of Edmonton - Neighbourhood Boundaries (Map View).geojson');
        
        //var wardName;
        
        // When the map is idle read the "submitted_checked_bylaw" table to color the regions red
        google.maps.event.addListenerOnce( map, 'idle', function() {
                readBylaw(map);
        });
        
        // Place all markers on the map
        loadMyData('Do not filter', false);
        
        
        // For creating a bubble window that pops up whenever the user hovers over a neighbourhoood region, displaying its name.
        // Currently not using it. 
        var bubbleWin = new google.maps.InfoWindow();
        
        
        // Color each neighbourhood black. Change the color to blue when the isHighlighted property
        // is set to true.
        // And the red regions will stay red. 
        map.data.setStyle(function(feature) {
          var color = 'black';
          var stroke = 2;
          //readBylaw(map); // BAD 
          if (feature.getProperty('isHighlighted')) {
                color = 'blue';
                //stroke = 8;
          }
          if (feature.getProperty('bylawShow')) {
                color = 'red';
                stroke = 5;
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
      
        // The icon used for Snow and Ice Maintenance
        var snowflake = {
                url: './img/snowflake.ico', // url
                scaledSize: new google.maps.Size(50, 50), // scaled size
                //origin: new google.maps.Point(0,0),
                anchor: new google.maps.Point(32,32)
        };
        
        // The icon used for Vandalism and Graffiti
        var G = {
                url: './img/g.png', // url
                scaledSize: new google.maps.Size(50, 50), // scaled size
                //origin: new google.maps.Point(0,0),
                anchor: new google.maps.Point(32,32)
        };
        
        // Set the neighbourhoods red based on the "submitted_checked_bylaw" table. 
        //map.data.addListener('setProperty', function(event) {
        //        if (event.feature.getProperty('bylawShow')) {
        //                console.log('overriding style');
        //                map.data.Style(event.feature, {fillColor: 'red', strokeColor: 'red', strokeWeight: 5});
        //        }
        //        
        //});
        
        // When the user clicks, set 'isHighlighted' to true, changing the color of the region to blue.
        // If the region is red it will stay red, but it will be outlined. 
        map.data.addListener('click', function(event) {
                
                // Set all regions "isHighlighted" property to false, so no region is in blue or outlined (if the region is red).
                map.data.forEach(function(features) {
                        features.setProperty('isHighlighted', false);
                });
                
                // Set the clicked region's property 'isHighlighted' property to true, making it blue. or outlined (if the region is red).
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
        
        // The dataset from the CSV file (exported the table "submitted_checked_311")
        var dataset;
        
        // After the data is loaded, show the markers for the dataset
        // Parameter: dataset -> the dataset we use to get the longtitude and latitude to place a marker on the map. 
        function myDataLoaded(dataset) {
            
            // Create the markers and add them to the 'markers' array
            // Also check which type of service category they are.
            // If the service category is 1 set the snowflake icon (mentioned earlier - line 74)
            // If the service category is 2 set the G icon (mentioned earlier - line 82)
            for( i = 0; i < dataset.length; i++ ) {
                if (dataset[i][2] == 1){
                        marker = new google.maps.Marker({
                                position: {lat: dataset[i][0], lng: dataset[i][1]},
                                map: map,
                                icon: snowflake
                        });
                }
                
                if (dataset[i][2] == 2){
                        //console.log(dataset[i][0]);
                        //console.log(dataset[i][1])
                        marker = new google.maps.Marker({
                                position: {lat: dataset[i][0], lng: dataset[i][1]},
                                map: map,
                                icon: G
                        });
                }
                markers.push(marker);	
            }
            
            // Place the markers on the map.
            showAllMarkers(map);
        }
        
        // Show all the markers in the 'markers' array
        // Parameter: map -> the map to place the markers on. 
        function showAllMarkers(map) {
                //console.log(markers.length);
                for (var i = 0; i < markers.length; i++) {
                        markers[i].setMap(map);
                }
        }
        
        // Remove markers, resetting the 'markers' to an empty array.  
        function removeMarkers() {
            showAllMarkers(null);
            markers = [];
        }
        
        
        // Loading the data, filter the data, to return markers only in that region, or show all markers
        // Parameter: keyWord -> the name of the Neighbourhood to find in our dataset. 
        // Parameter: doFilter -> If region is selected (True) filter the dataset, if a region is not selected
        //                        (false) get the whole dataset from the server's database table. 
        function loadMyData(keyWord, doFilter) {
            
            var filterData;
            
            // When a neighbourhood is selected
            if (doFilter) {
                
                // Export the table "submitted_checked_311" from the server's database to a CSV file.
                d3.csv("./dataset/exportTable.php", function(data) {
                        
                        // Look for the neighbourhood's name that matches with the keyword and returns only those rows where a match is found.
                        dataFilter = data.filter(function(d) {
                            //console.log("first");
                                if (d["311_neighbourhood"].toLowerCase() == keyWord.toLowerCase()) {
                                    //console.log("second");
                                    //return [ +d["Lat"], +d["Long"] ];
                                    return d;
                                }
                        });
                        
                        // After filtering, for each row return only the columns with "311_latitude", "311_longtitude", and "service_category"
                        filterData = dataFilter.map(function(d) { return [ +d["311_latitude"], +d["311_longtitude"], +d["service_category"] ]; });
                        //console.log(filterData);
                        
                        // Remove any existing markers
                        removeMarkers();
                        
                        // Load the new filterDataset into the markers array. 
                        myDataLoaded(filterData);
                });
            }
            else {
                // Region is not selected, so display all markers
                d3.csv("./dataset/exportTable.php", function(data) {
                        dataset = data.map(function(d) { return [ +d["311_latitude"], +d["311_longtitude"], +d["service_category"] ]; });
                        removeMarkers();
                        myDataLoaded(dataset);
                });
                
            }
        }
        
        // Export the table "submitted_checked_bylaw" from the server's database to a CSV file.
        // Setting all matched neighbourhoods' property "bylawShow" to true so the regions will be colored red.
        // Parameter: map -> the map to change the black regions to red. 
        function readBylaw(map) {
                
                d3.csv("./dataset/exportTableSubmittedBylaw.php", function(data) {
                        bylawFilter = data.map(function(d) {return d;});
                        //console.log(bylawFilter[0]["bylaw_neighbourhood"]);
                        //var count = 0;
                        bylawFilter.forEach(function(row) {
                                //console.log(row);
                                bylawName = row["bylaw_neighbourhood"].toLowerCase();
                                //console.log(bylawName);
                                //console.log(map.data);
                                //console.log(map.data.getProperty('name'));
                                map.data.forEach(function(region) {
                                        //console.log(region);
                                        //console.log("SEARCHING MAP");
                                        neighbourName = region.getProperty('name').toLowerCase();
                                        //console.log(neighbourName);
                                        if (bylawName == neighbourName) {
                                                //count = count + 1;
                                                //console.log("match!");
                                                //console.log(bylawName);
                                                //console.log(neighbourName);
                                                region.setProperty('bylawShow',true);
                                                //console.log(region.getProperty('bylawShow'));
                                                //map.data.revertStyle();
                                        }
                                        //return bylawName === neighbourName;
                                        
                                });
                                
                        
                        });

                });  
        }
                
}

