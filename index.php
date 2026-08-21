<?php

session_start();

require_once "config/db.php";

$sql = "SELECT blogpost.id,
               blogpost.user_id,
               blogpost.title,
               blogpost.content,
               blogpost.created_at,
               user.username
        FROM blogpost
        INNER JOIN user
        ON blogpost.user_id = user.id
        ORDER BY blogpost.created_at DESC";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Story Bloom</title>

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

        <a href="write.php">Write</a>

        <?php if (isset($_SESSION["user_id"])): ?>

            <span>
                Welcome,
                <?php echo htmlspecialchars($_SESSION["username"]); ?>
            </span>

            <a href="logout.php">Logout</a>

        <?php else: ?>

            <a href="login.html">Login</a>

            <a href="register.html"
               class="signup-btn">
                Sign Up
            </a>

        <?php endif; ?>

    </nav>

</header>


<section class="hero">

    <h1>Stories that inspire.</h1>

    <p>
        Write. Share. Discover.
    </p>

    <div class="hero-buttons">

        <a href="write.php"
           class="primary-btn">
            Start Writing
        </a>

        <a href="#stories"
           class="secondary-btn">
            Explore Stories
        </a>

    </div>

</section>


<section class="stories"
         id="stories">

    <h2>Latest Stories</h2>


    <?php

    if ($result && $result->num_rows > 0) {

        while ($story = $result->fetch_assoc()) {

    ?>

        <article class="blog-card">

            <div class="blog-content">

                <h3>
                    <?php
                    echo htmlspecialchars($story["title"]);
                    ?>
                </h3>

                <p>
                    <?php
                    echo htmlspecialchars($story["content"]);
                    ?>
                </p>

                <div class="blog-info">

                    <span>
                        By
                        <?php
                        echo htmlspecialchars($story["username"]);
                        ?>
                    </span>

                    <span>
                        <?php
                        echo date(
                            "M d, Y",
                            strtotime($story["created_at"])
                        );
                        ?>
                    </span>

                </div>

                <a href="post.php?id=<?php echo $story["id"]; ?>"
                   class="read-more">

                    Read more →

                </a>
                <?php if (isset($_SESSION["user_id"]) && $_SESSION["user_id"] == $story["user_id"]): ?>

    <br><br>

    <a href="edit-post.php?id=<?php echo $story["id"]; ?>">
        Edit
    </a>

    <a href="delete-post.php?id=<?php echo $story["id"]; ?>"
       onclick="return confirm('Are you sure you want to delete this blog?');">
        Delete
    </a>

<?php endif; ?>

            </div>

        </article>

    <?php

        }

    } else {

        echo "<p>No stories available yet.</p>";

    }

    ?>

</section>


<footer>

    <p>
        © 2026 Story Bloom. All rights reserved.
    </p>

</footer>


</body>

</html>

<?php

$conn->close();

?>