<?php

session_start();

$_SESSION["test"] = "Story Bloom";

echo "Session created successfully!";
echo "<br>";
echo "Test value: " . $_SESSION["test"];

?>