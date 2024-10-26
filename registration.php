<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $name = trim($_POST['name']);
    $password = trim($_POST['password']);
    $password = md5($password);

    $conn = new mysqli("localhost", "root", "", "registration");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT * FROM user WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "<script>
        alert('Email already exists');
        window.location.href = 'registration.html';
            </script>";
    } else {
        $stmt = $conn->prepare("INSERT INTO user (email, name, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $email, $name, $password);

        if ($stmt->execute()) {
            echo "<script>
        alert('Successful Registration!');
        window.location.href = 'index.html';
            </script>";
        } else {
            echo "Error: " . $stmt->error;
        }
    }

    $stmt->close();
    $conn->close();
}
?>
