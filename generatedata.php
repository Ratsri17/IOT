<?PHP

for ($x = 0; $x <= 500; $x++) 
{
	$farm_id=rand(998, 999);
	$soil_moisture=rand(15, 30);
	$humidity=rand(700, 1200);
	$temp=rand(15, 35);
	$year=rand(2016, 2018);
	$month=rand(1, 12);
	if($month <10)
		$month='0'.$month;
	
	$day=rand(1, 28);
	if($day <10)
		$day='0'.$day;
	
	$hour=rand(1, 23);
	if($hour <10)
		$hour='0'.$hour;
	
	$min=rand(1, 59);
	if($min <10)
		$min='0'.$min;
	
	$sec=rand(1, 59);
	if($sec <10)
		$sec='0'.$sec;
	
	$timestamp=$year.'-'.$month.'-'.$day.' '.$hour.':'.$min.':'.$sec;
    echo "insert into farm_data (farm_id, timestamp, soil_moisture,humidity,temp) values('$farm_id','$timestamp','$soil_moisture','$humidity','$temp');";
	echo "<br>";
} 

/* select TRUNCATE(AVG(temp), 1) AS avgtemp,MONTH(timestamp) as month from farm_data where farm_id='999' AND timestamp BETWEEN '2018-01-01 00:00:00' AND '2018-12-31 23:59:59' GROUP BY MONTH(timestamp)
 */
?>