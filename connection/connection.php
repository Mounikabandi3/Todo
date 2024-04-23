<?php 
function connectDB() {
    $servername = "localhost";
    $username = "root";
    $password = "";  // Use an empty string if there is no password
    $db_name = "todo";  
    $conn = new mysqli($servername, $username, $password, $db_name);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}
function getTasks($conn) {
    $tasks = [];
    $sql = "SELECT * FROM tasks";
    $result = $conn->query($sql);

    if ($result === false) {
        // Log error, for example:
        error_log("Error fetching tasks: " . $conn->error);
        return []; // Return an empty array or handle error as appropriate
    }

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $tasks[] = $row;
        }
    }
    return $tasks;
}

?>