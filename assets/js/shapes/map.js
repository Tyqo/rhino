/**
 * src/js/modules/leafletmap.js
 *
 * Depens on mapbox-gl
 *
 * `npm install mapbox-gl`
 *
 * In `gulpfile.js`:
 * Add `./node_modules/mapboxgl/dist/mapbox-gl.js` to jsVendor
 * and `./node_modules/mapboxgl/dist/mapbox-gl.css' to cssVendor
 *
 * @author Johannes Braun <j.braun@agentur-halma.de>
 * @package halma-kickstart
 * @version 2021-05-28
 * @usage
 *
 * <div id="map" data-latitude="{latitude}" data-longitude="{longitude}" data-zoom="{zoom}">
 * 	<p>Any HTML content inside the map element will be used as a popup
 * 	content</p>
 * 	</div>
 *
 * 	Use the data-* attributes or pass as options to Javascript class
 *
 * 	new Map({
 * 	 	latitude: ...
 * 	 	longitude: ...
 * 	 	...
 *  });
 */
export default class Map {

	constructor(mapElement, _options) {

		if (mapElement == null) {
			return;
		}

		let options = Object.assign({
			accessToken: 'pk.eyJ1IjoiYWdlbnR1cmhhbG1hIiwiYSI6ImNraG5oZG5kNTJmb2gyc3FxMm55OGJiNmkifQ.2ekMtf7xhWqCQHoJCxZjvQ',
			style: 'mapbox://styles/mapbox/outdoors-v11',
			latitude: parseFloat(mapElement.dataset.latitude),
			longitude: parseFloat(mapElement.dataset.longitude),
			zoom: parseInt(mapElement.dataset.zoom),
		}, _options);

		// Make sure mapbox-gl is available
		if (typeof mapboxgl == 'undefined') {
			console.warn("MapboxGL is not installed, run `npm install --save mapbox-gl`");
			return;
		}
		var innerHTML = mapElement.innerHTML.trim();

		// Map elements need a minimum height
		mapElement.style.minHeight = '150px';

		this.LngLat = [
			options.longitude, 
			options.latitude
		];
		
		let location = this.LngLat;
		mapboxgl.accessToken = options.accessToken;

		this.map = new mapboxgl.Map({
			container: mapElement, // container ID
			style: options.style, // style URL
			center: location, // starting position [lng, lat]
			zoom: options.zoom, // starting zoom
			interactive: false,
		});

		// Scroll to zoom only after click / while focused
		mapElement.addEventListener('focusin', () => this.toggleInteractions(true));
		mapElement.addEventListener('focusout', () => this.toggleInteractions(false));

		let nav = new mapboxgl.NavigationControl();
		this.map.addControl(nav, 'top-left');

		let marker = new mapboxgl.Marker()
			.setLngLat(this.LngLat)
			.addTo(this.map);
		;


		if (innerHTML.length > 0) {
			let popup = new mapboxgl.Popup({
				offset: {
					bottom: [0, -50]
				}
			})
			.setLngLat(this.LngLat)
			.setHTML(innerHTML)
			.setMaxWidth('300px')
			.addTo(this.map);

			marker.setPopup(popup);
		}
	}

	toggleInteractions(status) {
		if (status) {
			this.map.dragPan.enable();
			this.map.dragRotate.enable();
			this.map.scrollZoom.enable(); //{ around: 'center' }
			this.map.boxZoom.enable();
			this.map.doubleClickZoom.enable();
	
			this.map.touchZoomRotate.enable();
			this.map.touchPitch.enable(); 
		} else {
			this.map.dragPan.disable();
			this.map.dragRotate.disable();
			this.map.scrollZoom.disable();
			this.map.boxZoom.disable();
			this.map.doubleClickZoom.disable();
	
			this.map.touchZoomRotate.disable();
			this.map.touchPitch.disable();
		}
	}


	/**
	 * Returns the MapboxGL object
	 */
	getMap() {
		return this.map;
	}

};

