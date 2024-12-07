<?php
session_start();
if (!isset($_SESSION['user_name'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['assessment']['staff_name'] = $_POST['name'] ?? $_SESSION['assessment']['staff_name'];
    $_SESSION['assessment']['position'] = $_POST['position'] ?? $_SESSION['assessment']['position'];
    $_SESSION['assessment']['hazards'] = $_POST['hazards'] ?? $_SESSION['assessment']['hazards'];
}

$selectedHazards = $_SESSION['assessment']['hazards'] ?? [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Risk Assessment</title>
    <link rel="stylesheet" href="/nav.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .container {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-top: 30px;
        }

        h4, h5 {
            color: #007bff;
        }

        h2 {
            font-weight: bold;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
            margin-bottom: 30px;
            
        }

        h4 {
            margin-top: 40px;
            font-weight: bold;
        }

        h5 {
            margin-top: 10px;
            font-weight: 600;
            color: #555;
        }

        /* Form */
        .form-group label {
            font-weight: bold;
            color: #555;
        }

        .form-control {
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 10px;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        .form-check-input {
            margin-top: 7px;
        }

        .form-check-label {
            margin-left: 10px;
            font-size: 0.95rem;
        }

        .form-group {
            margin-bottom: 20px;
            padding: 15px;
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .form-group div {
            margin-top: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-group label {
            font-weight: bold;
            color: #333;
        }

        .form-group span {
            display: inline-block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }

        .btn-secondary {
            background-color: #007bff;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            font-size: 1rem;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        .btn-secondary:hover {
            background-color: #0056b3;
        }

        button.btn-success {
            background-color: #28a745;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            font-size: 1rem;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        button.btn-success:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-info">
    <!-- <a class="navbar-brand" href="#">P-Hailing Risk Tool</a> -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item"><a class="nav-link" href="form.php" style="color: #146a8c; background: #81aedb; border-radius: 5px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.15); color: black;">New Record</a></li>
            <li class="nav-item"><a class="nav-link" href="record_history.php">Record History</a></li>
            <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
        </ul>
    </div>
</nav>
<div class="container mt-5">
    <h2>Risk Assessment</h2>
    <form action="save_assessment.php" method="post">
        <?php foreach ($selectedHazards as $activity => $categories): ?>
            <h4><?php echo htmlspecialchars($activity); ?></h4>
            <?php foreach ($categories as $hazardCategory => $items): ?>
                <h5><?php echo htmlspecialchars($hazardCategory); ?></h5>
                <?php foreach ($items as $hazardItem): ?>
                    <div class="form-group">
                        <label><?php echo htmlspecialchars($hazardItem); ?></label><br/>
                        <!-- <div> -->
                            <span>Likelihood:</span>
                            <input type="number" name="likelihood[<?php echo htmlspecialchars($activity); ?>][<?php echo htmlspecialchars($hazardCategory); ?>][<?php echo htmlspecialchars($hazardItem); ?>]" min="1" max="5" required>
                            <!-- </div> -->
                            <!-- <div> -->
                            &nbsp;&nbsp;
                            <span>Severity:</span>
                            <input type="number" name="severity[<?php echo htmlspecialchars($activity); ?>][<?php echo htmlspecialchars($hazardCategory); ?>][<?php echo htmlspecialchars($hazardItem); ?>]" min="1" max="5" required>
                        <!-- </div> -->
                    </div>
                <?php endforeach; ?>
            <?php endforeach; ?>
        <?php endforeach; ?>
        <div class="mt-3"><br/>
            <a href="form.php" class="btn btn-secondary">Prev</a>
            <button type="submit" class="btn btn-success">Submit</button>
        </div><br/><br/>
    </form>
</div>
</body>
</html>
