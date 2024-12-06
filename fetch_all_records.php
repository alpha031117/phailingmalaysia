<?php
session_start();
if (!isset($_SESSION['user_name'])) {
    header("Location: login.php");
    exit();
}

include 'config.php';

$userName = $_SESSION['user_name'];

// Fetch all records for the logged-in user
$result = $conn->query("
    SELECT * 
    FROM hazards 
    WHERE user_name = '{$userName}' 
    ORDER BY created_at DESC, staff_name, position, activity_category
");

$records = [];
while ($row = $result->fetch_assoc()) {
    $records[$row['created_at']][] = $row; // Group rows by created_at
}

$conn->close();

// Generate HTML for all records
$output = '<table class="table table-bordered">';
$output .= '
    <thead>
    <tr>
        <th>No</th>
        <th>Staff/Riders Name</th>
        <th>Position</th>
        <th>Activity Category</th>
        <th>Causes leading to Hazards</th>
        <th>Hazard</th>
        <th>Likelihood</th>
        <th>Severity</th>        
        <th>Risk Level</th>
        <th>Suggested Control Measures</th>
        <th>Action</th>
        <th>Existing Control Measures</th>
        <th>Submitted At</th>
    </tr>
    </thead>
    <tbody>
';

$groupIndex = 0;
$submissionNo = 1;

foreach ($records as $submissionTime => $group) {
    $rowspan = count($group);
    $firstRow = true;
    $rowClass = "submission-group-" . ($groupIndex % 2);

    foreach ($group as $row) {
        $output .= "<tr class='$rowClass'>";

        if ($firstRow) {
            $output .= "<td rowspan='$rowspan'>$submissionNo</td>";
            $output .= "<td rowspan='$rowspan'>" . htmlspecialchars($row['staff_name']) . "</td>";
            $output .= "<td rowspan='$rowspan'>" . htmlspecialchars($row['position']) . "</td>";
            $firstRow = false; // Prevent duplication for rowspan columns
        }

        // Each row includes the corresponding `activity_category`
        $output .= "<td>" . htmlspecialchars($row['activity_category']) . "</td>";
        $output .= "<td>" . htmlspecialchars($row['hazard_category']) . "</td>";
        $output .= "<td>" . htmlspecialchars($row['hazard']) . "</td>";
        $output .= "<td>" . htmlspecialchars($row['likelihood']) . "</td>";
        $output .= "<td>" . htmlspecialchars($row['severity']) . "</td>";        
        $output .= "<td>" . htmlspecialchars($row['risk_level']) . "</td>";

        // Display control measures as a list
        $controlMeasures = explode(',', $row['control_measures']);
        $output .= "<td>";
        if (!empty($controlMeasures)) {
            $output .= "<ol>";
            foreach ($controlMeasures as $measure) {
                $output .= "<li>" . htmlspecialchars(trim($measure)) . "</li>";
            }
            $output .= "</ol>";
        }
        $output .= "</td>";

        // Show action completed and completion date
        $output .= "<td>" . htmlspecialchars($row['action']) . "</td>";
        $output .= "<td>" . htmlspecialchars($row['existing_control_measures']) . "</td>";

        // Submitted at
        $output .= "<td>" . date("d-m-Y g:i A", strtotime($row['created_at'])) . "</td>";

        $output .= "</tr>";
    }

    $groupIndex++;
    $submissionNo++;
}

$output .= '</tbody></table>';

echo $output;
?>