<?php

session_start();

require_once "config/db.php";

// Check if user is logged in
if (!isset($_SESSION["user_id"])) {

    header("Location: login.html");
    exit();

}

// Check blog ID
if (!isset($_GET["id"])) {

    echo "Blog ID not found.";
    exit();

}

$blog_id = intval($_GET["id"]);

$user_id = $_SESSION["user_id"];

// Delete only user's own blog
$sql = "DELETE FROM blogpost
        WHERE id = ? AND user_id = ?";

$stmt = $conn->prepare($sql);

if (!$stmt) {

    die("SQL Prepare Error: " . $conn->error);

}

$stmt->bind_param(
    "ii",
    $blog_id,
    $user_id
);

if ($stmt->execute()) {

    if ($stmt->affected_rows > 0) {

        header("Location: index.php");
        exit();

    } else {

        echo "You are not authorized to delete this blog.";

    }

} else {

    echo "Delete failed: " . $stmt->error;

}

$stmt->close();

$conn->close();

?>