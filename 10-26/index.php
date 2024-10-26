<?php
header("Content-Type: application/json; charset=UTF-8");
require 'db.php'; // Include the database connection

// Handle GET requests
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $stmt = $pdo->query("SELECT * FROM persons");
    $persons = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($persons);
}

// Handle POST requests
elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the JSON data from the request body
    $data = json_decode(file_get_contents("php://input"), true);
    
    // Check if the required fields are present
    if (isset($data['name']) && isset($data['age'])) {
        $name = $data['name'];
        $age = $data['age'];

        // Prepare and execute the SQL statement to insert data
        $stmt = $pdo->prepare("INSERT INTO persons (name, age) VALUES (:name, :age)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':age', $age);

        if ($stmt->execute()) {
            // Return a success response
            http_response_code(201); // Created
            echo json_encode(["message" => "Person added successfully"]);
        } else {
            // Return an error response
            http_response_code(500); // Internal Server Error
            echo json_encode(["message" => "Failed to add person"]);
        }
    } else {
        // Return a bad request response
        http_response_code(400); // Bad Request
        echo json_encode(["message" => "Invalid input"]);
    }
} else {
    // Return a 405 Method Not Allowed response
    http_response_code(405);
    echo json_encode(["message" => "Method not allowed"]);
}
?>