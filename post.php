<?php

require_once "config/db.php";

if (!isset($_GET["id"])) {
    echo "Story ID not found.";
    exit();
}

$id = intval($_GET["id"]);

$sql = "SELECT blogpost.id,
               blogpost.title,
               blogpost.content,
               blogpost.created_at,
               user.username
        FROM blogpost
        INNER JOIN user
        ON blogpost.user_id = user.id
        WHERE blogpost.id = ?";

$stmt = $conn->prepare($sql);

$stmt->bind_param("i", $id);

$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows == 1) {

    $story = $result->fetch_assoc();

} else {

    echo "Story not found.";
    exit();

}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>
        <?php echo htmlspecialchars($story["title"]); ?>
        - Story Bloom
    </title>

    <link rel="stylesheet"
          href="css/style.css">

</head>

<body>

<header class="navbar">

    <div class="logo">
        🌱 Story Bloom
    </div>

    <nav>

        <a href="index.php">Home</a>

        <a href="create-post.html">Write</a>

        <a href="login.html">Login</a>

        <a href="register.html"
           class="signup-btn">
            Sign Up
        </a>

    </nav>

</header>


<section class="post-page">

    <h1 id="post-title">

        <?php
        echo htmlspecialchars($story["title"]);
        ?>

    </h1>


    <p id="post-author">

        By
        <?php
        echo htmlspecialchars($story["username"]);
        ?>

    </p>


    <p id="post-date">

        <?php

        echo date(
            "M d, Y",
            strtotime($story["created_at"])
        );

        ?>

    </p>


    <div id="post-content">

        <?php
        echo nl2br(
            htmlspecialchars($story["content"])
        );
        ?>

    </div>

</section>


<footer>

    <p>
        © 2026 Story Bloom. All rights reserved.
    </p>

</footer>


</body>

</html>

<?php

$stmt->close();

$conn->close();

?>