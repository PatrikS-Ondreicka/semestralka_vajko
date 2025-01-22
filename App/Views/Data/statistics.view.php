<?php
?>

<h1>Weather Statistics</h1>

<form>
    <fieldset>
        <legend>Filters</legend>

        <label for="location">Location:</label>
        <input type="text" id="location" name="location" list="location-list">
        <datalist id="location-list">
            <option value="London">
            <option value="New York">
            <option value="Tokyo">
        </datalist>

        <br><br>

        <label for="data-type">Data Type:</label>
        <select id="data-type" name="data-type">
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
        <input type="submit" value="Apply Filters">
    </fieldset>
</form>

<hr>

<h2>Temperature</h2>
<img src="placeholder_graph.png" alt="Temperature Graph" width="600" height="300">

<hr>

<h2>Humidity</h2>
<img src="placeholder_graph.png" alt="Humidity Graph" width="600" height="300">

<hr>

<h2>Wind Speed</h2>
<img src="placeholder_graph.png" alt="Wind Speed Graph" width="600" height="300">

<hr>

<h2>Precipitation</h2>
<img src="placeholder_graph.png" alt="Precipitation Graph" width="600" height="300">
