// import * as Plotly from 'https://cdn.plot.ly/plotly-2.35.2.min.js';

class DataChart {
    chart;
    dataset;
    chartId;
    textLabel;
    color;

    constructor(dataset, chartId, textLabel, color) {
        this.dataset = dataset;
        this.chartId = chartId;
        this.textLabel = textLabel;
        this.color = color;
    }

    createChart() {
        console.log(this.dataset)
        const trace = {
            x: this.dataset.map(item => item.date),
            y: this.dataset.map(item => item.value),
            mode: 'lines',
            marker: {
                color: this.color,
            },
        };

        const layout = {
            xaxis: {
                title: 'Date',
                type: 'date',
                tickformat: '%Y-%m-%d', // Adjust date format as needed
            },
            yaxis: {
                title: this.textLabel,
            },
        };

        this.chart = Plotly.newPlot(this.chartId, [trace], layout);
    }
}

export {DataChart};