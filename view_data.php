 <?php
include 'config.php';

$farm_id=$_POST["field_id"];
$field_duration=$_POST["field_duration"];
if($field_duration==1)
{
	$year=$_POST["year"];
	$month=$_POST["month"];
	$sql = "select TRUNCATE(AVG(humidity), 1) AS avghummi, TRUNCATE(AVG(temp), 1) AS avgtemp,TRUNCATE(AVG(soil_moisture), 1) as soil, DAY(timestamp) as day from farm_data where farm_id='$farm_id' AND timestamp BETWEEN '$year-$month-01 00:00:00' AND '$year-$month-31 23:59:59' GROUP BY DAY(timestamp)";

}
else if($field_duration==2)
{
	$year=$_POST["year"];
	//$sql = "select soil_moisture,humidity,temp,timestamp from farm_data where farm_id='$farm_id' AND timestamp BETWEEN '$year-01-01 00:00:00' AND '$year-12-31 23:59:59'";
	$sql = "select TRUNCATE(AVG(humidity), 1) AS avghummi, TRUNCATE(AVG(temp), 1) AS avgtemp,TRUNCATE(AVG(soil_moisture), 1) as soil, MONTH(timestamp) as month from farm_data where farm_id='$farm_id' AND timestamp BETWEEN '$year-01-01 00:00:00' AND '$year-12-31 23:59:59' GROUP BY MONTH(timestamp)";
}
//echo $sql;


$result = $conn->query($sql);




$conn->close();
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
	<link rel="icon" type="image/png" href="assets/img/favicon.png">	
	
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Smart Farming</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
	
	<script src="jquery/jquery-1.10.2.js" type="text/javascript"></script>
	<script src="assets/js/highcharts.js"></script>
	<script src="assets/js/exporting.js"></script>
	<script src="assets/js/export-data.js"></script>

    <link href="bootstrap3/css/bootstrap.css" rel="stylesheet" />
	<link href="assets/css/gsdk.css" rel="stylesheet" />  
    <link href="assets/css/demo.css" rel="stylesheet" /> 
    
    <!--     Font Awesome     -->
    <link href="bootstrap3/css/font-awesome.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Grand+Hotel' rel='stylesheet' type='text/css'>
	<script>
$(document).ready(function(){
    $('#field_durations').on('change', function() {
      if ( this.value == '1')
      {
        $("#monthx").show();
		$("#yearx").show();
      }
      else if ( this.value == '2')
      {
         $("#monthx").hide();
		$("#yearx").show();
      }
	  else
	  {
		$("#monthx").hide();
		$("#monthy").hide();
		$("#yearx").hide();
	  }
    });
});
</script>
</head>
<body>
<div id="navbar-full">
    <div class="container">
        <nav class="navbar navbar-ct-blue navbar-transparent navbar-fixed-top" role="navigation">
          
          <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a href="index.php">
                     <div class="logo-container">
                        <div class="logo">
                            <img src="assets/img/new_logo.png">
                        </div>
                        <div class="brand">
                            Nit raipur_phoenix
                        </div>
                    </div>
                </a>
            </div>
        
 
          </div><!-- /.container-fluid -->
        </nav>
    </div><!--  end container-->
    
    <div class='blurred-container'>
        <div class="motto">
            <div>Smart</div>
            <div class="border" align="center">Farming</div>
        </div>
        <div class="img-src" style="background-image: url('assets/img/cover_4.jpg')"></div>
        <div class='img-src blur' style="background-image: url('assets/img/cover_4_blur.jpg')"></div>
    </div>
    
</div>     
    


<div class="main">
    <div class="container tim-container">
       
        <div class="tim-title">
            <h2>View Graph</h2> <h5> Location limited to Raipur, Chattisgarh for demo </h5>
        </div>
        <br><br>
		
		 
		<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
		
		<br><br>
		<div id="container2" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

		<div class="tim-title">
            <h2>Export Raw Data</h2> <h5> Location limited to Raipur, Chattisgarh for demo </h5>
        </div>
        
		<form class="form-inline" action="export_data.php" method="post">
			<div class="form-group">
			  <label for="sel1">Select State:</label>
			  <select class="form-control" id="state" name="state">
				<option selected>Chattisgarh</option>
			  </select>
			</div>
			<div class="form-group">
			  <label for="sel1">Select City:</label>
			  <select class="form-control" id="city" name="city">
				<option selected>Raipur</option>
			  </select>
			</div>
			<div class="form-group">
			  <label for="sel1">Select Field:</label>
			  <select class="form-control"  id="field_id" name="field_id">
				<option selected value="999">Sample Field 1</option>
				<option value="998">Sample Field 2</option>
			  </select>
			</div>
			<div class="form-group" >
			  <label for="sel1">Graph Period:</label>
			  <select class="form-control" id='field_durations' name="field_duration" required>
				<option value="1">Monthly</option>
				<option value="2">Yearly</option>
			  </select>
			</div>
			
			<div class="form-group" id='monthx'>
			  <label for="sel1">Month:</label>
			  <select class="form-control" name="month">
				<option value="01">Jan</option>
				<option value="02">Feb</option>
				<option value="03">Mar</option>
				<option value="04">Apr</option>
				<option value="05">May</option>
				<option value="06">Jun</option>
				<option value="07">Jul</option>
				<option value="08">Aug</option>
				<option value="09">Sep</option>
				<option value="10">Oct</option>
				<option value="11">Nov</option>
				<option value="12">Dec</option>
			  </select>
			</div>
			
			<div class="form-group" id='yearx' style='display:none;'>
			  <label for="sel1">Year:</label>
			  <select class="form-control"  id='yearly_second' name="year">
				<option value="2018">2018</option>
				<option value="2017">2017</option>
				<option value="2016">2016</option>
			  </select>
			</div>
			
			<div class="form-group" id='format'>
			  <label for="sel1">Format</label>
			  <select class="form-control" name="export_type">
				<option value="json">JSON</option>
				<option value="csv">CSV</option>
				<option value="xml">XML</option>
			  </select>
			</div>
			
			<br><br>
			<div align="center">
				<button type="submit" class="btn btn-lg btn-info">Download</button> 
			</div>
		</form>
		
		<br><br>
		<a href="index.php" class="btn btn-block btn-lg btn-info">Back to Main Page</a>
    </div>
