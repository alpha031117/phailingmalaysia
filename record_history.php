<?php
session_start();
if (!isset($_SESSION['user_name'])) {
    header("Location: login.php");
    exit();
}

include 'config.php';

// Pagination logic remains the same
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = 5; 
$offset = ($page - 1) * $perPage;

$totalResult = $conn->query("
    SELECT DISTINCT created_at 
    FROM hazards 
    WHERE user_name = '{$_SESSION['user_name']}' 
    ORDER BY created_at DESC
");
$totalSubmissions = $totalResult->num_rows;
$totalPages = ceil($totalSubmissions / $perPage);

$submissionTimes = [];
$totalResult->data_seek($offset);
for ($i = 0; $i < $perPage && $row = $totalResult->fetch_assoc(); $i++) {
    $submissionTimes[] = $row['created_at'];
}

$records = [];
if (!empty($submissionTimes)) {
    $timesInClause = "'" . implode("','", $submissionTimes) . "'";
    $result = $conn->query("
        SELECT * 
        FROM hazards 
        WHERE user_name = '{$_SESSION['user_name']}' AND created_at IN ($timesInClause)
        ORDER BY created_at DESC, staff_name, position, activity_category
    ");

    while ($row = $result->fetch_assoc()) {
        $records[$row['created_at']][] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Record History</title>
    <link rel="stylesheet" href="assets/nav.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .submission-group-0 { background-color: #f9f9f9; }
        .submission-group-1 { background-color: #e9f7fc; }
        body {
            background-color: #f5f5f5;
        }
        .container {
            max-width: 90%;
        }
        table {
            background-color: #ffffff;
            margin: 20px auto;
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            text-align: center;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-info">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item"><a class="nav-link" href="form.php">New Record</a></li>
            <li class="nav-item"><a class="nav-link" href="form.php" style="color: #146a8c; background: #81aedb; border-radius: 5px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.15); color: black;">Record History</a></li>
            <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
        </ul>
    </div>
</nav>

<div class="container mt-5">
    <h2 class="text-center mb-4">Submitted Risk Assessments</h2>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>No</th>
            <th>Staff/Riders' Name</th>
            <th>Position</th>
            <th>Activity Category</th>
            <th>Hazard</th>
            <th>Causes leading to Hazards</th>
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
        <?php
        $groupIndex = 0;
        $submissionNo = $offset + 1;
        foreach ($records as $submissionTime => $group) {
            $rowspan = count($group);
            $rowClass = "submission-group-" . ($groupIndex % 2);
            $firstRow = true;

            foreach ($group as $row) {
                echo "<tr class='$rowClass'>";

                if ($firstRow) {
                    echo "<td rowspan='$rowspan'>$submissionNo</td>";
                    echo "<td rowspan='$rowspan'>" . htmlspecialchars($row['staff_name']) . "</td>";
                    echo "<td rowspan='$rowspan'>" . htmlspecialchars($row['position']) . "</td>";
                    $firstRow = false;
                }

                echo "<td>" . htmlspecialchars($row['activity_category']) . "</td>";
                echo "<td>" . htmlspecialchars($row['hazard_category']) . "</td>";
                echo "<td>" . htmlspecialchars($row['hazard']) . "</td>";
                echo "<td>" . htmlspecialchars($row['likelihood']) . "</td>";
                echo "<td>" . htmlspecialchars($row['severity']) . "</td>";
                echo "<td>" . htmlspecialchars($row['risk_level']) . "</td>";
                echo "<td>";
                $controlMeasures = explode(',', $row['control_measures']);
                echo "<ol>";
                foreach ($controlMeasures as $measure) {
                    echo "<li>" . htmlspecialchars(trim($measure)) . "</li>";
                }
                echo "</ol>";
                echo "</td>";

                echo "<td><textarea class='action' data-id='" . $row['id'] . "'>" . 
                (isset($row['action']) ? htmlspecialchars($row['action']) : '') . 
                "</textarea></td>";
            
            echo "<td><textarea class='existing-control-measures' data-id='" . $row['id'] . "'>" . 
                (isset($row['existing_control_measures']) ? htmlspecialchars($row['existing_control_measures']) : '') . 
                "</textarea></td>";
            


                $submittedDate = date("d-m-Y", strtotime($row['created_at']));
                $submittedTime = date("g:i A", strtotime($row['created_at']));
                echo "<td>$submittedDate<br>$submittedTime</td>";

                echo "</tr>";
            }

            $groupIndex++;
            $submissionNo++;
        }
        ?>
        </tbody>
    </table>

    <nav>
        <ul class="pagination justify-content-center">
            <?php if ($page > 1): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?php echo $page - 1; ?>">&laquo;</a>
                </li>
            <?php endif; ?>
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>
            <?php if ($page < $totalPages): ?>
                <li class="page-item">
                    <a class="page-link" href="?page=<?php echo $page + 1; ?>">&raquo;</a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>

    <button id="print-all-records" class="btn btn-primary mb-3">Print All Records</button>

</div>

<script>
    $(document).ready(function () {
        $('.action, .existing-control-measures').on('change', function () {
            const id = $(this).data('id');
            const field = $(this).hasClass('action') ? 'action' : 'existing_control_measures';
            const value = $(this).val();

            $.ajax({
                url: 'update_record.php',
                type: 'POST',
                data: { id, field, value },
                success: function (response) {
                    Swal.fire('Success', 'Record updated successfully!', 'success');
                },
                error: function () {
                    Swal.fire('Error', 'Failed to update record.', 'error');
                }
            });
        });
    });
    $(document).ready(function () {
        $('#print-all-records').on('click', function () {
            $.ajax({
                url: 'fetch_all_records.php',
                type: 'GET',
                success: function (data) {
                    const printWindow = window.open('', '', 'width=800,height=600');
                    printWindow.document.write('<html><head><title>All Records</title>');
                    printWindow.document.write('<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">');
                    printWindow.document.write('<style>.submission-group-0 { background-color: #f9f9f9; } .submission-group-1 { background-color: #e9f7fc; }</style>');
                    printWindow.document.write('</head><body>');
                    printWindow.document.write('<h2>All Submitted Risk Assessments</h2>');
                    printWindow.document.write(data);
                    printWindow.document.write('</body></html>');
                    printWindow.document.close();
                    printWindow.print();
                },
                error: function () {
                    Swal.fire('Error', 'Failed to fetch records for printing.', 'error');
                }
            });
        });
    });
</script>

</body>
</html>
