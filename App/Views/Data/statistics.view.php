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
<div id="temperature_chart" width="400" height="200"></div>

<hr>

<h2>Humidity</h2>
<div id="humidity_chart"></div>

<hr>

<h2>Wind Speed</h2>
<div id="wind_speed_chart"></div>

<hr>

<h2>Precipitation</h2>
<div id=pPrecipitation_chart"></div>

<script type="module">
    import {DataChart} from "/public/js/DataChart.js";

    const data = [
        { value: 18, date: '2024-10-26' },
        { value: 22, date: '2024-10-27' },
        { value: 20,  date: '2024-10-28' },
        { value: 25, date: '2024-10-29' },
        { value: 23, date: '2024-10-30' },
    ];

    let tempChart = new DataChart(data, "temperature_chart", "Temperature", 'rgb(75, 192, 192)');
    tempChart.createChart();

</script>