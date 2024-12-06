<?php
header('Content-Type: application/json');

include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $completion_date = $_POST['completion_date']; // Already in dd-mm-yyyy format

    // Convert to database-friendly format (if needed)
    // If your database stores it as dd-mm-yyyy, no conversion is needed.
    $date_parts = explode('-', $completion_date); // Split dd-mm-yyyy
    $db_date = "{$date_parts[2]}-{$date_parts[1]}-{$date_parts[0]}"; // yyyy-mm-dd

    $stmt = $conn->prepare("UPDATE hazards SET completion_date = ?, action_completed = 1 WHERE id = ?");
    $stmt->bind_param('si', $db_date, $id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $stmt->error]);
    }
    $stmt->close();
    $conn->close();
    exit();
}
