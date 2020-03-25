<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
    unset($_SESSION);
    session_destroy();
}
?>
<?php
require __DIR__.'/vendor/autoload.php';

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

// This assumes that you have placed the Firebase credentials in the same directory
// as this PHP file.
$serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/service-account.json');

$firebase = (new Factory)
    ->withServiceAccount($serviceAccount)
    ->withDatabaseUri('https://logistics-car.firebaseio.com')
    ->create();

$database = $firebase->getDatabase();
$reference = $database->getReference('/Device1');
$snapshot = $reference->getSnapshot();
$value = $snapshot->getValue();

$temperature = [];
$humidity = [];
$timearr = [];
if(empty($value)){
    $value = "-";
    $timestart = "0.00";
    $timeend = "0.00";
    $result1 = "0";
    $result2 = "00";
    $temperature = [0];
    $humidity = [0];
    $averagehumid = "0";
    $averagetemp = "0";
    $timearr = [0];
    $i = 0;
    $lat1 = "0";
    $lat11 = "0";
    $lat2 = "0";
    $lat22 = "0";
    $long1 = "0";
    $long11 = "0";
    $long2 = "0";
    $long22 = "0";
    $c = 0;
    $dataPoints1 = array();
    $dataPoints2 = array();
    for($i=0; $i < count($temperature); $i++){
        $t_data = array("label"=> $timearr[$i], "y"=> $temperature[$i]);
        array_push($dataPoints1, $t_data);

        $h_data = array("label"=> $timearr[$i], "y"=> $humidity[$i]);
        array_push($dataPoints2, $h_data);
    }
}else{
    $c = 0;
  foreach($value as $x=>$x_value)
    { 
        $str = explode(' ',$x_value);
        array_push($temperature, $str[3]); 
        array_push($humidity, $str[5]);
        if($str[13] != "'Stop'"){
            array_push($timearr, $str[13].":".$str[15]);
        }
        elseif($str[13] == "'Stop'"){
            $c = $c+1;
            array_push($timearr, $c.":".$str[13]."-".$str[15].":".$str[17]);
        }

    }
    $i = 0;
    $dataPoints1 = array();
    $dataPoints2 = array();
    for($i=0; $i < count($temperature); $i++){
        $t_data = array("label"=> $timearr[$i], "y"=> $temperature[$i]);
        array_push($dataPoints1, $t_data);

        $h_data = array("label"=> $timearr[$i], "y"=> $humidity[$i]);
        array_push($dataPoints2, $h_data);
    }	
}
?>
<?php
    $temp = [];
    $humid = [];
    $c = 0;
    $arrcount = []; // หยุดที่ค่า Stop คึอ ตำแหน่งที่ 9 ค่าที่ 10
    $arrcount2 = [];
    $arrcount3 = [];
    
    
    // รอบแรกที่จะหยุด
    foreach($value as $x=>$x_value){
        array_push($arrcount, $x_value);
        $str = explode(' ',$x_value);
    
        if($str[13] === "'Stop'"){
            $c = $c + 1;
            break;
        }
    }
    // ค่าแรก
    $cut1arrcount = current($arrcount);
    $cut2arrcount = end($arrcount);
    $str1 = explode(' ',$cut1arrcount);
    $str11 = explode(' ',$cut2arrcount);
    $lat1 = json_decode($str11[7]);
    $long1 = json_decode($str11[9]);
    $lat11 = json_decode($str11[7]);
    $long11 = json_decode($str11[9]);
    
    // หยุดหารอบสองค่าแรก
    foreach($value as $x=>$x_value){
        array_push($arrcount, $x_value);
        $str = explode(' ',$x_value);
    
        array_push($temp, $str[3]);
        array_push($humid, $str[5]);
        if($str[13] === "'Stop'"){
            $c = $c + 1;
            $cstop = $c;
            break;
        }
    }
    // ค่าที่เอามาเทียบ
    foreach($value as $x=>$x_value){
        array_push($arrcount2, $x_value);
        $strch = explode(' ',$x_value);
    }
    
    $c2 = []; // ค่าแรกในรอบที่ 2
    if($strch[13] == "'Stop'"){
    
    }
    if($c == 2){
    // รอบที่ 2
    $arrstop = [];
    if(empty($arrcount2[count($temp)])){
        $lat2 = json_decode(0);
        $long2 = json_decode(0);
        $lat22 = json_decode(0);
        $long22 = json_decode(0);
    }elseif (!empty($arrcount2[count($temp)])) {
        $c2 = explode(' ', $arrcount2[count($temp)]);
        foreach($value as $x=>$x_value){
            array_push($arrcount3, $x_value);
            $str = explode(' ',$x_value);
            for($i = 0; $i <= count($temp) -1; $i++){
                unset($arrcount3[$i]);
            }
        }
        $cut1arrcount3 = current($arrcount3);
        $cut2arrcount3 = end($arrcount3);
        $str2 = explode(' ',$cut1arrcount3);
        $str22 = explode(' ',$cut2arrcount3);
        $lat2 = json_decode($str2[7]);
        $long2 = json_decode($str2[9]);
        $lat22 = json_decode($str22[7]);
        $long22 = json_decode($str22[9]);
    }
}
?>
<html>
  <head>
  <script>
