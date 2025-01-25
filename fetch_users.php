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

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $query = "SELECT id, username, password FROM users";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $users = [];
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
        echo json_encode(["success" => true, "users" => $users]);
    } else {
        echo json_encode(["success" => false, "message" => "No users found."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
}

$conn->close();
?>
