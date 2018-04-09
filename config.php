<?PHP
date_default_timezone_set("Asia/Bangkok");
$servername = "sql12.freemysqlhosting.net";
$username = "sql12231556";
$password = "g4jKazTtnX";
$dbname = "sql12231556";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


?>