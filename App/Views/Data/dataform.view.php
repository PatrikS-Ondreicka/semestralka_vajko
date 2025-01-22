
<?php
/** @var \App\Core\LinkGenerator $link */
/** @var Array $data */

use App\Models\Data;
use \App\Models\Location;

$id = -1;
$temp = "";
$hum = "";
$ws = "";
$wd = "";
$precip = "";
$lat = "";
$lon = "";
$loc_name = "";
$errors = null;

if ($data && key_exists('errors', $data))
{
    $errors = $data['errors'];
}


if ($data && key_exists('weatherData', $data)){
    $weatherData = $data['weatherData'];

    if (!is_null($weatherData))
    {
        $id = $weatherData->getId();
        $temp = $weatherData->getTemperature();
        $hum = $weatherData->getHumidity();
        $ws = $weatherData->getWindSpeed();
        $wd = $weatherData->getWindDirection();
        $precip = $weatherData->getPrecipitation();

        $loc = Location::getOne($weatherData->getLocation());
        $lat = $loc->getLat();
        $lon = $loc->getLon();
        $loc_name = $loc->getName();
    }
}
?>

<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>

<div id="errors">
    <?php
        if ($errors != null)
        {
            foreach ($errors as $error) {
                echo '<div class="text-danger">'.$error.'</div>';
            }
        }
    ?>
</div>
<form id="dataForm" action="<?= $link->url("Data.uploadData", ['dataId' => $id])?>" method="post" onsubmit="return formCheck()">
    <div class="container add_data_form_container col-md-9 col-sm-12">

        <div class="form-group">
            <div class="temp_icon_bg value_icon"></div>
            <label for="temperature" class="form-label">Temperature (°C)</label>
            <input type="number" id="temperature" name="temperature" class="form-control" value="<?= $temp ?>"
                   step="0.01" min="-90.0" max="57.0" required>
        </div>

        <div class="form-group">
            <div class="hum_icon_bg value_icon"></div>
            <label for="humidity" class="form-label">Humidity (%)</label>
            <input type="number" id="humidity" name="humidity" class="form-control" value="<?= $hum ?>"
                   min="0" max="100" required>
        </div>

        <div class="wind_data_block row">
            <div class="form-group col-xl-6 col-12">
                <div class="wind_icon_bg value_icon"></div>
                <label for="wind_speed" class="form-label">Wind Speed (km/h)</label>
                <input type="number" id="wind_speed" name="wind_speed" class="form-control" value="<?= $ws ?>"
                       min="0" required>
            </div>

            <div class="form-group col-xl-6 col-12">
                <div class="wind_arr_icon_bg value_icon"></div>
                <label for="wind_direction" class="form-label">Wind Direction</label>
                <select id="wind_direction" name="wind_direction" class="form-select" required>
                    <option value="" disabled <?php if ($wd == "") {echo 'selected';} ?> >------</option>
                    <option value="N" <?php if ($wd == "N") {echo 'selected';} ?>>N</option>
                    <option value="NE" <?php if ($wd == "NW") {echo 'selected';} ?>>NW</option>
                    <option value="E" <?php if ($wd == "E") {echo 'selected';} ?>>NE</option>
                    <option value="SE" <?php if ($wd == "SE") {echo 'selected';} ?>>SE</option>
                    <option value="S" <?php if ($wd == "S") {echo 'selected';} ?>>S</option>
                    <option value="SW" <?php if ($wd == "SW") {echo 'selected';} ?>>SW</option>
                    <option value="W" <?php if ($wd == "W") {echo 'selected';} ?>>W</option>
                    <option value="NW" <?php if ($wd == "NW") {echo 'selected';} ?>>NW</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <div class="precip_icon_bg value_icon"></div>
            <label for="precipitation" class="form-label">Precipitation (mm)</label>
            <input type="number" id="precipitation" name="precipitation" class="form-control" value="<?= $precip ?>"
                   step="0.01" min="0" required >
        </div>

        <div id="location_selection">
            <hr class="form_split_line">
            <div id="location_selection_header">
                <div class="compass_icon_bg value_icon"></div>
                <label class="form-label">Location</label>
                <br>
                <div class="row">
                    <div>
                        <input type="radio" id="manual" name="selection_mode" value="manual" checked>
                        <label for="manual">Manual</label>
                    </div>

                    <div>
                        <input type="radio" id="automatic" name="selection_mode" value="automatic">
                        <label for="automatic">Automatic</label>
                    </div>

                    <div>
                        <input type="radio" id="map" name="selection_mode" value="map">
                        <label for="map">Map</label>
                    </div>
                </div>

            </div>
            <div id="location_selection_content">

                <!-- Manual selection content -->
                <div id="man_selection_content" class="selection_content row" style="display:flex;">
                    <div class="form-group col-12">
                        <label for="lat" class="form-label">Name</label>
                        <input type="text" id="loc_name" name="loc_name" class="form-control" value="<?= $loc_name ?>">
                    </div>
                    <div class="form-group col-xl-6 col-12">
                        <label for="lat" class="form-label">Latitude</label>
                        <input type="number" id="lat" name="lat" class="form-control" step="0.0001" value="<?= $lat ?>" required>
                    </div>
                    <div class="form-group col-xl-6 col-12">
                        <label for="lon" class="form-label">Longitude</label>
                        <input type="number" id="lon" name="lon" class="form-control" step="0.0001" value="<?= $lon ?>" required>
                    </div>
                </div>

                <!-- Automatic selection content -->
                <div id="auto_selection_content" class="selection_content" style="display:flex;">Auto</div>

                <!-- Map selection content-->
                <div id="map_selection_content" class="selection_content" style="display:flex;">
                    <div id="map" style="width:600px; height:600px;">

                    </div>
                </div>
            </div>
        </div>

        <div class="form-group col-lg-4 col-sm-12">
            <button type="submit" class="form-control">Submit</button>
        </div>
    </div>
</form>

<script>
    console.log(L);
    let map = L.map('map');
    map.setView([0, 0], 7);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);
</script>


<script src="../../../public/js/formCheck.js"></script>
<script src="../../../public/js/locationSelectOptions.js"></script>
