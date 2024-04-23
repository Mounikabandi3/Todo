<?php
require_once('../connection/connection.php');
$conn = connectDB();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM tasks WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->close();
    }
    header("Location: index.php");  // Redirect back to the main page to see the list update
    exit();
}
?>
