<?php
$servername = "localhost";  // replace with your database server name
$username = "Dhairya";         // replace with your database username
$password = "dhairya#122";             // replace with your database password
$dbname = "new";        // replace with your database name

// Create connection to MySQL
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the file was uploaded
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['csvFile']) && $_FILES['csvFile']['error'] == 0) {
        $fileTmpPath = $_FILES['csvFile']['tmp_name'];
        $fileName = $_FILES['csvFile']['name'];
        $fileSize = $_FILES['csvFile']['size'];
        $fileType = $_FILES['csvFile']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Verify file extension
        $allowedExtensions = array('csv');
        if (in_array($fileExtension, $allowedExtensions)) {
            // Open the file and read its contents
            if (($file = fopen($fileTmpPath, 'r')) !== FALSE) {
                // Skip the first row if it contains column headers
                fgetcsv($file, 1000, ',');

                // Loop through the file and insert data into the database
                while (($data = fgetcsv($file, 1000, ',')) !== FALSE) {
                    // Prepare the data array with nulls for missing columns
                    $data = array_pad($data, 11, null);

                    // Escape data for security
                    $escapedData = array_map([$conn, 'real_escape_string'], $data);

                    // Insert data into the table
                    $sql = "INSERT INTO teachers(name,cno) 
                            VALUES ('$escapedData[0]', '$escapedData[1]')";
                    if (!$conn->query($sql)) {
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }
                }
                fclose($file);
                echo "File is successfully uploaded and data is inserted into the database.";
            } else {
                echo "Error opening the uploaded file.";
            }
        } else {
            echo "Upload failed. Only CSV files are allowed.";
        }
    } else {
        echo "No file uploaded or there was an upload error.";
    }
} else {
    echo "Invalid request method.";
}

// Close the MySQL connection
$conn->close();
?>

