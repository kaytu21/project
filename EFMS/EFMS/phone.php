<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phone</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <script deref src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script deref src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script deref src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script>
  $(document).ready(function () {
            $('#example').dataTable();
        });
</script>
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
            align-items: center; /* Center content horizontally */
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
            padding: 10px 0;
            bottom: 0;
            width: 100%;
            position: absolute;
        }
       
        .containers {
            width: 300px;
            border: 2px solid black; 
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-left: 30px; 
            height: 400px;
        
        }
        .form-group {
            text-align: center;
            margin-bottom: 15px;
        }

        label {
            display: block;
            font-weight: bold;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="number"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        } 

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;

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

        <div class="containers">
        <div class="content-left">
        <h4 style="font-size: 20px; text-align: center;  font-weight: bold; padding: 10px; background-color: #007bff;  border: 1px solid #ccc; border-radius: 5px; ">Add Phone Number</h4>
       <br>
        <form action="add_number.php" method="POST">
        <div class="form-group">
                <label style="text-align: left;" for="name">Full Name:</label>
                <input type="text" id="name" name="name" required>
        </div>
        <div class="form-group">
                <label style="text-align: left;" for="number">Phone Number:</label>
                <input type="number" id="number" name="number" required>
        </div>
        <div class="form-group">
        <input type="submit" name="Add" value="Add">
        </div>
        </form>
        </div>
        </div>

<!-- Table -->
    <div class="content-right">
    <div style="width: 600px;  border: 2px solid black; padding: 20px;  box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);  border: 1px solid #ccc;
            border-radius: 5px; margin-left: 20px; margin-right: 50px; ">
    <table id="example" class="table table-striped" style="width:100%">
    <thead>
        <tr>
        <th>Fullname</th>
        <th>Phone Number</th>
        <th>Action</th>
        </tr>
    </thead>
        <tbody>
        <?php
        include_once("db.php");
        $sqlResult = mysqli_query($conn, "SELECT * FROM phonenumber");
        while ($row = mysqli_fetch_assoc($sqlResult)) {
        ?>
        
         <tr>
        <td><?= $row["name"] ?></td>
        <td><?= $row["number"] ?></td>
        <td style="text-align: center;">
        <a href="delete.php?id=<?= $row["id"] ?>" class="btn btn-danger" title="Delete" data-toggle="tooltip">
        <span class="fa fa-trash"></span> </a>
        <button class="btn btn-warning" data-toggle="modal" type="button" data-target="#update_modal<?php echo $fetch['id']?>"><span class="fa fa-edit"></span> </a></button>
        </td>
         </tr>
         <?php 
        include 'update_user.php';
        } 
        ?>
        </tbody>
    </table>
    </div>
    </div>
    </div>
    <footer>
        <p>&copy; 2023 BSIT - 4A</p>
    </footer>
</div>

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
    <script>

        
    </script>

</body>
</html>