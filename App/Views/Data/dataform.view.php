
<?php
/** @var \App\Core\LinkGenerator $link */
?>

<form action="<?= $link->url("Data.uploadData")?>" method="post">
    <div class="container add_data_form_container col-md-9 col-sm-12">

        <div class="form-group">
            <div class="temp_icon_bg value_icon"></div>
            <label for="temperature" class="form-label">Temperature (°C)</label>
            <input type="number" id="temperature" name="temperature" class="form-control" required>
        </div>

        <div class="form-group">
            <div class="hum_icon_bg value_icon"></div>
            <label for="humidity" class="form-label">Humidity (%)</label>
            <input type="number" id="humidity" name="humidity" class="form-control" required>
        </div>

        <div class="wind_data_block row">
            <div class="form-group col-xl-6 col-12">
                <div class="wind_icon_bg value_icon"></div>
                <label for="wind_speed" class="form-label">Wind Speed (km/h)</label>
                <input type="number" id="wind_speed" name="wind_speed" class="form-control" required>
            </div>

            <div class="form-group col-xl-6 col-12">
                <div class="wind_arr_icon_bg value_icon"></div>
                <label for="wind_direction" class="form-label">Wind Direction</label>
                <select id="wind_direction" name="wind_direction" class="form-select" required>
                    <option value="" disabled selected>------</option>
                    <option value="N">North</option>
                    <option value="NE">Northeast</option>
                    <option value="E">East</option>
                    <option value="SE">Southeast</option>
                    <option value="S">South</option>
                    <option value="SW">Southwest</option>
                    <option value="W">West</option>
                    <option value="NW">Northwest</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <div class="precip_icon_bg value_icon"></div>
            <label for="precipitation" class="form-label">Precipitation (mm)</label>
            <input type="number" id="precipitation" name="precipitation" class="form-control" required>
        </div>

        <div class="row">
            <div class="compass_icon_bg value_icon"></div>
            <label class="form-label">Location</label>
            <div class="form-group col-xl-6 col-12">
                <label for="lat" class="form-label">Latitude</label>
                <input type="number" id="lat" name="lat" class="form-control" required>
            </div>
            <div class="form-group col-xl-6 col-12">
                <label for="lon" class="form-label">Longitude </label>
                <input type="number" id="lon" name="lon" class="form-control" required>
            </div>
        </div>

        <div class="form-group col-lg-4 col-sm-12">
            <button type="submit" class="form-control">Submit</button>
        </div>
    </div>
</form>
