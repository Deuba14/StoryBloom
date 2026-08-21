<?php

require_once "config/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO user (username, email, password, role)
            VALUES (?, ?, ?, 'user')";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param("sss", $username, $email, $hashedPassword);
if ($stmt->execute()) {
    echo "Registration successful!<br>";
    echo "Inserted User ID: " . $stmt->insert_id . "<br>";
    echo "Database: " . $database;
} else {
    echo "Registration failed: " . $stmt->error;
}

    $stmt->close();
}

$conn->close();

?>