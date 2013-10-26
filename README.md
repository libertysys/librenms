# Leaflet.awesome-markers plugin v2.0
Colorful iconic & retina-proof markers for Leaflet, based on the Glyphicons / Font-Awesome icons

Version 2.0 of Leaflet.awesome-markers is tested with:
- Bootstrap 3
- Font Awesome 4.0
- Leaflet 0.5-Latest

For bootstrap 2.x & Fontawesome 3.x use Leaflet.awesome-markers v1.0

## Screenshots
![AwesomeMarkers screenshot](https://raw.github.com/lvoogdt/Leaflet.awesome-markers/master/screenshots/screenshot-soft.png "Screenshot of AwesomeMarkers")

<a href="http://jsfiddle.net/VPzu4/28/" target="_blank">JSfiddle demo</a> 

### Twitter Bootstrap/Font-Awesome icons
This plugin depends on either Bootstrap or Font-Awesome for the rendering of the icons. See these urls for more information:

For Font-Awesome
- http://fortawesome.github.com/Font-Awesome/
- http://fortawesome.github.com/Font-Awesome/#integration

For Twitter bootstrap:
- http://twitter.github.com/bootstrap/

## Using the plugin
- 1) First, follow the steps for including Font-Awesome or Twitter bootstrap into your application.

    For Font-Awesome, steps are located here:
    
    http://fortawesome.github.io/Font-Awesome/get-started/
    
    For Twitter bootstrap, steps are here:
    
    http://twitter.github.io/bootstrap/getting-started.html
    

- 2) Next, copy the dist/images directory, awesome-markers.css, and awesome-markers.js to your project and include them:
````xml
<link rel="stylesheet" href="css/leaflet.awesome-markers.css">
````
````xml
<script src="js/leaflet.awesome-markers.js"></script>
````

- 3) Now use the plugin to create a marker like this:
````js
// Creates a red marker with the coffee icon
var redMarker = L.AwesomeMarkers.icon({
  icon: 'coffee', 
  markerColor: 'red'
})

    
    L.marker([51.941196,4.512291], {icon: redMarker}).addTo(map);
````

### Supported marker colors:
**The following colors are supported**

The 'markerColor' property currently supports these strings:
- 'red'
- 'darkred'
- 'orange'
- 'green'
- 'darkgreen'
- 'blue'
- 'darkblue'
- 'purple'
- 'darkpurple'
- 'cadetblue'

### Supported icons
The 'icon' property supports these strings:
- 'home'
- 'glass'
- 'flag'
- 'star'
- 'bookmark'
- .... and many more, see: http://fortawesome.github.com/Font-Awesome/#icons-new
- Or: http://twitter.github.com/bootstrap/base-css.html#icons

### Spinning icons (only Font-Awesome)
You can make any icon spin by setting the spin option to true:
````js
// Creates a red marker with the coffee icon
var redMarker = L.AwesomeMarkers.icon({
  icon: 'spinner', 
  markerColor: 'red',
  spin: true
})

L.marker([51.941196,4.512291], {icon: redMarker}).addTo(map);
````

## License
- Leaflet.AwesomeMarkers and colored markers are licensed under the MIT License - http://opensource.org/licenses/mit-license.html.
- Font Awesome: http://fortawesome.github.com/Font-Awesome/#license
- Twitter Bootstrap: http://twitter.github.com/bootstrap/

## Contact
- Email: lvoogdt@gmail.com
- Website: http://lennardvoogdt.nl
