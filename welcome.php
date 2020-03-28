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
$reference = $database->getReference('/Cars');
$reference2 = $database->getReference('/Cars2');
$reference3 = $database->getReference('/Cars3');
$reference4 = $database->getReference('/Cars4');

$snapshot = $reference->getSnapshot();
$snapshot2 = $reference2->getSnapshot();
$snapshot3 = $reference3->getSnapshot();
$snapshot4 = $reference4->getSnapshot();

$value = $snapshot->getValue();
$value2 = $snapshot2->getValue();
$value3 = $snapshot3->getValue();
$value4 = $snapshot4->getValue();

if(empty($value)){
    $value11 = "-";
}else{
    $value21 = current($value);
    $value11 = end($value);

    // current = ค่าแรก - end = ค่าสุดท้าย
    // ทำการตัดข้อมูลภายใน ' '
    $str11 = explode(' ',$value21);
    $str21 = explode(' ',$value11);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.0/jquery.min.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Type" content="text/html">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style type="text/css">
        body{
            font: 14px sans-serif;
            text-align: center;
        }
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
        table{
            background-color: White;
        }
        table, td, th{  
            border: 1px solid #ddd;
            align: center;
        }
        table {
            border-collapse: collapse;
            width: 45%;
            margin: auto;
            align: center;
        }
        th, td {
            padding: 15px;
            align: center;
        }
        .td1 {
            width: 70%;
        }
        .header{
            width: auto;
            background-image: url('images/bg1.jpg');
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
            padding: 20px;
        }
        .top{
            width: auto;
            background-color: #ffffcc;
        }
    </style>
    <script src="https://www.gstatic.com/firebasejs/4.9.0/firebase.js"></script>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    
    <style>
        .w3-btn {margin-bottom:10px;}
    </style>

    <script>
        function startTime() {
        var today = new Date();
        var h = today.getHours();
        var m = today.getMinutes();
        var s = today.getSeconds();
        m = checkTime(m);
        s = checkTime(s);
        document.getElementById('txt').innerHTML =
        h + ":" + m + ":" + s;
        var t = setTimeout(startTime, 500);
        }
        function checkTime(i) {
        if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
        return i;
        }
    </script>
</head>
<body onload="startTime()">
    <div class = "header"><img class = "logo" src="images/logo.png"></div>
    <ul>
        <li><font face="th sarabun new" size="6" color="White">Account : <?php echo htmlspecialchars($_SESSION["username"]); ?>&nbsp;</font></li>
        <li><a class="active" href="home.php">Home</a></li>
        <li><a class="active" href="adddevice.php">Add Device</a></li>
        <li><a target ="_blank" class="active" href="reportall.php">Report All</a></li>
        <li style="float:right" class="activeout"><a href="logout.php">Logout</a></li>
    </ul>
    <br>
    <table class="top">
    <td>
        <div class="Car1">
        <br>
        <div id="txt"></div>
        <?php
            $date = new DateTime("now",  new DateTimeZone('Asia/Bangkok') );
            echo $date->format("d-m-Y"); //\T H:i:s
            echo "<br>";
            $timeall = [4, 5, 6, 7 ,8 ,9 ,10 ,11 ,12, 17, 18, 19, 20, 21];
            $timeMooning = [4, 5, 6, 7 ,8 ,9 ,10 ,11 ,12]; // [0, 1, 2, 3, 4, 5, 6, 7 ,8 ,9 ,10 ,11 ,12]
            $timeeve = [17 ,18, 19, 20, 21]; // [13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23]
            $timech = $date->format("H");
            $timeChint = intval($timech);
            $result_array = in_array($timeChint, $timeMooning);
            $result_array2 = in_array($timeChint, $timeeve);
            $result_array4 = in_array($timeChint, $timeall);

            if ($result_array != False){
                echo "รอบเช้า";
            }else if($result_array2 != False){
                echo "รอบเย็น";
            }else if($result_array4 != True){
                echo "ไม่อยู่ในรอบการส่ง";
            }
        ?>
    </td>
    </table>
    <br>
    <?php
        //1. เชื่อมต่อ database: 
        include('config.php');  //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้านี้
        
        //2. query ข้อมูลจากตาราง users: 
        $query = "SELECT * FROM device ORDER BY id ASC" or die("Error:" . mysqli_error());
        //3.เก็บข้อมูลที่ query ออกมาไว้ในตัวแปร result . 
        $result = mysqli_query($link, $query);
        //4 . แสดงข้อมูลที่ query ออกมา โดยใช้ตารางในการจัดข้อมูล: 
        
        echo "<table id='table' border='1' align='center' width='500'>";
        //หัวข้อตาราง
        echo "<tr align='center' bgcolor='#CCCCCC'><td>Device ID</td><td>Vehicle Registration</td><td>Monitor Site</td><td>Status</td><td>Car Status</td>";
        echo "<td>edit</td><td>delete</td>";
        while($row = mysqli_fetch_array($result)) { 
        echo "<tr>";
        echo "<td>" .$row["deviceid"] .  "</td> "; 
        echo "<td>" .$row["carnum"] .  "</td> ";
        if($value2 == "-"){
            echo "'Stop'";
        }
        else if($row["status"] != "Ready")
        {
            echo "<td><a>Click here</a></td>";
            echo "<td><i class='fa fa-circle' style='font-size:24px;color:red;'></i></td>";
            
        }
        else if($row["status"] == "Ready"){
            echo "<td><a href='dashboard",$row["deviceid"],".php'>Click here</a></td>";
            echo "<td><i class='fa fa-circle' style='font-size:24px;color:green;'></i></td>";
        }
        echo "<td>" .$row["status"] .  "</td> ";
        //แก้ไขข้อมูล
        echo "<td><a type='button' href='editdevice.php?id=$row[0]'>edit</a></td> ";
        
        //ลบข้อมูล
        echo "<td><a href='deldevice.php?id=$row[0]' onclick=\"return confirm('Do you want to delete this record? !!!')\">del</a></td> ";
        echo "</tr>";
        }
        echo "</table>";
        //5. close connection
        mysqli_close($link);
    ?>
    </div>
    <style></style>
</body>
</html>