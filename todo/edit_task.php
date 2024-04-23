<?php
require_once('../connection/connection.php');
$conn = connectDB();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    // Handle the post data to update the task
    $id = $_POST['id'];
    $task_name = $_POST['task_name'];
    $task_details = $_POST['task_details'];
    $due_datetime = $_POST['due_datetime'];

    $sql = "UPDATE tasks SET task_name = ?, task_details = ?, due_datetime = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param('sssi', $task_name, $task_details, $due_datetime, $id);
        $stmt->execute();
        $stmt->close();
    }
    header("Location: index.php");
    exit();
}

// Assuming 'id' is passed to edit a specific task
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM tasks WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $task = $result->fetch_assoc();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <h2>Edit Task</h2>
    <form action="edit_task.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $task['id']; ?>">
        <input type="text" name="task_name" value="<?php echo htmlspecialchars($task['task_name']); ?>" required>
        <textarea name="task_details" rows="4" cols="50"><?php echo htmlspecialchars($task['task_details']); ?></textarea>
        <input type="datetime-local" name="due_datetime" value="<?php echo date('Y-m-d\TH:i', strtotime($task['due_datetime'])); ?>">
        <div class="but">
           <button type="submit" name="update">Update Task</button>
        </div>
    </form>
</body>
</html>
