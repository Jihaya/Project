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
$serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/logistics-car-94e09b126562.json');

$firebase = (new Factory)
    ->withServiceAccount($serviceAccount)
    ->withDatabaseUri('https://logistics-car.firebaseio.com')
    ->create();

$database = $firebase->getDatabase();
$reference = $database->getReference('/Cars');

$snapshot = $reference->getSnapshot();

$value = $snapshot->getValue();

if(empty($value)){
    $value = "-";
}else{
    $value2 = current($value);
    $value1 = end($value);

    // current = ค่าแรก - end = ค่าสุดท้าย
    $myJSON = json_encode($value1);

    // $myJSON1 = json_decode($myJSON);

    // ทำการตัดข้อมูลภายใน ' '
    $str = explode(' ',$value2);
    $str2 = explode(' ',$value1);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
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
            background-image: url('bg1.jpg');
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
            padding: 20px;
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
    <div class = "header"><img class = "logo" src="logo.png"></div>
    <ul>
        <li><font face="th sarabun new" size="6" color="White">Account : <?php echo htmlspecialchars($_SESSION["username"]); ?></font></li>
        <li><a class="active" href="home.php">Home</a></li>
        <li style="float:right" class="activeout"><a href="logout.php">Logout</a></li>
    </ul>

    <div clas="Car1">
    <br>
    <div id="txt"></div>
    <?php
        $date = new DateTime("now", new DateTimeZone('Asia/Bangkok') );
        echo $date->format("d-m-Y"); //\T H:i:s
        echo "<br>";
        $timeMooning = [4, 5, 6, 7 ,8 ,9 ,10 ,11 ,12]; // [0, 1, 2, 3, 4, 5, 6, 7 ,8 ,9 ,10 ,11 ,12]
        $timeafter = [13, 14, 15, 16, 17]; // [13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23]
        $timeeve = [18, 19, 20, 21];
        $timech = $date->format("H");
        $timeChint = intval($timech);
        $result_array = array_search($timeChint, $timeMooning);
        $result_array2 = array_search($timeChint, $timeafter);
        $result_array3 = array_search($timeChint, $timeeve);

        if ($result_array != False){
            echo "รอบเช้า";
        }if($result_array = False){
            echo "ไม่อยู่ในรอบการส่ง";
        }if($result_array2 != False){
            echo "รอบบ่าย";
        }if($result_array2 = False){
            echo "ไม่อยู่ในรอบการส่ง";
        }if($result_array3 != False){
            echo "รอบเย็น";
        }if($result_array3 = False){
            echo "ไม่อยู่ในรอบการส่ง";
        }
    ?>
    <br>
    <br>
    <table>
    <tr></tr>
    <td><img src="ic.png" alt="Trulli" width="150">
        <h4>Device 01</h4>
        <h5>กย105</h5>
        <h5>Status:
        <?php
            if($value == "-"){
                echo "'Stop'";
            }
            else if($str2[13] != "'Stop'")
            { 
                echo $str[11];
            }
            else if($str2[13] == "'Stop'"){
                echo $str2[13];
            }
        ?>
        </h5>
        <input class="w3-btn w3-white w3-border w3-round-large" type="button" value=" Moniter " onclick="window.location='dashboard.php' " />
    </td>
    <td><img src="ic.png" alt="Trulli" width="150">
        <h4>Device 02</h4>
        <h5>ทข354</h5>
        <input class="w3-btn w3-white w3-border w3-round-large" type="button" value=" Moniter " onclick="window.location='dashboard.php' " />
    </td>
    <tr>
    <td><img src="ic.png" alt="Trulli" width="150">
        <h4>Device 03</h4>
        <h5>คซ3754</h5>
        <input class="w3-btn w3-white w3-border w3-round-large" type="button" value=" Moniter " onclick="window.location='dashboard.php' " />
    </td>
    <td><img src="ic.png" alt="Trulli" width="150">
        <h4>Device 04</h4>
        <h5>กข1054</h5>
        <input class="w3-btn w3-white w3-border w3-round-large" type="button" value=" Moniter " onclick="window.location='dashboard.php' " />
    </td>
    </tr>
    </table>
    </div>
</body>
</html>