<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple To-Do List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f4;
        }

        h2 {
            text-align: center;
        }

        form {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px #ccc;
            margin: 20px auto;
            width: 50%;
        }

        input[type="text"], input[type="datetime-local"], textarea {
            width: 100%;
            padding: 8px;
            margin-top: 6px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button, .btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }

        button:hover, .btn:hover {
            background-color: #45a049;
        }

        .btn-edit {
            background-color: #FFA500; /* orange */
        }

        .btn-delete {
            background-color: #FF6347; /* tomato */
        }

        .task-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .task-card {
            background: #fff;
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            width: 300px;
        }

        .button-container {
            text-align: center;
            margin-top: 10px;
        }
        
        .button-containers{
            text-align: center;
            margin-top: 10px;
        }
        
    </style>
</head>
<body>
    <h2 >Add a New Task</h2>
    <form action="add_task.php" method="POST">
        <input type="text" name="task_name" placeholder="Enter task name" required>
        <textarea name="task_details" placeholder="Enter task details" rows="4" cols="50"></textarea>
        <input type="datetime-local" name="due_datetime" placeholder="Due date and time">
        <div class="button-containers">
        <button type="submit">Add Task</button>
       </div>
    </form>

    <h2>Recent Tasks</h2>
    <div class="task-container">
        <?php
        require_once('../connection/connection.php');  // Ensure this path is correct
        $conn = connectDB();
        $tasks = getTasks($conn); // Fetch tasks from the database
        if (!empty($tasks)) {
            foreach ($tasks as $task) {
                echo '<div class="task-card">';
                echo '<h3>' . htmlspecialchars($task['task_name']) . '</h3>';
                echo '<p>' . nl2br(htmlspecialchars($task['task_details'])) . '</p>';
                echo '<p><strong>Due:</strong> ' . ($task['due_datetime'] ? date('F j, Y, g:i a', strtotime($task['due_datetime'])) : 'No deadline') . '</p>';
                echo '<div class="button-container">';
                echo '<a href="edit_task.php?id=' . $task['id'] . '" class="btn btn-edit">Edit</a>';
                echo '<a href="delete_task.php?id=' . $task['id'] . '" class="btn btn-delete" onclick="return confirm(\'Are you sure you want to delete this task?\');">Delete</a>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo '<p>No tasks found.</p>';
        }
        ?>
    </div>
</body>
</html>
