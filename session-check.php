<?php

session_start();

if (isset($_SESSION["test"])) {
    echo "Session is working!";
    echo "<br>";
    echo "Value: " . $_SESSION["test"];
} else {
    echo "Session is NOT working!";
}

?>