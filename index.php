<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require 'error_page.php';
require 'config.php';

$user_id = $_SESSION['user_id'];

$sql = "SELECT email FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($email);
$stmt->fetch();
$stmt->close();

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">User System</h1>
        <nav class="navbar navbar-expand-lg navbar-light bg-light mt-3">
            <a class="navbar-brand" href="index.php">Home</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <span class="navbar-text">
                            Logged in as: <?php echo $email; ?>
                        </span>
                    </li>
<!--                     <li class="nav-item">
                        <a class="nav-link" href="welcome.php">Welcome</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="users.php">View Users</a>
                    </li> -->
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </nav>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Email</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                <?php
                require 'config.php';
                $sql = "SELECT email, created_at FROM users WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("i", $user_id);
                $stmt->execute();
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["email"] . "</td>";
                        echo "<td>" . $row["created_at"] . "</td>";
                        echo '<td><button type="button" class="btn btn-secondary" onclick="window.location.href=\'welcome.php\'">Edit Password</button></td>';
                            
                        echo "</tr>"; 
                     }
                     } else {
                            echo "0 results";
                            }
               
                      
                /* if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr></td><td>".$row["email"]."</td><td>".$row["created_at"]."</td></tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>No results</td></tr>";
                } */
               
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
