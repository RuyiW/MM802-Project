
function initMap() {
        var mapDiv = document.getElementById('map');
        var map = new google.maps.Map(mapDiv, {
                center: {lat: 53.5466707, lng: -113.5196069},
                zoom: 10
        });
        map.data.loadGeoJson('./dataset/City of Edmonton - Ward Boundaries.geojson');
        
        // Color each Ward black. Change the color to blue when the isHighlighted property
        // is set to true.
        map.data.setStyle(function(feature) {
          var color = 'black';
          if (feature.getProperty('isHighlighted')) {
                color = 'blue';
          }
          return /** @type {google.maps.Data.StyleOptions} */({
                fillColor: color,
                strokeColor: color,
                strokeWeight: 2
          });
        });
      
        // When the user clicks, set 'isHighlighted' to true, changing the color of the Ward.
        map.data.addListener('click', function(event) {
                // make sure all the other regions are not highlighted
                map.data.forEach(function(features) {
                        features.setProperty('isHighlighted', false);
                });
                event.feature.setProperty('isHighlighted', true);
        });
        
        // When the user hovers, outlining the Ward boundaries.
        // Call revertStyle() to remove all overrides. This will use the style rules
        // defined in the function passed to setStyle()
        map.data.addListener('mouseover', function(event) {
                map.data.revertStyle();
                map.data.overrideStyle(event.feature, {strokeWeight: 8});
        });
      
        map.data.addListener('mouseout', function(event) {
                map.data.revertStyle();
        });
        
      }