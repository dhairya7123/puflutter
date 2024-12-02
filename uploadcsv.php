<?php
    // Set the temporary file path
    $tmp_file = $_FILES['csv_file']['tmp_name'];

    // Move the file to a temporary location
    $target_file = 'uploads/' . basename($_FILES['csv_file']['name']);
    move_uploaded_file($tmp_file, $target_file);
    require 'upload.php'
?>