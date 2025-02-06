class LocationMap {
    mapElement;
    markers;

    constructor(elementName) {
        this.mapElement = L.map(elementName);
        this.mapElement.setView([0, 0], 2);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(this.mapElement);
        this.markers = [];
    }

    removeMarkers() {
        for (var i = 0; i < this.markers.length; i++) {
            this.markers[i].remove();
        }
    }

    placeMarkers(markers) {
        this.removeMarkers();
        for (var i = 0; i < markers.length; i++) {
            let marker = markers[i];
            let placed = L.marker([marker.lat, marker.lon]).addTo(this.mapElement);
            placed.bindPopup(marker.name);
            placed.on('contextmenu', () => {
                window.open("http://localhost/?c=location&a=data&location_id=" + marker.id, '_blank');
            })
            this.markers.push(placed);
        }
    }

    setView(latlng) {
        this.mapElement.setView([latlng.lat, latlng.lng], 12);
    }

}

export {LocationMap};