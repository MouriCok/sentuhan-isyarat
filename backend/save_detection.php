<?php
$conn = new mysqli("localhost", "root", "", "sign_language_db");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sign = $_POST['sign'];
    $confidence = $_POST['confidence'];

    $sql = "INSERT INTO detections (sign, confidence, timestamp) 
            VALUES ('$sign', '$confidence', NOW())";

    if ($conn->query($sql) === TRUE) {
        echo "Record saved successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>
