<?php
header("Content-Type: application/json");

// Database connection
$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'logintrial';

$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Database connection failed."]));
}

// Retrieve the JSON payload
$data = json_decode(file_get_contents("php://input"), true);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $data['id'] ?? null;
    $username = $data['username'] ?? '';
    $password = $data['password'] ?? '';

    if (!$id || empty($username) || empty($password)) {
        echo json_encode(["success" => false, "message" => "All fields are required."]);
        exit;
    }

    // Update query
    $stmt = $conn->prepare("UPDATE users SET username = ?, password = ? WHERE id = ?");
    $stmt->bind_param("ssi", $username, $password, $id);
    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "User updated successfully."]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to update user."]);
    }
    $stmt->close();
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
}

$conn->close();
?>
