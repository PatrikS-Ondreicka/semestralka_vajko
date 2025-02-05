import {DataChart} from "/public/js/DataChart.js";
import {DataAPI} from "/public/js/DataAPI.js";

async function defaultCharts() {
    const dataAPI = new DataAPI();

    const tempData = await dataAPI.getTemperature();
    let tempChart = new DataChart(tempData, "temperature_chart", "Temperature", 'rgb(215,68,68)');
    tempChart.createChart();

    const humData = await dataAPI.getHumidity();
    let humChart = new DataChart(humData, "humidity_chart", "Humidity", 'rgb(75,85,192)');
    humChart.createChart();

    const wsData = await dataAPI.getWindSpeed();
    let wsChart = new DataChart(wsData, "wind_speed_chart", "Wind Speed", 'rgb(192,169,75)');
    wsChart.createChart();

    const precData = await dataAPI.getPrecipitation();
    let precChart = new DataChart(precData, "precipitation_chart", "Precipitation", 'rgb(184,75,192)');
    precChart.createChart();
}

async function clickEvent() {
    const locationElement = document.getElementById('location');
    const valueTypeElement = document.getElementById('data-type');
    const fromDateElement = document.getElementById('from-date');
    const toDateElement = document.getElementById('to-date');

    let location = locationElement.value;
    let valueType = valueTypeElement.value;
    let fromDate = fromDateElement.value;
    let toDate = toDateElement.value;

    const dataAPI = new DataAPI();

    const tempData = await dataAPI.getTemperature(fromDate, toDate, location, valueType);
    let tempChart = new DataChart(tempData, "temperature_chart", "Temperature", 'rgb(215,68,68)');
    tempChart.createChart();

    const humData = await dataAPI.getHumidity(fromDate, toDate, location, valueType);
    let humChart = new DataChart(humData, "humidity_chart", "Humidity", 'rgb(75,85,192)');
    humChart.createChart();

    const wsData = await dataAPI.getWindSpeed(fromDate, toDate, location, valueType);
    let wsChart = new DataChart(wsData, "wind_speed_chart", "Wind Speed", 'rgb(192,169,75)');
    wsChart.createChart();

    const precData = await dataAPI.getPrecipitation(fromDate, toDate, location, valueType);
    let precChart = new DataChart(precData, "precipitation_chart", "Precipitation", 'rgb(184,75,192)');
    precChart.createChart();
}

await defaultCharts();

const confirmButton = document.getElementById('applyFiltersButton');
confirmButton.onclick = () => clickEvent();