window.onload = function () {
 
var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	theme: "light2",
	title:{
		text: "Temperature and Humidity"
	},
	legend:{
		cursor: "pointer",
		verticalAlign: "center",
		horizontalAlign: "right",
		itemclick: toggleDataSeries
	},
	data: [{
		type: "column",
		name: "Temperature",
		indexLabel: "{y}",
		yValueFormatString: "#.##",
		showInLegend: true,
		dataPoints: <?php echo json_encode($dataPoints1, JSON_NUMERIC_CHECK); ?>
	},{
		type: "column",
		name: "Humidity",
		indexLabel: "{y}",
		yValueFormatString: "#.##",
		showInLegend: true,
		dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();
 
function toggleDataSeries(e){
	if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
		e.dataSeries.visible = false;
	}
	else{
		e.dataSeries.visible = true;
	}
	chart.render();
  }
}
</script>
    <meta charset="UTF-8">
    <title>Log Data Page</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <script src="https://www.gstatic.com/firebasejs/4.9.0/firebase.js"></script>
    <meta name="viewport" content="initial-scale=1.0">
    <script src="http://code.jquery.com/jquery-latest.min.js"></script>
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
    </style>

    <style>
        ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            overflow: hidden;
            background-color: #333;
        }

        li {
            float: left;
        }

        li a {
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }
        
        li a:hover {
            background-color: #111;
        }
        li {
            border-right: 1px solid #bbb;
        }
        li:last-child {
            border-right: none;
        }
        a{
            font-size:16px;
        }
        ul{
            box-shadow: 5px 10px 16px #888888;

        }
        .active {
            background-color: #4CAF50;
        }
    </style>

    <style>
        .Top{
            background-color: lightblue;
        }
        table, td, th{  
            border: 1px solid #ddd;
            text-align: center;
        }
        table {
            border-collapse: collapse;
            margin:0 auto;
            width: 45%;
            margin-left: 28%;
            margin-right: 38%;
            align: center;
        }
        th, td {
            padding: 15px;
            align: center;
        }
        .header{
            width: auto;
            background-image: url('images/background.png');
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
            padding: 20px;
        }
    </style>
    <style>
        #customers {
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 45%;
        }

        #customers td, #customers th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #customers tr:nth-child(even){background-color: #f2f2f2;}

        #customers tr:hover {background-color: #ddd;}

        #customers th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #4CAF50;
            color: white;
        }
        ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            overflow: hidden;
            background-color: #333333;
        }

        li {
            float: left;
        }

        li a {
            display: block;
            color: white;
            text-align: center;
            padding: 16px;
            text-decoration: none;
        }

        li a:hover {
            background-color: #111111;
        }
        #map {
            height: 100%;
        }
        html {
            height: 100%;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        #map {
            height: 500px;
            width: 600px;
        }
    </style>
    
  </head>
  <body>
  <div class = "header"><img class = "logo" src="images/logo.png"></div>
  <ul>
    <li><a target ="_blank" href="report1.php">Report</a></li>
    <li style="float:right"><a href="dashboard1.php">Back</a></li>
  </ul>
<br><br>
<div id="chartContainer" style="height: 370px; width: 100%;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<p>*หากปรากฏ 'Stop' ด้านหน้าเวลา หมายถึงสิ้นสุดรอบการส่งในครั้งนั้น</p>
<p>**หมายเลขด้านหน้า 'Stop' หมายถึงรอบการขนส่งที่สิ้นสุด</p>
<br><br><br>

<div id="map" style="margin:auto;width:600px;height:500px;"></div>
    <script>
      var jsonObj = [{"location":"Start Around1", "lat": "<?php echo $lat1?>", "lng": "<?php echo $long1?>"},
			  {"location":"Stop Around1", "lat": "<?php echo $lat11?>", "lng": "<?php echo $long11?>"},
			  {"location":"Start Around2", "lat": "<?php echo $lat2?>", "lng": "<?php echo $long2?>"},
			  {"location":"Stop Around2", "lat": "<?php echo $lat22?>", "lng": "<?php echo $long22?>"}]

      function initMap() {
			var mapOptions = {
			  center: {lat: <?php echo $lat11; ?>, lng: <?php echo $long11; ?>},
			  zoom: 15,
			}
				
			var maps = new google.maps.Map(document.getElementById("map"),mapOptions);

			var marker, info;

			$.each(jsonObj, function(i, item){

				marker = new google.maps.Marker({
				   position: new google.maps.LatLng(item.lat, item.lng),
				   map: maps,
				   title: item.location
				});

			  info = new google.maps.InfoWindow();

			  google.maps.event.addListener(marker, 'click', (function(marker, i) {
				return function() {
				  info.setContent(item.location);
				  info.open(maps, marker);
				}
			  })(marker, i));

			});
		}
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAK3RgqSLy1toc4lkh2JVFQ5ipuRB106vU&callback=initMap" async defer></script>
<br><br>
</body>
</html>