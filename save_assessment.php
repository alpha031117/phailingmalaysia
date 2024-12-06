<?php
session_start();
if (!isset($_SESSION['user_name'])) {
    header("Location: login.php");
    exit();
}

include 'config.php';

$userName = $_SESSION['user_name'];
$name = $_SESSION['assessment']['staff_name'];
$position = $_SESSION['assessment']['position'];
$selectedHazards = $_SESSION['assessment']['hazards'];

foreach ($selectedHazards as $activity => $categories) {
    foreach ($categories as $hazardCategory => $hazardItems) {
        foreach ($hazardItems as $hazardItem) {            
            $likelihood = $_POST['likelihood'][$activity][$hazardCategory][$hazardItem];
            $severity = $_POST['severity'][$activity][$hazardCategory][$hazardItem];
            $riskLevel = $likelihood * $severity;
            $controlMeasures = $_SESSION['activity_categories'][$activity][$hazardCategory][$hazardItem];

            $stmt = $conn->prepare("INSERT INTO hazards (staff_name, position, activity_category, hazard_category, hazard, likelihood, severity, risk_level, control_measures, user_name) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssiisss", $name, $position, $activity, $hazardCategory, $hazardItem, $likelihood, $severity, $riskLevel, $controlMeasures, $userName);
            $stmt->execute();
            $stmt->close();
        }
    }
}

$conn->close();
// Clear session data after submission
unset($_SESSION['assessment']);
unset($_SESSION['activity_categories']);
header("Location: record_history.php");
exit();
?>
