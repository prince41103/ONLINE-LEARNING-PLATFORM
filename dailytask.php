<?php
include 'db.php'; // Include the connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Decode the JSON arrays from the form
    $subjects = json_decode($_POST['subjects'], true); // Array of subjects
    $schedule = json_decode($_POST['schedule'], true); // Array of schedule entries
    $goals = $_POST['goals']; // Goals
    $notes = $_POST['notes']; // Notes

    // Prepare the statement to insert each task into the tasks table
    $stmt = $conn->prepare("INSERT INTO tasks (subject, tasks, start_time, end_time, priority, goals, notes) VALUES (?, ?, ?, ?, ?, ?, ?)");

    // Ensure we only add one task per subject by iterating up to the length of subjects or schedule, whichever is smaller
    $count = min(count($subjects), count($schedule));

    for ($i = 0; $i < $count; $i++) {
        // Bind parameters for each task entry
        $stmt->bind_param(
            "sssssss",
            $subjects[$i],            // Subject name
            $schedule[$i]['task'],    // Task description
            $schedule[$i]['startTime'], // Start time
            $schedule[$i]['endTime'],   // End time
            $schedule[$i]['priority'],  // Priority
            $goals,                   // Study goals (same for all tasks)
            $notes                    // Notes (same for all tasks)
        );

        // Execute the prepared statement
        if (!$stmt->execute()) {
            echo "Error: " . $stmt->error;
            exit;
        }
    }

    // Close the statement
    $stmt->close();

    echo "Tasks saved successfully!";
}
?>
