<?php
// Include database connection
include('connect_db.php');

// Secure signup with prepared statements
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['new-username']) && !empty($_POST['email']) && !empty($_POST['new-password'])) {
        $username = $_POST['new-username'];
        $email = $_POST['email'];
        $password = password_hash($_POST['new-password'], PASSWORD_BCRYPT);

        // Check if username or email already exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            echo json_encode(["status" => "error", "message" => "Username or Email already exists"]);
        } else {
            $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $email, $password);
            if ($stmt->execute()) {
                echo json_encode(["status" => "success", "message" => "User registered successfully"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Database error"]);
            }
        }
        $stmt->close();
    } else {
        echo json_encode(["status" => "error", "message" => "All fields are required"]);
    }
}
$conn->close();

?>
