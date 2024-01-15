document.addEventListener("DOMContentLoaded", function() {
    // Fetch current flood level
    axios.get('/api/currentFloodLevel')
        .then(response => {
            // Update UI with current flood level data
            console.log(response.data);
        })
        .catch(error => {
            console.error('Error fetching current flood level', error);
        });

    // Fetch past months' data for the selected year
    const yearSelector = document.getElementById('yearSelector');
    const timeSeriesChart = document.getElementById('timeSeriesChart');
    const floodChart = document.getElementById('floodChart').getContext('2d');

    yearSelector.addEventListener('change', function() {
        const selectedYear = yearSelector.value;
        axios.get(`/api/pastMonthsData?year=${selectedYear}`)
            .then(response => {
                // Update bar chart with past months' data
                console.log(response.data);
            })
            .catch(error => {
                console.error('Error fetching past months data', error);
            });
    });

    // Fetch time series data
    axios.get('/api/timeSeriesData')
        .then(response => {
            // Update time series visualization with the data
            console.log(response.data);
        })
        .catch(error => {
            console.error('Error fetching time series data', error);
        });
});
