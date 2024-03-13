<?php
// Database connection details
$host = 'your_database_host';
$dbname = 'your_database_name';
$username = 'your_database_username';
$password = 'your_database_password';

// Create a PDO instance
try {
  $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  die("Connection failed: " . $e->getMessage());
}

// Handle the button details and insert into the database
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $buttonInfo = json_decode(file_get_contents('php://input'), true);

  // Prepare the SQL statement
  $stmt = $pdo->prepare("INSERT INTO button_details (button_name, button_shape, button_size_width, button_size_height, button_position_x, button_position_y) VALUES (?, ?, ?, ?, ?, ?)");

  // Bind parameters
  $stmt->bindParam(1, $buttonInfo['buttonName']);
  $stmt->bindParam(2, $buttonInfo['buttonShape']);
  $stmt->bindParam(3, $buttonInfo['buttonSizeWidth']);
  $stmt->bindParam(4, $buttonInfo['buttonSizeHeight']);
  $stmt->bindParam(5, $buttonInfo['buttonPositionX']);
  $stmt->bindParam(6, $buttonInfo['buttonPositionY']);

  // Execute the statement
  try {
    $stmt->execute();
    $response = ['success' => true, 'message' => 'Button details saved successfully'];
  } catch (PDOException $ex) {
    $response = ['success' => false, 'message' => 'Error saving button details: ' . $ex->getMessage()];
  }

  // Return the response
  header('Content-Type: application/json');
  echo json_encode($response);
}
