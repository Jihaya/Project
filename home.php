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
            margin: 35px;
            background-color: #ffffff;
            border: 1px;
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
            width: 45%;
            margin-left: 25%;
            margin-right: 38%;
            align: center;
        }
        th, td {
            padding: 15px;
            align: center;
        }
        .td1 {
            width: 70%;
        }
    </style>
    <style>
        body {
            background-image: url('bghome.jpg');
        }
    </style>
    
    <script src="https://www.gstatic.com/firebasejs/4.9.0/firebase.js"></script>
    <script>
        // Initialize Firebase
        var config = {
            apiKey: "AIzaSyDZlLeEp_1W-pWTInUkU4YJEJxq8Kg86ds",
            authDomain: "logistics-car.firebaseapp.com",
            databaseURL: "https://logistics-car.firebaseio.com",
            projectId: "logistics-car",
            storageBucket: "logistics-car.appspot.com",
            messagingSenderId: "1032198316609"
        };
        firebase.initializeApp(config);
    </script>
</head>
<body>
    <ul>
        <!-- <li><a href="updateforuser.php">แก้ไขข้อมูลส่วนตัว</a></li> -->
        <li><a href="welcome.php">Moniter Page</a></li>
        <li><a href="reset-password.php">Reset Password</a></li>
        <li style="float:right" class="activeout"><a href="logout.php">Logout</a></li>
    </ul>
    <div class="databox">
        <h3>ทำไมเราจึงต้องการผักสด ?</h3>
        <p>ปฏิเสธไม่ได้เลยว่าผู้คนนิยมเลือกผักที่สดเพื่อประกอบอาหาร 
        ไม่ว่าจะเพื่อให้มีระยะเวลาในการเก็บรักษาที่ยาวนานกว่าผักที่ไม่สด</p>
        <p>หรือจะด้วยรสชาติที่กรอบใหม่ 
        อีกทั้งยังเป็นความมั่นใจว่าพวกเขาได้ทานผักคุณภาพ</p>
        <p>หากเป็นผู้ผลิตอาหาร แน่นอนว่าผักที่สดย่อมดีกว่า
        ไม่จำเป็นจะต้องเสียค่าเสียจ่ายจากเศษผักที่เน่าเสีย </p>
        <p>หรือส่วนที่มีตำหนิ
        โดยการนำไปทิ้งและไม่แม้แต่จะนำมาใช้นอกเสียจากนำไปขายเพื่อทดแทนค่าใช้จ่ายที่เสียไปจากการซื้อ</p>
    </div>

    <div class="databox">
        <h3>แล้วทำอย่างไรจึงจะเก็บผักสดไว้ได้นาน ?</h3>
        <p>จัดเก็บไว้ในอุณหภูมิที่เหมาะสม</p>
        <p>ไม่จัดเก็บผักไว้รวมกัน จะทำให้เกิดการเน่าเสียและเสื่อมสภาพเร็วขึ้น</p>
    </div>
</body>
</html>