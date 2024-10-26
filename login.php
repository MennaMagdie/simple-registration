<?php
$errorMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $conn = new mysqli("localhost", "root", "", "registration");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT name, password FROM user WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($name, $storedPassword);
        $stmt->fetch();

        if ($password === $storedPassword) {
            echo "Welcome, " . htmlspecialchars($name) . "!";
        } else {
            echo "<script>
                    alert('Incorrect password!');
                    window.location.href = 'lab4/login.html';
                  </script>";
           }
    } else {
        echo "<script>
        alert('No user registered with this email');
        window.location.href = 'lab4/login.html';
      </script>";
    }

    $stmt->close();
    $conn->close();
}
?>
