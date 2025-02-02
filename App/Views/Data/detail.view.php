<?php
/** @var Array $data */
/** @var \App\Core\LinkGenerator $link */
/** @var \App\Core\IAuthenticator $auth */
use App\Models\User;
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

$weather_data = $data['weather_data'];
$location = $data['location'];
$report_types = $data['report_types'];
session_start();
?>

<div class="container">
    <h1 class="text-center mb-4">Weather Data Details</h1>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Weather Conditions</h2>
                </div>
                <div class="card-body">
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
                </div>
                <div class="card-footer">
                    <?php if ($auth->isLogged() && $weather_data->getUser() != $auth->getLoggedUserId()): ?>
                        <form action="<?= $link->url("report.add", ['user_id' => $auth->getLoggedUserId(), 'data_id' => $weather_data->getId()])?>" method="post">
                            <label for="report_type">Reason:</label>
                            <select id="report_type" name="report_type">
                                <?php foreach($report_types as $type):?>
                                    <option value="<?= $type->getId(); ?>"><?= $type->getDescription(); ?></option>
                                <?php endforeach; ?>
                            </select>
                            <input class="btn btn-primary" type="submit" value="Report">
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Location</h2>
                </div>
                <div class="card-body">
                    <div class="location_item">
                        <span class="data-label">Name:</span>
                        <span id="location_name"><?= $location->getName() ?></span>
                    </div>
                    <div class="location_item">
                        <span class="data-label">Latitude:</span>
                        <span id="location_lat"><?= $location->getLat() ?></span>
                    </div>
                    <div class="location_item">
                        <span class="data-label">Longitude:</span>
                        <span id="location_lon"><?= $location->getLon() ?></span>
                    </div>
                    <div id="map" style="width: 100%; height: 400px;"></div> </div>
            </div>
        </div>
    </div>
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
