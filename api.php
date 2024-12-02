<?php
// Database connection parameters
$servername = "localhost";
$username = "Dhairya";
$password = "dhairya#122";
$dbname = "new";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// SQL query to fetch data
$sql = "SELECT * FROM teachers";
$result = $conn->query($sql);

$data = array();
if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
} else {
    echo "0 results";
}



// Set headers and output JSON data
header('Content-Type: application/json');
json_encode($data);
echo json_encode($data);

// Close connection
$conn->close();
?>
