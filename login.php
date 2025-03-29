<?php
session_start(); // Start the session
include 'db.php'; // Include database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if (password_verify($password, $row['password'])) {
            $_SESSION['loggedin'] = true;
            $_SESSION['name'] = $row['name'];
            echo "
            <script>
                alert('Welcome, {$row['name']}!');
                window.location.href = '../index.html'; // Redirect to your main page
            </script>";
        } else {
            echo "
            <script>
                alert('Invalid password.');
                window.history.back();
            </script>";
        }
    } else {
        echo "
        <script>
            alert('No account found with this email.');
            window.history.back();
        </script>";
    }

    $conn->close();
}
?>
