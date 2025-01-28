<?php
/** @var \App\Core\LinkGenerator $link */

use App\Models\Data;
use App\Models\Location;

$locations = Location::getAll();
?>

<h1>Weather Statistics</h1>

<form>
    <fieldset>
        <legend>Filters</legend>

        <label for="location">Location:</label>
        <input type="text" id="location" name="location" list="location-list">
        <datalist id="location-list">
            <?php foreach ($locations as $loc): ?>
            <option value="<?= $loc->getId();?>"><?= $loc->getName(); ?></option>
            <?php endforeach; ?>
        </datalist>

        <br><br>

        <label for="data-type">Data Type:</label>
        <select id="data-type" name="data-type">
            <option value="values">Values</option>
            <option value="average">Average</option>
            <option value="min">Minimum</option>
            <option value="max">Maximum</option>
        </select>
        <br><br>

        <label for="from-date">From Date:</label>
        <input type="date" id="from-date" name="from-date">

        <label for="to-date">To Date:</label>
        <input type="date" id="to-date" name="to-date">

        <br><br>
        <input type="button" id="applyFiltersButton" value="Apply Filters">
    </fieldset>
</form>

<hr>

<h2>Temperature</h2>
<div id="temperature_chart" width="400" height="200"></div>

<hr>

<h2>Humidity</h2>
<div id="humidity_chart"></div>

<hr>

<h2>Wind Speed</h2>
<div id="wind_speed_chart"></div>

<hr>

<h2>Precipitation</h2>
<div id="precipitation_chart"></div>

<div id="test"></div>

<script src="/public/js/statsScript.js" type="module"></script>