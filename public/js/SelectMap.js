class SelectMap {
    mapElement;
    marker;
    latElement;
    lonElement;

    constructor(elementName) {
        this.mapElement = L.map(elementName);
        this.mapElement.setView([0, 0], 7);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(this.mapElement);

        this.mapElement.on('contextmenu', this.placeMarkerEvent.bind(this));
    }

    setView(latlng) {
        this.mapElement.setView([latlng.lat, latlng.lng], 12);
    }

    removeMarker() {
        if (this.marker) {
            this.mapElement.removeLayer(this.marker);
            if (this.latElement != null) {
                this.latElement.value = "";
            }
            if (this.lonElement != null) {
                this.lonElement.value = "";
            }
        }
    }

    setLatElement(element) {
        this.latElement = document.getElementById(element);
    }

    setLonElement(element) {
        this.lonElement = document.getElementById(element);
    }

    placeMarkerEvent(event) {
        let latLng = event.latlng;
        this.placeMarker(latLng);
    }

    placeMarker(latlng) {
        if (this.marker) {
            this.mapElement.removeLayer(this.marker);
        }
        this.marker = L.marker(latlng).addTo(this.mapElement);
        let lat = latlng.lat;
        let lon = latlng.lng;
        if (this.latElement != null) {
            this.latElement.value = lat.toFixed(4);
        }
        if (this.lonElement != null) {
            this.lonElement.value = lon.toFixed(4);
        }
    }
}

export {SelectMap};