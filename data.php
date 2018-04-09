 <?php
include 'config.php';

$farm_id=$_GET["id"];
$time_stamp=$_GET["TT"];
$soil_moisture=$_GET["S"];
$humidity=$_GET["H"];
$temp=$_GET["T"];



$sql = "INSERT INTO farm_data (farm_id, timestamp, soil_moisture, humidity, temp)
VALUES ('$farm_id', '$time_stamp', '$soil_moisture', '$humidity', '$temp')";

if ($conn->query($sql) === TRUE) {
    echo "$sql";
} else {
    echo "error";
}

$conn->close();
?> 