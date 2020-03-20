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
$reference = $database->getReference('/Cars4');

$snapshot = $reference->getSnapshot();

$value = $snapshot->getValue();

if(empty($value)){
    $value = "-";
    $valueem = 0;
    $lat = json_decode($valueem);
    $long = json_decode($valueem);
}else{
    // current = ค่าแรก - end = ค่าสุดท้าย
    // $value2 = current($value);
    // $value1 = end($value);

    // // ทำการตัดข้อมูลภายใน ' '
    // $str = explode(' ',$value2);
    // $str2 = explode(' ',$value1);
    // $tempHumid = $str2[3].' '.'&'.' '.$str2[5];
    // $latlon = $str2[7].' '.','.' '.$str2[9];
    // $lat = json_decode($str2[7]);
    // $long = json_decode($str2[9]);
}

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

// หยุดหารอบสองค่าแรก
foreach($value as $x=>$x_value){
    array_push($arrcount, $x_value);
    $str = explode(' ',$x_value);

    array_push($temp, $str[3]);
    array_push($humid, $str[5]);
    if($str[13] === "'Stop'"){
        $c = $c + 1;
        break;
    }
}

// ค่าที่เอามาเทียบ
foreach($value as $x=>$x_value){
    array_push($arrcount2, $x_value);
    $str = explode(' ',$x_value);
}

$c2 = []; // ค่าแรกในรอบที่ 2
//print_r ($arrcount2[count($temp)]); // ได้ตำแหน่งสุดท้ายของตัวแรก ที่จะเป็นรอบเริ่มของตัวสอง
$c2 = explode(' ', $arrcount2[count($temp)]);

// รอบที่ 2
$arrstop = [];
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


?>

<!DOCTYPE html>
<html>
<head>
<title>Moniter Datas</title>
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
                }if($c = 1){
                    echo $c2[3];
                }
            ?>
            </td>

            <td>
            <?php //humid
            if($value == "-"){
                echo "-";
            }else if($c = 0){
                echo $c2[5];
            }else if($c = 1){
                echo $c2[5];
            }
            ?>
            </td>

            <td><?php //time start
            if($value == "-"){
                echo "-";
            }else if($c = 1){
                echo $c2[13].$c2[14].$c2[15];
            }
            ?>
            </td>

            <td>
            <?php //time stop
                if($value == "-"){
                    echo "-";
                }
                else if($c = 0)
                { 
                    echo $str2[13].$str2[14].$str2[15];
                }
                else if($c = 1){
                    echo $str22[15].$str22[16].$str22[17];
                }
            ?>
            </td>

            <td>
            <?php // time use
                if($value == "-"){
                    echo "-";
                }else if($c = 0){
                    if($str1[13] != "'Stop'"){
                        echo "Not ending the transport";
                    }else if($str11[13] == "'Stop'"){
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
                        }else{
                            echo $timeresult1;
                            echo ".";
                        }
                        if($timeresult2 < 0){
                            echo abs($timeresult2);
                        }else{
                            echo $timeresult2;
                        }
                    }
                }else if ($c = 1){
                    if($str22[13] != "'Stop'"){
                        echo "Not ending the transport";
                    }else if($str22[13] == "'Stop'"){
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
            ?>
            </td>
            <td>
            <?php // status
                if($value == "-"){
                    echo "-";
                }elseif($c = 0){
                    if($str11[13] != "'Stop'"){
                        echo $str1[13];
                    }elseif($str11[13] == "'Stop'"){
                        echo $str11[13];
                    }
                }elseif($c = 1){
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
</body>
</html>