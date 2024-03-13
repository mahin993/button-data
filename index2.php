<?php
// Connect to the database using PDO
$dsn = 'mysql:host=localhost;dbname=your_database_name';
$username = 'your_username';
$password = 'your_password';

try {
    $pdo = new PDO($dsn, $username, $password);
} catch (PDOException $e) {
    die('Connection failed: ' . $e->getMessage());
}

// Handle the form data and insert or update in the database
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $employee_id = $_POST['employee_id'];
    // Retrieve other form fields in a similar manner

    // Check if data with the given employee_id already exists
    $stmt_check = $pdo->prepare("SELECT COUNT(*) FROM employees WHERE employee_id = ?");
    $stmt_check->bindParam(1, $employee_id);
    $stmt_check->execute();
    $data_count = $stmt_check->fetchColumn();

    if ($data_count > 0) {
        // Data exists, perform update
        $stmt_update = $pdo->prepare("UPDATE employees SET kojo_name = ?, phase_name = ?, equipment_name = ?, ordering_department = ?, oirderer = ?, remarks = ? WHERE employee_id = ?");
        // Bind other parameters

        $stmt_update->bindParam(1, $_POST['kojo_name']);
        $stmt_update->bindParam(2, $_POST['phase_name']);
        $stmt_update->bindParam(3, $_POST['equipment_name']);
        $stmt_update->bindParam(4, $_POST['ordering_department']);
        $stmt_update->bindParam(5, $_POST['oirderer']);
        $stmt_update->bindParam(6, $_POST['remarks']);
        $stmt_update->bindParam(7, $employee_id);

        $success = $stmt_update->execute();
    } else {
        // Data doesn't exist, perform insert
        $stmt_insert = $pdo->prepare("INSERT INTO employees (employee_id, kojo_name, phase_name, equipment_name, ordering_department, oirderer, remarks) VALUES (?, ?, ?, ?, ?, ?, ?)");
        // Bind other parameters

        $stmt_insert->bindParam(1, $employee_id);
        $stmt_insert->bindParam(2, $_POST['kojo_name']);
        $stmt_insert->bindParam(3, $_POST['phase_name']);
        $stmt_insert->bindParam(4, $_POST['equipment_name']);
        $stmt_insert->bindParam(5, $_POST['ordering_department']);
        $stmt_insert->bindParam(6, $_POST['oirderer']);
        $stmt_insert->bindParam(7, $_POST['remarks']);

        $success = $stmt_insert->execute();
    }

    if ($success) {
        // Return success message
        echo json_encode(['success' => true, 'message' => 'Data saved successfully']);
    } else {
        // Return error message
        echo json_encode(['success' => false, 'message' => 'Error saving data']);
    }
}













// fetch('save_employee.php', {
//     method: 'POST',
//     body: formData,
//   })
//     .then(response => response.json())
//     .then(data => {
//       console.log(data);
//       closeModal(); // Close the modal after successful save
//     })
//     .catch(error => {
//       console.error('Error:', error);
//     });
