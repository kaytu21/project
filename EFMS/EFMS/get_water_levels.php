<?php
header('Content-Type: application/json');

include_once('db.php');


$sql = "SELECT date, water_level FROM level WHERE YEAR(date) >= YEAR(CURRENT_DATE)";
$result = $conn->query($sql);

$data = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
} else {
    echo "0 results";
}

$conn->close();

echo json_encode($data);
?>