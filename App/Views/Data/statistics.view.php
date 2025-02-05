<?php
/** @var \App\Core\LinkGenerator $link */

use App\Models\Data;
use App\Models\Location;

$locations = Location::getAll();
?>

<div class="container">
    <div class="card">
        <div class="card-header">
            <h2>Filters</h2>
        </div>
        <div class="card-body">  <form>
                <div class="form-group">  <label for="location">Location:</label>
                    <input type="text" class="form-control" id="location" name="location" list="location-list">
                    <datalist id="location-list">
                        <?php foreach ($locations as $loc): ?>
                            <option value="<?= $loc->getId(); ?>"><?= $loc->getName(); ?></option>
                        <?php endforeach; ?>
                    </datalist>
                </div>

                <div class="form-group">  <label for="data-type">Data Type:</label>
                    <select class="form-control" id="data-type" name="data-type">
                        <option value="values">Values</option>
                        <option value="min">Minimum</option>
                        <option value="max">Maximum</option>
                    </select>
                </div>

                <div class="form-group">  <label for="from-date">From Date:</label>
                    <input type="date" class="form-control" id="from-date" name="from-date">
                </div>

                <div class="form-group">  <label for="to-date">To Date:</label>
                    <input type="date" class="form-control" id="to-date" name="to-date">
                </div>

                <button type="button" class="btn btn-primary" id="applyFiltersButton">Apply Filters</button>  </form>
        </div>
    </div>

    <div class="card mt-1">
        <div class="card-header">
            <h2>Temperature</h2>
        </div>
        <div id="temperature_chart"></div>
        <hr>
    </div>

    <div class="card mt-1">
        <div class="card-header">
            <h2>Humidity</h2>
        </div>
        <div id="humidity_chart"></div>
        <hr>
    </div>

    <div class="card mt-1">
        <div class="card-header">
            <h2>Wind Speed</h2>
        </div>
        <div id="wind_speed_chart"></div>
        <hr>
    </div>

    <div class="card mt-1">
        <div class="card-header">
            <h2>Precipitation</h2>
        </div>
        <div id="precipitation_chart"></div>
    </div>
    <div id="test"></div>
</div>

<script src="/public/js/statsScript.js" type="module"></script>