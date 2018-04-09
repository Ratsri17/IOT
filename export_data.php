<?php
include 'config.php';

$farm_id=$_POST["field_id"];
$field_duration=$_POST["field_duration"];
$format=$_POST["export_type"];

if($field_duration==1)
{
	$year=$_POST["year"];
	$month=$_POST["month"];
	$sql = "select timestamp, humidity, temp, soil_moisture from farm_data where farm_id='999' AND timestamp BETWEEN '$year-$month-01 00:00:00' AND '$year-$month-31 23:59:59' order by timestamp";
}
else if($field_duration==2)
{
	$year=$_POST["year"];
	$sql = "select timestamp, humidity, temp, soil_moisture from farm_data where farm_id='999' AND timestamp BETWEEN '$year-01-01 00:00:00' AND '$year-12-31 23:59:59' order by timestamp";
}


switch ($format) {
    case "json":
        $result = $conn->query($sql);
		 $emparray = array();
		while($row =mysqli_fetch_assoc($result))
		{
			$emparray[] = $row;
		}
		$filename=substr(md5(date("h:i:sa").date("Y-m-d")),-10).'.json';
		$fp = fopen($filename, 'w');
		fwrite($fp, json_encode($emparray));
		fclose($fp);
		
		$file = $filename;
		$text = file_get_contents($file);
		header("Content-Disposition: attachment; filename=\"$file\"");
		echo $text;
        break;
		
    case "csv":
		$query = $conn->query($sql);
		if($query->num_rows > 0){
		$delimiter = ",";
		$filename = substr(md5(date("h:i:sa").date("Y-m-d")),-10).'.csv';
		
		//create a file pointer
		$f = fopen('php://memory', 'w');
		
		//set column headers
		$fields = array('timestamp', 'humidity', 'temp', 'soil_moisture');
		fputcsv($f, $fields, $delimiter);
		
		//output each row of the data, format line as csv and write to file pointer
		while($row = $query->fetch_assoc()){
			$lineData = array($row['timestamp'], $row['humidity'], $row['temp'], $row['soil_moisture']);
			fputcsv($f, $lineData, $delimiter);
		}
		
		//move back to beginning of file
		fseek($f, 0);
		
		//set headers to download file rather than displayed
		header('Content-Type: text/csv');
		header('Content-Disposition: attachment; filename="' . $filename . '";');
		
		//output all remaining data on a file pointer
		fpassthru($f);
	}
	break;
	
    case "xml":
        $dom   = new DOMDocument( '1.0', 'utf-8' );
		$dom   ->formatOutput = True;
		$root  = $dom->createElement( 'farmhistoricaldata' );
		$dom   ->appendChild( $root );
		$result   = $conn->query($sql);
		while( $row = $result->fetch_assoc() )
		{
			$node = $dom->createElement( 'record' );
			foreach( $row as $key => $val )
			{
				$child = $dom->createElement( $key );
				$child ->appendChild( $dom->createCDATASection( $val) );
				$node  ->appendChild( $child );
			}
			$root->appendChild( $node );
		}
		$filename = substr(md5(date("h:i:sa").date("Y-m-d")),-10).'.xml';
		$dom->save( $filename );
		
		$file = $filename;
		$text = file_get_contents($file);
		header("Content-Disposition: attachment; filename=\"$file\"");
		echo $text;
		
        break;
    default:
        echo "Error Invalid Format";
}
?> 
