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
$reference = $database->getReference('/Car5');

$snapshot = $reference->getSnapshot();

$value = $snapshot->getValue();

if(empty($value)){
    $value = "-";
    $valueem = 0;
    $lat = json_decode(0);
    $long = json_decode(0);
}else{
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
    $lat = json_decode($str11[7]);
    $long = json_decode($str11[9]);
    
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
    $lat = json_decode($str22[7]);
    $long = json_decode($str22[9]);
    }
}
// $c2 = explode(' ', $arrcount2[count($temp)]);
// foreach($value as $x=>$x_value){
//     array_push($arrcount3, $x_value);
//     $str = explode(' ',$x_value);
//     for($i = 0; $i <= count($temp) -1; $i++){
//         unset($arrcount3[$i]);
//     }
// }
// $cut1arrcount3 = current($arrcount3);
// $cut2arrcount3 = end($arrcount3);
// $str2 = explode(' ',$cut1arrcount3);
// $str22 = explode(' ',$cut2arrcount3);
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Moniter Datas</title>
<meta http-equiv="refresh" content="5" >
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
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
        .activeout {
            background-color: #cc0000;
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
        .databox{
            margin: 30px;
            background-color: #ffffff;
            border: 1px solid black;
            opacity: 0.9;
            /*filter: alpha(opacity=100); /* For IE8 and earlier */
        }
        .page-header, table{
            background-color: lightblue;
        }
        table{
            background-color: White;
        }
        table, td, th{  
            border: 1px solid #ddd;
            align: center;
        }
        table {
            border-collapse: collapse;
            margin: auto;
            align: center;
        }
        th, td {
            padding: 15px;
            align: center;
        }
        .td1 {
            width: 25%;
        }
        .header{
            width: auto;
            background-image: url('images/bg2.jpg');
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
            padding: 20px;
        }
    </style>
    <script src="https://www.gstatic.com/firebasejs/4.9.0/firebase.js"></script>
    <style>
       /* Set the size of the div element that contains the map */
      #map {
        height: 400px;  /* The height is 400 pixels */
        width: 25%;  /* The width is the width of the web page */
       }
    </style>