</div>
<div style="margin: 50px 0;"></div>
<br>
<!-- end main -->

<div class="parallax-pro">
    <div class="img-src" style="background-image: url('http://get-shit-done-pro.herokuapp.com/assets/img/bg6.jpg');"></div>
    <div class="container">
        <div class="space-30"></div>
        <div class="row">
             <div class="col-md-12 text-center">
                <div class="credits">
                    &copy; Smart Farming by <a href="#"> Team Name</a>, made with <i class="fa fa-heart heart" alt="love"></i> for a better web.
                </div>
            </div>
        </div>
    </div>

</div>

<script>
Highcharts.chart('container', {
    chart: {
        type: 'line'
    },
    title: {
        text: 'Soil Moisture & Temprature Graph'
    },
    subtitle: {
        text: 'History of Recorded values from Fields'
    },
    xAxis: {
        <?PHP 
			if($field_duration==2)
			{
				$yr=substr($year,-2);
				echo "categories: ['Jan $yr', 'Feb $yr', 'Mar $yr', 'Apr $yr', 'May $yr', 'Jun $yr', 'Jul $yr', 'Aug $yr', 'Sep $yr', 'Oct $yr', 'Nov $yr', 'Dec $yr']";
			}
			if($field_duration==1)
			{
				echo "categories: ['01', '02 ', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31']";
			}
			?>
    },
    yAxis: {
        title: {
            text: 'Moisture / Humidity value'
        }
    },
    plotOptions: {
        line: {
            dataLabels: {
                enabled: true
            },
            enableMouseTracking: false
        }
    },
    series: [{
        name: 'Soil Moisture',
        data: [<?PHP
		if($field_duration==2)
		{
			 while($row = $result->fetch_assoc()) 
			{
				echo $row["soil"];
				if($row["month"] != 12)
					echo ", ";
			}
		}
		else if($field_duration==1)
		{
			while($row = $result->fetch_assoc()) 
			{
				echo $row["soil"];
				if($row["day"] != 31)
					echo ", ";
			}
		}
		$result->data_seek(0); 		
		?>]
    }, {
        name: 'Temprature Graph',
        data: [<?PHP
		if($field_duration==2)
		{
			while($row = $result->fetch_assoc()) 
			{
				echo $row["avgtemp"];
				if($row["month"] != 12)
					echo ", ";
			}
		}
		else if($field_duration==1)
		{
			while($row = $result->fetch_assoc()) 
			{
				echo $row["avgtemp"];
				if($row["day"] != 31)
					echo ", ";
			}
		}
		$result->data_seek(0); 
		?>]
    }]
});
</script>
<script>
Highcharts.chart('container2', {
    chart: {
        type: 'line'
    },
    title: {
        text: 'Humidity Graph'
    },
    subtitle: {
        text: 'History of Recorded values from Fields'
    },
    xAxis: {
        <?PHP 
			if($field_duration==2)
			{
				$yr=substr($year,-2);
				echo "categories: ['Jan $yr', 'Feb $yr', 'Mar $yr', 'Apr $yr', 'May $yr', 'Jun $yr', 'Jul $yr', 'Aug $yr', 'Sep $yr', 'Oct $yr', 'Nov $yr', 'Dec $yr']";
			}
			if($field_duration==1)
			{
				echo "categories: ['01', '02 ', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31']";
			}
			?>
    },
    yAxis: {
        title: {
            text: 'Humidity Level'
        }
    },
    plotOptions: {
        line: {
            dataLabels: {
                enabled: true
            },
            enableMouseTracking: false
        }
    },
    series: [{
        name: 'Humidity',
        data: [<?PHP
		if($field_duration==2)
		{
			 while($row = $result->fetch_assoc()) 
			{
				echo $row["avghummi"];
				if($row["month"] != 12)
					echo ", ";
			}
		}
		else if($field_duration==1)
		{
			while($row = $result->fetch_assoc()) 
			{
				echo $row["avghummi"];
				if($row["day"] != 31)
					echo ", ";
			}
		}
		?>]
    }]
});
</script>
</body>

    
	<script src="assets/js/jquery-ui-1.10.4.custom.min.js" type="text/javascript"></script>

	<script src="bootstrap3/js/bootstrap.js" type="text/javascript"></script>
	<!-- <script src="assets/js/gsdk-checkbox.js"></script>
	<script src="assets/js/gsdk-radio.js"></script>
	<script src="assets/js/gsdk-bootstrapswitch.js"></script> -->
	<script src="assets/js/get-shit-done.js"></script>
    <script src="assets/js/custom.js"></script>

</html>