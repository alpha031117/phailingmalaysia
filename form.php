<?php
session_start();
if (!isset($_SESSION['user_name'])) {
    header("Location: login.php");
    exit();
}

include 'config.php';

$activityCategories = [
    "Activities: Pick Up/Deliver the orders to customers" => [
        "Stress" => [
            "Customer Complaints" => "Training, Feedback Mechanism, Emotional Support",
            "Sexual Harassment" => "Clear Policies, Reporting Mechanisms, Support Systems, Training",
            "Job Status Ambiguity" => "Clear Communication, Performance Feedback, Career Development Resources",
            "Economic Pressure" => "Fair Compensation, Benefits and Support, Expense Reimbursement"
        ],
        "Ergonomic Hazards" => [
            "Prolonged Riding" => "Ergonomic Seating, Regular Breaks, Physical Fitness Programs, Health Monitoring",
            "Overreaching" => "Regular Physical Therapy, Stretching Routines, Ergonomic Accessories"
        ],
        "Health Hazards" => [
            "Smoke from Other Vehicles" => "Personal Protective Equipments, Route Planning, Health Monitoring",
            "Direct Exposure to UV Rays" => "Personal Protective Equipments",
            "Fatigue" => "Regular Breaks, Ergonomic Seating, Hydration and Nutrition",
            "Eye Strain" => "Personal Protective Equipments, Regular Vehicle Maintenance, Ergonomic Accessories",
            "Exposure to Unidentified and Hazardous Packaging" => "Training"
        ],
        "Extreme Temperature" => [
            "Heat" => "Hydration, Heat Awareness Training, Personal Protective Equipments",
            "Heavy Rain" => "Waterproof Equipments, Cautious Riding Training, Weather Monitoring, Emergency Plans"
        ],
        "Other road-related issues" => [
            "Unmarked Road Humps" => "Route Familiarization, Speed Management, Reporting Mechanisms, Regular Vehicle Maintenance",
            "Sudden Appear of Animals" => "Defensive Riding Training, Community Signage, Awareness Campaigns, Regular Vehicle Maintenance"
        ],
        "Objects on Road" => [
            "Construction  Waste Bins" => "Location Awareness, Reporting Mechanism, Defensive Riding Training, Communication with Construction Sites",
            "Construction Materials" => "Location Awareness, Reporting Mechanism, Defensive Riding Training, Communication with Construction Sites",
            "Portable Traffic Barrier" => "Location Awareness, Reporting Mechanism, Defensive Riding Training, Communication with Construction Sites",
            "Sizable Debris" => "Reporting Mechanism, Defensive Riding Training"
        ],
        "Construction and maintenance works" => [  
            "Closure of Riding Lane and Shoulder" => "Route Planning and Communication, Training and Awareness, Collaboration with Local Authorities",
            "Dug out Adjacent Lane" => "Enhanced Safety Equipment, Technology and Navigation Aids, Incident Reporting, Regular Vehicle Maintenance"
        ],
        "Road Surface Issues" => [
            "Potholes" => "Real-Time Updates, Defensive Riding Training, Regular Maintenance, Personal Protective Equipments, Collaboration with Local Authorities",
            "Uneven Surface due to Poor Resurfacing Works" => "Real-Time Updates, Defensive Riding Training, Regular Maintenance, Personal Protective Equipments, Collaboration with Local Authorities",
            "Depression in Asphalt Surface" => "Real-Time Updates, Defensive Riding Training, Regular Maintenance, Personal Protective Equipments, Collaboration with Local Authorities",
            "Uneven Surface due to Manhole" => "Real-Time Updates, Defensive Riding Training, Regular Maintenance, Personal Protective Equipments, Collaboration with Local Authorities",
            "Leftover Concrete Mix" => "Real-Time Updates, Defensive Riding Training, Regular Maintenance, Personal Protective Equipments, Collaboration with Local Authorities",
            "A Sudden Change in Surface Types" => "Real-Time Updates, Defensive Riding Training, Regular Maintenance, Personal Protective Equipments, Collaboration with Local Authorities"
        ],    
        "Obstruction of View" => [
            "Parked Vehicles on the Roadside" => "Real-Time Updates, Defensive Riding Training, Collaboration with Authorities",
            "Obscured Unsignalised Junction" => "Real-Time Updates, DJunction Navigation Training, Collaboration with Authorities",
            "Hedges and Landscaping Greenery" => "Real-Time Updates, Defensive Riding Training, Collaboration with Authorities"
        ],
        "Pedestrians and cyclists" => [
            "Crossing at Undesignated Places (Jaywalking)" => "Rider Training, Navigation Alerts, Dashcam Installation, Feedback Mechanism, Collaboration with Authorities",
            "Obscured by Traffic" => "Navigation Alerts,Dashcam Installation,Feedback Mechanism,Collaboration with Authorities",
            "Waiting to Cross on the Roadside" => "Navigation Alerts,Dashcam Installation,Feedback Mechanism,Collaboration with Authorities",
            "On Pedestrian Crossing when P-hailers’ Have the Right of Way" => "Navigation Alerts,Dashcam Installation,Feedback Mechanism,Collaboration with Authorities", 
            "Utility Worker Working on the Roadside" => "Navigation Alerts,Dashcam Installation,Feedback Mechanism,Collaboration with Authorities",
            "Children on the Roadside" => "Navigation Alerts,Dashcam Installation,Feedback Mechanism,Collaboration with Authorities",
            "Walking on the Roadside Next to P-hailers" => "Navigation Alerts,Dashcam Installation,Feedback Mechanism,Collaboration with Authorities",
            "Bicyclist Encroached P-hailers’ Riding Path" => "Navigation Alerts,Dashcam Installation,Feedback Mechanism,Collaboration with Authorities"
        ],
        "P-hailers’ Riding Behaviours" => [
            "Unsafe Lane Filtering" => "Training Programs, Technology Integration, Strict Penalties, Reward System",
            "Not Stopping at Unsignalised Junction" => "Training Programs, Technology Integration, Strict Penalties, Reward System",
            "Riding on Pedestrian Facilities" => "Training Programs, Technology Integration, Strict Penalties, Reward System",
            "Riding Wrong Way" => "Training Programs, Technology Integration, Strict Penalties, Reward System",
            "Late Overtaking" => "Training Programs, Technology Integration, Strict Penalties, Reward System",
            "Close Following" => "Training Programs, Technology Integration, Strict Penalties, Reward System",
            "Illegal U-turn" => "Training Programs, Technology Integration, Strict Penalties, Reward System",
            "Unsafe Turning at Unsignalised Junction" => "Training Programs, Technology Integration, Strict Penalties, Reward System",
            "Distracted Riding" => "Training Programs, Technology Integration, Strict Penalties, Reward System",
            "Riding on Unpaved Shoulder" => "Training Programs, Technology Integration, Strict Penalties, Reward System",
            "Unsafe Lane Changing or Merging" => "Training Programs, Technology Integration, Strict Penalties, Reward System",
            "Not Stopping at Red Light" => "Training Programs, Technology Integration, Strict Penalties, Reward System",
            "Speeding" => "Training Programs, Technology Integration, Strict Penalties, Reward System"
        ],    
        "Driving/Riding Behaviors of Other Motorists" => [
            "Braking" => "Training Programs,Technology Integration,Feedback Mechanism",
            "Having Trajectory Crossing P-hailers' Trajectory" => "Collaboration with Authorities, Technology Integration, Feedback Mechanism",
            "Encroachment of P-hailers’ riding path" => "Training Programs, Technology Integration, Feedback Mechanism",
            "Unsafe Lane Changing or Merging" => "Technology Integration, Feedback Mechanism",
            "Reversing Towards P-hailers" => "Training Programs, Technology Integration, Feedback Mechanism",
            "Motorcycle Riding Wrong Way" => "Technology Integration, Feedback Mechanism",
            "Running Red Light" => "Training Programs, Technology Integration, Feedback Mechanism"
        ]    
    ],
    "Activities: Deal with customers' requirements" => [
        "Stress" => [
            "Customer Complaints" => "Training, Feedback Mechanism, Emotional Support",
            "Sexual Harassment" => "Clear Policies, Reporting Mechanisms, Support Systems, Training"
        ]
    ],
    "Activities: Sorting Shipment Activities (Scanning)" => [
        "Ergonomic Hazards" => [
            "Repetitive motion" => "Stretching Routines, Physical Fitness Programs, Health Monitoring"
        ],
        "Health Hazards" => [
            "Exposure to unidentified and hazardous packaging" => "Training"
        ]
    ]
];

