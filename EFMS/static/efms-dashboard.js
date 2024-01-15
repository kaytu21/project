document.addEventListener("DOMContentLoaded", function() {
    // Fetch data and render charts
    create_past_charts(2023);
    let pastMonthChart;
    let floodLevelchart;
    let timechart;
    function fetchAndRenderCurrentFloodLevel() {
        axios.get('/api/currentFloodLevel')
        .then(response => {
            // Render current flood level chart
            renderFloodLevelChart(response.data);
            
        })
        .catch(error => {
            console.error('Error fetching current flood level', error);
        });
    }
    // Call the function immediately to fetch and render the data
    fetchAndRenderCurrentFloodLevel();

    // Set up a 10-second interval to fetch and render the current flood level
    setInterval(fetchAndRenderCurrentFloodLevel, 10000); // 10000 milliseconds = 10 seconds

    const yearSelector = document.getElementById('yearSelector');
    yearSelector.addEventListener('change', function() {
        const selectedYear = yearSelector.value;
        create_past_charts(selectedYear);
    });

    function create_past_charts(selectedYear){
        axios.get(`/api/pastMonthsData?year=${selectedYear}`)
            .then(response => {
                // Render past months data chart
                
                renderPastMonthsChart(response.data);
            })
            .catch(error => {
                console.error('Error fetching past months data', error);
            });
    }

    function timeSerieschartchange(){
        axios.get('/api/timeSeriesData')
        .then(response => {
            // Render time series chart
            renderTimeSeriesChart(response.data);
        })
        .catch(error => {
            console.error('Error fetching time series data', error);
        });
    }
    timeSerieschartchange();
    setInterval(timeSerieschartchange, 10000); // 10000 milliseconds = 10 seconds

    // Function to render the current flood level chart
    function renderFloodLevelChart(data) {
        if(floodLevelchart){
            floodLevelchart.destroy();
        }
        floodLevelchart = new Chart(document.getElementById('floodChart'), {
            type: 'bar',
            data: {
                labels: [data.location],
                datasets: [{
                    label: 'Current Flood Level',
                    data: [data.current_level],
                    backgroundColor: getBackgroundColor(data.current_level),
                    borderColor: getBorderColor(data.current_level),
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        suggestedMin: 0, // Set the minimum value for the y-axis
                        suggestedMax: 6, // Set the maximum value for the y-axis
                        ticks: {
                            callback: function (value, index, values) {
                                return value + ' ft'; // Add "feet" to the label
                            }
                        }
                    }
                },
                maintainAspectRatio: false,
                animation: {
                    duration: 1000, // Set the animation duration (in milliseconds)
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top', // Set the legend position to 'bottom'
                        labels: {
                            generateLabels: function (chart) {
                                return [
                                {
                                    text: 'High Risk Level',
                                    fillStyle: 'red'
                                },
                                {
                                    text: 'Medium Risk Level',
                                    fillStyle: 'orange'
                                },
                                {
                                    text: 'Low Risk Level',
                                    fillStyle: 'green'
                                }
                            
                            ];
                            }
                        }
                    }
                }
            }
        });
    }

    function getBackgroundColor(level) {
        
        if (level >= 0 && level <= 2) {
            return 'rgba(75, 192, 192, 0.5)';
        } else if (level >= 3 && level <= 4) {
            return 'rgba(255, 159, 64, 0.5)';
        } else if (level >= 5 && level <= 6) {
            return 'rgba(255, 99, 132, 0.5)';
        }
    }
    
    function getBorderColor(level) {
        if (level >= 0 && level <= 2) {
            return 'rgba(75, 192, 192, 1)';
        } else if (level >= 3 && level <= 4) {
            return 'rgba(255, 159, 64, 1)';
        } else if (level >= 5 && level <= 6) {
            return 'rgba(255, 99, 132, 1)';
        }
    }

    // Function to render the past months data chart
    function renderPastMonthsChart(data1) { 
        if(pastMonthChart){
            pastMonthChart.destroy();
        }
        const down = (ctx, value) => {
            if (ctx.p0.parsed.y >= 0 && ctx.p0.parsed.y<= 2) {
                return "green";
            } else if (ctx.p0.parsed.y >= 3 && ctx.p0.parsed.y <= 4) {
                return "orange";
            } else if (ctx.p0.parsed.y >= 5 && ctx.p0.parsed.y <= 6) {
                return "red";
            }
            return undefined;
        };
        const timeSeries = data1.data;
        const colors = timeSeries.map((value, index) => {
            try {
                if (index < timeSeries.length) {
                    const diff = timeSeries[index][1];
                    if (diff >= 0 && diff <= 2) {
                        return 'green';
                    } else if (diff >= 3 && diff <= 4) {
                        return 'orange';
                    } else if (diff >= 5 && diff <= 6) {
                        return 'red';
                    }
                }
            } catch (error) {
                
            }
            
            return 'blue'; // Fallback color for the last point
        });
        pastMonthChart = new Chart(document.getElementById('pastmonthCharts'), {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: `Flood Levels for ${data1.year}`,
                    data: data1.data,
                    backgroundColor: colors,
                    segment: {
                        borderColor: pastMonthChart => down(pastMonthChart, 'rgb(255,75,75)'),
                        
                      },
                    tension: 0.1
                }]
            },
            options: {
                
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                maintainAspectRatio: false,
                animation: {
                    duration: 1000, // Set the animation duration (in milliseconds)
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top', // Set the legend position to 'bottom'
                        labels: {
                            generateLabels: function (chart) {
                                return [
                                {
                                    text: 'High Risk Level',
                                    fillStyle: 'red'
                                },
                                {
                                    text: 'Medium Risk Level',
                                    fillStyle: 'orange'
                                },
                                {
                                    text: 'Low Risk Level',
                                    fillStyle: 'green'
                                }
                            
                            ];
                            }
                        }
                    }
                }
                
            }
        });
        
        
    }
    

    // Function to render the time series chart
    function renderTimeSeriesChart(data) {
        if (timechart){
            timechart.destroy();
        }
        const timeSeries = data.time_series;
        const colors = timeSeries.map((value, index) => {
            try {
                if (index < timeSeries.length) {
                    const diff = timeSeries[index][1];
                    if (diff >= 0 && diff <= 2) {
                        return 'green';
                    } else if (diff >= 3 && diff <= 4) {
                        return 'orange';
                    } else if (diff >= 5 && diff <= 6) {
                        return 'red';
                    }
                }
            } catch (error) {
                
            }
            
            return 'blue'; // Fallback color for the last point
        });
        const ctx =document.getElementById('timeSeriesChart');
        const skipped = (ctx, value) => ctx.p0.skip || ctx.p1.skip ? value : undefined;
        const down = (ctx, value) => {
            if (ctx.p0.parsed.y >= 0 && ctx.p0.parsed.y<= 2) {
                return "green";
            } else if (ctx.p0.parsed.y >= 3 && ctx.p0.parsed.y <= 4) {
                return "orange";
            } else if (ctx.p0.parsed.y >= 5 && ctx.p0.parsed.y <= 6) {
                return "red";
            }
            return undefined;
        };
        const dates = data.time_series.map((item) => {
            return item[2];
          });
        timechart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: dates,
                datasets: [{
                    label: 'Time Series Data',
                    data: data.time_series,
                    backgroundColor: colors,
                    segment: {
                        borderColor: ctx => down(ctx, 'rgb(255,75,75)'),
                        
                      },
                    tension: 0.1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                maintainAspectRatio: false,
                animation: {
                    duration: 1000, // Set the animation duration (in milliseconds)
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top', // Set the legend position to 'bottom'
                        labels: {
                            generateLabels: function (chart) {
                                return [
                                {
                                    text: 'High Risk Level',
                                    fillStyle: 'red'
                                },
                                {
                                    text: 'Medium Risk Level',
                                    fillStyle: 'orange'
                                },
                                {
                                    text: 'Low Risk Level',
                                    fillStyle: 'green'
                                }
                            
                            ];
                            }
                        }
                    }
                }
            }
        });
    }
});
