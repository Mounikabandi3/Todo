<?php
require_once('../connection/connection.php'); 
$conn = connectDB();  // Ensure this line is present to set $conn

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // SQL injection vulnerability (address this as noted below)
    $sql = "SELECT * FROM login WHERE username = '$username' AND password = '$password'";  
    $result = mysqli_query($conn, $sql);  
    $count = mysqli_num_rows($result);  
    
    if($count == 1){  
        header("Location: ../todo/index.php");
        exit();
    }  
    else{  
        echo  '<script>
                    alert("Login failed. Invalid username or password!!");
                    window.location.href = "index.php";
                </script>';
    }     
}
?>