$_SESSION['activity_categories'] = $activityCategories;

$name = $_SESSION['assessment']['staff_name'] ?? '';
$position = $_SESSION['assessment']['position'] ?? '';
$selectedHazards = $_SESSION['assessment']['hazards'] ?? [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Risk Assessment Form</title>
    <link rel="stylesheet" href="/assets/nav.css">
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
            margin-top: 20px;
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

        button.btn-primary {
            background-color: #007bff;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            font-size: 1rem;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        button.btn-primary:hover {
            background-color: #0056b3;
        }

        .pdf-btn {
            background-color: #007bff;
            color: white;
            font-size: 1rem;
            font-weight: bold;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            transition: background-color 0.3s;
            margin-top: -10px;
            margin-bottom: -35px;
            /* display: inline-block; */
        }

        .pdf-btn:hover {
            background-color: #0056b3;
            text-decoration: none;
            color: white;
        }

    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-info">
    <!-- <a class="navbar-brand" href="#">P-Hailing Risks Tool</a> -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item"><a class="nav-link" href="form.php" style="color: #146a8c; background: #81aedb; border-radius: 5px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.15); color: black;;">New Record</a></li>
            <li class="nav-item"><a class="nav-link" href="record_history.php">Record History</a></li>
            <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
        </ul>
    </div>
</nav>
<!-- 
<div class="d-flex justify-content-end">
    <a href="assets/manual.pdf" target="_blank" class="pdf-btn mt-3">User Manual</a><br/><br/> 
</div> -->

<div class="container mt-5">
    <div class="d-flex justify-content-end" style="margin-top: -20px;">
        <a href="assets/manual.pdf" target="_blank" class="pdf-btn mt-3">User Manual</a>
    </div>
    <h2>Hazard Identification</h2>
    
    <form action="process_form.php" method="post">
        <div class="form-group">
            <label for="name">Staff/Riders' Name:</label>
            <input type="text" name="name" id="name" class="form-control" value="<?php echo htmlspecialchars($name); ?>" required>
        </div>
        <div class="form-group">
            <label for="position">Position:</label>
            <input type="text" name="position" id="position" class="form-control" value="<?php echo htmlspecialchars($position); ?>" required>
        </div>
        <?php foreach ($activityCategories as $activity => $hazardCategories): ?>
            <br/>
            <h4><?php echo htmlspecialchars($activity); ?></h4>
            <?php foreach ($hazardCategories as $hazardCategory => $hazardItems): ?>
                <div>                    
                    <h5><?php echo htmlspecialchars($hazardCategory); ?></h5>
                    <?php foreach ($hazardItems as $hazardItem => $controlMeasures): ?>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="hazards[<?php echo htmlspecialchars($activity); ?>][<?php echo htmlspecialchars($hazardCategory); ?>][]" value="<?php echo htmlspecialchars($hazardItem); ?>" 
                                <?php if (isset($selectedHazards[$activity][$hazardCategory]) && in_array($hazardItem, $selectedHazards[$activity][$hazardCategory])) echo 'checked'; ?>>
                            <label class="form-check-label">
                                <?php echo htmlspecialchars($hazardItem); ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        <?php endforeach; ?><br/>
        <button type="submit" class="btn btn-primary mt-3">Next</button><br/><br/>
    </form>
</div>
</body>
</html>
