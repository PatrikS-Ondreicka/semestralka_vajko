
<?php
/** @var \App\Core\LinkGenerator $link */
/** @var Array $data */

use App\Models\Data;

$id = -1;
$temp = "";
$hum = "";
$ws = "";
$wd = "";
$precip = "";
$lat = "";
$lon = "";
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
        $lat = 1;
        $lon = 1;
    }
}
?>
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
            <input type="number" id="temperature" name="temperature" class="form-control" value="<?= $temp ?>">
                   <!-- step="0.01" min="-90.0" max="57.0" required> -->
        </div>

        <div class="form-group">
            <div class="hum_icon_bg value_icon"></div>
            <label for="humidity" class="form-label">Humidity (%)</label>
            <input type="number" id="humidity" name="humidity" class="form-control" value="<?= $hum ?>">
                   <!-- min="0" max="100" required> -->
        </div>

        <div class="wind_data_block row">
            <div class="form-group col-xl-6 col-12">
                <div class="wind_icon_bg value_icon"></div>
                <label for="wind_speed" class="form-label">Wind Speed (km/h)</label>
                <input type="number" id="wind_speed" name="wind_speed" class="form-control" value="<?= $ws ?>">
                       <!-- min="0" required >-->
            </div>

            <div class="form-group col-xl-6 col-12">
                <div class="wind_arr_icon_bg value_icon"></div>
                <label for="wind_direction" class="form-label">Wind Direction</label>
                <select id="wind_direction" name="wind_direction" class="form-select"> <!-- required >-->
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
                   step="0.01"> <!-- min="0" required >-->
        </div>

        <div class="row">
            <div class="compass_icon_bg value_icon"></div>
            <label class="form-label">Location</label>
            <div class="form-group col-xl-6 col-12">
                <label for="lat" class="form-label">Latitude</label>
                <input type="number" id="lat" name="lat" class="form-control" value="<?= $lat ?>" required>
            </div>
            <div class="form-group col-xl-6 col-12">
                <label for="lon" class="form-label">Longitude</label>
                <input type="number" id="lon" name="lon" class="form-control" value="<?= $lon ?>" required>
            </div>
        </div>

        <div class="form-group col-lg-4 col-sm-12">
            <button type="submit" class="form-control">Submit</button>
        </div>
    </div>
</form>

<!-- <script src="../../../public/js/formCheck.js"></script> -->
