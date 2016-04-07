var markers = []; // array of the markers
function initMap() {
        var mapDiv = document.getElementById('map');
        var map = new google.maps.Map(mapDiv, {
                center: {lat: 53.5466707, lng: -113.5196069},
                zoom: 10
        });
        
        // load the the Ward Boundaries
        map.data.loadGeoJson('./dataset/City of Edmonton - Ward Boundaries.geojson');
        
        var wardName;
        
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
          }
          if (feature.getProperty('hover')) {
                stroke = 8;
          }
          if (feature.getProperty('hover') != true) {
                stroke = 2;
          }
          return /** @type {google.maps.Data.StyleOptions} */({
                fillColor: color,
                strokeColor: color,
                strokeWeight: stroke    
          });
        });
      
        // When the user clicks, set 'isHighlighted' to true, changing the color of the region.
        map.data.addListener('click', function(event) {
                // make sure all the other regions are not highlighted
                map.data.forEach(function(features) {
                        features.setProperty('isHighlighted', false);
                });
                event.feature.setProperty('isHighlighted', true);
                // get the ward name to display the bubble window
                wardName = event.feature.getProperty('name');
                // only show the markers in the selected regions
                loadMyData(wardName, true);
                
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
                wardName = event.feature.getProperty('name');
                // the bubble window will display the region name that the mouse is hovering over
                bubbleWin.setPosition(event.latLng);
                bubbleWin.setContent(wardName);
                bubbleWin.open(map);
        });
      
        map.data.addListener('mouseout', function(event) {
                event.feature.setProperty('hover', false);
        });
        
        // load the dataset
        var dataset;
        
        // after the data is loaded, show the markers for the dataset
        function myDataLoaded(dataset) {
            for( i = 0; i < dataset.length; i++ ) {
                marker = new google.maps.Marker({
                position: {lat: dataset[i][0], lng: dataset[i][1]},
                map: map
                });
                markers.push(marker);	
            }
            showAllMarkers(map);
        }
        
        // show all the markers in the markers array
        function showAllMarkers(map) {
                for (var i = 0; i < markers.length; i++) {
                        markers[i].setMap(map);
                }
        }
        
        // remove markers that are not in the region
        function removeMarkers() {
            showAllMarkers(null);
            markers = [];
        }
        
        // loading the data, filter the data, to return markers only in that region, or show all markers
        function loadMyData(keyWord, doFilter) {
            //var dataset;
            var filterData;
            // when a region is selected
            if (doFilter) {
                d3.csv("./dataset/exportTable.php", function(data) {
                        dataFilter = data.filter(function(d) {
                                if (d["311_ward"] == keyWord) {
                                    //return [ +d["Lat"], +d["Long"] ];
                                    return d;
                                }
                        });
                        filterData = dataFilter.map(function(d) { return [ +d["311_latitude"], +d["311_longtitude"] ]; });
                        //console.log(filterData);
                        removeMarkers();
                        myDataLoaded(filterData);
                });
            }
            else {
                // region is not selected, so display all markers
                d3.csv("./dataset/exportTable.php", function(data) {
                        dataset = data.map(function(d) { return [ +d["311_latitude"], +d["311_longtitude"] ]; });
                        myDataLoaded(dataset);
                });
                
            }
        }
      }
      //google.maps.event.addDomListener(window, 'load', initMap);
      