var markers = []; // array of the markers
var countDataset = [];
function initMap() {
        var mapDiv = document.getElementById('algorithm_map');
        var map = new google.maps.Map(mapDiv, {
                center: {lat: 53.5466707, lng: -113.5196069},
                zoom: 10
        });
        
        // load the the Ward Boundaries
        map.data.loadGeoJson('./dataset/City of Edmonton - Neighbourhood Boundaries (Map View).geojson');
        
    
        
        // place all markers on the map
        loadMyData('Do not filter', false);
        
        
        var bubbleWin = new google.maps.InfoWindow();
        
        // Color each Ward black. Change the color to blue when the isHighlighted property
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
          return /** @type {google.maps.Data.StyleOptions} */({
                fillColor: color,
                strokeColor: color,
                strokeWeight: stroke    
          });
        });
      
        
        //map.data.addListener('setProperty', function(event) {
        //        if (event.feature.getProperty('bylawShow')) {
        //                console.log('overriding style');
        //                map.data.Style(event.feature, {fillColor: 'red', strokeColor: 'red', strokeWeight: 5});
        //        }
        //        
        //});
        
        // When the user clicks, set 'isHighlighted' to true, changing the color of the region.
        map.data.addListener('click', function(event) {
                // make sure all the other regions are not highlighted
                map.data.forEach(function(features) {
                        features.setProperty('isHighlighted', false);
                });
                event.feature.setProperty('isHighlighted', true);
                // get the ward name to display the bubble window
                neighbourName = event.feature.getProperty('name');
                // only show the markers in the selected regions
                loadMyData(neighbourName, true);
                
        });
        
        // when the user clicks outside the regions, reset the map to initial view
        map.addListener('click', function(event) {
                // make sure all the regions are not highlighted
                map.data.forEach(function(features) {
                        features.setProperty('isHighlighted', false);
                });
                // load all the markers again
                loadMyData('Do not filter', false);
                //close the bubble window
                bubbleWin.close();
                
        });
        
        // When the user hovers, outlining the Ward boundaries.
        // if the mouse hovers over the region, setProperty hover to true, so the region will be outlined
        map.data.addListener('mouseover', function(event) {
                event.feature.setProperty('hover', true);
                neighbourName = event.feature.getProperty('name');
                // the bubble window will display the region name that the mouse is hovering over
                bubbleWin.setPosition(event.latLng);
                bubbleWin.setContent(neighbourName);
                //bubbleWin.open(map);
        });
      
        map.data.addListener('mouseout', function(event) {
                event.feature.setProperty('hover', false);
        });
        
        // load the dataset
        var dataset;
        
        
        // after the data is loaded, show the markers for the dataset
        function myDataLoaded(data) {
            //google.maps.event.trigger(map, 'resize');
            //var count = 10;
            var total;
            
            if (data.length != dataset.length) {
                console.log("filter length is not the same");
                console.log(data.length);
                console.log(dataset.length);
                
                for (count = 0; count < data.length; count++) {
                        //console.log("counting in here");
                        total = 0;
                        for (count2 = 0; count2 < dataset.length; count2++) {
                                //if (count != count2) {
                                        if (data[count][2] == dataset[count2][3]) {
                                                //console.log("MATCHED");
                                                total++;
                                        }   
                                //}
                        
                        
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
            showAllMarkers(map);
        }
        
        
        // show all the markers in the markers array
        function showAllMarkers(map) {
                console.log("NUMBER OF MARKERS");
                console.log(markers.length);
                for (var i = 0; i < markers.length; i++) {
                        markers[i].setMap(map);
                }
        }
        
        // remove markers that are not in the region
        function removeMarkers() {
            showAllMarkers(null);
            markers = [];
            countDataset = [];
        }
        
        // loading the data, filter the data, to return markers only in that region, or show all markers
        function loadMyData(keyWord, doFilter) {
            //var dataset;
            var filterData;
            //map.data.loadGeoJson('./dataset/City of Edmonton - Neighbourhood Boundaries (Map View).geojson');
            //readBylaw(map);
            // when a region is selected
            if (doFilter) {
                d3.csv("./dataset/export311.php", function(data) {
                        dataFilter = data.filter(function(d) {
                            console.log("first");
                                if (d["311_neighbourhood"].toLowerCase() == keyWord.toLowerCase()) {
                                    console.log("second");
                                    //return [ +d["Lat"], +d["Long"] ];
                                    for (j = 0; j<dataset.length; j++) {
                                        if (d["ticket_number"] == dataset[j][3]) {
                                            return d;
                                        }
                                        
                                    }
                                    
                                }
                        });
                        filterData = dataFilter.map(function(d) { return [ +d["311_latitude"], +d["311_longtitude"], +d["ticket_number"] ]; });
                        //console.log(filterData);
                        removeMarkers();
                        console.log(filterData);
                        //google.maps.event.trigger(map, 'resize');
                        myDataLoaded(filterData);
                });
            }
            else {
                // region is not selected, so display all markers
                d3.csv("./dataset/exportAlgorithmTable.php", function(data) {
                        dataset = data.map(function(d) { return [ +d["311_latitude"], +d["311_longtitude"], +d["complaint_number"], +d["matched_ticket_number"] ]; });
                        removeMarkers();
                        console.log(dataset);
                        //google.maps.event.trigger(map, 'resize');
                        myDataLoaded(dataset);
                });
                
            }
        }
        
        
        

        
}
      //google.maps.event.addDomListener(window, 'load', initMap);
