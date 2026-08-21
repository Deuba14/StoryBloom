<?php

session_start();

require_once "config/db.php";

if (!isset($_SESSION["user_id"])) {

    echo "SESSION NOT FOUND";
    exit();

}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = trim($_POST["title"]);
    $content = trim($_POST["content"]);

    $user_id = $_SESSION["user_id"];

    $sql = "INSERT INTO blogpost
            (user_id, title, content, created_at, updated_at)
            VALUES (?, ?, ?, NOW(), NOW())";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("SQL Prepare Error: " . $conn->error);
    }

    $stmt->bind_param(
        "iss",
        $user_id,
        $title,
        $content
    );

    if ($stmt->execute()) {

        echo "Blog published successfully!";

    } else {

        echo "Blog publication failed: " . $stmt->error;

    }

    $stmt->close();

} else {

    echo "Please submit the blog form.";

}

$conn->close();

?>