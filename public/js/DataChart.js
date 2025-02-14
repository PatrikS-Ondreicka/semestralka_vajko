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
                tickformat: '%Y-%m-%d',
            },
            yaxis: {
                title: this.textLabel,
            },
            plot_bgcolor: '#ADD7F6',
            paper_bgcolor: '#ADD7F6',
        };

        this.chart = Plotly.newPlot(this.chartId, [trace], layout,{ responsive: true});
    }
}

export {DataChart};