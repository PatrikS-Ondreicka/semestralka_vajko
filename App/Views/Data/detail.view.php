<?php
/** @var Array $data */
use App\Models\User;

$weather_data = $data['weather_data'];
$location = $data['location'];
?>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<div class="container">
    <h1>Weather Data Details</h1>

    <div class="data-item">
        <span class="data-label">Date:</span>
        <span id="date"><?= $weather_data->getDate() ?></span>
    </div>
    <div class="data-item">
        <span class="data-label">Temperature:</span>
        <span id="temperature"><?= $weather_data->getTemperature() ?></span>
    </div>
    <div class="data-item">
        <span class="data-label">Humidity:</span>
        <span id="humidity"><?= $weather_data->getHumidity() ?></span>
    </div>
    <div class="data-item">
        <span class="data-label">Wind Speed:</span>
        <span id="wind_speed"><?= $weather_data->getWindSpeed() ?></span>
    </div>
    <div class="data-item">
        <span class="data-label">Wind Direction:</span>
        <span id="wind_direction"><?= $weather_data->getWindDirection() ?></span>
    </div>
    <div class="data-item">
        <span class="data-label">Precipitation:</span>
        <span id="precipitation"><?= $weather_data->getPrecipitation() ?></span>
    </div>
    <div class="data-item">
        <span class="data-label">Posted By:</span>
        <span id="user"><?= (!is_null(User::getOne($weather_data->getUser()))) ? User::getOne($weather_data->getUser())->getUsername() : "unknown"?></span>
    </div>

    <h2>Location</h2>
    <div class="location_item">
        <span class="data-label">Name:</span>
        <span id="precipitation"><?= $location->getName() ?></span>
    </div>
    <div class="location_item">
        <span class="data-label">Latitude:</span>
        <span id="precipitation"><?= $location->getLat() ?></span>
    </div>
    <div class="location_item">
        <span class="data-label">Longitude:</span>
        <span id="precipitation"><?= $location->getLon() ?></span>
    </div>
    <div id="map" style="width: 600px; height: 600px"></div>
</div>

<script>
    let lat = <?= $location->getLat() ?>;
    let lon = <?= $location->getLon() ?>;
    const map = L.map('map');
    map.setView([lat, lon], 12);
    map.dragging.disable();
    map.scrollWheelZoom.disable();
    map.doubleClickZoom.disable();
    map.touchZoom.disable();
    map.keyboard.disable();
    map.zoomControl.remove();

    location_marker = L.marker([lat, lon], 7);
    location_marker.addTo(map);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);
</script>
