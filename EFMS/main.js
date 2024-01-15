var x = [];
var y = [];

fetch('get_water_levels.php')
    .then(response => response.json())
    .then(data => {
        data.forEach(function(item) {
            x.push(item.date);
            y.push(item.water_level);
        });

        var trace = {
            x: x,
            y: y,
            mode: 'lines',
            type: 'scatter',
            line: {shape: 'spline'}
        };

        var layout = {
            title: 'Water Level Graph',
            xaxis: {title: 'Date'},
            yaxis: {title: 'Water Level'}
        };

        Plotly.newPlot('graph', [trace], layout);
    });