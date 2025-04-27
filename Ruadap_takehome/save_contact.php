<?php
// SHOW ALL ERRORS (for debugging)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection details
$servername = "sql304.infinityfree.com";       // from MySQL Details
$username   = "if0_38844347";          // your MySQL user
$password   = "xAdT8UwyR8";    // your hosting password
$dbname     = "if0_38844347_dbcontacts"; // your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Turn MySQLi into exceptions so we can catch them
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    // Connect
    $conn = new mysqli($servername, $username, $password, $dbname);
    $conn->set_charset('utf8mb4');

    // Grab and sanitize POST data
    $studno = trim($_POST['studno'] ?? '');
    $name   = trim($_POST['name']   ?? '');
    $cpno   = trim($_POST['cpno']   ?? '');

    if (empty($studno) || empty($name) || empty($cpno)) {
        throw new Exception("All fields are required.");
    }

    // Prepare and execute
    $stmt = $conn->prepare("
      INSERT INTO tblSMS (studno, name, cpno) 
      VALUES (?, ?, ?)
    ");
    $stmt->bind_param("sss", $studno, $name, $cpno);
    $stmt->execute();

    echo "✅ New contact saved successfully!";
} catch (Exception $e) {
    // Show the error message
    echo "<h3>Error:</h3>";
    echo "<pre>" . htmlspecialchars($e->getMessage()) . "</pre>";
}

// Close connection if it exists
if (isset($conn) && $conn instanceof mysqli) {
    $conn->close();
}
