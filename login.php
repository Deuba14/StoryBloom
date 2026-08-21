<?php

session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'httponly' => true,
    'samesite' => 'Lax'
]);

session_start();

require_once "config/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    $sql = "SELECT id, username, email, password, role
            FROM user
            WHERE email = ?";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param("s", $email);

    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows == 1) {

    echo "USER FOUND<br>";

    $user = $result->fetch_assoc();

    echo "USER ID: " . $user["id"] . "<br>";
    echo "USERNAME: " . $user["username"] . "<br>";
    echo "EMAIL: " . $user["email"] . "<br>";

    if (password_verify($password, $user["password"])) {

        echo "PASSWORD MATCH<br>";

        session_regenerate_id(true);

        $_SESSION["user_id"] = $user["id"];
        $_SESSION["username"] = $user["username"];
        $_SESSION["role"] = $user["role"];

       header("Location: index.php");
exit();

    } else {

        echo "PASSWORD DOES NOT MATCH";
    }

} else {

    echo "USER NOT FOUND";
}
    $stmt->close();
}

$conn->close();

?>