<?php
require_once('../connection/connection.php');  
$conn = connectDB(); 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["task_name"]) && !empty($_POST["task_name"])) {
        $task_name = $_POST["task_name"];
        $task_details = $_POST["task_details"] ?? ''; // Using null coalescing operator to handle absence of task details
        $due_datetime = $_POST["due_datetime"] ?? null; // Assuming due_datetime can be optional

        // Insert task into database
       // Establish database connection
        $sql = "INSERT INTO tasks (task_name, task_details, due_datetime) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            echo "Prepare failed: (" . $conn->errno . ") " . $conn->error;
            exit();
        }

        // Bind the parameters
        $stmt->bind_param("sss", $task_name, $task_details, $due_datetime);
        if ($stmt->execute()) {
            header("Location: index.php"); // Redirect back to the main page
            exit();
        } else {
            echo "Error adding task: " . $stmt->error;
        }
    } else {
        echo "Task name is empty.";
    }
}
?>
