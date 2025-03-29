<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = ""; // Default XAMPP password
$dbname = "mydatabase";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (empty($weeklyGoals)) {
    echo "Error: Weekly goals are missing.";
    exit;
}

if (!$scheduleData || !is_array($scheduleData)) {
    echo "Error: Schedule data is either missing or invalid.";
    exit;
}

// Check if data is posted
// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     // Get POST data safely
//     $weeklyGoals = isset($_POST['weeklyGoals']) ? trim($_POST['weeklyGoals']) : null;
//     $weeklyNotes = isset($_POST['weeklyNotes']) ? trim($_POST['weeklyNotes']) : null;
//     $scheduleData = isset($_POST['scheduleData']) ? json_decode($_POST['scheduleData'], true) : null;

//     // Validate inputs
//     if (empty($weeklyGoals) || empty($scheduleData)) {
//         echo "Error: Weekly goals and schedule data are required.";
//         exit;
//     }
// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     echo "<pre>";
//     print_r($_POST); // To check the POST data
//     echo "</pre>";
//     exit;
// }

    // Insert weekly goals and notes into the database
    $stmt = $conn->prepare("INSERT INTO weekly_plan (weekly_goals, weekly_notes) VALUES (?, ?)");
    $stmt->bind_param("ss", $weeklyGoals, $weeklyNotes);
    $stmt->execute();
    $plan_id = $stmt->insert_id; // Get the ID of the inserted plan
    $stmt->close();

    // Insert schedule tasks into the database
    $stmt_schedule = $conn->prepare("INSERT INTO schedule_tasks (plan_id, day, task, start_time, end_time, priority) VALUES (?, ?, ?, ?, ?, ?)");
    if ($scheduleData && is_array($scheduleData)) {
        foreach ($scheduleData as $task) {
            $day = $task['day'] ?? '';
            $taskName = $task['task'] ?? '';
            $startTime = $task['startTime'] ?? '';
            $endTime = $task['endTime'] ?? '';
            $priority = $task['priority'] ?? '';

            // Validate task data
            if (!empty($day) && !empty($taskName) && !empty($startTime) && !empty($endTime) && !empty($priority)) {
                $stmt_schedule->bind_param("isssss", $plan_id, $day, $taskName, $startTime, $endTime, $priority);
                $stmt_schedule->execute();
            }
        }
 }
//  else {
//         echo "Error: Invalid or empty schedule data.";
//         exit;
//     }
//     $stmt_schedule->close();

//     echo "Weekly plan and schedule saved successfully!";
// } else {
//     echo "Invalid request method.";
// }

$conn->close();
?>
