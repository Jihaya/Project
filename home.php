<?php
// Initialize the session
session_start();

//Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
    unset($_SESSION);
    session_destroy();
}

//1. เชื่อมต่อ database: 
include('config.php');  //ไฟล์เชื่อมต่อกับ database ที่เราได้สร้างไว้ก่อนหน้านี้
//2. query ข้อมูลจากตาราง users:
$query = "SELECT * FROM users WHERE username = '".$_SESSION['username']."' " or die("Error:" . mysqli_error()); 
//3.เก็บข้อมูลที่ query ออกมาไว้ในตัวแปร result . 
$result = mysqli_query($link, $query); 
//4 . แสดงข้อมูลที่ query ออกมา โดยใช้ตารางในการจัดข้อมูล: 
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
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
            padding: 20px 16px;
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

    </style>

    <style>
        .databox{
            margin-left: 28%;
            margin-right: 38%;
            width: 45%;
            background-color: #ffffff;
            border: 1px;
            opacity: 0.9;

            /*filter: alpha(opacity=100); /* For IE8 and earlier */
        }
        .page-header, table{
            background-color: lightblue;
            
        }
        a{
           font-size:16px;
        }
        ul{
            box-shadow: 5px 10px 16px #888888;

        }
    </style>
    <style>
        .header{
            width: auto;
            background-image: url('images/background.png');
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
            padding: 20px;
        }
        .icon{
            padding-left: 4em;
        }
        .active {
        background-color: #4CAF50;
        }
    </style>
    <script src="https://www.gstatic.com/firebasejs/4.9.0/firebase.js"></script>
</head>
<body>
<div class = "header"><img class = "logo" src="images/logo.png"></div>
    <ul>
        <li class="active"><a href="welcome.php">Monitor Page</a></li>
        <?php if($_SESSION["level"] == 'a' ){?>
        <li><a href="admin.php">Manage Members</a></li>
        <?php }?>
        <li class="active2"><a href="about.php">About us</a></li>
        <?php if($_SESSION["level"] == 'u' ){?>
        <li class="active"><a href="reset-password">Reset Password</a></li>
        <?php }?>
        <li style="float:right" class="activeout"><a href="logout.php">Logout</a></li>
    </ul>
    <br><br>
    <div class="databox">
        <h3><font face="th sarabun new" size="6">ทำไมเราจึงต้องการผักสด ?</font></h3>
        <p><font face="th sarabun new" size="5">ปฏิเสธไม่ได้เลยว่าผู้คนนิยมเลือกผักที่สดเพื่อประกอบอาหาร 
        ไม่ว่าจะเพื่อให้มีระยะเวลาในการเก็บรักษาที่ยาวนานกว่าผักที่ไม่สดหรือจะด้วยรสชาติที่กรอบ
        ใหม่ อีกทั้งยังเป็นความมั่นใจว่าพวกเขาได้ทานผักคุณภาพ หากเป็นผู้ผลิตอาหาร แน่นอนว่าผักที่สดย่อมดีกว่า
        ไม่จำเป็นจะต้องเสียค่าเสียจ่ายจากเศษผักที่เน่าเสีย หรือส่วนที่มีตำหนิ
        โดยการนำไปทิ้งและไม่แม้แต่จะนำมาใช้นอกเสียจากนำไปขายเพื่อทดแทนค่าใช้จ่ายที่เสียไป</font></p>
    </div>
    <br>
    <div class="databox">
        <h3><font face="th sarabun new" size="6">แล้วจะมั่นใจได้อย่างไรว่าผักที่ได้เลือกซื้อสดมา ?</font></h3>
        <p><font face="th sarabun new" size="5">แม้ผู้ขายจะรับประกันว่า ผักที่เขานำมาส่งนั้นสดอย่างแน่นอน แต่ไม่มีอะไรรับประกันเลยว่าสดจริงหรือไม่</font></p>
    </div>
    <br>
    <div class="databox">
        <h3><font face="th sarabun new" size="6">ทำไมไม่ใช้บริการของเราล่ะ</font></h3>
        <img class = "center" src="images/logo.png">
        <h3><font face="th sarabun new" size="6">ระบบติดตามการขนส่งผัก</font></h3>
        <p><font face="th sarabun new" size="5">ที่จะเป็นการรับประกันได้ว่าผักที่คุณได้รับนั้นสดใหม่ และถูกเก็บไว้ในอุณหภูมิที่ช่วยให้อายุของผักนานขึ้น อีกทั้งยังสามารถตามขณะการขนส่ง</font></p>
        <br><br>
        <img class = "icon" src="images/clock.png" width="190px">
        <img class = "icon" src="images/temp.png" width="150px">
        <img class = "icon" src="images/humid.png" width="190px">
        <p><font face="th sarabun new" size="5">ไม่ว่าจะเวลาในการขนส่ง หรืออุณหภูมิ รวมถึงความชื่นในระหว่างขนส่งก็สามารถตรวจสอบได้ทันที</font></p>
    </div>
</body>
</html>