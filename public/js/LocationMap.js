class LocationMap {
    mapElement;

    constructor(elementName) {
        this.mapElement = L.map(elementName);
        this.mapElement.setView([0, 0], 7);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(this.mapElement);

    }

    setView(latlng) {
        this.mapElement.setView([latlng.lat, latlng.lng], 12);
    }

}

export {LocationMap};