</head>
<body>
    <div class = "header"><img class = "logo" src="images/logo.png"></div>
    <ul>
        <li><a class="active" href="logpage.php">LogPage</a></li>
        <li style="float:right"><a class="active" href="welcome.php">Back</a></li>
    </ul>
    <div style="margin:auto;width:100%;">
    <div id="chart_div" style="margin:auto;width:600px;height:400px;"></div>  
    <br><br>
    <table class="td1" name= "td1" id="tbl_Cars_list" border="1">
        <tr>
            <td>Device</td>
            <td>Temp(°C)</td>
            <td>Humid(%)</td>
            <td>Time (Start)</td>
            <td>Time (Now)</td>
            <td>Time used</td>
            <td>Status</td>
        </tr>
            <td>
            <?php //device id
                if($value == "-"){
                    echo "-";
                }else{
                echo $str[1];
                }
            ?>
            </td>

            <td>
            <?php //temp
                if($value == "-"){
                    echo "-";
                }if($value != "-"){
                    if($c = 3){
                        if(empty($arrcount2[count($temp)]))
                        {
                            echo $str11[3];
                        }elseif(!empty($arrcount2[count($temp)])){
                            echo $str22[3];
                        }
                    }
                }
            ?>
            </td>

            <td>
            <?php //humid
            if($value == "-"){
                echo "-";
            }if($value != "-"){
                if(empty($arrcount2[count($temp)])){
                    echo $str11[5];
                }if(!empty($arrcount2[count($temp)])){
                        echo $str22[5];
                }
            }
            ?>
            </td>

            <td><?php //time start
            if($value == "-"){
                echo "-";
            }if($value != "-"){
                if(empty($arrcount2[count($temp)])){
                    echo $str1[13].$str1[14].$str1[15];
                }elseif(!empty($arrcount2[count($temp)])){
                    echo $str2[13].$str2[14].$str2[15];
            }
            }
            ?>
            </td>

            <td>
            <?php //time stop
                if($value == "-"){
                    echo "-";
                }if($value != "-"){
                    if($c = 2){
                        if(empty($arrcount2[count($temp)]))
                        {
                            if($str11[13] != "'Stop'"){
                                echo $str11[13].$str11[14].$str11[15];
                            }
                            else{
                                echo $str11[15].$str11[16].$str11[17];
                            }
                        }
                    }if(!empty($arrcount2[count($temp)]))
                    {
                        if($str22[13] != "'Stop'"){
                            echo $str22[13].$str22[14].$str22[15];
                        }
                        else{
                            echo $str22[15].$str22[16].$str22[17];
                        }
                    }
                }
            ?>
            </td>

            <td>
            <?php // time use
                if($value == "-"){
                    echo "-";
                }else if ($c = 2){
                    if(empty($arrcount2[count($temp)])){
                        if($str11[13] != "'Stop'"){
                            echo "Not ending the transport";
                        }elseif($str11[13] == "'Stop'"){
                            $strTime1 = $str1[13].$str1[14].$str1[15];
                            $timestart1 = intval($str1[13]);
                            $timestart2 = intval($str1[15]);

                            $strTime2 = $str11[15].$str11[16].$str11[17];
                            $timeend1 = intval($str11[15]);
                            $timeend2 = intval($str11[17]);

                            $timeresult1 = $timestart1 - $timeend1;
                            $timeresult2 = $timestart2 - $timeend2;
                            if($timeresult1 < 0){
                                echo abs($timeresult1);
                                echo ".";
                            } else{
                                echo $timeresult1;
                                echo ".";
                            }
                            if($timeresult2 < 0){
                                echo abs($timeresult2);
                            }else{
                                echo $timeresult2;
                            }
                        }
                    }elseif(!empty($arrcount2[count($temp)])){
                        if($str22[13] != "'Stop'"){
                            echo "Not ending the transport";
                        }elseif($str22[13] == "'Stop'"){
                            $strTime1 = $str2[13].$str2[14].$str2[15];
                            $timestart1 = intval($str2[13]);
                            $timestart2 = intval($str2[15]);

                            $strTime2 = $str22[15].$str22[16].$str22[17];
                            $timeend1 = intval($str22[15]);
                            $timeend2 = intval($str22[17]);

                            $timeresult1 = $timestart1 - $timeend1;
                            $timeresult2 = $timestart2 - $timeend2;
                            if($timeresult1 < 0){
                                echo abs($timeresult1);
                                echo ".";
                            } else{
                                echo $timeresult1;
                                echo ".";
                            }
                            if($timeresult2 < 0){
                                echo abs($timeresult2);
                            }else{
                                echo $timeresult2;
                            }
                        }
                    }
                }
            ?>
            </td>
            <td>
            <?php // status
                if($value == "-"){
                    echo "-";
                }elseif(empty($arrcount2[count($temp)])){
                    if($str11[13] != "'Stop'"){
                        echo $str1[11];
                    }elseif($str11[13] == "'Stop'"){
                        echo $str11[13];
                    }
                }elseif(!empty($arrcount2[count($temp)])){
                    if($str22[13] != "'Stop'"){
                        echo $str2[11];
                    }elseif($str22[13] == "'Stop'"){
                        echo $str22[13];
                    }
                }
            ?>
            </td>
    </table>
    <a target ="_blank" href='https://www.google.com/maps/search/?api=1&query=<?php echo $lat ?>,<?php echo $long ?>'>Check Location in Google MAP</a>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>   
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
    google.load("visualization", "1", {packages:["corechart"]});
    google.setOnLoadCallback(drawChart);
    function drawChart() {
        // สร้างตัวแปร array เก็บค่า ข้อมูล
        var temp = <?php echo (int)$str[3]?>;
        var humid = <?php echo (int)$str[5] ?>;
        var dataArray1=[
        ['Time', 'Temperature', 'Humidity'],
        ['Now', temp , humid],           
        ];
            
        // แปลงข้อมูลจาก array สำหรับใช้ในการสร้าง กราฟ
        var data = google.visualization.arrayToDataTable(dataArray1);
    
        // ตั้งค่าต่างๆ ของกราฟ
        var options = { 
            title: "Temp&Humid",
            hAxis: {titleTextStyle: {color: 'red'}},
            vAxis: {titleTextStyle: {color: 'blue'}},
            width: 600,
            height: 400,
            bar: {groupWidth: "50%"},
            legend: { position: 'right', maxLines: 3 },
            tooltip: { trigger: 'select' }
        };
    
        // สร้างกราฟแนวตั้ง แสดงใน div id = chart_div
        var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
        chart.draw(data, options); // สร้างกราฟ
        
    }
    </script>

<h3>Google Maps</h3>
    The div element for the map
<div id="map"></div>
<script>
// Initialize and add the map
function initMap() {
  // The location of Uluru
  var uluru = {lat: <?php echo $lat ?>, lng: <?php echo $long ?>};
  // The map, centered at Uluru
  var map = new google.maps.Map(
      document.getElementById('map'), {zoom: 17, center: uluru});
  // The marker, positioned at Uluru
  var marker = new google.maps.Marker({position: uluru, map: map});
}
</script>
    <!--Load the API from the specified URL
    * The async attribute allows the browser to render the page while the API loads
    * The key parameter will contain your own API key (which is not needed for this tutorial)
    * The callback parameter executes the initMap() function -->
   
<script async defer
src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDZlLeEp_1W-pWTInUkU4YJEJxq8Kg86ds&callback=initMap">
</script>
</body>
</html>