<?php
// index.php
header("Content-Type: application/json; charset=UTF-8");
require 'db.php'; // Include the database connection

// Check if the request method is GET
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Fetch all persons from the database
    $stmt = $pdo->query("SELECT * FROM persons");
    $persons = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Return the data as JSON
    echo json_encode($persons);
} else {
    // Return a 405 Method Not Allowed response
    http_response_code(405);
    echo json_encode(["message" => "Method not allowed"]);
}
?>
