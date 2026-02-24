<?php
$conn = new mysqli('82.98.177.105', 'usradmintra007', 'sL*o7_k7[68)}8', 'intranext007');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully to intranext007\n";
