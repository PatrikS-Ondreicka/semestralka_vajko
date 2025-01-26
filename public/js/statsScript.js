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

defaultCharts();