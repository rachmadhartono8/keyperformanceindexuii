<?php

// Check if a file was uploaded
if ($_FILES["file"]["error"] == UPLOAD_ERR_OK) {
    // File information
    $filename = $_FILES["file"]["name"];
    $temp_path = $_FILES["file"]["tmp_name"];

    // Move the uploaded file to a permanent location
    $upload_path = "uploads/" . $filename;
    move_uploaded_file($temp_path, $upload_path);

    // Save the file information to the database
    $dbHost = "localhost";
    $dbUser = "root";
    $dbPass = "";
    $dbName = "keyperformance";

    $conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert the file information into the database
    $sql = "INSERT INTO files (filename, filepath) VALUES ('$filename', '$upload_path')";
    $conn->query($sql);

    $conn->close();

    // Respond with a success message
    echo json_encode(["status" => "success", "message" => "File uploaded successfully"]);
} else {
    // Respond with an error message
    echo json_encode(["status" => "error", "message" => "File upload failed"]);
}
// Output any PHP errors to the browser for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Your existing code...

// Debugging statements
echo "File information: " . json_encode($_FILES) . "\n";
echo "SQL query: " . $sql . "\n";

?>
