<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $field = $_POST['field'];
    $value = $_POST['value'];

    // Prevent SQL injection
    $id = $conn->real_escape_string($id);
    $field = $conn->real_escape_string($field);
    $value = $conn->real_escape_string($value);

    if (in_array($field, ['action', 'existing_control_measures'])) {
        $sql = "UPDATE hazards SET $field = '$value' WHERE id = $id";
        if ($conn->query($sql)) {
            echo "Success";
        } else {
            echo "Error: " . $conn->error;
        }
    }
}

$conn->close();
?>
