 <!-- PHP connection for Bar Graph Showing the Months Highest Water level Detected -->
 <?php
        include_once('db.php');

        // Initialize variables
        $currentYear = date("Y"); // Get the current year
        $selectedYear = $currentYear; // Set the default selected year
        $noDataMessage = "";

        // Check if a year has been selected in the form
        if (isset($_POST['year'])) {
            $selectedYear = $_POST['year'];
        }
        ?>
        
        <?php

        // Prepare SQL query
        $sql = "SELECT MONTH(date) as month, MAX(water_level) as max_water_level
                FROM level
                WHERE YEAR(date) = ?
                GROUP BY MONTH(date)";

        // Prepare statement
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $selectedYear);

        // Execute statement
        $stmt->execute();

        // Bind result variables
        $stmt->bind_result($month, $max_water_level);

        // Fetch data and create data array for the chart
        $data = array();
        $monthNames = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");

        while ($stmt->fetch()) {
            $monthName = $monthNames[$month - 1]; // Get the month name
            $data[] = array($monthName, $max_water_level);
        }

        // Close statement and connection
        $stmt->close();
        $conn->close();

        // Check if there's no data for the selected year
        if (empty($data)) {
            $noDataMessage = "No data available for the selected year.";
        }
        ?>
<!--  End of PHP connection for Bar Graph Showing the Months Highest Water level Detected -->

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Phone</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script type='text/javascript' src='https://www.gstatic.com/charts/loader.js'></script>
        <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
        <script type='text/javascript'></script>
        <script src="main.js"></script>

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
                flex-direction: column; /* Center content vertically */
                overflow-y: scroll; /* Enable vertical scrolling */
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
                padding: 10px;
                margin-right: 10px;
            }

            /* Sidebar styles */
            .sidebar {
                width: 250px; /* Increased width */
                background-color: #97C7ED;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
                z-index: 1;
                position: fixed;
                top: 0;
                left: -250px; /* Start with the sidebar closed */
                height: 100%;
                overflow-y: auto;
                padding-top: 20px;
                transition: left 0.3s ease-in-out; /* Added transition */
            }

            /* Show the sidebar when the 'show' class is added */
            .sidebar.show {
                left: 0;
            }

            .sidebar a {
                display: flex;
                align-items: center;
                padding: 20px; /* Increased padding */
                text-decoration: none;
                color: black;
                transition: background-color 0.3s ease;
                font-size: 15px; /* Increased font size */
                justify-content: center; /* Center text horizontally */
            }

            .sidebar a:hover {
                background-color: #555;
            }

            .sidebar i {
                margin-right: 10px;
                font-size: 24px; /* Increased icon size */
            }


            /* Button to open/close the sidebar */
            .open-btn {
                position: absolute;
                top: 20px;
                left: 20px;
                cursor: pointer;
                z-index: 2;
                font-size: 24px; /* Increased button size */
            }

            footer {
                background-color: #333;
                color: white;
                text-align: center;
                padding: 10px 10px;
                bottom: 0;
                width: 100%;
                position: absolute
                
            }
            .graph-container {
                width: 400px;
                height: 420px;  
                position: left;
                border: 2px solid black; 
                padding: 20px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
                border: 1px solid #ccc;
                border-radius: 5px;
                margin-left: 20px;
                margin-right: 150px;
            }
        
        

        </style>
    </head>
    <body>
    <header>
            <h1>Early Flood Monitoring System</h1>
            <img src="your-logo.png" alt="Logo" width="100">
    </header>

        <!-- Container for sidebar and content -->
        <div class="container">
            <!-- Sidebar -->
            <div class="sidebar" id="sidebar">
                <a href="dashboard.php"><i class="fas fa-home"></i> Home</a>
                <a href="history.php"><i class="fas fa-info-circle"></i>History</a>
                <a href="phone.php"><i class="fas fa-plus"></i>Add Phone Number</a>
                <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>

            <!-- Button to open/close the sidebar -->
            <div class="open-btn" id="open-btn">
                <span>&#9776;</span>
            </div>
            </div>
        <div class="container">
        <div style="width: 550px; font-size: 20px; text-align: center;  font-weight: bold; padding: 20px; background-color: #007bff;  border: 1px solid #ccc; border-radius: 5px; ">
        
        <!--  Form to select the year -->
        <form method="POST" action="">
            <label for="year">Select Year:</label>
            <select name="year" id="year">
            <?php
            error_reporting(E_ALL & ~E_NOTICE); // Disable notices for the chart error
            
            // Generate options for the dropdown (e.g., from the current year to the upcoming year)
            $currentYear = date("Y");
            $upcomingYear = $currentYear + 5; // Calculate the upcoming year
            $noDataMessage = ''; // Initialize the variable to an empty string
            for ($y = $currentYear; $y <= $upcomingYear; $y++) {
                // Set the selected attribute for the current year
                $selected = ($y == $selectedYear) ? "selected" : "";
                echo "<option value=\"$y\" $selected>$y</option>";
            }
            ?>
            </select>
            <input type="submit" value="Submit">
            </form>
            <!-- End of Form to select the year -->
            
            <!--Bar Chart -->
            <div id='chart_div'></div>
            <?php
            // Display the "No data" message if applicable
            if (!empty($noDataMessage)) {
                echo "<p>$noDataMessage</p>";
            }
            ?>
            
        </div>
        <br>
        <!--Spline Chart -->
        <div style="width: 550px; font-size: 20px; text-align: center;  font-weight: bold; padding: 0px;" id="graph" class="graph-container"></div>
        <!--End of Spline Chart -->

        </div>
        </div>

        <!-- Footer Content -->
        <footer>
            <p>&copy; 2023 BSIT - 4A</p>
        </footer>
        <!-- End of Footer Content -->

        </div>

           <!-- Script for the Bar Graph -->
           <script type='text/javascript'>
            google.charts.load('current', {'packages':['corechart']});
            google.charts.setOnLoadCallback(drawChart);
            function drawChart() {
            var data = google.visualization.arrayToDataTable([
                ['Month', 'Water Level (m)', {role: 'style'}],
                <?php
                // Add data to the chart with colors based on water level ranges
                foreach ($data as $row) {
                    $waterLevel = $row[1];
                    $color = '';
                    if ($waterLevel >= 0 && $waterLevel <= 1.4) {
                        $color = 'blue';
                    } elseif ($waterLevel >= 1.5 && $waterLevel <= 2.4) {
                        $color = 'green';
                    } else {
                        $color = 'red';
                    }
                    echo "['" . $row[0] . "', " . $waterLevel . ", '" . $color . "'],";
                }
                ?>
            ]);
            var options = {
                'title': 'Max Water Level by Month for <?php echo $selectedYear; ?>', // Display the selected year in the chart title
                'width': 500,
                'height': 300,
                'legend': 'none' // Hide the legend
            };
            var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
            chart.draw(data, options);
        }
        </script>
    <!-- End of Script for the Bar Graph -->

    <!-- Sidebar Script -->
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
        <!-- End of Sidebar Script -->

</body>
</html>