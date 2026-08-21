<?php

session_start();

require_once "config/db.php";

// Check login
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

// Get only the user's own blog
$sql = "SELECT id, title, content
        FROM blogpost
        WHERE id = ? AND user_id = ?";

$stmt = $conn->prepare($sql);

$stmt->bind_param("ii", $blog_id, $user_id);

$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows != 1) {

    echo "You are not authorized to edit this blog.";
    exit();

}

$blog = $result->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Edit Story - Story Bloom</title>

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

        <a href="logout.php">Logout</a>

    </nav>

</header>


<section class="create-post">

    <h1>Edit Your Story</h1>

    <p>Update your story below.</p>


    <form action="update-post.php"
          method="POST">

        <input
            type="hidden"
            name="id"
            value="<?php echo $blog["id"]; ?>"
        >


        <label for="title">
            Story Title
        </label>

        <input
            type="text"
            id="title"
            name="title"
            value="<?php echo htmlspecialchars($blog["title"]); ?>"
            required
        >


        <label for="content">
            Your Story
        </label>

        <textarea
            id="content"
            name="content"
            rows="12"
            required
        ><?php echo htmlspecialchars($blog["content"]); ?></textarea>


        <button type="submit">
            Update Story
        </button>

    </form>

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