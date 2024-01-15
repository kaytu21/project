<?php
session_start();
if (!isset($_SESSION["admin_id"])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script type='text/javascript' src='https://www.gstatic.com/charts/loader.js'></script>
    <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
    <title>Dashboard</title>

    <!-- Add Google Charts library -->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <style>
         * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Body styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            display: flex;
            flex-direction: column; 
            align-items: center; 
            overflow-y: scroll; 
        }

        /* Header styles */
        header {
           
           background-color: #00A885;
           color: white;
           text-align: center;
           padding: 10px 0;
           width: 100%;
       } 
       h1 {
           font-weight: bold;
           background-image: linear-gradient(to right, #553c9a 45%, #ee4b2b);
           color: transparent;
           background-clip: text;
           -webkit-background-clip: text;
       }

        /* Container for sidebar and content */
        .container {
            display: flex;

        }

        /* Sidebar styles */
        .sidebar {
            width: 250px;
            background-color: #97C7ED;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            z-index: 1;
            position: fixed;
            top: 0;
            left: -250px; 
            height: 100%;
            overflow-y: auto;
            padding-top: 20px;
            transition: left 0.3s ease-in-out;
        }

        /* Show the sidebar when the 'show' class is added */
        .sidebar.show {
            left: 0;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            padding: 20px; 
            text-decoration: none;
            color: black;
            transition: background-color 0.3s ease;
            font-size: 15px;
            justify-content: center; 
        }

        .sidebar a:hover {
            background-color: #555;
        }

        .sidebar i {
            margin-right: 10px;
            font-size: 24px; 
        }

        /* Button to open/close the sidebar */
        .open-btn {
            position: absolute;
            top: 20px;
            left: 20px;
            cursor: pointer;
            z-index: 2;
            font-size: 24px;
        }

        /* Content area styles */
        .content {
            flex-grow: 1;
            padding: 20px;
            min-height: calc(100vh - 80px);
            display: flex;
            flex-direction: column;
            align-items: center; 
        }

        .chart-container {
            width: 100%;
            max-width: 2000px;
            background-color: white;
            padding: 20px; 
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3); 
            margin-bottom: 30px;
            margin-top: 30px;
            display: flex; 
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        /* Style for the chart itself */
        #chart_div {
            flex-grow: 1; 
            height: 450px; 
           
        }

        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 10px 0;
            bottom: 0;
            width: 100%;
        }

        /* Legend styles */
        .legend {
            width: 200px;
            background-color: #f0f0f0;
            padding: 10px;
            border: 1px solid #ccc;
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column; 
            align-items: center; 
        }

        .legend-item {
            display: flex;
            align-items: center;
            margin-top: 90px;
            margin-bottom: 5px;
        }

        .legend-color {
            width: 20px;
            height: 20px;
           
            margin-right: 10px;
            border: 1px solid #888;
        }

        /* Define different colors for the legend items */
        .legend-item.item1 .legend-color { background-color: #0000FF; }
        .legend-item.item2 .legend-color { background-color: #00ff00; }
        .legend-item.item3 .legend-color { background-color: #ff0000; }
    

        .legend-text {
            font-size: 14px;
        }
        .title{
            font-weight: bold;
            font-size: 40px;
            text-align: center;
            padding-top: 20px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <h1>Early Flood Monitoring System</h1>
        <img src="your-logo.png" alt="Logo" width="100">
    </header>

    <!-- Container for sidebar and content -->
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <a href="dashboard.php"><i class="fas fa-home"></i> Home</a>
            <a href="history.php"><i class="fas fa-info-circle"></i> History</a>
            <a href="phone.php"><i class="fas fa-plus"></i> Add Phone Number</a>
            <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>

        <!-- Button to open/close the sidebar -->
        <div class="open-btn" id="open-btn">
            <span>&#9776;</span>
        </div>

        <!-- Content area -->
        <div class="title">
        <p>Current Water Level</p>
        </div>
    </div>
        <div class="content">
            <div class="chart-container">
                <!-- Graph container -->
                <div id="chart_div"></div>
                <!-- Legend container -->
                <div class="legend">
                <h3>Level Description</h3>
                    <div class="legend-item item1">
                        <div class="legend-color"></div>
                        <div class="legend-text">Low Risk Water Level (0-1.4 meter)</div>
                    </div>
                    <div class="legend-item item2">
                        <div class="legend-color"></div>
                        <div class="legend-text">Medium Risk Water Level (1.5-2.5 meter)</div>
                    </div>
                    <div class="legend-item item3">
                        <div class="legend-color"></div>
                        <div class="legend-text">High Risk Water Level (2.5 above meter) </div>
                    </div>
                    <!-- Add more legend items as needed -->
                </div>
            </div>
        </div>
        
    </div>
    

    <footer>
        <p>&copy; 2023 BSIT - 4A</p>
    </footer>

    <?php
     // Step 1: Establish a database connection
     include_once('db.php');

     // Step 2: Fetch data from the database
     $query = "SELECT date, time, water_level FROM level";
     $result = $conn->query($query);
 
     // Step 3: Organize data into arrays
     $data = array();
     while ($row = $result->fetch_assoc()) {
         $datetime = $row['date'] . ' ' . $row['time']; // Combine date and time
         $waterLevel = (float)$row['water_level'];
 
         // Push data into the array
         $data[] = array(
             "datetime" => $datetime,
             "water_level" => $waterLevel
         );
     }

    ?>

    <!-- JavaScript for Google Charts -->
    <script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('datetime', 'Date and Time');
        data.addColumn('number', 'Water Level');
        data.addColumn({type: 'string', role: 'style'}); // Add a column for custom line colors

        // Populate the data table with water levels and colors
        <?php foreach ($data as $entry) { ?>
            var waterLevel = <?php echo $entry['water_level']; ?>;
            var color = getColorForWaterLevel(waterLevel); // Determine the color based on water level
            data.addRow([new Date("<?php echo $entry['datetime']; ?>"), waterLevel, color]);
        <?php } ?>

        var options = {
            title: 'Current Water Level',
            textStyle: {
                fontSize: 25,
                bold: true,
                textAlign: 'center',
            },
            curveType: 'function',
            legend: { position: 'none' },
            hAxis: {
                format: 'MMM dd, yyyy HH:mm'
            },
            vAxes: {
                0: {
                    title: 'Water Level (m)'
                }
            },
            backgroundColor: {
                fill: 'transparent'
            },
            series: {
                0: { areaOpacity: 0.2 }
            }
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));

        chart.draw(data, options);
    }

    // Function to determine line color based on water level
    function getColorForWaterLevel(waterLevel) {
        if (waterLevel > 2.5) {
            return 'red'; // Above 2.0 meters - Red
        } else if (waterLevel >= 1.5 && waterLevel <= 2.5) {
            return 'green'; // Between 1.0 and 2.0 meters - Green
        } else {
            return 'blue'; // Below 1.0 meters - Blue
        }
    }
</script>

    <!-- JavaScript to toggle the sidebar -->
    <script>
    var sidebar = document.getElementById('sidebar');
    var openBtn = document.getElementById('open-btn');
    var container = document.querySelector('.container');

        // Function to open the sidebar
        function openSidebar() {
            sidebar.classList.add('show');
        }

        // Function to close the sidebar
        function closeSidebar() {
            sidebar.classList.remove('show');
        }

        // Toggle the sidebar when the open button is clicked
        openBtn.addEventListener('click', function(event) {
            event.stopPropagation(); // Prevent the click from closing the sidebar immediately
            toggleSidebar();
        });

        // Close the sidebar if a click event occurs outside the sidebar or container
        document.addEventListener('click', function(event) {
            if (sidebar.classList.contains('show') && !sidebar.contains(event.target) && event.target !== openBtn) {
                closeSidebar();
            }
        });

        // Prevent clicks inside the sidebar from closing it
        sidebar.addEventListener('click', function(event) {
            event.stopPropagation();
        });

        // Prevent clicks inside the container from closing it
        container.addEventListener('click', function(event) {
            event.stopPropagation();
        });

        // Function to toggle the sidebar
        function toggleSidebar() {
            if (sidebar.classList.contains('show')) {
                closeSidebar();
            } else {
                openSidebar();
            }
        }

        // Initialize the sidebar as closed
        closeSidebar();

    </script>

</body>
</html>
